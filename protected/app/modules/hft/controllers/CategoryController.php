<?php

/**
 * Description of CategoryController
 *
 * @author robinwilliams
 */
class CategoryController extends AController 
{
	
	/**
	 *	Action to display the default categorys grid view 
	 */
	public function actionIndex() {
		
		$this->pageTitle = Yii::app()->name . ' - Categories';
		$categoryModel = 'HftCategory';
	
		$model = new $categoryModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$categoryModel]))
			$model->attributes = $_GET[$categoryModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionDelete($id) {
		if (NActiveRecord::model('NTag')->deleteByPk($id))
			echo CJSON::encode(array('success'=>'Category successfully deleted'));
		Yii::app()->end();
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='category')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}