<?php
/**
 * Enables notes to be recorded against items in the website.
 *
 * Installation:
 * 
 * 1)Run the sql script called database.sql which can be found within the Notes
 * "data" folder.
 *
 * 2)Copy the following code into the actions array in the controller which the
 * application will use to remotely connect to the application:
 *
 * <code><?php
 * public function actions(){
 *		return array(
 *			'NNotes'=>'modules.nii.widgets.notes.NNotesAction'
 *		);
 *	}
 * ?></code>
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
 * <code>
 * <?php $this->widget('modules.nii.widgets.notes.NNotes',array(
 *	'model'=>MODEL,
 *	'title'=>TITLE,
 *	'newNoteText'=>NEWNOTETEXT,
 *	'AjaxController'=>AJAXCONTROLLER,
 *	'displayUserPic'=>DISPLAYUSERPIC,
 *	'canEdit'=>CANEDIT,
 *	'canDelete'=>CANDELETE,
 *	'canAdd'=>CANADD,
 *	'emptyText'=>EMPTYTEXT)
 * ?></code>
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
 * TITLE = Text, the title to be put at the top of the widget (default = 'Notes')
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
 *
 * @author Matthew Turner
 * @version 0.1
 */
class NNotes extends CWidget{
	/**
	 * Whether or not to display a user picture
	 * @var boolean
	 */
	public $displayUserPic = true;

	/**
	 * The CActiveRecord which the note should be linked to
	 * @var CActiveRecord
	 */
	public $model;

	/**
	 * The empty text which will be displayed when no notes are present
	 * @var string
	 */
	public $emptyText = 'There are no notes attached to this item';

	/**
	 * Whether the user can add notes to the system
	 * @var boolean
	 */
	public $canAdd = false;

	/**
	 * The controller to send the AJAX request to.
	 * @var array
	 */
	public $ajaxController = array('nii/index/NNotes');

	/**
	 * The title of the widget
	 * @var string
	 */
	public $title = 'Notes';

	/**
	 * The text which should be placed in the new note box
	 * @var <type>
	 */
	public $newNoteText= 'New note...';

	public function run(){
		//The id of the item the notes should relate to
		$area = $this->model->tableName();
		$id = $this->model->getPrimaryKey();

		// The location of the markdown widgets asset folder
		$assetLocation = dirname(__FILE__) . DIRECTORY_SEPARATOR. 'assets';

		// Includes the style sheet
		$assetManager = yii::app()->getAssetManager();
		$assetFolder = $assetManager->publish($assetLocation);
		yii::app()->clientScript->registerCssFile("$assetFolder/style.css");

		yii::app()->clientScript->registerScript('NNote','
		$(document).ready(function(){
			// Hides all the text areas on page load
			$(".NNotes .newNote .NTextareaMarkdown").hide();

			// Adds a new note to the system
			$(".NNotes .newNote .add").click(function(event){
				var base = $(this).parent().parent().parent().children(".newNote");
				var ajaxUrl = $(base).data("ajaxLoc");
				var model = $(base).data("model");
				var itemId = $(base).data("id");
				var note = $(this).parent().parent().children(".note").children(".NTextareaMarkdown").children(".input").children("textarea").val();
				var notesModelLocation = $(base).data("notesmodellocation");
				var $note = $(this).closest(".newNote").find(".note");
				$note.fadeTo(1,0.5);
				$note.find("textarea").attr("disabled","disabled");

				var $adding = $(this).parent().parent().parent().children(".adding");
				$adding.show();
				$adding.position({my:"center", at:"center", of:$note});

				$.ajax({
					url: ajaxUrl,
					type: "POST",
					data: ({itemId : itemId,model:model,note:note,notesModelLocation:notesModelLocation}),
					success: function(){
					location.reload();
					}
				});
			});

			// Shows the edit box when entered
			$(".NNotes .newNote .newNoteBox").focus(function() {
				$(this).hide();
				$(this).parent().children(".NTextareaMarkdown").fadeIn("medium",function() {
				$(this).parent().children(".NTextareaMarkdown").children(".input").children(\'textarea\').focus();
			});
			});

			// Closes the edit box if no text entered
			$(".NNotes .newNote .note .input textarea").blur(function() {
				if($(this).val()==""){
					$(this).parent().parent().parent().children(".NTextareaMarkdown").hide();
					$(this).parent().parent().parent().children(".newNoteBox").fadeIn("medium");
				}

			});

		   // If there is not a value in the notes button then
		   // you should not be able to submit it
		   $(".NNotes .newNote .note .input").keyup(function() {
				var notesValue = $(this).children(\'textarea\').val();
				var addButton = $(this).parent().parent().parent().children(\'.buttons\').children(\'.add\');

				if(notesValue==""){
					$(addButton).attr("disabled", "disabled");
				}else{
					$(addButton).removeAttr(\'disabled\');
				}
			});
		 });
		');

		$profilePic = $assetFolder.'/profilePic.png';

		// Gets the data to initially display when the widget loads.
		$data = Yii::app()->db->createCommand()
			->select('notes.id,
				user_id,
				u.username,
				added,
				note')
			->from('notes')
			->leftjoin('user_user u', 'u.id=notes.user_id')
			->where('item_id=:itemId AND area=:area', array(':itemId'=>$id,':area'=>$area))
			->order('id DESC')
			->queryAll();

		$this->render('overall',array('data'=>$data,
			'emptyText'=>$this->emptyText,
			'displayUserPic'=>$this->displayUserPic,
			'profilePic'=>$profilePic,
			'canAdd'=>$this->canAdd,
			'area'=>$area,
			'id'=>$id,
			'ajaxController'=>yii::app()->createAbsoluteUrl($this->ajaxController),
			'title'=>$this->title,
			'newNoteText'=>$this->newNoteText
		));
	}
}
?>
