<?php

class UpgradesController extends AController {

	public function actionIndex() {
		$this->render('index');
	}
	
	/**
	 * Runs the main application installation
	 */
	public function actionInstall(){
		// lets also flush the cache incase schema chaching is on
		try {
			Yii::app()->cache->flush();
			Yii::app()->installAll();
			Yii::app()->cache->flush();
			Yii::app()->user->setFlash('success','Modules and db installed.');
		} catch (Exception $e){
			throw $e;
		}
		
		$this->redirect(array('index'));
	}

}