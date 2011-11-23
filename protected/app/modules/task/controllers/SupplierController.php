<?php

Class SupplierController extends AController {

	public function actionIndex() {
		$model = new ContactSupplier('search');
		
		$model->unsetAttributes();
		if (isset($_GET['ContactSupplier'])) {
			$model->attributes = $_GET['ContactSupplier'];
		}
		
		$this->render('//task/admin/suppliers', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}
	
	public function actionView($id) {
		$this->render('//task/supplier/view');
	}
	
	public function actionAdd() {
		$this->render('//task/supplier/add');
	}
}