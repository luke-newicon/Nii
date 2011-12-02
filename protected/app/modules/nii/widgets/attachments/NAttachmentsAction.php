<?php
/**
 * This file contains interaction with the widget
 *
 * @author robinwilliams
 * @version 0.1
 */
class NAttachmentsAction extends CAction 
{
	public function run() {
		if(isset($_REQUEST['action']))
			$action = $_REQUEST['action'];
		else
			return false;
		
		$ds = DIRECTORY_SEPARATOR;
		//require dirname(__FILE__).$ds.'models'.$ds.'NAttachment.php';
		switch ($action){
			case "uploadAttachment" :
				$this->_uploadAttachment();
			break;
			case "displayNew" :
				$this->_newAttachmentInput();
			break;
			case "saveAttachment":
				$this->_saveAttachment();
			break;
			case "deleteAttachment":
				$this->_deleteAttachment();
			break;
		}
	}
	
	private function _newAttachmentInput() {
		
		$classname = $_GET['model'];
		$model_id = $_GET['model_id'];
		$type = $_GET['type'];
		
		$model = new NAttachment;
		
		$controller = $this->getController();
		$controller->render(
			'nii.widgets.attachments.views._input',array(
				'classname'=>$classname,
				'id'=>$model_id,
				'model'=>$model,
				'type'=>$type,
			)
		);
	}
	
	/**
	 * Save an attachment in the system
	 * @return boolean 
	 */
	private function _saveAttachment(){
		
		if ($_REQUEST['Attachment']) {

			$a = new NAttachment;
			$a->attributes = $_REQUEST['Attachment'];

			if($a->save())
				echo CJSON::encode (array('success'=> 'Attachment successfully added','id'=>$a->id,'count'=>$a->totalAttachments));
			else
				print_r($a->attributes);
//				return false;
		}
	}
	
	/**
	 * Delete an attachment from the system
	 * @return boolean
	 */
	private function _deleteAttachment(){
		if(isset($_REQUEST['id']))
			$id = $_REQUEST['id'];
		else
			return false;
		
		if(NAttachment::model()->deleteByPk($id))
			echo NAttachment::countAttachments($_REQUEST['a_model'], $_REQUEST['a_model_id']);
		else
			return false;
	}
	
	/**
	 * 
	 */
	private function _uploadAttachment() {

		$upload = Yii::app()->fileManager;
		$newFileId = $upload->saveFile();
		
		echo $newFileId;
		exit;

	}

}