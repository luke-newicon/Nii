<?php
/**
 * This file contains interaction with the widget
 *
 * @author matthewturner
 */
class NNotesAction extends CAction 
{

	public $displayUserPic = false;

	public $line;

	public function run() {
		$model = $_REQUEST['model'];
		$itemId = $_REQUEST['itemId'];
		$note = $_REQUEST['note'];

		// use require incase not in the context of nii module
		require dirname(__FILE__).DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'NNote.php';

		$n = new NNote;
		$n->user_id = yii::app()->user->id;
		$n->area = $model;
		$n->item_id = $itemId;
		$n->note = $note;
		$n->save();
		echo $this->getController()->widget('nii.widgets.notes.NNotes')->getNote($n);
	}
}