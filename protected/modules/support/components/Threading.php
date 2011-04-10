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
	public $idTable = array();
	
	public function parseMessagesIntoThreads(){
		foreach(SupportEmail::model()->findAll() as $msg){
			if(array_key_exists($msg->message_id, $this->idTable)){
				// ensure container is empty 
				$c = $this->idTable[$msg->message_id];
				if($c instanceof Container && $c->isEmpty()){
					$c->message = new Message($msg);
				}
			} else {
				$this->idTable[$msg->message_id] = new Message($msg);
			}
			// For each element in the message's References field:
			$msg = $this->idTable[$msg->message_id];
			foreach($msg->references as $refId){
				//Find a Container object for the given Message-ID:
				//	If there's one in id_table use that;
				//	Otherwise, make (and index) one with a null Message.
				if(array_key_exists($refId, $this->idTable)){
					$refMsg = $this->idTable[$refId];
				} else {
					$this->idTable[$refId] = new Message();
				}
				
				// Link the References field's Containers together in the order implied by the References header.
				// - If they are already linked, don't change the existing links.
				// - Do not add a link if adding that link would introduce a loop: that is, 
				//	 before asserting A->B, search down the children of B to see if A is reachable, 
				//	 and also search down the children of A to see if B is reachable. 
				//	 If either is already reachable as a child of the other, don't add the link.			
			}
		}
		
	}
	
	
}

class Message extends CComponent
{
	public function __construct($msg=null) {
		if ($msg!==null){
			$this->_msg = $msg;
			$this->subject = $msg->subject;
			$this->message_id = $msg->message_id;
			$this->processReferences();
		}
	}
	/**
	 *
	 * @var SupportEmail 
	 */
	public $_msg;
	public $subject;
	public $message_id;	 // the ID of this message
	public $references = array();
	
	public function processReferences()
	{
		$headers = json_decode($this->_msg->headers);
		if(array_key_exists('references', $headers)){
			// msg id's are seperated by spaces.
			if(($refs = explode(' ', $headers['references'])))
				$this->references = $refs;
		}
		if(array_key_exists('in-reply-to', $headers)){
			// can contain absolute junk as valid data.
			// lets try n find message ids
			preg_match('/(<.*>)/', $headers['in-reply-to'], $matches);
			if(array_key_exists(1,$matches)){
				$this->references[] = $matches[1];
			}
		}
	}
	
}
class Container extends CComponent
{
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
	public $child;	 // first child
	/**
	 * @var Container 
	 */
	public $next;
	
	public function isEmpty(){
		return ($this->message===null);
	}
}