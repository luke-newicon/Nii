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
	public function actionFlushCache($return='index'){
		try {
			Yii::app()->cache->flush();
			Yii::app()->user->setFlash('success','Cache succesfully flushed');
		}catch(Exception $e){
			Yii::app()->user->setFlash('error','Cache flush failed');
		}
		$this->redirect(array($return));
	}
	
	/**
	 * remove all assets from the assets folder
	 */
	public function actionFlushAssets($return='index'){
		$ignore = array(
			Yii::app()->getAssetManager()->basePath.'/.gitignore',
		);
		NFileHelper::deleteFilesRecursive(Yii::app()->getAssetManager()->basePath,$ignore);
		Yii::app()->user->setFlash('success','Assets folder succesfully flushed');
		$this->redirect(array($return));
	}
	
	/**
	 * remove all files from the runtime folder
	 */
	public function actionFlushRuntime($return='index'){
		$ignore = array(
			Yii::app()->runtimePath.'/.gitignore',
		);
		NFileHelper::deleteFilesRecursive(Yii::app()->runtimePath,$ignore);
		Yii::app()->user->setFlash('success','Runtime folder succesfully flushed');
		$this->redirect(array($return));
	}
	
	public function actionFlushPermissions($return='index'){
		Yii::app()->authManager->db->createCommand()->delete(Yii::app()->authManager->itemChildTable);
		Yii::app()->authManager->db->createCommand()->delete(Yii::app()->authManager->itemTable);
		Yii::app()->cache->flush();
		Yii::app()->installAll();
		Yii::app()->cache->flush();
		Yii::app()->user->setFlash('success','Permissions succesfully flushed');
		$this->redirect(array($return));
	}
	
}