<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Threading
 *
 * @author steve
 */
class Threading extends CComponent
{
	/**
	 * message_id => Container
	 * @var array
	 */
	public $idTable = array();

	/**
	 *
	 * @var CList
	 */
	public $rootSet = array();


	public $subjectTable = array();
	
	public function parseMessagesIntoThreads(){

		// 1.
		$this->createIdTable();
		// 2. find root set with no parents
		$this->findRootSet();
		// 3. discard idtable
		$this->idTable=array();

		$this->pruneRecursive($this->rootSet);

		$this->groupBySubject();
		
	}


	public function pruneRecursive($parent){
		foreach($parent->children as $c){
			$this->pruneRecursive($c);
			if($c->message===null && empty($c->children)){
				// no message and no children: nuke
				$this->rootSet->removeChild($c);
			} else if ($c->message===null && !empty($c->children)){
				// promote children dont promote if they would become children of the root
				// if we are on a root node then it wont have a parent. We dont want to promote children above these.
				if ($c->parent!==null && count($c->children)==1) {
					$this->promoteChildrenToCurrent($parent, $c);
				} elseif($c->parent!==null && count($c->children) > 1) {
					// don't promote children
				} else{
					$this->promoteChildrenToCurrent($parent, $c);
				}
			}
		}
	}

	public function promoteChildrenToCurrent(Container $parent, Container $child){
		foreach($child->children as $c)
			$parent->addChild($c);
		$parent->removeChild($child);
	}

	public function findRootSet(){
		$this->rootSet = new Container;
		foreach($this->idTable as $c){
			if(!$c->hasParent()){
				//$this->rootSet[$k] = $c;
				$this->rootSet->addChild($c);
			}

		}
	}
	
	
	public function createIdTable(){
		foreach(SupportEmail::model()->findAll() as $msg){
			
			$parnetCont = $this->getContainerById($msg->message_id);
			// check container is empty
			if($parnetCont->isEmpty())
				$parnetCont->message = new Message($msg);	

			// For each element in the message's References field:
			$prev = null;
			foreach($parnetCont->message->references as $refId){
				// Find a Container object for the given Message-ID:
				//	If there's one in id_table use that;
				$container = $this->getContainerById($refId);
				
				
				// Link the References field's Containers together in the order implied by the References header.
				// - If they are already linked, don't change the existing links.
				// - Do not add a link if adding that link would introduce a loop: that is, 
				//	 before asserting A->B, search down the children of B to see if A is reachable, 
				//	 and also search down the children of A to see if B is reachable. 
				//	 If either is already reachable as a child of the other, don't add the link.
				# * container is not linked yet (has no parent)
				# * don't create loop
				if ($prev && !$container->hasDescendant($prev) && !$prev->hasDescendant($container)){
					$prev->addChild($container);
				}
				$prev = $container;
			}
			
			// C: Set the parent of this message to be the last element in References
			if ($prev && !$parnetCont->hasDescendant($prev))
				$prev->addChild($parnetCont) ;
		}
	}
	
	public function getContainerById($id){
		# if id_table contains empty container for message id
		return array_key_exists($id,$this->idTable) ? $this->idTable[$id] : $this->createContainer($id);
	}
	
	public function createContainer($id){
		$c = new Container;
		// Index the Container by Message-ID in id_table.
		$this->idTable[$id] = $c;
		return $c;
	}

	/**
	 * Find the subject of that sub-tree:
	 * If there is a message in the Container, the subject is the subject of that message.
	 * If there is no message in the Container, then the Container will have at least one child Container,
	 * and that Container will have a message. Use the subject of that message instead.
	 * Strip ``Re:'', ``RE:'', ``RE[5]:'', ``Re: Re[4]: Re:'' and so on.
	 * If the subject is now "", give up on this Container.
	 * Add this Container to the subject_table if:
	 * - There is no container in the table with this subject, or
	 * - This one is an empty container and the old one is not: the empty one is more interesting as a root,
	 *   so put it in the table instead.
	 * - The container in the table has a ``Re:'' version of this subject,
	 *   and this container has a non-``Re:'' version of this subject.
	 *   The non-re version is the more interesting of the two.
	 */
	public function groupBySubject() {
		foreach($this->rootSet->children as $c){
			$subject = NMailReader::normalizeSubject($c->getSubject());

			if($subject == '')
				continue;

			if(!array_key_exists($subject,$this->subjectTable)){
				$this->subjectTable[$subject] = $c;
			} else {
				// This one is an empty container and the old one is not: the empty one is more interesting as a root,
				// so put it in the table instead.
				if(($this->subjectTable[$subject]->hasMessage() && !$c->hasMessage())
				|| ($this->subjectTable[$subject]->isReOrFwd() && !$c->isReOrFwd())){

					$this->subjectTable[$subject] = $c;
				}
			}
		}
	}

}

class Message
{
	public function __construct($msg=null) {
		if ($msg!==null){
			//$this->_msg = $msg;
			$this->dbId = $msg->id;
			$this->subject = $msg->subject;
			$this->message_id = $msg->message_id;
			$this->processReferences($msg);
		}
	}
	/**
	 *
	 * @var SupportEmail 
	 */
	//public $_msg;
	public $dbId;
	public $subject;
	public $message_id;	 // the ID of this message
	public $references = array();
	
	public function processReferences($msg)
	{
		$references = $msg->references;
		$replyTo = $msg->in_reply_to;

		if(!empty($references)){
			// msg id's are seperated by spaces.
			$refs = explode(' ', trim($references));
			if($refs)
				$this->references = $refs;
		}
		if(!empty($replyTo)){
			// can contain absolute junk as valid data.
			// lets try n find message ids
			preg_match('(<[^<>]+>)', $replyTo, $matches);
			if(!empty($matches))
				$this->references[] = $matches[0];
		}
	}
	
}
class Container
{
	public static $count=0;
	/**
	 * @var message 
	 */
	public $message;
	/**
	 * @var Container 
	 */
	public $parent;
	/**
	 * @var Container 
	 */
	public $children=array();	 // first child
		
	/**
	 * @var Container 
	 */
	public $next;
	
	private $_id;
	
	public function __construct(){
		self::$count++;
		//assign the unique id to this new object IMPORTANT STEP!
		$this->getId();
	}
	
	
	public function getId(){
		if($this->_id === null)
			$this->_id = self::$count;
		return $this->_id;
	}
	
	public function isEmpty(){
		return ($this->message===null);
	}

	public function hasParent(){
		return ($this->parent !== null);
	}
	public function hasChildren(){
		return count($this->children);
	}

	public function hasMessage(){
		return !empty($this->message);
	}
	
	public function hasDescendant($container){
		if ($this == $container)
			return true;
		if (empty($this->children))
			return false;
		foreach($this->children as $c){
			if($c->hasDescendant($container))
				return true;
		}
		return false;
	}
	
	public function addChild($child){
		if($child->parent !== null)
			$child->parent->removeChild($child);
		$id = $child->getId();
		$child->parent = $this;
		$this->children[$id] = $child;
		
	}
	
	public function removeChild($child){
		$id = $child->getId();
		unset($this->children[$id]);
		$child->parent = null;
	}

	private $_subject = null;
	public function getSubject()
	{
		if($this->_subject === null){
			if($this->hasMessage()){
				$this->_subject = $this->message->subject;
			}else{
				if($this->hasChildren()){
					// dp($this->children);
					echo ($this->hasChildren()) ? 'children_true': 'children_false';
					$children = $this->children;
					$c = reset($children);
					$this->_subject = $c->message->subject;
				}
			}
			if($this->_subject === null)
				$this->_subject = '';
		}

		return $this->_subject;
	}

	public function isReOrFwd(){
		$pattern = '/^(Re|Fwd)/i';
		return preg_match($pattern, $this->getSubject());
	}

}