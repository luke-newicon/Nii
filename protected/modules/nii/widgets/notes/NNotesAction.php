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
		}
	}
	
	/**
	 * Save a note in the system
	 * @return boolean 
	 */
	private function saveNote(){
		if(isset($_REQUEST['model']) &&
			isset($_REQUEST['noteNumber'])&&
			isset($_REQUEST['note'])){
				$model = $_REQUEST['model'];
				$noteNumber = $_REQUEST['noteNumber'];
				$note = $_REQUEST['note'];
			}else{
				return false;
			}
			
		$n = new NNote;
			$n->user_id = yii::app()->user->id;
			$n->area = $model;
			$n->item_id = $noteNumber;
			$n->note = $note;

		if($n->save())
			return true;
		else
			return false;
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
		
		if(NNote::model()->deleteByPk($noteId))
			return true;
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
}