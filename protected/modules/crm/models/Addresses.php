<?php 

Class Nworx_Crm_Model_Addresses extends Newicon_Db_Table
{
	const VERIFIED_FALSE = 0;
	const VERIFIED_TRUE = 1;
	
	protected $_rowClass = 'Nworx_Crm_Model_Address';
	
	public function configure(){
		$this->hasColumn('address_id', 'primary');
		$this->hasColumn('address_lines', 'text');
		$this->hasColumn('address_city', 'varchar', 250);
		$this->hasColumn('address_postcode', 'varchar', 10);
		$this->hasColumn('address_county', 'varchar', 250);
		$this->hasColumn('address_country_id', 'varchar', 10);
		$this->hasColumn('address_label', 'varchar', 250);
		$this->hasColumn('address_contact_id', 'int', 11);
		$this->hasColumnEnum('address_verified',array(
			self::VERIFIED_FALSE=>'Address Unverified',
			self::VERIFIED_TRUE=>'Address Verified'
		), self::VERIFIED_FALSE);
	}
	
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