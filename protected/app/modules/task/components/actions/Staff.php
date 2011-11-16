<?php

class Staff extends CAction {

	public function run() {
		$controller = $this->getController();
		
		$model = new ContactStaff('search');
		
		$model->unsetAttributes();
		if (isset($_GET['ContactStaff'])) {
			$model->attributes = $_GET['ContactStaff'];
		}
		
		$controller->render('//task/admin/staff', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}

}