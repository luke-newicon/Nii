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
		// I need the model to be present to be able to interact with data in 
		// the system.
		$ds = DIRECTORY_SEPARATOR;
		require dirname(__FILE__).$ds.'models'.$ds.'NNote.php';
		$model = $_REQUEST['model'];
		$itemId = $_REQUEST['itemId'];
		$action = $_REQUEST['action'];
		$note = $_REQUEST['note'];
		
		switch ($action){
			case "addNote":
				$this->saveNote($model,$itemId,$note);
				break;
			case "deleteNote":
				break;
		}
	}
	
	/**
	 * Save a note in the system
	 * @param string $model
	 * @param int $item_id
	 * @param string $note
	 * @return boolean 
	 */
	private function saveNote($model,$itemId,$note){
		$n = new NNote;
			$n->user_id = yii::app()->user->id;
			$n->area = $model;
			$n->item_id = $itemId;
			$n->note = $note;

		if($n->save())
			return true;
		else
			return false;
	}
	
	/**
	 * Delete a note from the system
	 * @param int $noteId The id of the note to delete
	 */
	private function deleteNote($noteId){
		NNote::model()->deleteByPk($noteId);
	}
}