<?php 

Class Nworx_Crm_Model_Contacts extends Newicon_Db_Table
{
	const TYPE_CONTACT = 'CONTACT';
	const TYPE_COMPANY = 'COMPANY';
	
	public function configure(){
		$this->hasColumn('contact_id', 'primary');
		$this->hasColumn('contact_title','varchar',50);
		$this->hasColumn('contact_first_name','varchar',250);
		$this->hasColumn('contact_last_name','varchar',250);
		$this->hasColumn('contact_company', 'varchar', 250);
		$this->hasColumn('contact_company_id', 'int', 11);
		//$this->hasColumn('contact_job_title');
		$this->hasColumnEnum('contact_type',array(
			self::TYPE_CONTACT=>'Contact',
			self::TYPE_COMPANY=>'Company'
		),self::TYPE_CONTACT);
		
		$this->hasMany('emails','Nworx_Crm_Model_Emails','email_contact_id','contact_id');
		$this->hasMany('phones','Nworx_Crm_Model_Phones','phone_contact_id','contact_id');
		$this->hasMany('websites','Nworx_Crm_Model_Websites','website_contact_id','contact_id');
		$this->hasMany('addresses','Nworx_Crm_Model_Addresses','address_contact_id','contact_id');
		
		$this->hasMany('contacts','Nworx_Crm_Model_Contacts','contact_company_id','contact_id');
		
	}
	
	/**
	 * Returns a contact object for the company
	 * or returns false if none exists
	 * 
	 * @param string $companyName
	 * @return Nworx_Crm_Model_Contact || false
	 */
	public function findCompany($companyName){
		return $this->select()
			->where('contact_company=?',$companyName)
			->where('contact_type=?',self::TYPE_COMPANY)
			->goGetRow();
	}
	
	/**
	 * returns a company based on the contact id
	 * @param $id
	 * @return unknown_type
	 */
	public function getCompany($id){
		try{
			return new Nworx_Crm_Model_Contact($id);
		}catch(Newicon_Db_Exception_RowNotFound $e){
			return false;
		}
	}
	
	/**
	 * builds a typical contact query
	 * and orders by name
	 * @return Newicon_Db_Query
	 */
	public function getContactsQ(){
		if(Yii::app()->getModule('crm')->sortOrderFirstLast) 
				$this->
			$q = $this->select('*, CONCAT(contact_first_name, contact_company) AS name');
		else
			$q = $this->select('*, CONCAT(contact_last_name, contact_company) AS name');
		$q->limit(100);
		return $q->order('name');
	}
	
	public function getContactsWhereNameLike($term=''){
		if(Nworx_Crm_Crm::get()->displayOrderFirstLast){
			$col1='contact_first_name';	$col2='contact_last_name';
		}else{
			$col1='contact_last_name'; $col2='contact_first_name';
		}
		$q = $this->getContactsQ();
		$q->limit(200);
		if($term!=''){
			if(strpos($term, ' ') === false) {
				$q->where($col1.' LIKE ?',"%$term%",1);
				$q->orWhere($col2.' LIKE ?',"%$term%",1);
			} else {
				// as soon as there is a space assume firstname *space* lastname
				$name = explode(' ', $term);
				$q->where($col1.' LIKE ?',"%{$name[0]}%",1);
	            if(array_key_exists(1, $name)){
				    $q->where($col2.' LIKE ?',"%{$name[1]}%",1);
				}
			}
			$q->orWhere('contact_company like ?',"%$term%");
			$q->limit(200);
		}
		return $q;
	}

	public function addGroupFilter(Newicon_Db_Query $q, $group){
		// built in groups
		if($group=='people')
			$q->where('contact_type = ?',self::TYPE_CONTACT);
		if($group=='companies')
			$q->where('contact_type = ?',self::TYPE_COMPANY);
	}
	
	public function getContacts(){
		return $this->getContactsQ()->go();
	}

	public function getCompanys(){
		return $this->select()->where('contact_type = ?',self::TYPE_COMPANY)->go();
	}
	
}