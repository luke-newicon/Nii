<?php 

Class CrmCard extends CWidget
{
	/**
	 * Contact object CrmContact
	 * @var CrmContact
	 */
	public $contact;
	
	/**
	 * Highlight text in matching the term.
	 * Useful when used in conjunction with a search lookup.
	 * @var string 
	 */
	public $term;
	
	/**
	 * size of the contacts image thumbnail/avatar
	 * @var int 
	 */
	public $size = 24;
	
	/**
	 * link to the user details page
	 * @var string route 
	 */
	public $profileUrl;
	
	public function init(){
		
		if($this->profileUrl===null && $this->contact !== null)
			$this->profileUrl = $this->contact->getUrl();
		$this->render('card',array('contact'=>$this->contact,'term'=>$this->term));
	}
	
}