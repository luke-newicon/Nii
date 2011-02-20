<?php
class IndexController extends NiiController
{

	public function init() {
		// Only logged in people can see pages within this file.
//		Nworx::auth()->doAuth();
//
//		$f = new Nworx_Crm_Model_Form_Contact();
	}

	public function actionIndex() {
		$contacts = CrmContact::model()->findAll();
		$this->render('index',array(
			'term'=>'',
			'contacts'=>$contacts
		));
	}

	public function actionGetContactForm($cid=null) {
		$c = CrmContact::model()->findByPk($cid);
		if(!$c) $c = new CrmContact();
		echo $this->render('_edit-contact', array('c' => $c), true);
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
	public function actionEditContact($cid=null) {
		
		$card = false;
		$html = false;
		$ret = array();
		
		$c = CrmContact::model()->findByPk($cid);
		if($cid!==null){
			$c = CrmContact::model()->findByPk($cid);
			if($c !== null){
				//found contact
				echo 'found!';
			}
		}else{
			//add contact
			
		}
		$c = new CrmContact();
		$c->populateAttributes($_POST['CrmContact']);
		$c->save();
		
		CrmEmail::model()->deleteAll('contact_id=:id',array(':id'=>$cid));
		foreach($_POST['CrmEmail'] as $i => $v){
			
			$e = new CrmEmail;
			$e->attributes = $_POST['CrmEmail'][$i];
			$e->contact_id = $cid;
			$e->save(false);
		}

	
		if ($c->validate()) {
			$card = $this->widget('crm.components.CrmCard', array('contact' => $c),true);
		} else {
			$html = $this->render('_edit-contact', array('c' => $c), true);
		}

		$compData = false;
		if (($company = $c->getCreatedCompany())) {
			$companyCard = $this->widget('crm.components.CrmCard', array('contact' => $company),true);
			$compData = array('id' => $company->id(), 'card' => $companyCard);
		}

		echo CJSON::encode(array(
			'valid' => $valid, 'form' => $html, 'id' => $c->id(), 'card' => $card, 'createdCompany' => $compData
		));
	}

	public function actionLookupCompany() {
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

	public function actionDelete($contactId) {
		$c = new Nworx_Crm_Model_Contact($contactId);
		$c->delete();
		echo CJSON::encode(true);
	}

	public function actionFindContact($term='', $group='') {
		$cs = CrmContact::model();
		$contacts = $cs->orderByName()->nameLike($term)->group($group)->findAll();
		echo $this->render('_user-list', array('contacts' => $contacts, 'term' => $term), true);
	}

	public function actionFindContactAlpha($letter){
		$cs = CrmContact::model();
		//$cs->orderByName()->nameLetterIndex()
		if(Nworx_Crm_Crm::get()->sortOrderFirstLast){
			$col = 'first_name';
		}else{
			$col = 'last_name';
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
	
	public function actionFacebookLookup($id){
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