<?php

/**
 * This is the model class for table "trinity.contact".
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
class Contact extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
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
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, contact_type', 'required'),
			array('name, givennames, lastname', 'length', 'max'=>255),
			array('title', 'length', 'max'=>9),
			array('gender', 'length', 'max'=>1),
			array('email', 'length', 'max'=>75),
			array('addr1, addr2, addr3', 'length', 'max'=>100),
			array('city, county, country, tel_primary, tel_secondary, mobile, fax', 'length', 'max'=>50),
			array('postcode', 'length', 'max'=>20),
			array('dob, title, company_name, contact_name, photoID, comment, city', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, title, givennames, lastname, dob, gender, email, addr1, addr2, addr3, city, county, country, postcode, tel_primary, tel_secondary, mobile, fax, type, comment', 'safe', 'on'=>'search'),
			array('givennames, lastname','required','on'=>'Person'),
			array('company_name, contact_name','required','on'=>'Organisation'),
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
			'photo'=>array(self::HAS_ONE, 'NAttachment', 'model_id',
				'condition' => 'photo.model="'.__CLASS__.'" AND photo.type="contact-thumbnail" '),		
			'student'=>array(self::HAS_ONE, 'Student', 'contact_id'),		
			'staff'=>array(self::HAS_ONE, 'Staff', 'contact_id'),		
			'academic'=>array(self::HAS_ONE, 'Academic', 'contact_id'),	
			'cleric'=>array(self::HAS_ONE, 'Cleric', 'contact_id'),	
			'diocese'=>array(self::HAS_ONE, 'Diocese', 'contact_id'),	
			'church'=>array(self::HAS_ONE, 'Church', 'contact_id'),
			'trainingfacility'=>array(self::HAS_ONE, 'Trainingfacility', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'photo' => 'Photo',
			'title' => 'Title',
			'givennames' => 'Firstname',
			'lastname' => 'Surname',
			'salutation' => 'Salutation/Nickname',
			'dob' => 'DOB',
			'gender' => 'Sex',
			'email' => 'Email',
			'addr1' => 'Address',
			'addr2' => 'Address Line 2',
			'addr3' => 'Address Line 3',
			'city' => 'City',
			'county' => 'County',
			'country' => 'Country',
			'postcode' => 'Postcode',
			'tel_primary' => 'Tel - Primary',
			'tel_secondary' => 'Tel - Secondary',
			'mobile' => 'Mobile',
			'fax' => 'Fax',
			'website' => 'Website URL',
			'company_name' => 'Company Name',
			'contact_name' => 'Contact Name',
			'contact_type' => 'Contact Type',
			'type' => 'Relationship',
		);
	}

	
	public $type;
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('givennames',$this->givennames,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('salutation',$this->salutation,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('addr1',$this->addr1,true);
		$criteria->compare('addr2',$this->addr2,true);
		$criteria->compare('addr3',$this->addr3,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('tel_primary',$this->tel_primary,true);
		$criteria->compare('tel_secondary',$this->tel_secondary,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('website',$this->fax,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_type',$this->contact_type,true);
		$criteria->compare('comment',$this->comment,true);

		if ($this->type) {
			$criteria->addCondition($this->type.'.id > 0');
		}		
		
		//$criteria->with = array('student','staff','academic','cleric','diocese','church','trainingfacility');
		//$criteria->together = true;
		
		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,	
			'pagination'=>array(
				'pageSize'=>20,
            ),
		));
	}
	
	public function scopes() {
		return array(
			'students'=>array(
				'condition'=>'student.id > 0',
				'with'=>array('student'),
			),
			'academics'=>array(
				'condition'=>'academic.id > 0',
				'with'=>array('academic'),
			),
		);
	}
	
	public function translateCustomScopes($field=null, $value=null, $sm=null, $op=null, &$criteria) {
		
		switch ($field) {
			case 'type' :
				if ($sm=='<>')
					$criteria->addCondition($value.'.id IS NULL', $op);
				else
					$criteria->addCondition($value.'.id > 0', $op);
				break;
				
			default :
				return false;
		}
	}
	
	public function columns($visibleColumns) {
		return array(
//			array(
//				'class'=>'CCheckBoxColumn',
//			),
//			array(
//				'name' => 'photo',
//				'type'=>'raw',
//				'value' => '$data->getContactPhoto()',
//	//				'exportValue' => '$data->getContactPhotoUrl()',
//				'visible'=>$visibleColumns['photo'],
//				'export'=>false,
//				'filter'=>false,
//				'header' => '',
//				'htmlOptions' => array('width'=>'24px'),
//			),
			array(
				'name' => 'name',
				'type'=>'raw',
				'value' => '$data->getContactLink(null,false)',
				'visible'=>$visibleColumns['name'],
				'htmlOptions'=>array('width'=>'200px'),
			),
			array(
				'name'=>'title',
				'visible'=>$visibleColumns['title'],
				'filter'=> NHtml::enumItem($this, 'title'),
				'htmlOptions'=>array('width'=>'50px'),
			),
			array(
				'name'=>'givennames',
				'visible'=>$visibleColumns['givennames'],
			),
			array(
				'name'=>'lastname',
				'visible'=>$visibleColumns['lastname'],
			),
//			array(
//				'name'=>'type',
//				'type'=>'raw',
//				'value' => '$data->getContactTypeList($data->contact_type)',
//				'exportValue' => '$data->getContactTypeListCsv($data->contact_type)',
//				'visible'=>$visibleColumns['type'],
//				'filter'=>$this->getRelationships(),
//				'htmlOptions'=>array('width'=>'150px'),
//			),
			array(
				'name'=>'addr1',
				'visible'=>$visibleColumns['addr1'],
			),
//			array(
//				'name'=>'addr2',
//				'visible'=>$visibleColumns['addr2'],
//			),
//			array(
//				'name'=>'addr3',
//				'visible'=>$visibleColumns['addr3'],
//			),
			array(
				'name'=>'city',
				'visible'=>$visibleColumns['city'],
				'htmlOptions'=>array('width'=>'120px'),
			),
			array(
				'name'=>'county',
				'visible'=>$visibleColumns['county'],
			),
			array(
				'name'=>'country',
				'visible'=>$visibleColumns['country'],
			),
			array(
				'name'=>'postcode',
				'visible'=>$visibleColumns['postcode'],
				'htmlOptions'=>array('width'=>'70px'),
			),
			array(
				'name'=>'email',
				'type'=>'raw',
				'value'=>'$data->getEmailLink()',
				'visible'=>$visibleColumns['email'],
				'htmlOptions'=>array('width'=>'150px'),
			),
			array(
				'name' => 'tel_primary',
				'visible'=>$visibleColumns['tel_primary'],
				'htmlOptions'=>array('width'=>'100px','style'=>'text-align:center'),
			),
//			array(
//				'name' => 'tel_secondary',
//				'visible'=>$visibleColumns['tel_secondary'],
//				'htmlOptions'=>array('width'=>'80px','style'=>'text-align:center'),
//			),
//			array(
//				'name' => 'mobile',
//				'visible'=>$visibleColumns['mobile'],
//				'htmlOptions'=>array('width'=>'80px','style'=>'text-align:center'),
//			),
			array(
				'name' => 'fax',
				'visible'=>$visibleColumns['fax'],
				'htmlOptions'=>array('width'=>'80px','style'=>'text-align:center'),
			),
			array(
				'name' => 'website',
				'visible'=>$visibleColumns['website'],
				'htmlOptions'=>array('width'=>'120px','style'=>'text-align:center'),
			),
//			array(
//				'name' => 'comment',
//				'visible'=>$visibleColumns['comment'],
//			),
		);
	}
	
	public function getPhoto($type=null, $failOnNoLogo=false){
		if($this->photo && $this->photo->file)
			$src = Yii::app()->image->url($this->photo->file->id,$type);
		else {
			if ($failOnNoLogo)
				return null;
			$src = Yii::app()->image->url(0,$type);
		}
		return '<img src="'.$src.'" />';
	}
	
	public static function getRelationships($contactType='all') {
		
		$all = array();
		
		$Person = array(
			'student' => 'Student',
			'academic' => 'Academic',
			'staff' => 'Staff',
			'cleric' => 'Cleric',
		);
		
		$Organisation = array(
			'diocese' => 'Diocese',
			'church' => 'Church',
			'trainingfacility' => 'Training Facility'
		);
		
		$all = array_merge($all, $Person);
		$all = array_merge($all, $Organisation);
		
		return $$contactType;
	}
	
	public function getContactTypes($contactType='all',$returnNotFound=false) {
		
		$relationships = self::getRelationships($contactType);
		
		$r = array();
		foreach ($relationships as $key => $value) :
			
			if ($this->$key && $returnNotFound == false) {
				$r[] = array('value'=>$value, 'key'=>$key, 'id'=>$id);
			} else if (!$this->$key && $returnNotFound == true) {
				$r[] = array('value'=>$value, 'key'=>$key);
			}

		endforeach;
		
		return $r;
	}
	
	public function getContactTypeList($contactType='all',$returnNotFound=false) {
				
		if ($rels = $this->getContactTypes($contactType, $returnNotFound)) {
			foreach ($rels as $rel) {
				$r[] = CHtml::link(CHtml::encode($rel['value']), array("contact/view/","id"=>$this->id,"selectedTab"=>$rel['key']));
			}	
			return implode(', ',$r);
		}
			
	}
	
	public function getContactTypeListCsv($contactType='all',$returnNotFound=false) {
				
		$relationships = self::getRelationships($contactType);
		
		$r = array();
		foreach ($relationships as $key => $value) {
			if ($this->$key) {
				$r[] = $value;
			}
		}
		
		return implode(', ',$r);
			
	}
	
	public function getContactTypePairs($contactType='all',$returnNotFound=false) {
				
		if ($rels = $this->getContactTypes($contactType, $returnNotFound)) {
			foreach ($rels as $rel) {
				$r[$rel['key']] = $rel['value'];
			}	
			return $r;
		}
			
	}
	
	public function getLiveProgrammes() {
		
		$programmes = Programme::model()->findAll(array('order'=>'name'));
		$return = array();
		foreach ($programmes as $p) {
			$return[$p->id] = $p->name;
		}
		return $return;
		
	}
	
	public function getContactLink($tab=null, $showIcon=true) {
		
		$type = "grid-thumbnail-".strtolower($this->contact_type);
		$label = $showIcon ? $this->getPhoto($type) . '<span>'.$this->displayName.'</span>' : $this->displayName;
		if ($tab)
			return CHtml::link($label, array("view","id"=>$this->id, 'selectedTab'=>$tab),array('class'=>'grid-thumb-label'));
		else
			return CHtml::link($label, array("view","id"=>$this->id),array('class'=>'grid-thumb-label'));

	}
	
	public function getContactPhoto($link=true, $tab=null) {
		$type = "grid-thumbnail-".strtolower($this->contact_type);
		$label = $this->getPhoto($type);
		if ($link) {
			if ($tab)
				return CHtml::link($label, array("view","id"=>$this->id, 'selectedTab'=>$tab));
			else
				return CHtml::link($label, array("view","id"=>$this->id));
		}
		else
			return $label;
	}
	
	
	public function getContactLinkById($id, $tab=null) {
		
		$model = Contact::model()->findByPk($id);
		return $model->getContactLink($tab);

	}
		
	public function getEmailLink() {
		return NHtml::emailLink($this->email);
	}
	
	public function getFullAddress() {
		
		$addressLines = array(
			'addr1'=>$this->addr1,
			'addr2'=>$this->addr2,
			'addr3'=>$this->addr3,
			'city'=>$this->city,
			'county'=>$this->county,
			'postcode'=>$this->postcode,
			'country'=>$this->country,
		);
		
		$address = array();
		
		foreach ($addressLines as $addressLine) :
			if ($addressLine) $address[] = $addressLine;
		endforeach;
		
		return implode('<br />', $address);
		
	}
	
	public function getAddressFields() {
		
		$addressLines = array(
			'addr1'=>$this->addr1,
			'addr2'=>$this->addr2,
			'addr3'=>$this->addr3,
		);
		
		$address = array();
		
		foreach ($addressLines as $addressLine) :
			if ($addressLine) $address[] = $addressLine;
		endforeach;
		
		return implode('<br />', $address);
		
	}
	
	public function addRelationshipDialog() {
		$dialog_id = 'addRelationshipDialog';
		$url = CHtml::normalizeUrl(array('/contact/addRelationship/','id'=>$this->id));
		return '$("#'.$dialog_id.'").dialog({
			open: function(event, ui){
				$("#'.$dialog_id.'").load("'.$url.'");
			},
			minHeight: 100, position: ["center", 100],
			width: 400,
			autoOpen: true,
			title: "Add a Relationship",
			modal: true,
		});
		return false;';
	}
	
	public static function addProgrammeDialog($id) {
		$dialog_id = 'addProgrammeDialog';
		$url = CHtml::normalizeUrl(array('/contact/addProgramme/','id'=>$id));
		return '$("#'.$dialog_id.'").dialog({
			open: function(event, ui){
				$("#'.$dialog_id.'").load("'.$url.'");
			},
			minHeight: 100, position: ["center", 100],
			width: 600,
			autoOpen: true,
			title: "Add a Programme of Study",
			modal: true,
		});
		return false;';
	}
	
	public function getDisplayName() {
		
		if ($this->contact_type == 'Person')
			return $this->title . ' ' . ($this->givennames ? $this->givennames . '  ':'') . $this->lastname; 
		else 
			return $this->name;
		
	}
	
	public function getComputerUserId() {
		$names = explode(' ',$this->salutation . ' ' . $this->lastname);
		foreach ($names as $name) {
			if (substr($name, 0,1) != '')
				$initials[] = substr($name, 0,1);
		}
		return implode('', $initials) . $this->student->id;
	}
	
	public function getDobFormatted() {
		return date('d M Y',strtotime($this->dob));
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
				'title' => "enum('Mr','Mrs','Ms','Miss','Dr','Prof','Revd','Revd Dr','Revd Prof','Revd Canon','Most Revd','Rt Revd','Rt Revd Dr','Venerable','Revd Preb','Pastor','Sister')",
				'lastname' => "varchar(255)",
				'salutation' => "varchar(255)",
				'givennames' => "varchar(255)",
				'dob' => "date",
				'gender' => "enum('M','F')",
				'email' => "varchar(75)",
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
				'name' => "varchar(255) NOT NULL",
				'contact_type' => "enum('Person','Organisation')",
				'trashed' => "int(1) unsigned NOT NULL",
			), 
			'keys' => array());
	}
}