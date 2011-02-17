<?php 

Class Nworx_Crm_Model_Form_Contact extends Newicon_Form
{
	public function configure(){
		$this->setName('contactForm');
		
		$gen = new Newicon_Form();
		$gen->setName('general');
		$gen->setFormLabel('General');
		$gen->addFieldHidden('title');
		$gen->addFieldText('first_name')->setHint('First')->addClass('ui-corner-off');
		$gen->addFieldText('last_name')->setHint('Last');
		$gen->addFieldText('company')->setHint('Company');
		$this->addSubForm($gen);
		
		$this->addSubForm(new Newicon_Form(array('name'=>'email')));
		$this->addSubForm(new Newicon_Form(array('name'=>'phone')));
		$this->addSubForm(new Newicon_Form(array('name'=>'website')));
		$this->addSubForm(new Newicon_Form(array('name'=>'address')));
		
		$this->buildFromPost();
		
		$this->addFieldSubmit('save')->addClass('btn btnN')->setValue('Save');
	}
	
	public function addEmailSubForm($key){
		$e = new Newicon_Form(array('name'=>$key));
		$e->addFieldHidden('label')->setValue('Home');
		$e->addFieldHidden('id');
		$e->addFieldText('address')->setHint('Email')->setAsEmail();
		$this->email->addSubForm($e);
		return $e;
	}
	public function addPhoneSubForm($key){
		$p = new Newicon_Form(array('name'=>$key));
		$p->addFieldHidden('label')->setValue('Home');
		$p->addFieldHidden('id');
		$p->addFieldText('number')->setHint('Phone');
		$this->phone->addSubForm($p);
		return $p;
	}
	public function addWebsiteSubForm($key){
		$w = new Newicon_Form(array('name'=>$key));
		$w->addFieldHidden('label')->setValue('Website');
		$w->addFieldHidden('id');
		$w->addFieldText('address')->setHint('Website');
		$this->website->addSubForm($w);
		return $w;
	}
	public function addAddressSubForm($key){
		$a = new Newicon_Form(array('name'=>$key));
		$a->addFieldHidden('label')->setValue('Home');
		$a->addFieldHidden('id');
		$a->addFieldTextarea('lines')->setAutoResize(true,30,100)->setHint('Street');
		$a->addFieldText('city')->setHint('City');
		$a->addFieldText('postcode')->setHint('Postcode');
		$a->addFieldText('county')->setHint('County');
		$a->addFieldSelect('country')
			->setOptions(Nworx_Crm_Model_Addresses::getCountryArray())
			->setValue('UK');
		$this->address->addSubForm($a);
		return $a;
	}
	
	public function buildFromPost(){
		$r = Nworx::request();
		// email
		foreach($r->getPost('email',array('default')) as $key=>$dontCare){
			$this->addEmailSubForm($key);
		}
		// phones
		foreach($r->getPost('phone',array('default')) as $key=>$dontCare){
			$this->addPhoneSubForm($key);
		}
		// websites
		foreach($r->getPost('website',array('default')) as $key=>$dontCare){
			$this->addWebsiteSubForm($key);
		}
		// addresses
		foreach($r->getPost('address',array('default')) as $key=>$dontCare){
			$this->addAddressSubForm($key);
		}
	}
	
	
	public function populateFromContact(Nworx_Crm_Model_Contact $contact){
		$this->general->populateFromRow($contact);
		if($contact->hasCompany()){
			$this->general->company->value = $contact->getCompany()->contact_company;
		}
		foreach($contact->emails as $key=>$row){
			$e = $this->addEmailSubForm($key);
			$e->populateFromRow($row);
		}
		foreach($contact->phones as $key=>$row){
			$p = $this->addPhoneSubForm($key);
			$p->populateFromRow($row);
		}
		foreach($contact->websites as $key=>$row){
			$w = $this->addWebsiteSubForm($key);
			$w->populateFromRow($row);
		}
		foreach($contact->addresses as $key=>$row){
			$a = $this->addAddressSubForm($key);
			$a->populateFromRow($row);
		}
	}
	
	public function populateContactFromForm(Nworx_Crm_Model_Contact $c) {
		$g = $this->general;
		// either a new compny or a new contact or editing existing contact
		if(($c->contact_type == Nworx_Crm_Model_Contacts::TYPE_COMPANY) 
		|| ($g->company->value != '' && empty($g->first_name->value) && empty($g->last_name->value))){
			// must be saving a company
			$c->contact_type = Nworx_Crm_Model_Contacts::TYPE_COMPANY;
			$c->contact_company = $g->company->value;
		}else{
			$c->contact_title      = $g->title->value;
			$c->contact_first_name = $g->first_name->value;
			$c->contact_last_name  = $g->last_name->value;
			$c->saveCompany($g->company->value);
		}
		$c->save();
		
		// emails
		$cs = new Nworx_Crm_Model_Emails();
		$cs->deleteQuery()->where('email_contact_id=?',$c->id())->go();
		foreach($this->email->getSubForms() as $e){
			$c->saveEmailAddress($e->address->value, $e->label->value);
		}
		// phones
		$cs = new Nworx_Crm_Model_Phones();
		$cs->deleteQuery()->where('phone_contact_id=?',$c->id())->go();
		foreach($this->phone->getSubForms() as $p){
			$c->savePhone($p->number->value, $p->label->value);
		}
		// websites
		$cs = new Nworx_Crm_Model_Websites();
		$cs->deleteQuery()->where('website_contact_id=?',$c->id())->go();
		foreach($this->website->getSubForms() as $w){
			$c->saveWebsite($w->address->value, $w->label->value);
		}
		// addresses
		$cs = new Nworx_Crm_Model_Addresses();
		$cs->deleteQuery()->where('address_contact_id=?',$c->id())->go();
		foreach($this->address->getSubForms() as $a){
			$c->saveAddress($a->lines->value, $a->city->value, $a->postcode->value, $a->county->value, 
				$a->country->value, $a->label->value
			);
		}
	}


	public function getEmailLabels(){
		$t = new Nworx_Crm_Model_Emails();
		return $this->labelArray(
			$t->select('DISTINCT email_label')->go(),
			array(
				'Home'=>array('title'=>''),
				'Work'=>array('title'=>''),
				'Other'=>array('title'=>'')
			)
		);
	}

	public function getAddressLabels(){
		$t = new Nworx_Crm_Model_Addresses();
		return $this->labelArray(
			$t->select('DISTINCT address_label')->go(),
			array(
				'Home'=>array('title'=>''),
				'Work'=>array('title'=>''),
				'Other'=>array('title'=>'')
			)
		);
	}

	public function getPhoneLabels(){
		$t = new Nworx_Crm_Model_Phones();
		return $this->labelArray(
			$t->select('DISTINCT phone_label')->go(),
			array(
				'Home'=>array('title'=>''),
				'Mobile'=>array('title'=>''),
				'Work'=>array('title'=>''),
				'Tel'=>array('title'=>''),
				'Fax'=>array('title'=>'')
			)
		);
	}

	public function getWebsiteLabels(){
		$t = new Nworx_Crm_Model_Websites();
		return $this->labelArray(
			$t->select('DISTINCT website_label')->go(),
			array(
				'Website'=>array('title'=>'enter A web address'),
				'Facebook'=>array('title'=>'enter a Facebook profile address e.g. "http://www.facebook.com/markzuckerberg"'),
				'LinkedIn'=>array('title'=>'enter a Linkedin profile address like "http://www.linkedin.com/in/profilename" or "http://www.linkedin.com/compnay/newicon"'),
				'Twitter'=>array('title'=>''),
				'Blog'=>array('title'=>'')
			)
		);
	}

	public function labelArray($rowset, $defaultsArray){
		$tmp=array();
		foreach($rowset as $l){
			if(empty($l->label)) continue;
			$tmp[$l->label] = $l->label;
		}
		return array_merge($tmp, array_combine(array_keys($defaultsArray), array_values($defaultsArray)));
	}

}