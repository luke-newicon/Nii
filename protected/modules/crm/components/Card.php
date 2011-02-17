<?php 

Class Nworx_Crm_Model_Card extends Nworx_Core_Component
{
	
	public $contact;
	
	public $term;
	
	public function configure(){
		$this->view->term = $this->term;
		$this->view->contact = $this->contact;
	}
	
}