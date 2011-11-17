<?php

/**
 * Description of DonationsController
 *
 * @author robinwilliams
 */
class DonationController extends AController 
{
	
	/**
	 *	Action to display the default donations grid view 
	 */
	public function actionIndex() {
		
		$this->pageTitle = Yii::app()->name . ' - Donations';
		$donationModel = 'HftDonation';
	
		$model = new $donationModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$donationModel]))
			$model->attributes = $_GET[$donationModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	/**
	 * View donation details
	 * @param int $id
	 */
	public function actionView($id=null) {
		
		$this->pageTitle = Yii::app()->name . ' - View Donation Details';
		
		$donationModel = 'HftDonation';
		$model = NActiveRecord::model($donationModel)->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No donation exists for ID: ".$id."</strong>");
		
		$viewData = array(
			'model'=>$model,
		);
		
		$this->render('view',array(
			'model'=>$model,
		));
		
	}
	
	/**
	 *	Action to create a new donation in the database 
	 */
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - Add a Donation';
		$donationModel = 'HftDonation';
		
		$model = new $donationModel;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$donationModel])) {
			$model->attributes = $_POST[$donationModel];
			
			if($model->save()) {
				
				Log::insertLog('Inserted new donation details: '.NHtml::formatPrice($model->donation_amount).' received on '.NHtml::formatDate($model->date_received, 'd M Y, H:i').' (id: '.$model->id.')', $model);
				$this->redirect(array("donation/view","id"=>$model->id));		
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
		
	}
	
	
	/**
	 *	Action to create a new donation in the database 
	 */
	public function actionEdit($id) {
		
		$this->pageTitle = Yii::app()->name . ' - Edit a Donation';
		$donationModel = 'HftDonation';
		
		$model = HftDonation::model()->findByPk($id);
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$donationModel])) {
			$model->attributes = $_POST[$donationModel];
			
			if($model->save()) {
				
				Log::insertLog('Updated donation details: '.NHtml::formatPrice($model->donation_amount).' received on '.NHtml::formatDate($model->date_received, 'd M Y, H:i').' (id: '.$model->id.')', $model);
				$this->redirect(array("donation/view","id"=>$model->id));		
				
			}
		}
		
		$this->render('edit',array(
			'model'=>$model,
		));
		
	}
	
	
	public function actionGeneralInfo($id) {

		$model = HftDonation::model()->findByPk($id);
		
		$this->render('view/tabs/general',array(
			'model'=>$model,
		));

	}
	
	/**
	 * @param type $id
	 */
	public function actionNotes($id) {

		$model = HftDonation::model()->findByPk($id);
		if ($model) {
			$this->render('view/tabs/notes',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}

	/**
	 * @param type $id
	 */
	public function actionAttachments($id) {

		$model = HftDonation::model()->findByPk($id);
		if ($model) {
			$this->render('view/tabs/attachments',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='donation')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}