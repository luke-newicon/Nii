<?php 

Class ImportController extends NiiController
{
	public function actionKashflow(){
		$ks = new KashCustomers();
		$kc = $ks->getCustomers();
		dp($kc);
		foreach($kc as $i=>$k){
			$cust = new CrmContact();
			$name = explode(' ', $k->Contact);
			$cust->first_name = (isset($name[0]))?$name[0]:'';
			$cust->last_name = (isset($name[1]))?$name[1]:'';
			$c=false;

			if($cust->first_name != '' || $cust->last_name != ''){
				$cust->type = CrmContact::TYPE_CONTACT;
				$c = $cust->saveCompany($k->Name);
				$cust->type =  CrmContact::TYPE_CONTACT;
				$cust->save(false);
				$c = $cust;
			}else{
				$c = ($c!==false) ? $c : new CrmContact();
				$c->type = CrmContact::TYPE_COMPANY;
				$c->company = $k->Name;
				$c->save(false);
			}
			
			$c->saveEmailAddress($k->Email);

			$c->savePhone($k->Mobile, 'Mobile');
			$c->savePhone($k->Fax,'Fax');
			$c->savePhone($k->Telephone,'Tel');

			$c->saveWebsite($k->Website,'Website');
			$addy = (empty($k->Address1)?'':$k->Address1."\n").(empty($k->Address2)?'':$k->Address2."\n")
				.(empty($k->Address3)?'':$k->Address3."\n").(empty($k->Address4)?'':$k->Address4);
			$c->saveAddress($addy, '',$k->Postcode,'','UK');
			
		}
	}

	public function actionAdd(){

		$c = new CrmContact();
		$c->first_name = 'steve';
		$c->last_name = 'obrien';
		$c->save();
		$e = new CrmEmail();
		$e->address    = 'steve@newicon.net';
		$e->label      = 'home';
		$e->contact_id = $c->id();
		$e->save();

		$a = new CrmAddress();
		$a->contact_id=$c->id();

		$a->save();

		//$c->saveEmailAddress('steve@newicon.net');

	}
}