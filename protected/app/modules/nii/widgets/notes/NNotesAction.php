<?php
/**
 * This file contains interaction with the widget
 *
 * @author matthewturner
 * @version 0.1
 */
class NNotesAction extends CAction 
{
	public function run() {
		if(isset($_REQUEST['action']))
			$action = $_REQUEST['action'];
		else
			return false;
		
		$ds = DIRECTORY_SEPARATOR;
		require dirname(__FILE__).$ds.'models'.$ds.'NNote.php';
		switch ($action){
			case "addNote":
				$this->saveNote();
				break;
			case "editNote":
				$this->editNote();
				break;
			case "deleteNote":
				$this->deleteNote();
				break;
			case "updateNote":
				$this->updateNote();
				break;
		}
	}
	
	/**
	 * Save a note in the system
	 * @return boolean 
	 */
	private function saveNote(){
		
		if(isset($_REQUEST['model']) &&
				isset($_REQUEST['model_id'])&&
				isset($_REQUEST['note'])){
			
			$model = $_REQUEST['model'];
			$modelId = $_REQUEST['model_id'];
			$note = $_REQUEST['note'];

			$n = new NNote;
			$user = Yii::app()->user->record;
			if ($user) $n->user_id = $user->id; 
			$n->model = $model;
			$n->model_id = $modelId;
			//$n->type = $noteNumber;
			$n->note = $note;

			if($n->save())
				echo CJSON::encode(array('id'=>$n->id,'count'=>NNote::model()->countByAttributes(array('model'=>$model, 'model_id'=>$modelId))));
			else
				return false;
		}
	}
	
	/**
	 * Delete a note from the system
	 * @return boolean
	 */
	private function deleteNote(){
		if(isset($_REQUEST['noteId']))
			$noteId = $_REQUEST['noteId'];
		else
			return false;
		
		$model = $_REQUEST['note_model'];
		$modelId = $_REQUEST['model_id'];
		
		if(NNote::model()->deleteByPk($noteId))
			echo CJSON::encode(array('count'=>NNote::model()->countByAttributes(array('model'=>$model, 'model_id'=>$modelId))));
		else
			return false;
	}
	
	private function editNote(){

		if(isset($_REQUEST['noteId']))
			$noteId = $_REQUEST['noteId'];
		else
			return false;
		$note = NNote::model()->findByPk($noteId);
		echo $note->note;

	}
	
	private function updateNote(){
		if(isset($_REQUEST['noteId']) &&
			isset($_REQUEST['noteText'])){
			$noteId = $_REQUEST['noteId'];
			$noteText = $_REQUEST['noteText'];
		}else{
			return false;
		}
		
		$note = NNote::model()->findByPk($noteId);
			$note->note = $noteText;
		$note->save();
	}
}