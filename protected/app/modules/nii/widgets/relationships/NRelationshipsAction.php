<?php
/**
 * This file contains interaction with the widget
 *
 * @author robinwilliams
 * @version 0.1
 */
class NRelationshipsAction extends CAction 
{
	public function run() {
		if(isset($_REQUEST['action']))
			$action = $_REQUEST['action'];
		else
			return false;
		
		$ds = DIRECTORY_SEPARATOR;
		require dirname(__FILE__).$ds.'models'.$ds.'NRelationship.php';
		switch ($action){
			case "displayNew" :
				$this->_newRelationshipInput();
			break;
			case "save":
				$this->_saveRelationship();
			break;
			case "delete":
				$this->_deleteRelationship();
			break;
		}
	}
	
	private function _newRelationshipInput() {
		
		$classname = $_GET['model'];
		$model_id = $_GET['model_id'];
		$model = new NRelationship;
		
		$controller = $this->getController();
		$controller->render(
			'nii.widgets.relationships.views._input',array(
				'classname'=>$classname,
				'id'=>$model_id,
				'model'=>$model,
			)
		);
	}
	
	/**
	 * Save an attachment in the system
	 * @return boolean 
	 */
	private function _saveRelationship(){
		
		if ($_REQUEST['NRelationship']) {

			$r = new NRelationship;
			$r->attributes = $_REQUEST['NRelationship'];

			if($r->save())
				echo CJSON::encode (array('success'=> 'Relationship successfully added','id'=>$r->id));
			else
				print_r($r->attributes);
//				return false;
		}
	}
	
	/**
	 * Delete an attachment from the system
	 * @return boolean
	 */
	private function _deleteRelationship(){
		if(isset($_REQUEST['id']))
			$id = $_REQUEST['id'];
		else
			return false;
		
		if(NRelationship::model()->deleteByPk($id))
			return true;
		else
			return false;
	}

}