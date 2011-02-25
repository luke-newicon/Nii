<?php 

Class CrmCard extends CWidget
{
	
	public $contact;
	
	public $term;
	
	public $size = 24;
	
	
	public function init(){
		$this->render('card',array('contact'=>$this->contact,'term'=>$this->term));
	}
	
}