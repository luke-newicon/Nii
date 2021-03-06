<?php

Class CustomerController extends AController {

	public function actionIndex() {
		$model = new ContactCustomer('search');
		
		$model->unsetAttributes();
		if (isset($_GET['ContactCustomer'])) {
			$model->attributes = $_GET['ContactCustomer'];
		}
		
		$this->render('//task/admin/customers', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}
	
	public function actionView($id) {
		$this->render('//task/customer/view');
	}
	
	public function actionAdd() {
		$this->render('//task/customer/add');
	}

}