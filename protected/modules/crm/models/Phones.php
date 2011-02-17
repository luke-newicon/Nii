<?php 

Class Nworx_Crm_Model_Phones extends Newicon_Db_Table
{
	const VERIFIED_FALSE = 0;
	const VERIFIED_TRUE = 1;
	
	public function configure(){
		$this->hasColumn('phone_id','primary');
		$this->hasColumn('phone_number','varchar',250);
		$this->hasColumn('phone_label','varchar',250);
		$this->hasColumn('phone_contact_id','int',11);
		$this->hasColumnEnum('phone_verified',array(
			self::VERIFIED_FALSE=>'Phone Number Unverified',
			self::VERIFIED_TRUE=>'Phone Number Verified'
		), self::VERIFIED_FALSE);
	}
}