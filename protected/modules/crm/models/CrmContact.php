<?php

/**
 * This is the model class for table "pm__nworx_crm_contacts".
 *
 * The followings are the available columns in table 'pm__nworx_crm_contacts':
 * @property int $id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $company
 * @property int $company_id
 * @property enum $type
 * @property int $user_id
 *
 * The followings are the available model relations:
 * @property addresses[] $CrmAddress
 * @property emails[] $CrmEmail
 * @property phones[] $CrmPhone
 * @property websites[] $CrmWebsite
 * @property user $User
 */
class CrmContact extends NAppRecord
{
	const TYPE_CONTACT = 'CONTACT';
	const TYPE_COMPANY = 'COMPANY';
	const TYPE_USER = 'USER';

	public function init(){
		$this->onAfterDelete = array($this,'deleteLinkedData');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @return CrmContact
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "{{crm_contact}}";//'{{crm_contact}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name', 'nii.components.validators.NOneRequiredValidator', 'message'=>'You must enter a first or last name'),
			array('title', 'length', 'max'=>50),
			array('first_name, last_name, company', 'length', 'max'=>250),
			array('company_id', 'length', 'max'=>11),
			array('type', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, first_name, last_name, company, company_id, type, user_id', 'safe', 'on'=>'search'),
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
			'contacts'=> array(self::HAS_MANY, 'CrmContact', 'company_id'),
			'company'=>array(self::BELONGS_TO, 'CrmContact', 'company_id'),
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
			// this relation has not yet been tested
			'groups' => array(self::MANY_MANY, 'CrmGroup', 'crm_group_contact(contact_id, group_id)'),
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
	 * @return CrmEmail
	 */
	public function saveEmailAddress($emailAddress, $emailLabel='', $id=null){
		if(empty($emailAddress)) return false;
		$e = (empty($id)) ? new CrmEmail() : CrmEmail::model()->findByPk($id);
		$e->address    = $emailAddress;
		$e->label      = $emailLabel;
		$e->contact_id = $this->id();

		return $e->save() ? $e : false;
	}

	/**
	 * Adds a phone number to the contact
	 *
	 * @param (string) $number the phone number
	 * @param (string) $label description e.g. Home, Work, Office, Mobile
	 * @return CrmPhone | false on failure to save
	 */
	public function savePhone($number, $label='', $id=null){
		if(empty($number)) return false;
		$p = (empty($id)) ? new CrmPhone() : CrmPhone::model()->findByPk($id);
		$p->number     = $number;
		$p->label      = $label;
		$p->contact_id = $this->id();
		return $p->save() ? $p : false;
	}

	/**
	 * Adds a website address to the contact record
	 *
	 * @param (string) $address the website address
	 * @param (string) $label description e.g. Home, Work, facebook profile, blog
	 * @return Nworx_Crm_Model_Website | false not added
	 */
	public function saveWebsite($address, $label='', $id=null){
		if(empty($address)) return false;
		$w = (empty($id)) ? new CrmWebsite() : CrmWebsite::model()->findByPk($id);
		$w->address    = $address;
		$w->label      = $label;
		$w->contact_id = $this->id();
		return $w->save() ? $w : false;
	}

	/**
	 * Add an address to the contact record
	 *
	 * @param (string) $attrbutes array of key => value pairs associated with CrmAddress
	 * @return CrmAddress
	 */
	public function saveAddress(array $attributes, $id=null){
		$a = (empty($id)) ? new CrmAddress() : CrmAddress::model()->findByPk($id);
		$a->attributes = $attributes;
		$a->contact_id = $this->id();
		return $a->save() ? $a : false;
	}

	/**
	 * Add an address to the contact record
	 *
	 * @param (string) $attrbutes array of key => value pairs associated with CrmAddress
	 * @param (string) $model the model name of the object e.g. CrmAddress
	 * @return CrmAddress
	 */
	public function saveContactObject(array $attributes, $model, $id=null){
		if (empty($id)){
			$a = new $model();
		}else{
			$m = call_user_func(array($model,'model'));
			$a = $m->findByPk($id);
		}
		$a->attributes = $attributes;
		$a->contact_id = $this->id();
		return $a->save() ? $a : false;
	}


	/**
	 * boolean true or false
	 *
	 * @return boolean - true if contact is a person false if it is a company
	 */
	public function isPerson(){
		return ($this->type == self::TYPE_CONTACT || $this->type == self::TYPE_USER);
	}

	public function isCompany(){
		return ($this->type == self::TYPE_COMPANY);
	}


	/**
	 * cache a company contact row associated with this contact
	 * @var CrmContact
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

	
	public function scopes(){
		return array(
			'people'=>array(
				'condition'=>'type=:contact',
				'params'=>array(':contact'=>self::TYPE_CONTACT)
			),
			'companies'=>array(
				'condition'=>'type=:company',
				'params'=>array(':company'=>self::TYPE_COMPANY)
			),
			'users'=>array(
				'condition'=>'type=:users',
				'params'=>array(':users'=>self::TYPE_USER)
			)
		);
	}

	public function orderByName(){
		if(Yii::app()->getModule('crm')->sortOrderFirstLast){
			$order = 'first_name, last_name, company';
		}else{
			$order = 'last_name, first_name, company';
		}
		$this->getDbCriteria()->mergeWith(array(
//			'select'=>"*, CONCAT($name, company) AS order_name",
			'order'=>$order
		));
		return $this;
	}

	public function sortName(){
		if(!$this->isPerson())
			return $this->company;
		if(Yii::app()->getModule('crm')->sortOrderFirstLast)
			return $this->first_name .' '.$this->last_name;
		else
			return $this->last_name .' '.$this->first_name;
	}
	
	/**
	 * name and company search scope
	 * @param string $term
	 * @return CrmContact 
	 */
	public function nameLike($term='', $useAnd=true){
		$this->getDbCriteria()->mergeWith($this->nameLikeQuery($term),$useAnd);
		return $this;
	}
	
	public function nameLikeQuery($term){
		if(Yii::app()->getModule('crm')->displayOrderFirstLast){
			$col1='first_name';	$col2='last_name';
		}else{
			$col1='last_name'; $col2='first_name';
		}
		$p = array(':t0'=>"%$term%");
		if(strpos($term, ' ') === false) {
			$q = "($col1 like :t0 or $col2 like :t0)";
		} else {
			// as soon as there is a space assume firstname *space* lastname
			$name = explode(' ', $term);
			$t1 = trim($name[0]);
			$t2 = array_key_exists(1, $name) ? trim($name[1]) : '';
			$p[':t1'] = "%$t1%";
			$p[':t2'] = "%$t2%";
			
			$q = "($col1 like :t1 AND $col2 like :t2) or ($col1 like :t2 AND $col2 like :t1)";
		}
		$q .= " or company like :t0";
		return array(
			'condition'=>$q,
			'params'=>$p,
		);
	}
	
	public function emailLike($email, $useAnd=true){
		$this->getDbCriteria()->mergeWith(array(
			'with'=>array('emails'=>array(
				// only get user if has an email
				'joinType'=>'INNER JOIN')
			),
			'condition'=>'emails.address like :q',
			'params'=>array(':q'=>"%$email%"),
		),$useAnd);
		return $this;
	}

	/**
	 *
	 * 
	 * @param type $group
	 * @return CrmContact 
	 */
	public function group($group=''){
		// built in groups
		if($group=='people')
			return $this->people();
		if($group=='companies')
			return $this->companies();
		if($group=='users')
			return $this->users();
		if($group=='all')
			return $this;
		if($group!=''){
			// assume the group is the group id
			// get all members of group
			$tblGroup = CrmGroupContact::model()->tableName();
			$this->getDbCriteria()->mergeWith(array(
				//SELECT * FROM `crm_contact` WHERE id in (select contact_id from crm_group_contact where group_id = 1)
				'condition'=>"id in (select contact_id from $tblGroup where group_id = :g)",
				'params'=>array(':g'=>$group),
			));
		}
		return $this;
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


	public function deleteLinkedData(){
		CrmEmail::model()->deleteAll('contact_id=:id',array(':id'=>$this->id()));
		CrmPhone::model()->deleteAll('contact_id=:id',array(':id'=>$this->id()));
		CrmWebsite::model()->deleteAll('contact_id=:id',array(':id'=>$this->id()));
		CrmAddress::model()->deleteAll('contact_id=:id',array(':id'=>$this->id()));
	}



	public function name($term=''){
		if($term == ''){
			return trim($this->getNamePartOne().' '.$this->getNamePartTwo());
		}

		if(!$this->isPerson())
			return NHtml::hilightText($this->company,$term);

		if(CrmModule::get()->displayOrderFirstLast){
			$col1='first_name';	$col2='last_name';
		}else{
			$col1='last_name'; $col2='first_name';
		}

		if(strpos($term, ' ') === false) {
			return NData::replace($this->getNameTemplate(), array(
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
			return NData::replace($this->getNameTemplate(), $arr);
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
	
	/**
	 * return the route to the crm detail page for this contact
	 * The returned route has NOT been normalised
	 * @return array route
	 */
	public function getUrl(){
		return array('/crm/detail/index','id'=>$this->id());
	}
	
	/**
	 * Return the contacts primary email address
	 * This function will also look for the email address from within the user table
	 * 
	 * @return string | null if no email address exists for the contact
	 */
	public function getPrimaryEmail(){
		if($this->type == CrmContact::TYPE_USER){
			// if the contact has a user account
			// get the email from the user account
			if(($user = $this->user)===null)
				return null;
			return $user->email;
		}else{
			return empty($this->emails) ? null : $this->emails[0]->address;
		}
	}
	

	public function definition(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'title'=>'string',
				'first_name'=>'string',
				'last_name'=>'string',
				'company'=>'string',
				'company_id'=>'integer unsigned',
				'type'=>'enum("'.self::TYPE_CONTACT.'","'.self::TYPE_COMPANY.'","'.self::TYPE_USER.'") NOT NULL DEFAULT \'CONTACT\'',
				'user_id'=>'integer unsigned'
			),
			'extra'=>'ENGINE=InnoDB',
			'keys'=>array(
				array('company_id','company_id'),
				array('user_id','user_id'),
			)
		);
	}

	public function __get($name){
		if($name == 'name'){
			return $this->name();
		}
		return parent::__get($name);
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'title'=>'string',
				'first_name'=>'string',
				'last_name'=>'string',
				'company'=>'string',
				'type'=>"enum('CONTACT','COMPANY','USER') NOT NULL DEFAULT 'CONTACT'",
				'company_id'=>'int',
				'user_id'=>'int'
			),
			'keys'=>array(
				array('company_id'),
				array('user_id')
			)
		);
	}
	
}