<?php 

Class Nworx_Crm_Model_Address extends Newicon_Db_Row
{
	protected $_tableClass = 'Nworx_Crm_Model_Addresses';

	public function country(){
		$a = Nworx_Crm_Model_Addresses::getCountryArray();
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
}