<?php

Class StaffController extends AController {

	public function actionIndex() {
		$model = new ContactStaff('search');
		
		$model->unsetAttributes();
		if (isset($_GET['ContactStaff'])) {
			$model->attributes = $_GET['ContactStaff'];
		}
		
		$this->render('//task/admin/staff', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}
	
	public function actionView($id) {
		$this->render('//task/staff/view');
	}
	
	public function actionAdd() {
		$this->render('//task/staff/add');
	}

}