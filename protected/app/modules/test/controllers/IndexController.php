<?php

class IndexController extends AController {

	public function actionIndex() {
		$this->render('index');
	}

	public function actionGrid() {
		$model = new TestContactGrid('search');
		$model->unsetAttributes();
		$model->extra = new TestExtra('search');
		$model->extra->unsetAttributes();

		if(isset($_GET['TestContactGrid']))
			$model->attributes = $_GET['TestContactGrid'];
		
		$this->render('grid', array(
			'model' => $model,
		));
	}

	public function actionForm(){
		$model = new TestContactForm;
		
		$this->performAjaxValidation($model, 'test-contact-form');
		
		if (isset($_POST['TestContactForm'])) {
			$model->attributes = $_POST['TestContactForm'];
			
			if ($model->save()) {
				
			}	
		}
		
		$this->render('form', array(
			'model' => $model,
		));
	}
	
	public function actionAutoForm(){
		$model = new TestContactForm;
		$form = new LForm($model->fields());

		$form['contact']->model = new TestContact;
		$form['extra']->model = new TestExtra;
		
//		$form['contact']->showErrorSummary = true;
//		$form['extra']->showErrorSummary = true;
		
		$form->performAjaxValidation();
		
		if($form->submitted('save') && $form->validate()){
			
		}
		
		$this->render('autoform', array('form'=>$form));
	}
}
