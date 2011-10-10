<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends NController 
{

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/site';

	public function init() {
		
		
		$this->menu = array(
			array('label' => 'Newicon', 'url' => array('/site/index'), 'template'=>'<a style="padding:3px 8px;margin-left:0px;" href="'.NHtml::url('/site/index').'"><img style="padding-top:3px;" alt="Newicon" src="'.Yii::app()->request->baseUrl.'/images/newicon.png" /></a>'),
			array('label' => 'Register', 'url' => array('/user/account/registration')),
			array('label' => 'Login', 'url' => array('/user/account/login')),
		);
		
//		$this->menu = array(
//			array('label' => 'Newicon', 'url' => array('/site/index'), 'template'=>'<a style="padding:3px 8px;margin-left:0px;" href="'.NHtml::url('/site/index').'"><img style="padding-top:3px;" alt="Newicon" src="'.Yii::app()->request->baseUrl.'/images/newicon.png" /></a>'),
//			array('label' => 'Services', 'url' => array('/site/websites')),
//			array('label' => 'Hosting', 'url' => array('/hosting/domain/lookup')),
//			array('label' => 'Blog', 'url' => array('/site/blog')),
//			array('label' => 'Resources', 'url' => array('/site/resources')),
//			array('label' => 'Support', 'url' => array('/site/support')),
//		);
	}
	
/**
         * Returns a nested array of timzones by continant. Suitable for input into
         */
        public static function getTimeZones()
        {
                return array (
                        'Africa' => array (
                                'Africa/Casablanca' => '[GMT+00:00] Western European Time (Africa/ Casablanca)',
                                'Africa/Algiers' => '[GMT+01:00] Central European Time (Africa/ Algiers)',
                                'Africa/Bangui' => '[GMT+01:00] Western African Time (Africa/ Bangui)',
                                'Africa/Windhoek' => '[GMT+01:00] Western African Time (Africa/ Windhoek)',
                                'Africa/Tripoli' => '[GMT+02:00] Eastern European Time (Africa/ Tripoli)',
                                'Africa/Johannesburg' => '[GMT+02:00] South Africa Standard Time (Africa/ Johannesburg)',
                                'Africa/Dar_es_Salaam' => '[GMT+03:00] Eastern African Time (EAT)',
                        ),
                        'America (North & South)' => array (
                                'America/Scoresbysund' => '[GMT-01:00] Eastern Greenland Time (America/ Scoresbysund)',
                                'America/Noronha' => '[GMT-02:00] Fernando de Noronha Time (America/ Noronha)',
                                'America/Argentina/Buenos_Aires' => '[GMT-03:00] Argentine Time (AGT)',
                                'America/Belem' => '[GMT-03:00] Brazil Time (America/ Belem)',
                                'America/Sao_Paulo' => '[GMT-03:00] Brazil Time (BET)',
                                'America/Cayenne' => '[GMT-03:00] French Guiana Time (America/ Cayenne)',
                                'America/Miquelon' => '[GMT-03:00] Pierre & Miquelon Standard Time (America/ Miquelon)',
                                'America/Paramaribo' => '[GMT-03:00] Suriname Time (America/ Paramaribo)',
                                'America/Montevideo' => '[GMT-03:00] Uruguay Time (America/ Montevideo)',
                                'America/Godthab' => '[GMT-03:00] Western Greenland Time (America/ Godthab)',
                                'America/St_Johns' => '[GMT-03:30] Newfoundland Standard Time (America/ St Johns)',
                                'America/Cuiaba' => '[GMT-04:00] Amazon Standard Time (America/ Cuiaba)',
                                'America/Glace_Bay' => '[GMT-04:00] Atlantic Standard Time (America/ Glace Bay)',
                                'America/La_Paz' => '[GMT-04:00] Bolivia Time (America/ La Paz)',
                                'America/Santiago' => '[GMT-04:00] Chile Time (America/ Santiago)',
                                'America/Guyana' => '[GMT-04:00] Guyana Time (America/ Guyana)',
                                'America/Asuncion' => '[GMT-04:00] Paraguay Time (America/ Asuncion)',
                                'America/Caracas' => '[GMT-04:00] Venezuela Time (America/ Caracas)',
                                'America/Porto_Acre' => '[GMT-05:00] Acre Time (America/ Porto Acre)',
                                'America/Havana' => '[GMT-05:00] Central Standard Time (America/ Havana)',
                                'America/Bogota' => '[GMT-05:00] Colombia Time (America/ Bogota)',
                                'America/Jamaica' => '[GMT-05:00] Eastern Standard Time (America/ Jamaica)',
                                'America/Indianapolis' => '[GMT-05:00] Eastern Standard Time (US/ East-Indiana)',
                                'America/Guayaquil' => '[GMT-05:00] Ecuador Time (America/ Guayaquil)',
                                'America/Lima' => '[GMT-05:00] Peru Time (America/ Lima)',
                                'America/El_Salvador' => '[GMT-06:00] Central Standard Time (America/ El Salvador)',
                                'America/Regina' => '[GMT-06:00] Central Standard Time (Canada/ Saskatchewan)',
                                'America/Chicago' => '[GMT-06:00] Central Standard Time (US & Canada)',
                                'America/Phoenix' => '[GMT-07:00] Mountain Standard Time (US/ Arizona)',
                                'America/Los_Angeles' => '[GMT-08:00] Pacific Standard Time (US & Canada)',
                                'America/Anchorage' => '[GMT-09:00] Alaska Standard Time (AST)',
                                'America/Adak' => '[GMT-10:00] Hawaii-Aleutian Standard Time (America/ Adak)',
                        ),
                        'Antarctica' => array (
                                'Antarctica/Syowa' => '[GMT+03:00] Syowa Time (Antarctica/ Syowa)',
                                'Antarctica/Mawson' => '[GMT+06:00] Mawson Time (Antarctica/ Mawson)',
                                'Antarctica/Vostok' => '[GMT+06:00] Vostok Time (Antarctica/ Vostok)',
                                'Antarctica/Davis' => '[GMT+07:00] Davis Time (Antarctica/ Davis)',
                                'Antarctica/DumontDUrville' => '[GMT+10:00] Dumont-d\'Urville Time (Antarctica/ DumontDUrville)',
                                'Antarctica/Rothera' => '[GMT-03:00] Rothera Time (Antarctica/ Rothera)',
                        ),
                        'Asia' => array (
                                'Asia/Jerusalem' => '[GMT+02:00] Israel Standard Time (Asia/ Jerusalem)',
                                'Asia/Baghdad' => '[GMT+03:00] Arabia Standard Time (Asia/ Baghdad)',
                                'Asia/Kuwait' => '[GMT+03:00] Arabia Standard Time (Asia/ Kuwait)',
                                'Asia/Tehran' => '[GMT+03:30] Iran Standard Time (Asia/ Tehran)',
                                'Asia/Aqtau' => '[GMT+04:00] Aqtau Time (Asia/ Aqtau)',
                                'Asia/Yerevan' => '[GMT+04:00] Armenia Time (NET)',
                                'Asia/Baku' => '[GMT+04:00] Azerbaijan Time (Asia/ Baku)',
                                'Asia/Tbilisi' => '[GMT+04:00] Georgia Time (Asia/ Tbilisi)',
                                'Asia/Dubai' => '[GMT+04:00] Gulf Standard Time (Asia/ Dubai)',
                                'Asia/Oral' => '[GMT+04:00] Oral Time (Asia/ Oral)',
                                'Asia/Kabul' => '[GMT+04:30] Afghanistan Time (Asia/ Kabul)',
                                'Asia/Aqtobe' => '[GMT+05:00] Aqtobe Time (Asia/ Aqtobe)',
                                'Asia/Bishkek' => '[GMT+05:00] Kirgizstan Time (Asia/ Bishkek)',
                                'Asia/Karachi' => '[GMT+05:00] Pakistan Time (PLT)',
                                'Asia/Dushanbe' => '[GMT+05:00] Tajikistan Time (Asia/ Dushanbe)',
                                'Asia/Ashgabat' => '[GMT+05:00] Turkmenistan Time (Asia/ Ashgabat)',
                                'Asia/Tashkent' => '[GMT+05:00] Uzbekistan Time (Asia/ Tashkent)',
                                'Asia/Yekaterinburg' => '[GMT+05:00] Yekaterinburg Time (Asia/ Yekaterinburg)',
                                'Asia/Katmandu' => '[GMT+05:45] Nepal Time (Asia/ Katmandu)',
                                'Asia/Almaty' => '[GMT+06:00] Alma-Ata Time (Asia/ Almaty)',
                                'Asia/Thimbu' => '[GMT+06:00] Bhutan Time (Asia/ Thimbu)',
                                'Asia/Novosibirsk' => '[GMT+06:00] Novosibirsk Time (Asia/ Novosibirsk)',
                                'Asia/Omsk' => '[GMT+06:00] Omsk Time (Asia/ Omsk)',
                                'Asia/Qyzylorda' => '[GMT+06:00] Qyzylorda Time (Asia/ Qyzylorda)',
                                'Asia/Colombo' => '[GMT+06:00] Sri Lanka Time (Asia/ Colombo)',
                                'Asia/Rangoon' => '[GMT+06:30] Myanmar Time (Asia/ Rangoon)',
                                'Asia/Hovd' => '[GMT+07:00] Hovd Time (Asia/ Hovd)',
                                'Asia/Krasnoyarsk' => '[GMT+07:00] Krasnoyarsk Time (Asia/ Krasnoyarsk)',
                                'Asia/Jakarta' => '[GMT+07:00] West Indonesia Time (Asia/ Jakarta)',
                                'Asia/Brunei' => '[GMT+08:00] Brunei Time (Asia/ Brunei)',
                                'Asia/Makassar' => '[GMT+08:00] Central Indonesia Time (Asia/ Makassar)',
                                'Asia/Hong_Kong' => '[GMT+08:00] Hong Kong Time (Asia/ Hong Kong)',
                                'Asia/Irkutsk' => '[GMT+08:00] Irkutsk Time (Asia/ Irkutsk)',
                                'Asia/Kuala_Lumpur' => '[GMT+08:00] Malaysia Time (Asia/ Kuala Lumpur)',
                                'Asia/Manila' => '[GMT+08:00] Philippines Time (Asia/ Manila)',
                                'Asia/Shanghai' => '[GMT+08:00] Shanghai Time (Asia/ Shanghai)',
                                'Asia/Singapore' => '[GMT+08:00] Singapore Time (Asia/ Singapore)',
                                'Asia/Taipei' => '[GMT+08:00] Taipei Time (Asia/ Taipei)',
                                'Asia/Ulaanbaatar' => '[GMT+08:00] Ulaanbaatar Time (Asia/ Ulaanbaatar)',
                                'Asia/Choibalsan' => '[GMT+09:00] Choibalsan Time (Asia/ Choibalsan)',
                                'Asia/Jayapura' => '[GMT+09:00] East Indonesia Time (Asia/ Jayapura)',
                                'Asia/Dili' => '[GMT+09:00] East Timor Time (Asia/ Dili)',
                                'Asia/Tokyo' => '[GMT+09:00] Japan Standard Time (JST)',
                                'Asia/Seoul' => '[GMT+09:00] Korea Standard Time (Asia/ Seoul)',
                                'Asia/Yakutsk' => '[GMT+09:00] Yakutsk Time (Asia/ Yakutsk)',
                                'Asia/Sakhalin' => '[GMT+10:00] Sakhalin Time (Asia/ Sakhalin)',
                                'Asia/Vladivostok' => '[GMT+10:00] Vladivostok Time (Asia/ Vladivostok)',
                                'Asia/Magadan' => '[GMT+11:00] Magadan Time (Asia/ Magadan)',
                                'Asia/Anadyr' => '[GMT+12:00] Anadyr Time (Asia/ Anadyr)',
                                'Asia/Kamchatka' => '[GMT+12:00] Petropavlovsk-Kamchatski Time (Asia/ Kamchatka)',
                        ),
                        'Atlantic Ocean' => array (
                                'Atlantic/Jan_Mayen' => '[GMT+01:00] Eastern Greenland Time (Atlantic/ Jan Mayen)',
                                'Atlantic/Azores' => '[GMT-01:00] Azores Time (Atlantic/ Azores)',
                                'Atlantic/Cape_Verde' => '[GMT-01:00] Cape Verde Time (Atlantic/ Cape Verde)',
                                'Atlantic/South_Georgia' => '[GMT-02:00] South Georgia Standard Time (Atlantic/ South Georgia)',
                                'Atlantic/Bermuda' => '[GMT-04:00] Atlantic Standard Time (Atlantic/ Bermuda)',
                                'Atlantic/Stanley' => '[GMT-04:00] Falkland Is. Time (Atlantic/ Stanley)',
                        ),
                        'Australia' => array (
                                'Australia/Perth' => '[GMT+08:00] Western Standard Time (Australia) (Australia/ Perth)',
                                'Australia/Broken_Hill' => '[GMT+09:30] Central Standard Time (Australia/ Broken Hill)',
                                'Australia/Darwin' => '[GMT+09:30] Central Standard Time (Northern Territory) (ACT)',
                                'Australia/Adelaide' => '[GMT+09:30] Central Standard Time (South Australia) (Australia/ Adelaide)',
                                'Australia/Sydney' => '[GMT+10:00] Eastern Standard Time (New South Wales) (Australia/ Sydney)',
                                'Australia/Brisbane' => '[GMT+10:00] Eastern Standard Time (Queensland) (Australia/ Brisbane)',
                                'Australia/Hobart' => '[GMT+10:00] Eastern Standard Time (Tasmania) (Australia/ Hobart)',
                                'Australia/Melbourne' => '[GMT+10:00] Eastern Standard Time (Victoria) (Australia/ Melbourne)',
                                'Australia/Lord_Howe' => '[GMT+10:30] Load Howe Standard Time (Australia/ Lord Howe)',
                        ),
                        'Europe' => array (
                                'Europe/London' => '[GMT+00:00] Greenwich Mean Time (Europe/ London)',
                                'Europe/Lisbon' => '[GMT+00:00] Western European Time (Europe/ Lisbon)',
                                'Europe/Berlin' => '[GMT+01:00] Central European Time (Europe/ Berlin)',
                                'Europe/Istanbul' => '[GMT+02:00] Eastern European Time (Europe/ Istanbul)',
                                'Europe/Moscow' => '[GMT+03:00] Moscow Standard Time (Europe/ Moscow)',
                                'Europe/Samara' => '[GMT+04:00] Samara Time (Europe/ Samara)',
                        ),
                        'Indian' => array (
                                'Indian/Mauritius' => '[GMT+04:00] Mauritius Time (Indian/ Mauritius)',
                                'Indian/Reunion' => '[GMT+04:00] Reunion Time (Indian/ Reunion)',
                                'Indian/Mahe' => '[GMT+04:00] Seychelles Time (Indian/ Mahe)',
                                'Indian/Kerguelen' => '[GMT+05:00] French Southern & Antarctic Lands Time (Indian/ Kerguelen)',
                                'Indian/Maldives' => '[GMT+05:00] Maldives Time (Indian/ Maldives)',
                                'Indian/Chagos' => '[GMT+06:00] Indian Ocean Territory Time (Indian/ Chagos)',
                                'Indian/Cocos' => '[GMT+06:30] Cocos Islands Time (Indian/ Cocos)',
                                'Indian/Christmas' => '[GMT+07:00] Christmas Island Time (Indian/ Christmas)',
                        ),
                        'Pacific Ocean' => array (
                                'Pacific/Palau' => '[GMT+09:00] Palau Time (Pacific/ Palau)',
                                'Pacific/Guam' => '[GMT+10:00] Chamorro Standard Time (Pacific/ Guam)',
                                'Pacific/Port_Moresby' => '[GMT+10:00] Papua New Guinea Time (Pacific/ Port Moresby)',
                                'Pacific/Truk' => '[GMT+10:00] Truk Time (Pacific/ Truk)',
                                'Pacific/Yap' => '[GMT+10:00] Yap Time (Pacific/ Yap)',
                                'Pacific/Kosrae' => '[GMT+11:00] Kosrae Time (Pacific/ Kosrae)',
                                'Pacific/Noumea' => '[GMT+11:00] New Caledonia Time (Pacific/ Noumea)',
                                'Pacific/Ponape' => '[GMT+11:00] Ponape Time (Pacific/ Ponape)',
                                'Pacific/Efate' => '[GMT+11:00] Vanuatu Time (Pacific/ Efate)',
                                'Pacific/Norfolk' => '[GMT+11:30] Norfolk Time (Pacific/ Norfolk)',
                                'Pacific/Fiji' => '[GMT+12:00] Fiji Time (Pacific/ Fiji)',
                                'Pacific/Tarawa' => '[GMT+12:00] Gilbert Is. Time (Pacific/ Tarawa)',
                                'Pacific/Majuro' => '[GMT+12:00] Marshall Islands Time (Pacific/ Majuro)',
                                'Pacific/Nauru' => '[GMT+12:00] Nauru Time (Pacific/ Nauru)',
                                'Pacific/Auckland' => '[GMT+12:00] New Zealand Standard Time (Pacific/ Auckland)',
                                'Pacific/Funafuti' => '[GMT+12:00] Tuvalu Time (Pacific/ Funafuti)',
                                'Pacific/Wake' => '[GMT+12:00] Wake Time (Pacific/ Wake)',
                                'Pacific/Wallis' => '[GMT+12:00] Wallis & Futuna Time (Pacific/ Wallis)',
                                'Pacific/Chatham' => '[GMT+12:45] Chatham Standard Time (Pacific/ Chatham)',
                                'Pacific/Enderbury' => '[GMT+13:00] Phoenix Is. Time (Pacific/ Enderbury)',
                                'Pacific/Tongatapu' => '[GMT+13:00] Tonga Time (Pacific/ Tongatapu)',
                                'Pacific/Kiritimati' => '[GMT+14:00] Line Is. Time (Pacific/ Kiritimati)',
                                'Pacific/Easter' => '[GMT-06:00] Easter Is. Time (Pacific/ Easter)',
                                'Pacific/Galapagos' => '[GMT-06:00] Galapagos Time (Pacific/ Galapagos)',
                                'Pacific/Pitcairn' => '[GMT-08:00] Pitcairn Standard Time (Pacific/ Pitcairn)',
                                'Pacific/Gambier' => '[GMT-09:00] Gambier Time (Pacific/ Gambier)',
                                'Pacific/Marquesas' => '[GMT-09:30] Marquesas Time (Pacific/ Marquesas)',
                                'Pacific/Rarotonga' => '[GMT-10:00] Cook Is. Time (Pacific/ Rarotonga)',
                                'Pacific/Tahiti' => '[GMT-10:00] Tahiti Time (Pacific/ Tahiti)',
                                'Pacific/Fakaofo' => '[GMT-10:00] Tokelau Time (Pacific/ Fakaofo)',
                                'Pacific/Niue' => '[GMT-11:00] Niue Time (Pacific/ Niue)',
                                'Pacific/Apia' => '[GMT-11:00] West Samoa Time (MIT)',
                        ),
                );
        }

}