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

	public static function getCountryArray(){
		return array(
			'AF'=>'Afghanistan',
			'AL'=>'Albania',
			'DZ'=>'Algeria',
			'AS'=>'American Samoa',
			'AD'=>'Andorra',
			'AO'=>'Angola',
			'AI'=>'Anguilla',
			'AQ'=>'Antarctica',
			'AG'=>'Antigua And Barbuda',
			'AR'=>'Argentina',
			'AM'=>'Armenia',
			'AW'=>'Aruba',
			'AU'=>'Australia',
			'AT'=>'Austria',
			'AZ'=>'Azerbaijan',
			'BS'=>'Bahamas',
			'BH'=>'Bahrain',
			'BD'=>'Bangladesh',
			'BB'=>'Barbados',
			'BY'=>'Belarus',
			'BE'=>'Belgium',
			'BZ'=>'Belize',
			'BJ'=>'Benin',
			'BM'=>'Bermuda',
			'BT'=>'Bhutan',
			'BO'=>'Bolivia',
			'BA'=>'Bosnia And Herzegovina',
			'BW'=>'Botswana',
			'BV'=>'Bouvet Island',
			'BR'=>'Brazil',
			'IO'=>'British Indian Ocean Territory',
			'BN'=>'Brunei',
			'BG'=>'Bulgaria',
			'BF'=>'Burkina Faso',
			'BI'=>'Burundi',
			'KH'=>'Cambodia',
			'CM'=>'Cameroon',
			'CA'=>'Canada',
			'CV'=>'Cape Verde',
			'KY'=>'Cayman Islands',
			'CF'=>'Central African Republic',
			'TD'=>'Chad',
			'CL'=>'Chile',
			'CN'=>'China',
			'CX'=>'Christmas Island',
			'CC'=>'Cocos (Keeling) Islands',
			'CO'=>'Columbia',
			'KM'=>'Comoros',
			'CG'=>'Congo',
			'CK'=>'Cook Islands',
			'CR'=>'Costa Rica',
			'CI'=>'Cote D\'Ivorie (Ivory Coast)',
			'HR'=>'Croatia (Hrvatska)',
			'CU'=>'Cuba',
			'CY'=>'Cyprus',
			'CZ'=>'Czech Republic',
			'CD'=>'Democratic Republic Of Congo (Zaire)',
			'DK'=>'Denmark',
			'DJ'=>'Djibouti',
			'DM'=>'Dominica',
			'DO'=>'Dominican Republic',
			'TP'=>'East Timor',
			'EC'=>'Ecuador',
			'EG'=>'Egypt',
			'SV'=>'El Salvador',
			'GQ'=>'Equatorial Guinea',
			'ER'=>'Eritrea',
			'EE'=>'Estonia',
			'ET'=>'Ethiopia',
			'FK'=>'Falkland Islands (Malvinas)',
			'FO'=>'Faroe Islands',
			'FJ'=>'Fiji',
			'FI'=>'Finland',
			'FR'=>'France',
			'FX'=>'France, Metropolitan',
			'GF'=>'French Guinea',
			'PF'=>'French Polynesia',
			'TF'=>'French Southern Territories',
			'GA'=>'Gabon',
			'GM'=>'Gambia',
			'GE'=>'Georgia',
			'DE'=>'Germany',
			'GH'=>'Ghana',
			'GI'=>'Gibraltar',
			'GR'=>'Greece',
			'GL'=>'Greenland',
			'GD'=>'Grenada',
			'GP'=>'Guadeloupe',
			'GU'=>'Guam',
			'GT'=>'Guatemala',
			'GN'=>'Guinea',
			'GW'=>'Guinea-Bissau',
			'GY'=>'Guyana',
			'HT'=>'Haiti',
			'HM'=>'Heard And McDonald Islands',
			'HN'=>'Honduras',
			'HK'=>'Hong Kong',
			'HU'=>'Hungary',
			'IS'=>'Iceland',
			'IN'=>'India',
			'ID'=>'Indonesia',
			'IR'=>'Iran',
			'IQ'=>'Iraq',
			'IE'=>'Ireland',
			'IL'=>'Israel',
			'IT'=>'Italy',
			'JM'=>'Jamaica',
			'JP'=>'Japan',
			'JO'=>'Jordan',
			'KZ'=>'Kazakhstan',
			'KE'=>'Kenya',
			'KI'=>'Kiribati',
			'KW'=>'Kuwait',
			'KG'=>'Kyrgyzstan',
			'LA'=>'Laos',
			'LV'=>'Latvia',
			'LB'=>'Lebanon',
			'LS'=>'Lesotho',
			'LR'=>'Liberia',
			'LY'=>'Libya',
			'LI'=>'Liechtenstein',
			'LT'=>'Lithuania',
			'LU'=>'Luxembourg',
			'MO'=>'Macau',
			'MK'=>'Macedonia',
			'MG'=>'Madagascar',
			'MW'=>'Malawi',
			'MY'=>'Malaysia',
			'MV'=>'Maldives',
			'ML'=>'Mali',
			'MT'=>'Malta',
			'MH'=>'Marshall Islands',
			'MQ'=>'Martinique',
			'MR'=>'Mauritania',
			'MU'=>'Mauritius',
			'YT'=>'Mayotte',
			'MX'=>'Mexico',
			'FM'=>'Micronesia',
			'MD'=>'Moldova',
			'MC'=>'Monaco',
			'MN'=>'Mongolia',
			'MS'=>'Montserrat',
			'MA'=>'Morocco',
			'MZ'=>'Mozambique',
			'MM'=>'Myanmar (Burma)',
			'NA'=>'Namibia',
			'NR'=>'Nauru',
			'NP'=>'Nepal',
			'NL'=>'Netherlands',
			'AN'=>'Netherlands Antilles',
			'NC'=>'New Caledonia',
			'NZ'=>'New Zealand',
			'NI'=>'Nicaragua',
			'NE'=>'Niger',
			'NG'=>'Nigeria',
			'NU'=>'Niue',
			'NF'=>'Norfolk Island',
			'KP'=>'North Korea',
			'MP'=>'Northern Mariana Islands',
			'NO'=>'Norway',
			'OM'=>'Oman',
			'PK'=>'Pakistan',
			'PW'=>'Palau',
			'PA'=>'Panama',
			'PG'=>'Papua New Guinea',
			'PY'=>'Paraguay',
			'PE'=>'Peru',
			'PH'=>'Philippines',
			'PN'=>'Pitcairn',
			'PL'=>'Poland',
			'PT'=>'Portugal',
			'PR'=>'Puerto Rico',
			'QA'=>'Qatar',
			'RE'=>'Reunion',
			'RO'=>'Romania',
			'RU'=>'Russia',
			'RW'=>'Rwanda',
			'SH'=>'Saint Helena',
			'KN'=>'Saint Kitts And Nevis',
			'LC'=>'Saint Lucia',
			'PM'=>'Saint Pierre And Miquelon',
			'VC'=>'Saint Vincent And The Grenadines',
			'SM'=>'San Marino',
			'ST'=>'Sao Tome And Principe',
			'SA'=>'Saudi Arabia',
			'SN'=>'Senegal',
			'SC'=>'Seychelles',
			'SL'=>'Sierra Leone',
			'SG'=>'Singapore',
			'SK'=>'Slovak Republic',
			'SI'=>'Slovenia',
			'SB'=>'Solomon Islands',
			'SO'=>'Somalia',
			'ZA'=>'South Africa',
			'GS'=>'South Georgia And South Sandwich Islands',
			'KR'=>'South Korea',
			'ES'=>'Spain',
			'LK'=>'Sri Lanka',
			'SD'=>'Sudan',
			'SR'=>'Suriname',
			'SJ'=>'Svalbard And Jan Mayen',
			'SZ'=>'Swaziland',
			'SE'=>'Sweden',
			'CH'=>'Switzerland',
			'SY'=>'Syria',
			'TW'=>'Taiwan',
			'TJ'=>'Tajikistan',
			'TZ'=>'Tanzania',
			'TH'=>'Thailand',
			'TG'=>'Togo',
			'TK'=>'Tokelau',
			'TO'=>'Tonga',
			'TT'=>'Trinidad And Tobago',
			'TN'=>'Tunisia',
			'TR'=>'Turkey',
			'TM'=>'Turkmenistan',
			'TC'=>'Turks And Caicos Islands',
			'TV'=>'Tuvalu',
			'UG'=>'Uganda',
			'UA'=>'Ukraine',
			'AE'=>'United Arab Emirates',
			'UK'=>'United Kingdom',
			'US'=>'United States',
			'UM'=>'United States Minor Outlying Islands',
			'UY'=>'Uruguay',
			'UZ'=>'Uzbekistan',
			'VU'=>'Vanuatu',
			'VA'=>'Vatican City (Holy See)',
			'VE'=>'Venezuela',
			'VN'=>'Vietnam',
			'VG'=>'Virgin Islands (British)',
			'VI'=>'Virgin Islands (US)',
			'WF'=>'Wallis And Futuna Islands',
			'EH'=>'Western Sahara',
			'WS'=>'Western Samoa',
			'YE'=>'Yemen',
			'YU'=>'Yugoslavia',
			'ZM'=>'Zambia',
			'ZW'=>'Zimbabwe'
		);
	}

}