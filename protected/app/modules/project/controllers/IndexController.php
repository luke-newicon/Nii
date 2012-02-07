<?php
/**
 * Project index controller class file.
 *
 * @link http://newicon.net/nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/nii/license/
 */

/**
 * Description of Project
 *
 * @author steve
 * @package nii.project
 */
class IndexController extends AController 
{

	/**
	 *	Grid view - for now - of the open projects 
	 */
	public function actionIndex() {
		
		$modelName = 'ProjectProject';
	
		$model = new $modelName('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$modelName]))
			$model->attributes = $_GET[$modelName];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	
	
	/**
	 * Create a new project
	 */
	public function actionCreate() {
		// todo validate project name is unique
		
		$modelName = 'ProjectProject';
		
		$model = new $modelName;
		
		if ($_POST[$modelName]) {
			$model->attributes = $_POST[$modelName];
			$model->save();
		}
		Yii::app()->end();
	}
	
	
}