<?php

class Suppliers extends CAction {

	public function run() {
		$controller = $this->getController();
		
		$model = new ContactSupplier('search');
		
		$model->unsetAttributes();
		if (isset($_GET['ContactSupplier'])) {
			$model->attributes = $_GET['ContactSupplier'];
		}
		
		$controller->render('//task/admin/suppliers', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}

}