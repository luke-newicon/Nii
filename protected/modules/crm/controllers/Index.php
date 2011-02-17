<?php

Class Nworx_Crm_Controller_Index extends Nworx_Core_Controller {

	public function init() {
		// Only logged in people can see pages within this file.
		Nworx::auth()->doAuth();

		$f = new Nworx_Crm_Model_Form_Contact();
	}

	public function indexAction() {
		$c = new Nworx_Crm_Model_Contacts();
		$this->view->contacts = $c->getContacts();
		$this->view->term = '';
		$this->view->render();
	}

	public function getContactFormAction($cid=null) {
		extract($this->getEditContactObjects($cid));
		echo $this->view->renderPartial('edit-contact', array('f' => $f, 'c' => $c), true);
	}

	/**
	 * creates the contact form and populates it appropriately
	 * returns an array of f=>the form object, c=>the contact object
	 * the contact object can be either a new record or an existing record depending on
	 * the value passed to $cid or false if the contact record was not found
	 * 
	 * @param int $cid the contact_id of the contact
	 * @return array f=>Newicon_Form, c=>Nworx_Crm_Model_Contact || false
	 */
	public function getEditContactObjects($cid=null) {
		$f = new Nworx_Crm_Model_Form_Contact();
		$f->setFormAction('crm/index/edit-contact/' . $cid);
		if ($cid === null) {
			// load a blank form and a new contact
			$c = new Nworx_Crm_Model_Contact();
		} else {
			// load a pre filled form and the specified contact for edit
			try {
				$c = new Nworx_Crm_Model_Contact($cid);
			} catch (Newicon_Db_Exception_RowNotFound $e) {
				$c = false;
			}
			$f->populateFromContact($c);
		}
		return array('f' => $f, 'c' => $c);
	}

	/**
	 * Handles Add and Edit form actions
	 * 
	 * If cid is null then it will create a new contact based on post data.
	 * If cid is a valid contact record it will update the record.
	 * 
	 * @param int $cid contact_id
	 * @return string json array 
	 */
	public function editContactAction($cid=null) {
		extract($this->getEditContactObjects($cid));
		$card = false;
		$html = false;
		$ret = array();
		$valid = ($f->isValidPost() && $c !== false);
		if ($valid) {
			$f->populateContactFromForm($c);
			$card = $this->loadComponent('crm/card', array('contact' => $c))->render();
		} else {
			$html = $this->view->renderPartial('edit-contact', array('f' => $f, 'c' => $c), true);
		}

		$compData = false;
		if ($company = $c->getCreatedCompany()) {
			$companyCard = $this->loadComponent('crm/card', array('contact' => $company))->render();
			$compData = array('id' => $company->id(), 'card' => $companyCard);
		}

		echo CJSON::encode(array(
			'valid' => $valid, 'form' => $html, 'id' => $c->id(), 'card' => $card, 'createdCompany' => $compData
		));
	}

	public function lookupCompanyAction() {
		$t = $this->getRequest()->getParam('term', '');
		$c = new Nworx_Crm_Model_Contacts();
		$cs = $c->select()->where('contact_company like ?', "%$t%")->go();
		$arr = array();
		foreach ($cs as $c) {
			$l = Newicon_Html::hilightText($c->contact_company, $t);
			$arr[] = array('label' => $l, 'value' => $c->contact_company);
		}
		echo CJSON::encode($arr);
	}

	public function deleteAction($contactId) {
		$c = new Nworx_Crm_Model_Contact($contactId);
		$c->delete();
		echo CJSON::encode(true);
	}

	public function findContactAction($term='', $group='') {
		$cs = new Nworx_Crm_Model_Contacts();
		$q = $cs->getContactsWhereNameLike($term);
		$cs->addGroupFilter($q, $group);

		$contacts = $q->go();
		echo $this->view->renderPartial('user-list', array('contacts' => $contacts, 'term' => $term), true);
	}

	public function findContactAlphaAction($letter){
		$cs = new Nworx_Crm_Model_Contacts();
		$q = $cs->getContactsQ();

		if(Nworx_Crm_Crm::get()->sortOrderFirstLast){
			$col = 'contact_first_name';
		}else{
			$col = 'contact_last_name';
		}
		$q->where("$col like ?","$letter%");
		$q->orWhere('contact_company like ?',"$letter%");
		foreach(range($letter,'Z') as $l){
			if($letter==$l) continue;
			$q->orWhere("$col like ?","$l%");
			$q->orWhere('contact_company like ?',"$l%");
		}
		

		echo $this->view->renderPartial('user-list', array('contacts' => $q->go(), 'term' => ''), true);
	}



	public function facebookAction(){


		$config = array(
			'adapter'   => 'Zend_Http_Client_Adapter_Curl',
			'curloptions' => array(CURLOPT_FOLLOWLOCATION => true),
		);
		$client = new Zend_Http_Client('https://www.facebook.com/search.php?q=luke.spencer@newicon.net&type=all&init=srp', $config);
		$html = $client->request()->getBody();
		
		require_once Nworx::path('vendors/phpQuery/phpQuery/phpQuery.php','/');
		phpQuery::newDocument($html);
		$li = pq('#content ul.uiList li.objectListItem');
		if($li->length() == 1){
			//found facebook user. scrape their id
			$profileLink = $li->find('a')->attr('href');
			$fbId = str_replace(array('http://www.facebook.com/','profile.php?id='),'',$profileLink);
			echo $fbId;
		}

		// echo curl('http://www.facebook.com/search.php?q=dan.deluca@newicon.net&type=all&init=srp');
	}

	public function facebookLookupAction($id){
		$c = new Nworx_Crm_Model_Contact($id);
		$e = $c->emails[0]->address;
		$config = array(
			'adapter'   => 'Zend_Http_Client_Adapter_Curl',
			'curloptions' => array(CURLOPT_FOLLOWLOCATION => true),
		);
		$client = new Zend_Http_Client('https://www.facebook.com/search.php?q='.$e.'&type=all&init=srp', $config);
		$html = $client->request()->getBody();

		require_once Nworx::path('vendors/phpQuery/phpQuery/phpQuery.php','/');
		phpQuery::newDocument($html);
		$li = pq('#content ul.uiList li.objectListItem');
		if($li->length() == 1){
			//found facebook user. scrape their id
			$profileLink = $li->find('a')->attr('href');
			$fbId = str_replace(array('http://www.facebook.com/','profile.php?id='),'',$profileLink);
			echo $fbId;
		}
	}


}