<?php 

Class Nworx_Crm_Model_Websites extends Newicon_Db_Table
{
	public function configure(){
		$this->hasColumn('website_id','primary');
		$this->hasColumn('website_address','varchar',250);
		$this->hasColumn('website_label','varchar',250);
		$this->hasColumn('website_contact_id','int',11);
	}
}