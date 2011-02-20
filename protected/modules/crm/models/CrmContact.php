<?php

/**
 * This is the model class for table "pm__nworx_crm_contacts".
 *
 * The followings are the available columns in table 'pm__nworx_crm_contacts':
 * @property string $id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $company
 * @property string $company_id
 * @property string $type
 *
 * The followings are the available model relations:
 * @property addresses[] $CrmAddress
 * @property emails[] $CrmEmail
 * @property phones[] $CrmPhone
 * @property websites[] $CrmWebsite
 */
class CrmContact extends CActiveRecord
{

	const TYPE_CONTACT = 'CONTACT';
	const TYPE_COMPANY = 'COMPANY';

	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmContacts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{nii_crm__contact}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>50),
			array('first_name, last_name, company', 'length', 'max'=>250),
			array('company_id', 'length', 'max'=>11),
			array('type', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, first_name, last_name, company, company_id, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'addresses' => array(self::HAS_MANY, 'CrmAddress', 'contact_id'),
			'emails' => array(self::HAS_MANY, 'CrmEmail', 'contact_id'),
			'phones' => array(self::HAS_MANY, 'CrmPhone', 'contact_id'),
			'websites' => array(self::HAS_MANY, 'CrmWebsite', 'contact_id'),
			'contacts'=> array(self::HAS_MANY, 'CrmContact', 'company_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Contact',
			'title' => 'Contact Title',
			'first_name' => 'Contact First Name',
			'last_name' => 'Contact Last Name',
			'company' => 'Contact Company',
			'company_id' => 'Contact Company',
			'type' => 'Contact Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}


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
	 * @return CrmContact || false
	 */
	public function saveCompany($companyName){
		if (empty($companyName)) return false;
		if(!$newComp = $this->findCompany($companyName)){
			// no company exists, lets add one!
			$newComp = new CrmContact();
			$newComp->type = self::TYPE_COMPANY;
			$newComp->company = $companyName;
			$newComp->save();
			$this->_createdCompany = $newComp;
		}
		$this->company_id = $newComp->id();
		return $newComp;
	}


	/**
	 * Returns a contact object for the company
	 * or returns false if none exists
	 * 
	 * @param string $companyName
	 * @return CrmContact || null
	 */
	public function findCompany($companyName){
		return CrmContact::model()->find('company=:c and type=:t',
			array(':c'=>$companyName,':t'=>self::TYPE_COMPANY)
		);
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
		$a->lines      = $lines;
		$a->city       = $city;
		$a->postcode   = $postcode;
		$a->county     = $county;
		$a->country_id = $country;
		$a->label      = $label;
		$a->contact_id = $this->primaryKey();
		return $a->save();
	}


	/**
	 * boolean true or false
	 *
	 * @return boolean - true if contact is a person false if it is a company
	 */
	public function isPerson(){
		return ($this->type == self::TYPE_CONTACT);
	}

	public function isCompany(){
		return ($this->type == self::TYPE_COMPANY);
	}


	/**
	 * cache a company contact row associated with this contact
	 * @var unknown_type
	 */
	private $_company;

	public function getCompany(){
		if($this->company_id != 0){
			// look up company
			if($this->_company === null){
				if(!$c = self::model()->findByPk($this->company_id))
					return false;
				$this->_company = $c;
			}
			return $this->_company;
		}
		return false;
	}

	/**
	 * returns a company based on the contact id or null
	 * @param $id
	 * @return CrmModel | null
	 */
	public function getCompany($id){
		return self::model()->find('id=:id and type=:type',array(':id'=>$id,':type'=>self::TYPE_COMPANY));
	}
	
	/**
	 * builds a typical contact query
	 * and orders by name
	 * @return Newicon_Db_Query
	 */
	public function getContactsQ(){
		$q = new CDbCriteria();
		if(Yii::app()->getModule('crm')->sortOrderFirstLast) 
			$q = self::model()-> $this->select('*, CONCAT(contact_first_name, contact_company) AS name');
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
	
	public function hasCompany(){
		return ($this->getCompany() == true);
	}

	public function delete(){
		$this->deleteLinkedData();
		parent::delete();
	}

	public function deleteLinkedData(){
		$cs = new Nworx_Crm_Model_Emails();
		$cs->deleteQuery()->where('contact_id=?',$this->id())->go();
		$cs = new Nworx_Crm_Model_Phones();
		$cs->deleteQuery()->where('contact_id=?',$this->id())->go();
		$cs = new Nworx_Crm_Model_Websites();
		$cs->deleteQuery()->where('contact_id=?',$this->id())->go();
		$cs = new Nworx_Crm_Model_Addresses();
		$cs->deleteQuery()->where('contact_id=?',$this->id())->go();
	}



	public function name($term=''){
		if($term == '')
			return $this->getNamePartOne().' '.$this->getNamePartTwo();

		if(!$this->isPerson())
			return NHtml::hilightText($this->company,$term);

		if(CrmModule::get()->displayOrderFirstLast){
			$col1='first_name';	$col2='last_name';
		}else{
			$col1='last_name'; $col2='first_name';
		}

		if(strpos($term, ' ') === false) {
			return Yii::t($this->getNameTemplate(), array(
				$col1=>NHtml::hilightText($this->$col1,$term),
				$col2=>NHtml::hilightText($this->$col2,$term)
			));
		} else {
			// as soon as there is a space assume firstname *space* lastname
			$t = explode(' ', $term);
			$arr = array();
			$arr[$col1] = NHtml::hilightText($this->$col1,$t[0]);
            if(array_key_exists(1, $t)){
            	$arr[$col2] = NHtml::hilightText($this->$col2,$t[1]);
			}
//			FB::log($arr,'t arr');
			return Yii::t($this->getNameTemplate(), $arr);
		}
	}
	
	public function getNamePartOne(){
		if(!$this->isPerson())
			return $this->company;
		return (CrmModule::get()->displayOrderFirstLast) ? $this->first_name : $this->last_name;
	}

	public function getNamePartTwo(){
		if(!$this->isPerson())
			return '';
		return (Yii::app()->getModule('crm')->displayOrderFirstLast) ? $this->last_name : $this->first_name;
	}

	public function getNameTemplate(){
		$f = (CrmModule::get()->sortOrderFirstLast)?'<strong>first_name</strong>':'first_name';
		$l = (CrmModule::get()->sortOrderFirstLast)?'last_name':'<strong>last_name</strong>';
		return (CrmModule::get()->displayOrderFirstLast)?"$f $l":"$l $f";
	}

	public function id(){
		return $this->getPrimaryKey();
	}

	
	public function populateAttributes($array){
		if(($this->type == self::TYPE_COMPANY) 
		|| ($array['company'] != '' && empty($array['first_name']) && empty($array['last_name']))){
			// must be saving a company
			$this->type = self::TYPE_COMPANY;
			$this->company = $array['company'];
		}else{
			$this->title      = $array['title'];
			$this->first_name = $array['first_name'];
			$this->last_name  = $array['last_name'];
			$this->saveCompany($array['company']);
		}
		
	}
}