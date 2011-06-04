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
	
	public $threads = array();
	
	/**
	 * when an instance is created a large array containing threads is created, 
	 * this is then cached with a unique id
	 * so that guis can loook up correct message threads based on position
	 * using this cache.
	 * @var type 
	 */
	public static $cacheId;
	
	public function __construct(){
		self::$cacheId = '[thread_'.time().']';
	}
	
	
	public function parseMessagesIntoThreads(){

		// 1.
		$this->createIdTable();
		// 2. find root set with no parents
		$this->findRootSet();
		// 3. discard idtable
		$this->idTable=array();

		$this->pruneRecursive($this->rootSet);

		$this->groupBySubject();
		
		$this->order();
		
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
		foreach(EmailEmail::model()->findAll(array('limit'=>1500)) as $msg){
			
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
	 * Now the subject_table is populated with one entry for each subject which occurs in the root set.
	 * Now iterate over the root set, and gather together the difference.
	 * For each Container in the root set:
	 * - Find the subject of this Container (as above.)
	 * - Look up the Container of that subject in the table.
	 * - If it is null, or if it is this container, continue.
	 *
	 * - Otherwise, we want to group together this Container and the one in the table. There are a few possibilities:
	 *    - If both are dummies, append one's children to the other, and remove the now-empty container.
	 *    - If one container is a empty and the other is not, make the non-empty one be a child of the empty,
	 *      and a sibling of the other ``real'' messages with the same subject (the empty's children.)
	 *    - If that container is a non-empty, and that message's subject does not begin with ``Re:'',
	 *      but this message's subject does, then make this be a child of the other.
	 *    - If that container is a non-empty, and that message's subject begins with ``Re:'',
	 *      but this message's subject does not, then make that be a child of this one -- they were misordered.
	 *      (This happens somewhat implicitly, since if there are two messages, one with Re: and one without,
	 *      the one without will be in the hash table, regardless of the order in which they were seen.)
	 *    - Otherwise, make a new empty container and make both msgs be a child of it.
	 *      This catches the both-are-replies and neither-are-replies cases,
	 *      and makes them be siblings instead of asserting a hierarchical relationship which might not be true.
	 *
	 * (People who reply to messages without using ``Re:'' and without using a References line will break this slightly. Those people suck.)
	 * (It has occurred to me that taking the date or message number into account would be one way of
	 * resolving some of the ambiguous cases, but that's not altogether straightforward either.)
	 */
	public function groupBySubject() {
		$this->createSubjectTable();
		foreach($this->rootSet->children as $container){
			$subject = $container->getSubjectNormalized();
			if(!array_key_exists($subject, $this->subjectTable))
				continue;

			if($this->subjectTable[$subject] == $container)
				continue;
			
			$c = $this->subjectTable[$subject];
			// If both are dummies, append one's children to the other, and remove the now-empty container.
			if(!$c->hasMessage() && !$container->hasMessage()){
				foreach($container->children as $child){
					$c->addChild($child);
				}
				// remove?
				//$container->parent->removeChild($container);
			}
			// If one container is a empty and the other is not, make the non-empty one be a child of the empty,
			// and a sibling of the other ``real'' messages with the same subject (the empty's children.)
			elseif (!$c->hasMessage() && $container->hasMessage()){
				$c->addChild($container);

			}
			// If that container is a non-empty, and that message's subject begins with ``Re:'',
			// but this message's subject does not, then make that be a child of this one -- they were misordered.
			// (This happens somewhat implicitly, since if there are two messages, one with Re: and one without,
			// the one without will be in the hash table, regardless of the order in which they were seen.)
			elseif(!$c->isReOrFwd() && $container->isReOrFwd()) {
				$c->addChild($container);
			}

			else {
				$newC = new Container;
				$newC->addChild($c);
				$newC->addChild($container);
				$this->subjectTable[$subject] = $newC;
			}
		}
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
	public function createSubjectTable(){
		foreach($this->rootSet->children as $c){

			$subject = $c->getSubjectNormalized();
			//echo "$subject <br/>";
			if($subject == '')
				continue;

			if(!array_key_exists($subject,$this->subjectTable)){
				$c->parent = null;
				$this->subjectTable[$subject] = $c;
			} else {
				// This one is an empty container and the old one is not: the empty one is more interesting as a root,
				// so put it in the table instead.

				if(($this->subjectTable[$subject]->hasMessage() && !$c->hasMessage())
				|| ($this->subjectTable[$subject]->isReOrFwd() && !$c->isReOrFwd())){
					$c->parent = null;
					$this->subjectTable[$subject] = $c;
				}
			}
		}
	}
	
	public function order(){
		//Yii::app()->cache->set(self::$cacheId, $value)
		$this->threads = array_values($this->subjectTable);
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
	 * @var EmailEmail 
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
			if (($msg = $this->getMessage())){
				$this->_subject = $msg->subject;
			}else{
				$this->parent = null;
				//dp($this); // ignore these ones will be picced up later
				//echo 'shouldnt happen!';
				$this->_subject = '';
			}
		}

		return $this->_subject;
	}

	private $_subjectNormalized;
	public function getSubjectNormalized(){
		if($this->_subjectNormalized === null){
			$this->_subjectNormalized = NMailReader::normalizeSubject($this->getSubject());
		}
		return $this->_subjectNormalized;
	}

	private $_isReOrFwd;
	public function isReOrFwd(){
		if($this->_isReOrFwd === null){
			$pattern = '/^(Re|Fwd)/i';
			$this->_isReOrFwd = preg_match($pattern, $this->getSubject());
		}
		return $this->_isReOrFwd;
	}
	
	private $_rootMessage;
	public function getMessage(){
		if($this->_rootMessage === null){
			if($this->hasMessage()){
				$this->_rootMessage = $this->message;
			}else{
				if($this->hasChildren()){
					$children = $this->children;
					$c = reset($children);
					if($c->hasMessage()){
						$this->_rootMessage = $c->message;
					}
				}
			}
		}
		return $this->_rootMessage;
	}

	/**
	 * @var CActiveRecord
	 */
	private $_dbEmail;
	/**
	 *
	 * @return CActiveRecord
	 */
	public function getEmail(){
		if ($this->_dbEmail === null){
			$msg = $this->getMessage();
			if($msg){
				$this->_dbEmail = EmailEmail::model()->findByPk($msg->dbId);
			}
		}
		return $this->_dbEmail;
	}
	
	public function msgCount($c=null){
		if($c===null) $c = $this;
		$count = 0;
		if($c->hasMessage())
			$count++;
		if($c->hasChildren()){
			foreach($this->children as $c){
				$count += $c->msgCount($c);
			}
		}
		return $count;
	}
	
	/**
	 * gets a unique id for this container so it can be referenced later
	 */
	public function getLookupId(){
		return CHtml::encode($this->getSubjectNormalized());
	}
	
	public function markAsOpened(){
		if($this->getEmail()->opened == 0){
			$this->getEmail()->opened = 1;
			$this->getEmail()->save();
		}
	}

}