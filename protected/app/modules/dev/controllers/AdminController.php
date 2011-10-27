<?php

class AdminController extends AController {

	public function actionIndex() {
		$this->render('index');
	}

	public function actionBootstrap() {
		$this->redirect($this->getModule('dev')->assetsUrl . '/bootstrap/docs');
	}
	
	public function actionFlushAssets(){
		$ignore = array(
			Yii::app()->getAssetManager()->basePath.'/.gitignore',
		);
		NFileHelper::deleteFilesRecursive(Yii::app()->getAssetManager()->basePath,$ignore);
		Yii::app()->user->setFlash('success','Assets folder succesfully flushed');
		$this->redirect('index');
	}
	
	public function actionFlushRuntime(){
		$ignore = array(
			Yii::app()->runtimePath.'/.gitignore',
		);
		NFileHelper::deleteFilesRecursive(Yii::app()->runtimePath,$ignore);
		Yii::app()->user->setFlash('success','Runtime folder succesfully flushed');
		$this->redirect('index');
	}
}