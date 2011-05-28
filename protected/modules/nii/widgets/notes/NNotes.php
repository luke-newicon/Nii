<?php
/**
 * What is this widget?
 * Enables notes to be recorded against items in the website.
 *
 * Installation:
 * 1)Run the sql script called database.sql which can be found within the Notes
 * "data" folder.
 *
 * 2)Copy the following code into the actions array in the controller which the
 * application will use to remotely connect to the application:
 *
 * public function actions(){
 *		return array(
 *			'NNotes'=>'modules.nii.widgets.notes.NNotesAction'
 *		);
 *	}
 *
 * NOTE: Depending on how the controller is coded you may need to give the action
 * permission to run. The widget will not be able to communicate with the server
 * if this is not the case.
 *
 * 2)Put the follwing code in the view you would like to include the widget in:
 * <?php $this->widget('modules.nii.widgets.notes.NNotes',array(
 * 	'model'=>MODEL,
 *	'AjaxController'=>AJAXCONTROLLER)) ?>
 *
 * The code above will display a basic note widget. Below is an example of the
 * code required to display a widget with all the optional attributes specified:
 * <?php $this->widget('modules.nii.widgets.notes.NNotes',array(
 *	'model'=>MODEL,
 *	'newNoteText'=>NEWNOTETEXT,
 *	'AjaxController'=>AJAXCONTROLLER,
 *	'displayUserPic'=>DISPLAYUSERPIC,
 *	'canEdit'=>CANEDIT,
 *	'canDelete'=>CANDELETE,
 *	'canAdd'=>CANADD,
 *	'emptyText'=>EMPTYTEXT) ?>
 *
 * Variables:
 * MODEL = a CActiveRecord instance of the model which you would like the data to link to
 *
 * AJAXCONTROLLER = Text The controller which the Notes widget will try and contact
 * when interacting with the widget. This should be in normalizeUrl() format
 * eg "site/index/NNotes".
 *
 * DISPLAYUSERPIC = Boolean, whether the user display pic is shown (default= true).
 *
 * CANEDIT = Boolean, Whether the user can edit all the notes (default = false).
 *
 * CANDELETE = Boolean, Whether the user can delete noted (default = false).
 *
 * CANADD = Boolean, Whether the user can add notes (default = false).
 *
 * EMPTYTEXT = Text, The text to display if no notes are attached to the specified item
 * at the top or the bottom of the widget (default = 'bottom')
 *
 * NEWNOTETEXT = Text, The text to display in the new note text box (default = "New note...").
 *
 * TODO Section
 * @todo: If you do not want to use the primary key you should be able to override it and set a different one
 * @todo: permissions need to be checked on the server!
 * @todo: CActiverecords should be used.
 * @todo: namespace the notes table to be nii_notes
 *
 * @author matthewturner
 * @version 0.1
 */
class NNotes extends CWidget
{
	public $displayUserPic = true;
	public $model;
	public $emptyText = 'There are no notes attached to this item';
	public $canAdd = false;
	public $ajaxController = array('/nii/index/NNotes');
	public $newNoteText= 'New note...';

	
	public function run(){
		//The id of the item the notes should relate to
		$area = $this->model->tableName();
		$id = $this->model->getPrimaryKey();

		// Includes the style sheet
		$assetFolder = $this->getAssetsDir();
		yii::app()->clientScript->registerCssFile("$assetFolder/style.css");

		// this javascript support multiple note widgets on one page and 
		// therefore must obtain the specific information from the data attributes 
		// of the notes wrapper div
		yii::app()->clientScript->registerScript('NNote','
		$(document).ready(function(){
			// Hides all the text areas on page load

			// Adds a new note to the system
			$(".NNotes .newNote .add").click(function(event){
				var $data = $(this).closest(".NNotes").data();
				var $base = $(this).closest(".newNote");
				var note = $base.find(".note .NTextareaMarkdown textarea").val();
				
				var $note = $base.find(".note");
				$note.fadeTo(1,0.5);
				$note.find("textarea").attr("disabled","disabled");


				var $adding = $base.find(".adding");
				$adding.show();
				$adding.position({my:"center", at:"center", of:$note});

				$.ajax({
					url: $data.ajaxcontroller,
					type: "POST",
					data: ({itemId : $data.id,model:$data.area,note:note,profilePic:"'.$this->getProfilePic().'"}),
					success: function(){
					
					}
				});
			});

			// Shows the edit box when entered
			$(".NNotes .newNote .newNoteBox").click(function() {
				$(this).hide();
				$(this).parent().children(".markdownInput").fadeIn("medium",function() {
					$(this).find(\'textarea\').focus();
				});
			});

			// Closes the edit box if no text entered
			$(".NNotes .newNote .note .inputBox textarea").blur(function() {
				if($(this).val()==""){
					$(this).closest(".markdownInput").hide();
					$(this).closest(".note").find(".newNoteBox").fadeIn("medium");
				}

			});

		   // If there is not a value in the notes button then
		   // you should not be able to submit it
		   $(".NNotes .newNote .note .inputBox").keyup(function() {
				var notesValue = $(this).children(\'textarea\').val();
				var addButton = $(this).parent().parent().parent().find(\'.add\');

				if(notesValue==""){
					$(addButton).attr("disabled", "disabled");
				}else{
					$(addButton).removeAttr(\'disabled\');
				}
			});
		 });
		');


		// Gets the data to initially display when the widget loads.
		$data = Yii::app()->db->createCommand()
			->select('notes.id,
				user_id,
				u.username,
				added,
				note')
			->from('notes')
			->join('user_user u', 'u.id=notes.user_id')
			->where('item_id=:itemId AND area=:area', array(':itemId'=>$id,':area'=>$area))
			->order('id DESC')
			->queryAll();


		$this->render('overall',array('data'=>$data,
			'emptyText'=>$this->emptyText,
			'displayUserPic'=>$this->displayUserPic,
			'profilePic'=>$this->getProfilePic(),
			'canAdd'=>$this->canAdd,
			'area'=>$area,
			'id'=>$id,
			'ajaxController'=>CHtml::normalizeUrl($this->ajaxController),
			'newNoteText'=>$this->newNoteText
		));
	}
	
	public function getAssetsDir()
	{
		$assetLocation = Yii::getPathOfAlias('nii.widgets.notes.assets');
		return yii::app()->getAssetManager()->publish($assetLocation);
	}
	
	public function getProfilePic()
	{
		return $this->getAssetsDir().'/profilePic.png';
	}
	
	
	public function getNote($n)
	{
		return $this->render('_line',array('line'=>$n,'profilePic'=>$this->getProfilePic()), true);
	}
	
}
