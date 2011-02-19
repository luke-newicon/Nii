<?php 

Class CrmCard extends CWidget
{
	
	public $contact;
	
	public $term;
	
	public function init(){
		$this->render('card',array('contact'=>$this->contact,'term'=>$this->term));
	}
	
}