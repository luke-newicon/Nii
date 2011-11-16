<?php

class Customers extends CAction {

	public function run() {
		$controller = $this->getController();
		
		$model = new ContactCustomer('search');
		
		$model->unsetAttributes();
		if (isset($_GET['ContactCustomer'])) {
			$model->attributes = $_GET['ContactCustomer'];
		}
		
		$controller->render('//task/admin/customers', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}

}