<?php

class DomainController extends Controller {

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow',
				'users' => array('*'),
			),
		);
	}

	public function actionIndex() {
		$this->render('index');
	}

	public function actionLookup() {

		$model = new DomainLookup;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model, 'domain-lookup-form');

		$results = '';
		if (isset($_POST['DomainLookup'])) {
			$model->attributes = $_POST['DomainLookup'];
			$callArray = array(
				'func' => 'lookupDomain',
				'data' => array(
					'domain' => $model->domain,
					'defaulttld' => '.co.uk;.me;.org;.org.uk;.net;.tel;.com;.mobi;.biz;.info',
				)
			);

			$callstring = json_encode($callArray);
			$osrsHandler = processOpenSRS('json', $callstring);
			$results = json_decode($osrsHandler->resultFormated);
		}

		$this->render('lookup', array('results' => $results, 'model' => $model));
	}

}
