<?php 

Class Nworx_Crm_Model_Contact extends Nworx_Core_Row
{
	
	private $_createdCompany = false;
	
	public function getCreatedCompany(){
		return $this->_createdCompany;
	}
	
	/**
	 * Looks up a company on name.
	 * - If the compnay exists: attaches it to this contact
	 * - If the company does not exist: creates a new company and attaches it to this contact
	 * - If $companyName is empty it returns false 
	 * 
	 * Also see getCreatedCompany() sets the $this->_createdCompany variable if created a new company
	 * @param string $companyName
	 * @return Nworx_Crm_Model_Contact || false
	 */
	public function saveCompany($companyName){
		if (empty($companyName)) return false;
		if(!$newComp = $this->findCompany($companyName)){
			// no company exists, lets add one!
			$newComp = new Nworx_Crm_Model_Contact();
			$newComp->contact_type = Nworx_Crm_Model_Contacts::TYPE_COMPANY;
			$newComp->contact_company = $companyName;
			$newComp->save();
			$this->_createdCompany = $newComp;
		}
		$this->contact_company_id = $newComp->id();
		return $newComp;
	}
	
	
	
	/**
	 * Adds an email address to the contact
	 * 
	 * @param (string) $emailAddress
	 * @param (string) $emailLabel description e.g. Home, Work
	 * @return Nworx_Crm_Model_Email
	 */
	public function saveEmailAddress($emailAddress, $emailLabel='', $id=null){
		if($this->id()==0)
			throw Newicon_Exception('Can not save data to an empty contact object');
		if(empty($emailAddress)) return false;
		$e = (empty($id)) ? new Nworx_Crm_Model_Email() : new Nworx_Crm_Model_Email($id);
		$e->email_address    = $emailAddress;
		$e->email_label      = $emailLabel;
		$e->email_contact_id = $this->id();
		return $e->save();
	}
	
	/**
	 * Adds a phone number to the contact
	 * 
	 * @param (string) $number the phone number
	 * @param (string) $label description e.g. Home, Work, Office, Mobile
	 * @return Nworx_Crm_Model_Phone
	 */
	public function savePhone($number, $label='', $id=null){
		if($this->id()==0)
			throw Newicon_Exception('Can not save data to an empty contact object');
		if(empty($number)) return false;
		$p = (empty($id)) ? new Nworx_Crm_Model_Phone() : new Nworx_Crm_Model_Phone($id);
		$p->phone_number     = $number;
		$p->phone_label      = $label;
		$p->phone_contact_id = $this->id();
		return $p->save();
	}
	
	/**
	 * Adds a website address to the contact record
	 * 
	 * @param (string) $address the website address
	 * @param (string) $label description e.g. Home, Work, facebook profile, blog
	 * @return Nworx_Crm_Model_Website | false not added
	 */
	public function saveWebsite($address, $label='', $id=null){
		if($this->id()==0)
			throw Newicon_Exception('Can not save data to an empty contact object');
		if(empty($address)) return false;
		$w = (empty($id)) ? new Nworx_Crm_Model_Website() : new Nworx_Crm_Model_Website($id);
		$w->website_address    = $address;
		$w->website_label      = $label;
		$w->website_contact_id = $this->id();
		return $w->save();
	}
	
	/**
	 * Add an address to the contact record
	 * 
	 * @param (string) $lines
	 * @param (string) $city
	 * @param (string) $postcode
	 * @param (string) $county
	 * @param (string) $country The two characater country code
	 * @param (string) $label description e.g. Home, Office, Delivery
	 * @return Nworx_Crm_Model_Address
	 */
	public function saveAddress($lines, $city, $postcode, $county, $country, $label='', $id=null){
		if($this->id()==0)
			throw Newicon_Exception('Can not save data to an empty contact object');
		if(empty($lines) && empty($city) && empty($postcode) && empty($county)) return false;
		$a = (empty($id)) ? new Nworx_Crm_Model_Address() : new Nworx_Crm_Model_Address($id);
		$a->address_lines      = $lines;
		$a->address_city       = $city;
		$a->address_postcode   = $postcode;
		$a->address_county     = $county;
		$a->address_country_id = $country;
		$a->address_label      = $label;
		$a->address_contact_id = $this->id();
		return $a->save();
	}
	
	/**
	 * Returns a contact object for the company
	 * or returns false if none exists
	 * 
	 * @param string $companyName
	 * @return Nworx_Crm_Model_Contact || false
	 */
	public function findCompany($companyName){
		return $this->getTable()->findCompany($companyName);
	}
	
	/**
	 * boolean true or false
	 * 
	 * @return boolean - true if contact is a person false if it is a company
	 */
	public function isPerson(){
		return ($this->contact_type == Nworx_Crm_Model_Contacts::TYPE_CONTACT);
	}
	
	public function isCompany(){
		return ($this->contact_type == Nworx_Crm_Model_Contacts::TYPE_COMPANY);
	}
	
	/**
	 * gets the image for the contact record
	 * 
	 * @param array $options sets the options on the image component class typical usage size=>32
	 * @return string
	 */
	public function getImage($options=array()){
		$i = new Nworx_Crm_Model_Images($options);
		foreach($options as $key=>$val)
			$i->$key = $val;
		return $i->getImage($this);
	}
	
	/**
	 * cache a company contact row associated with this contact
	 * @var unknown_type
	 */
	private $_company;
	
	public function getCompany(){
		if($this->contact_company_id != 0){
			// look up company
			if($this->_company === null){
				if(!$c = $this->getTable()->getCompany($this->contact_company_id))
					return false;
				$this->_company = $c;
			}
			return $this->_company;
		}
		return false;
	}
	
	public function hasCompany(){
		return ($this->getCompany() == true);
	}
	
	public function delete(){
		$this->deleteLinkedData();
		parent::delete();
	}
	
	public function deleteLinkedData(){
		$cs = new Nworx_Crm_Model_Emails();
		$cs->deleteQuery()->where('email_contact_id=?',$this->id())->go();
		$cs = new Nworx_Crm_Model_Phones();
		$cs->deleteQuery()->where('phone_contact_id=?',$this->id())->go();
		$cs = new Nworx_Crm_Model_Websites();
		$cs->deleteQuery()->where('website_contact_id=?',$this->id())->go();
		$cs = new Nworx_Crm_Model_Addresses();
		$cs->deleteQuery()->where('address_contact_id=?',$this->id())->go();
	}
	
	public function name($term=''){
		if($term == '')
			return $this->getNamePartOne().' '.$this->getNamePartTwo();
		
		if(!$this->isPerson())
			return NPage::hilightText($this->contact_company,$term);
		
		if(Nworx_Crm_Crm::get()->displayOrderFirstLast){
			$col1='contact_first_name';	$col2='contact_last_name';
		}else{
			$col1='contact_last_name'; $col2='contact_first_name';
		}
		
		if(strpos($term, ' ') === false) {
			return Nworx::t($this->getNameTemplate(), array(
				$col1=>NPage::hilightText($this->$col1,$term),
				$col2=>NPage::hilightText($this->$col2,$term)
			));
		} else {
			// as soon as there is a space assume firstname *space* lastname
			$t = explode(' ', $term); 
			$arr = array();
			$arr[$col1] = NPage::hilightText($this->$col1,$t[0]);
            if(array_key_exists(1, $t)){
            	$arr[$col2] = NPage::hilightText($this->$col2,$t[1]);
			}
			FB::log($arr,'t arr');
			return Nworx::t($this->getNameTemplate(), $arr);
		}
	}
	
	public function getNamePartOne(){
		if(!$this->isPerson())
			return $this->contact_company;
		return (Nworx_Crm_Crm::get()->displayOrderFirstLast) ? $this->first_name : $this->last_name;
	}
	public function getNamePartTwo(){
		if(!$this->isPerson())
			return '';
		return (Nworx_Crm_Crm::get()->displayOrderFirstLast) ? $this->last_name : $this->first_name;
	}
	
	public function getNameTemplate(){
		$f = (Nworx_Crm_Crm::get()->sortOrderFirstLast)?'<strong>contact_first_name</strong>':'contact_first_name';
		$l = (Nworx_Crm_Crm::get()->sortOrderFirstLast)?'contact_last_name':'<strong>contact_last_name</strong>';
		return (Nworx_Crm_Crm::get()->displayOrderFirstLast)?"$f $l":"$l $f";
	}
}