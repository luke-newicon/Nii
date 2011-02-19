<?php 

Class Nworx_Crm_Controller_Detail extends Nworx_Core_Controller
{
	public function actionIndex($contactId){
		try {
			$c = new Nworx_Crm_Model_Contact($contactId);
			$this->view->contact = $c;
			$this->view->render();
		}catch(Newicon_Db_Exception_RowNotFound $e){
			$this->redirect404();
		}
	}
}