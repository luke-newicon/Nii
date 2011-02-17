<?php 

Class Nworx_Crm_Model_Images extends Newicon_Component
{
	
	public $size = 32;
	
	public function __construct($options=array()){
		foreach($options as $k=>$v)
			$this->$k = $v;
	}
	
	public function getImage($contact){
		if($contact->isPerson()){
			return $this->loadComponent('users/gravatar',array('size'=>$this->size,'email'=>$contact->emails[0]->address));
		}else{
			$orgImg = Nworx::url().'/app/Nworx/Crm/theme/assets/mistery-org.png';
			return NPage::image($orgImg,'Compnay Image',array('width'=>$this->size));
		}
	}
}