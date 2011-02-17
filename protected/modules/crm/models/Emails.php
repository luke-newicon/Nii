<?php 

Class Nworx_Crm_Model_Emails extends Newicon_Db_Table
{
	const VERIFIED_FALSE = 0;
	const VERIFIED_TRUE = 1;
	
	public function configure(){
		$this->hasColumn('email_id', 'primary');
		$this->hasColumn('email_contact_id', 'int', 11);
		$this->hasColumn('email_address', 'varchar', 250);
		$this->hasColumn('email_label', 'varchar', 250);
		$this->hasColumnEnum('email_verified', array(
			self::VERIFIED_FALSE=>'Email Unverified',
			self::VERIFIED_TRUE=>'Email Verified'
		),self::VERIFIED_FALSE);
	}
}