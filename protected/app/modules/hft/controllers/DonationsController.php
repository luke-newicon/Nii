<?php

/**
 * Description of DonationsController
 *
 * @author robinwilliams
 */
class DonationsController extends AController 
{
	public function actionIndex() {
//		$contact = Contact::model()->findByPk(1);
//		$contact->setEavAttribute('test','Steve');
//		$contact->save();
		
		$this->render('index');
	}
}