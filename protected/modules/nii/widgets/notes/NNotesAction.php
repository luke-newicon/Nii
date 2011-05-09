<?php
/**
 * This file contains interaction with the widget
 *
 * @author matthewturner
 */
class NNotesAction extends CAction {

	public $displayUserPic = false;

	public $line;

	public function run() {

		$model = $_REQUEST['model'];
		$itemId = $_REQUEST['itemId'];
		$note = $_REQUEST['note'];
		$userId = yii::app()->user->id;

		yii::import('nii.widgets.notes.models.NNotes');

		// Gets the data to initially display when the widget loads.
		$command = Yii::app()->db->createCommand();

		// Inserts the note
		$command->insert('notes', array(
			'user_id'=>$userId,
			'area'=>$model,
			'item_id'=>$itemId,
			'note'=>$note
		));

		//$this->line[''];
		// include(dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'_line.php');
	}
}
?>
