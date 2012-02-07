<?php
/**
 * DetailsController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 * @package nii
 */

/**
 * Project details controller.
 * This controller handles requests for specific project details
 *
 * @author steve
 */
class DetailsController extends AController
{
	/**
	 * Draws the project details screen
	 * 
	 * @param int $id project id
	 */
	public function actionIndex($id) 
	{
		$this->pageTitle = Yii::app()->name . ' - View Project Details';
		
		$modelName = 'ProjectProject';
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No project exists for ID: ".$id."</strong>");
		
		$viewData = array(
			'model'=>$model,
		);
		
		$this->render('index',array(
			'model'=>$model,
		));
	}	
}