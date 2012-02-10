<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'trinity.contact':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $givennames
 * @property string $lastname
 * @property string $salutation
 * @property string $dob
 * @property string $gender
 * @property string $email
 * @property string $addr1
 * @property string $addr2
 * @property string $addr3
 * @property string $city
 * @property string $county
 * @property string $country
 * @property string $postcode
 * @property string $tel_primary
 * @property string $tel_secondary
 * @property string $mobile
 * @property string $fax
 */
class Contact extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{contact_contact}}';
	}

	public function getModule() {
		return Yii::app()->getModule('contact');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_type', 'required'),
			array('name, givennames, lastname', 'length', 'max' => 255),
			array('title', 'length', 'max' => 9),
			array('gender', 'length', 'max' => 1),
			array('email, email_secondary', 'length', 'max' => 75),
			array('addr1, addr2, addr3', 'length', 'max' => 100),
			array('city, county, country, tel_primary, tel_secondary, mobile, fax', 'length', 'max' => 50),
			array('postcode', 'length', 'max' => 20),
			array('dob, title, suffix, company_name, contact_name, photoID, comment, city, website, tags, email', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, title, givennames, lastname, suffix, dob, gender, email, addr1, addr2, addr3, city, county, country, postcode, telephone_numbers, tel_primary, tel_secondary, mobile, fax, email_secondary, type, comment, website', 'safe', 'on' => 'search'),
			array('lastname', 'required', 'on' => 'Person'),
			array('company_name, contact_name', 'required', 'on' => 'Organisation'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'photo' => array(self::HAS_ONE, 'NAttachment', 'model_id',
				'condition' => 'photo.model="' . __CLASS__ . '" AND photo.type="contact-thumbnail" '),
		);

		foreach ($this->relations as $name => $relation) {
			if (isset($relation['relation']))
				$relations[$name] = $relation['relation']; 
		}
		return $relations;
	}

	public function getRelations($relations=array()) {
		if (isset($this->module->relations['Contact'])) {
//			foreach ($this->module->relations['Contact'] as $name => $class) {
//				if (is_array($class)) {
//					$relations[$name] = $class['relation'];
//				} else {
//					$relation = new $class;
//					$relations[$name] = $relation;
//				}
//			}
			return $this->module->relations['Contact'];
		} else {
			return array();
		}
	}
	
	public function getAddableTabs() {
		if ($this->relations) {
			foreach ($this->relations as $name => $relation) {
				if ($relation['isAddable']==true) 
					return true;
			}
		}
		return false;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'photo' => 'Photo',
			'title' => 'Title',
			'givennames' => 'Firstname',
			'lastname' => 'Surname',
			'salutation' => 'Salutation/Nickname',
			'suffix' => 'Suffix',
			'dob' => 'DOB',
			'gender' => 'Sex',
			'email' => 'Email - Main',
			'email_secondary' => 'Email - Other',
			'addr1' => 'Address',
			'addr2' => 'Address Line 2',
			'addr3' => 'Address Line 3',
			'city' => 'City',
			'county' => 'County',
			'country' => 'Country',
			'postcode' => 'Postcode',
			'tel_primary' => 'Tel - Home',
			'tel_secondary' => 'Tel - Work',
			'mobile' => 'Tel - Mobile',
			'fax' => 'Fax',
			'website' => 'Website URL',
			'company_name' => 'Company Name',
			'company_position' => 'Position',
			'contact_name' => 'Contact Name',
			'contact_type' => 'Contact Type',
			'type' => 'Relationship',
			'tags' => 'Categories'
		);
	}

	public $type;

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->getDbCriteria();

		$this->getSearchCriteria($criteria);

		//$criteria->with = array('student','staff','academic','cleric','diocese','church','trainingfacility');
		//$criteria->together = true;\

		$sort = new CSort;
		$sort->defaultOrder = 'id DESC';

		return new NActiveDataProvider($this, array(
					'criteria' => $criteria,
					'sort' => $sort,
					'pagination' => array(
						'pageSize' => 20,
					),
				));
	}

	public function getSearchCriteria(&$criteria) {
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('title', $this->title);
		$criteria->compare('givennames', $this->givennames, true);
		$criteria->compare('lastname', $this->lastname, true);
		$criteria->compare('suffix', $this->suffix, true);
		$criteria->compare('dob', $this->dob, true);
		$criteria->compare('gender', $this->gender, true);
		$criteria->compare('CONCAT(email," ",email_secondary)', $this->email, true);
		$criteria->compare('email_secondary', $this->email_secondary, true);
		$criteria->compare('addr1', $this->addr1, true);
		$criteria->compare('addr2', $this->addr2, true);
		$criteria->compare('addr3', $this->addr3, true);
		$criteria->compare('city', $this->city, true);
		$criteria->compare('county', $this->county, true);
		$criteria->compare('country', $this->country, true);
		$criteria->compare('postcode', $this->postcode, true);
		$criteria->compare('CONCAT(tel_primary, " " ,tel_secondary)', $this->telephone_numbers, true);
		$criteria->compare('tel_primary', $this->tel_primary, true);
		$criteria->compare('tel_secondary', $this->tel_secondary, true);
		$criteria->compare('mobile', $this->mobile, true);
		$criteria->compare('fax', $this->fax, true);
		$criteria->compare('website', $this->fax, true);
		$criteria->compare('company_name', $this->company_name, true);
		$criteria->compare('company_position', $this->company_position, true);
		$criteria->compare('contact_name', $this->contact_name, true);
		$criteria->compare('contact_type', $this->contact_type, true);
		$criteria->compare('comment', $this->comment, true);
		return true;
	}
	
//	public function searchGroupContacts($id=null) {
//		
//		$group = NActiveRecord::model('ContactGroup')->findByPk($id);
//		$cgcs = $group->groupContacts;
//		foreach ($cgcs as $key => $cgc)
//			$contacts[$key] = $key;
//		
//		$contactModel = Yii::app()->getModule('contact')->contactModel;
//		$contact = new $contactModel;
//		$criteria = $contact->getDbCriteria();
//
//		$contact->getSearchCriteria($criteria);
//		if (isset($contacts))
//			$criteria->addInCondition('t.id',$contacts);
//		
//		$criteria->join = 'LEFT JOIN contact_group_contact cgc ON (cgc.contact_id = t.id AND cgc.group_id = "'.$id.'")';
//		
//		$sort = new CSort;
//		$sort->defaultOrder = 'id DESC';
//
//		return new NActiveDataProvider($this, array(
//			'criteria' => $criteria,
//			'sort' => $sort,
//			'pagination' => array(
//				'pageSize' => 20,
//			),
//		));
//	}

	public function scopes() {
		return array(
			'emails' => array(
				'condition' => '(email <> "" OR email_secondary <> "") AND t.trashed <> 1',
			),
		);
	}
	
	public function getGridScopes() {
		return array(
			'items' => array(
				'default' => array(
					'label'=>'All',
				),
			),
		);
	}

	public function translateCustomScopes($field=null, $value=null, $sm=null, $op=null, &$criteria) {

		switch ($field) {
			case 'type' :
				if ($sm == '<>')
					$criteria->addCondition($value . '.id IS NULL', $op);
				else
					$criteria->addCondition($value . '.id > 0', $op);
				break;

			default :
				return false;
		}
	}

	public function columns() {
		return array(
//			array(
//				'class'=>'CCheckBoxColumn',
//			),
//			array(
//				'name' => 'photo',
//				'type'=>'raw',
//				'value' => '$data->getContactPhoto()',
//				'exportValue' => '$data->getContactPhotoUrl()',
//				'export'=>false,
//				'filter'=>false,
//				'header' => '',
//				'htmlOptions' => array('width'=>'24px'),
//			),
			array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '$data->getContactLink(null,false)',
				'htmlOptions' => array('width' => '200px'),
			),
			array(
				'name' => 'title',
				'filter' => NActiveRecord::model(Yii::app()->getModule('contact')->contactModel)->getTitlesArray(),
				'htmlOptions' => array('width' => '50px'),
			),
			array(
				'name' => 'givennames',
			),
			array(
				'name' => 'lastname',
			),
			array(
				'name' => 'addr1',
				'htmlOptions' => array('width' => '150px'),
			),
			array(
				'name' => 'addr2',
			),
			array(
				'name' => 'addr3',
			),
			array(
				'name' => 'city',
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'county',
			),
			array(
				'name' => 'country',
				'type' => 'raw',
				'value' => '$data->countryName',
				'filter' => Contact::model()->countriesArray,
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'postcode',
				'htmlOptions' => array('width' => '80px'),
			),
			array(
				'name' => 'email',
				'header' => 'Email(s)',
				'type' => 'raw',
				'value' => '$data->getEmailLinks()',
				'htmlOptions' => array('width' => '150px'),
			),
			array(
				'name' => 'telephone_numbers',
				'type' => 'raw',
				'value' => '$data->getTelephone_numbers()',
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'tel_primary',
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'tel_secondary',
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'mobile',
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'fax',
				'htmlOptions' => array('width' => '120px'),
			),
			array(
				'name' => 'website',
				'type' => 'raw',
				'value' => '$data->getWebsiteLink()',
				'htmlOptions' => array('width' => '120px', 'style' => 'text-align:center'),
			),
			array(
				'name' => 'company_position',
			),
		);

//		Yii::app()->getModule('contact')->getColumns();
	}

	public function getPhoto($type=null, $failOnNoLogo=false) {
		if ($this->photo && $this->photo->file)
			$src = Yii::app()->image->url($this->photo->file->id, $type);
		else {
			if ($failOnNoLogo)
				return null;
			$src = Yii::app()->image->url(0, $type);
		}
		return '<img src="' . $src . '" />';
	}

	public function getContactTypes($contactType='all', $returnNotFound=false) {

		$relationships = self::getRelationships($contactType);

		$r = array();
		foreach ($relationships as $key => $value) :

			if ($this->$key && $returnNotFound == false) {
				$r[] = array('value' => $value, 'key' => $key, 'id' => $id);
			} else if (!$this->$key && $returnNotFound == true) {
				$r[] = array('value' => $value, 'key' => $key);
			}

		endforeach;

		return $r;
	}

	public function getContactTypeList($contactType='all', $returnNotFound=false) {

		if ($rels = $this->getContactTypes($contactType, $returnNotFound)) {
			foreach ($rels as $rel) {
				$r[] = CHtml::link(CHtml::encode($rel['value']), array("contact/view/", "id" => $this->id, "selectedTab" => $rel['key']));
			}
			return implode(', ', $r);
		}
	}

	public function getContactTypeListCsv($contactType='all', $returnNotFound=false) {

		$relationships = self::getRelationships($contactType);

		$r = array();
		foreach ($relationships as $key => $value) {
			if ($this->$key) {
				$r[] = $value;
			}
		}

		return implode(', ', $r);
	}

	public function getContactTypePairs($contactType='all', $returnNotFound=false) {

		if ($rels = $this->getContactTypes($contactType, $returnNotFound)) {
			foreach ($rels as $rel) {
				$r[$rel['key']] = $rel['value'];
			}
			return $r;
		}
	}

	public function getContactLink($tab=null, $showIcon=true) {

		$type = "grid-thumbnail-" . strtolower($this->contact_type);
		$label = $showIcon ? $this->getPhoto($type) . '<span>' . $this->displayName . '</span>' : $this->displayName;
		if ($tab)
			return CHtml::link($label, CHtml::normalizeUrl(array('/contact/admin/view', 'id' => $this->id)).'#'.$tab, array('class' => 'grid-thumb-label'));
		else
			return CHtml::link($label, array('/contact/admin/view', 'id' => $this->id), array('class' => 'grid-thumb-label'));
	}

	public function getContactPhoto($link=true, $tab=null) {
		$type = "grid-thumbnail-" . strtolower($this->contact_type);
		$label = $this->getPhoto($type);
		if ($link) {
			if ($tab)
				return CHtml::link($label, array("view", "id" => $this->id, 'selectedTab' => $tab));
			else
				return CHtml::link($label, array("view", "id" => $this->id));
		}
		else
			return $label;
	}

	public function getContactLinkById($id, $tab=null) {

		$model = Contact::model()->findByPk($id);
		return $model->getContactLink($tab);
	}

	public function getEmailLink($type='home') {

		if ($type == 'work')
			return NHtml::emailLink($this->email_secondary);
		elseif ($type == 'home')
			return NHtml::emailLink($this->email);
	}

	/**
	 * 	Plural version of getEmailLink, returns all email addresses against a contact, comma separated 
	 */
	public function getEmailLinks() {
		return NHtml::emailLink($this->email) . ($this->email_secondary ? ', ' . NHtml::emailLink($this->email_secondary) : '');
	}

	public function getWebsiteLink() {
		$url = $this->website;
		return NHtml::link(str_replace('http://', '', $this->website), 'http://' . str_replace('http://', '', $this->website), array('target' => 'externalLink'));
	}

	public function getFullAddress() {

		$addressLines = array(
			'addr1' => $this->addr1,
			'addr2' => $this->addr2,
			'addr3' => $this->addr3,
			'city' => $this->city,
			'county' => $this->county,
			'postcode' => $this->postcode,
			'country' => $this->countryName,
		);

		$address = array();

		foreach ($addressLines as $addressLine) :
			if ($addressLine)
				$address[] = $addressLine;
		endforeach;

		return implode('<br />', $address);
	}

	public function getAddressFields() {

		$addressLines = array(
			'addr1' => $this->addr1,
			'addr2' => $this->addr2,
			'addr3' => $this->addr3,
		);

		$address = array();

		foreach ($addressLines as $addressLine) :
			if ($addressLine)
				$address[] = $addressLine;
		endforeach;

		return implode('<br />', $address);
	}

	public function getCountryName() {
		$countries = NData::countries();
		if (isset($countries[$this->country]))
			return $countries[$this->country];
		else
			return $this->country;
	}

	public static function getCountriesArray() {
		$countries = NData::countries();
		return $countries;
	}
//	
//	public static function getTitlesArray() {
//		return NHtml::enumItem(NActiveRecord::model(Yii::app()->getModule('contact')->contactModel), 'title');
//	}
	
	public static function getTitlesArray() {
		$titles = NActiveRecord::model(Yii::app()->getModule('contact')->contactModel)->findAll(array('group'=>'title', 'order'=>'title'));
		foreach ($titles as $title) {
			if ($title->title)
				$t[$title->title] = $title->title;
		}
		return $t;
	}

	public function getTelephone_numbers() {
		return
				($this->tel_primary ? '(h) ' . $this->tel_primary : '') .
				($this->tel_primary && $this->tel_secondary ? '<br />' : '') .
				($this->tel_secondary ? '(w) ' . $this->tel_secondary : '');
	}

	public function setTelephone_numbers($value) {
		if ($value)
			$this->telephone_numbers = $value;
	}

	public function createContactDialog() {
		$dialog_id = 'createContactDialog';
		$url = CHtml::normalizeUrl(array('admin/create/', 'dialog' => true));
		return '$("#' . $dialog_id . '").dialog({
			open: function(event, ui){
				$("#' . $dialog_id . '").load("' . $url . '");
			},
			minHeight: 100, position: ["center", 100],
			width: 400,
			autoOpen: true,
			title: "Create a Contact",
			modal: true,
			buttons: [ 
				{
					text: "Continue",
					class: "btn primary",
					click : function () {
						var url = "' . Yii::app()->baseUrl . '/contact/admin/create/type/"+$("#Contact_contact_type").val();
						window.location = url;
						return;
					}
				},
				{
					text: "Cancel",
					click: function() { $(this).dialog("close"); },
					class: "btn",
				}
			],
		});
		return false;';
	}

	public function getDisplayName() {

		if ($this->contact_type == 'Person')
			return $this->title . ' ' . ($this->givennames ? $this->givennames . '  ' : '') . $this->lastname . ($this->suffix ? ' ' . $this->suffix : '');
		else
			return $this->name;
	}
	
	public function nameLikeQuery($term){
		if(Yii::app()->getModule('contact')->displayOrderFirstLast){
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

	public function getComputerUserId() {
		$names = explode(' ', $this->salutation . ' ' . $this->lastname);
		foreach ($names as $name) {
			if (substr($name, 0, 1) != '')
				$initials[] = substr($name, 0, 1);
		}
		return implode('', $initials) . $this->student->id;
	}

	public function getDobFormatted() {
		return date('d M Y', strtotime($this->dob));
	}
	
	public function getCountRelationships() {
		return NRelationship::countRelationships(get_class($this), $this->id);
	}	
	public function getCountNotes() {
		return NNote::model()->countByAttributes(array('model'=>get_class($this), 'model_id'=>$this->id));
	}	
	public function getCountAttachments() {
		return NAttachment::model()->countByAttributes(array('model'=>get_class($this), 'model_id'=>$this->id));
	}

	public function getTabs() {
		/* Get the relations information from the module and convert into tabs */
		foreach ($this->relations as $name => $relation) {
			if ($this->$name) {
				$tabs[$relation['label']] = array('ajax' => array($relation['viewRoute'],'id'=>$this->id()), 'id' => $name);
				if ($relation['notification']) {
					if ($relation['notification'] == true)
						$tabs[$relation['label']]['count'] = count($this->$name);
					else
						$tabs[$relation['label']]['count'] = exec($relation['notification']);
				}
			}
		}

		/* Default tabs */
		$tabs['Relationships'] = array('ajax' => array('generalInfo', 'id' => $this->id()), 'id' => 'relationships', 'count' => $this->countRelationships);
		$tabs['Notes'] = array('ajax' => array('notes', 'id' => $this->id()), 'id' => 'notes', 'count' => $this->countNotes);
		$tabs['Attachments'] = array('ajax' => array('attachments', 'id' => $this->id()), 'id' => 'attachments', 'count' => $this->countAttachments);

		return $tabs;
	}

	public function relationDropDownList() {
		if(count($this->relations)){
			$data = $options = array();
			foreach ($this->relations as $name => $relation) {
				if(!$this->$name && $relation['isAddable']){
					$data[$name] = $relation['label'];
					$options[$name] = array('data-relation-url' => CHtml::normalizeUrl($relation['addRoute']));
				}
			}
			return CHtml::dropDownList('contact-relation', null, $data, array(
				'options' => $options,
				'prompt' => 'Select a contact relation',
			));
		}
	}

	public $dob_day;
	public $dob_month;
	public $dob_year;
	public $changedFields;
	public $photoID;
	public $selectedTab;

	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
//				'title' => "enum('Mr','Mrs','Ms','Miss','Dr','Prof','Revd','Revd Dr','Revd Prof','Revd Canon','Most Revd','Rt Revd','Rt Revd Dr','Venerable','Revd Preb','Pastor','Sister')",
				'title' => "varchar(255)",
				'lastname' => "varchar(255)",
				'salutation' => "varchar(255)",
				'givennames' => "varchar(255)",
				'suffix' => "varchar(100)",
				'dob' => "date",
				'gender' => "enum('M','F')",
				'email' => "varchar(75)",
				'email_secondary' => "varchar(75)",
				'addr1' => "varchar(100)",
				'addr2' => "varchar(100)",
				'addr3' => "varchar(100)",
				'city' => "varchar(50)",
				'county' => "varchar(50)",
				'country' => "varchar(50)",
				'postcode' => "varchar(20)",
				'tel_primary' => "varchar(50)",
				'mobile' => "varchar(50)",
				'tel_secondary' => "varchar(50)",
				'fax' => "varchar(50)",
				'website' => "varchar(255)",
				'comment' => "text",
				'company_name' => "varchar(255)",
				'contact_name' => "varchar(255)",
				'company_position' => "varchar(255)",
				'name' => "varchar(255) NOT NULL",
				'contact_type' => "enum('Person','Organisation')",
				'created_date' => 'datetime',
				'updated_date' => 'datetime',
				'trashed' => "int(1) unsigned NOT NULL",
			),
			'keys' => array());
	}
	
	function behaviors() {
		$behaviors = array(
			'trash'=>array(
				'class'=>'nii.components.behaviors.ETrashBinBehavior',
				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
			),
			'tag'=>array(
               'class'=>'nii.components.behaviors.NTaggable'
           )
		);
		
		return CMap::mergeArray($behaviors, Yii::app()->getModule('contact')->getBehaviorsFor(Yii::app()->getModule('contact')->contactModel));
	}


}