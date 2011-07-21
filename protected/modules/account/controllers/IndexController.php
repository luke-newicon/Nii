<?php
class IndexController extends AController
{

	public function init(){
		parent::init();
		$url = CrmModule::get()->getAssetsUrl();
		Yii::app()->getClientScript()->registerCssFile("$url/crm.css");
		//$this->breadcrumbs=array($this->module->id);
	}
	
	public function accessRules() 
	{
		return array(
			array('allow',
				//'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*')
			)
        );
	}
	
	public function actionIndex() 
	{
		$contacts = CrmContact::model()->orderByName()->findAll();
		$groups = CrmGroup::model()->findAll();
		$this->render('index',array(
			'term'=>'',
			'contacts'=>$contacts,
			'groups'=>$groups
		));
	}

}