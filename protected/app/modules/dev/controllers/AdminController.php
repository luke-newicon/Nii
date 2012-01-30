<?php

class AdminController extends AController {

	
	public function accessRules() {
		return array(
			// deny anyone who is not a super user
			array('deny',
				'expression'=>'!Yii::app()->user->isSuper()'
			),
		);
	}
	
	public function actionIndex() {
		$modules = array();
		foreach(Yii::app()->getNiiModules() as $m){
			
			$dir = Yii::getPathOfAlias("{$m->id}.views.dev");
			
			if(file_exists($dir)){
				$views = CFileHelper::findFiles($dir, array('fileTypes'=>array('php')));
				if(!empty($views)){
					$modules[$m->id] = $views;
				}
			}
		}
		
		$this->render('index', array('modules'=>$modules));
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
		Yii::app()->flushAssets();
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
	
}