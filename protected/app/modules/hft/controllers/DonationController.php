<?php

/**
 * Description of DonationsController
 *
 * @author robinwilliams
 */
class DonationController extends AController 
{
	
	public function actionIndex() {
		
		//$this->actionsMenu = $this->contactGridActions();
		
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
}