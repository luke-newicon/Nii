<?php 

Class ImportController extends NiiController
{
	public function actionKashflow(){
		$ks = new Nworx_Kashflow_Model_Customers();
		$kc = $ks->getCustomers();
		//for($i=1; $i<100; $i++){
		foreach($kc as $i=>$k){
			//$k = new Nworx_Kashflow_Model_Customer();
			$cust = new Nworx_Crm_Model_Contact();
			$name = explode(' ', $k->Contact);
			$cust->contact_first_name = (isset($name[0]))?$name[0]:'';
			$cust->contact_last_name = (isset($name[1]))?$name[1]:'';
			$c=false;


			if($cust->contact_first_name != '' || $cust->contact_last_name != ''){
				$cust->contact_type = Nworx_Crm_Model_Contacts::TYPE_CONTACT;
				$c = $cust->saveCompany($k->Name);
				$cust->contact_type =  Nworx_Crm_Model_Contacts::TYPE_CONTACT;
				$c = $cust->save();
			}else{
				$c = ($c!==false) ? $c : new Nworx_Crm_Model_Contact();
				$c->contact_type = Nworx_Crm_Model_Contacts::TYPE_COMPANY;
				$c->company = $k->Name;
				$c->save();
			}
						
			$c->saveEmailAddress($k->Email);
			$c->savePhone($k->Mobile, 'Mobile');
			$c->savePhone($k->Fax,'Fax');
			$c->savePhone($k->Telephone,'Tel');
			
			$c->saveWebsite($k->Website,'Website');
			$addy = (empty($k->Address1)?'':$k->Address1."\n").(empty($k->Address2)?'':$k->Address2."\n")
				.(empty($k->Address3)?'':$k->Address3."\n").(empty($k->Address4)?'':$k->Address4."\n");
			$c->saveAddress($addy, '',$k->Postcode,'','UK');
			
		}
		//}
	}
}