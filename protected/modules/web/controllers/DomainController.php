<?php

Yii::import('application.vendors.opensrs.opensrs.*');
require_once ('openSRS_loader.php');

class DomainController extends NController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

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

		$model = new DomainLookup;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

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

		$this->render('index', array('results' => $results, 'model' => $model));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'domain-lookup-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
