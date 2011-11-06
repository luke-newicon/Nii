<?php

class AdminController extends AController {

	public function actionIndex() {
		$this->render('index');
	}

	public function actionBootstrap() {
		$this->redirect($this->getModule('dev')->assetsUrl . '/bootstrap/docs');
	}
	
	/**
	 * Flush the cache
	 */
	public function actionFlushCache(){
		try {
			Yii::app()->cache->flush();
			Yii::app()->user->setFlash('success','Cache succesfully flushed');
		}catch(Exception $e){
			Yii::app()->user->setFlash('error','Cache flush failed');
		}
		$this->redirect('index');
	}
	
	/**
	 * remove all assets from the assets folder
	 */
	public function actionFlushAssets(){
		$ignore = array(
			Yii::app()->getAssetManager()->basePath.'/.gitignore',
		);
		NFileHelper::deleteFilesRecursive(Yii::app()->getAssetManager()->basePath,$ignore);
		Yii::app()->user->setFlash('success','Assets folder succesfully flushed');
		$this->redirect('index');
	}
	
	/**
	 * remove all files from the runtime folder
	 */
	public function actionFlushRuntime(){
		$ignore = array(
			Yii::app()->runtimePath.'/.gitignore',
		);
		NFileHelper::deleteFilesRecursive(Yii::app()->runtimePath,$ignore);
		Yii::app()->user->setFlash('success','Runtime folder succesfully flushed');
		$this->redirect('index');
	}
	
}