<?php

/**
 * This is the model class for table "nworx_crm__address".
 *
 * The followings are the available columns in table 'nworx_crm__address':
 * @property string $id
 * @property string $lines
 * @property string $city
 * @property string $postcode
 * @property string $county
 * @property string $country_id
 * @property string $label
 * @property string $contact_id
 * @property string $verified
 */
class CrmAddress extends CrmActiveRecord
{

	public function init(){
		$this->country_id = 'UK';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmAddress the static model class
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
		return '{{crm_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_id','required'),
			array('lines, city, postcode, county', 'NOneRequiredValidator'),
			array('city, county, label', 'length', 'max'=>250),
			array('postcode, country_id', 'length', 'max'=>10),
			array('contact_id', 'length', 'max'=>11),
			array('verified', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lines, city, postcode, county, country_id, label, verified', 'safe', 'on'=>'search'),
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
			'contact'=>array(self::BELONGS_TO, 'CrmContact', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lines' => 'Lines',
			'city' => 'City',
			'postcode' => 'Postcode',
			'county' => 'County',
			'country_id' => 'Country',
			'label' => 'Label',
			'contact_id' => 'Contact',
			'verified' => 'Verified',
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
		$criteria->compare('lines',$this->lines,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('verified',$this->verified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}



	public function country(){
		$a = self::getCountryArray();
		if(isset($this->address_country_id)){
			return $a[$this->address_country_id];
		}
		return '';
	}

	public function mapLink($directions=false){
		$l = ($directions)?'daddr=':'q=';
		$l .= str_replace("\n",' ',$this->lines)
			. NData::param($this->city,'','',',+')
			. NData::param($this->postcode,'','',',+')
			. NData::param($this->country(),'','',',+');
		return 'http://www.google.com/maps?f=q&'.$l;
	}

	public function address(){
		$a = NData::param(nl2br($this->lines),'','<br/>');
		$a .= NData::param($this->city,'','<br/>')
			.NData::param($this->postcode,'','<br/>')
			.NData::param($this->county,'','<br/>')
			.NData::param($this->country(),'','<br/>');
		return $a;
	}


	/**
	 * This function is not used yet but seems useful
	 * @param <type> $ipAddr
	 * @return <type>
	 */
	public function getCountryCityFromIP($ipAddr){
		//function to find country and city from IP address
		//Developed by Roshan Bhattarai [url]http://roshanbh.com.np[/url]

		//verify the IP address for the
		ip2long($ipAddr)== -1 || ip2long($ipAddr) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";
		$ipDetail=array(); //initialize a blank array

		//get the XML result from hostip.info
		$xml = file_get_contents("http://api.hostip.info/?ip=".$ipAddr);

		//get the city name inside the node <gml:name> and </gml:name>
		preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si",$xml,$match);

		//assing the city name to the array
		$ipDetail['city']=$match[2];

		//get the country name inside the node <countryName> and </countryName>
		preg_match("@<countryName>(.*?)</countryName>@si",$xml,$matches);

		//assign the country name to the $ipDetail array
		$ipDetail['country']=$matches[1];

		//get the country name inside the node <countryName> and </countryName>
		preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si",$xml,$cc_match);
		$ipDetail['country_code']=$cc_match[1]; //assing the country code to array

		//return the array containing city, country and country code
		return $ipDetail;

	}
	
	public static function getAddressLabels(){
		return self::getLabels(__CLASS__, array(
			'Home'=>array('title'=>''),
			'Work'=>array('title'=>''),
			'Office'=>array('title'=>''),
			'Other'=>array('title'=>''),
		));
	}

	public static function getCountryArray(){
		return require(Yii::getPathOfAlias('crm.models.countries').'.php');
	}

	public static function install($className=__CLASS__){
		parent::install($className);
	}

	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'lines'=>'text',
				'city'=>'string',
				'postcode'=>'string',
				'county'=>'string',
				'country_id'=>'int',
				'label'=>'string',
				'contact_id'=>'int',
				'verified'=>'boolean'
			),
			'keys'=>array(
				array('contact_id')
			),
			'foreignKeys'=>array(
				array('crm_address_contact', 'contact_id', 'crm_contact', 'id', 'CASCADE', 'CASCADE')
			)
		);
	}
	
}