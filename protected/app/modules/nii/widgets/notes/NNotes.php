<?php
Yii::import('nii.widgets.notes.models.NNote');
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
 * NOTE: Depending on how the controller is coded you may need to give the 
 * action permission to run. The widget will not be able to communicate with the 
 * server if this is not the case.
 *
 * 2)Put the follwing code in the view you would like to include the widget in:
 * <?php $this->widget('modules.nii.widgets.notes.NNotes',array(
 * 	'model'=>MODEL,
 *	'AjaxController'=>AJAXCONTROLLER)); ?>
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
 *	'emptyText'=>EMPTYTEXT); ?>
 *
 * Variables:
 * MODEL = a CActiveRecord instance of the model which you would like the data 
 * to link to.
 *
 * AJAXCONTROLLER = Text The controller which the Notes widget will try and 
 * contact when interacting with the widget. This should be in normalizeUrl() 
 * format eg "site/index/NNotes".
 *
 * DISPLAYUSERPIC = Boolean, whether the user display pic is shown (default= true).
 *
 * CANEDIT = Boolean, Whether the user can edit all the notes (default = false).
 *
 * CANDELETE = Boolean, Whether the user can delete noted (default = false).
 *
 * CANADD = Boolean, Whether the user can add notes (default = false).
 *
 * EMPTYTEXT = Text, The text to display if no notes are attached to the 
 * specified item at the top or the bottom of the widget (default = 'bottom').
 *
 * NEWNOTETEXT = Text, The text to display in the new note text box 
 * (default = "New note...").
 *
 * @property $displayUserPic 
 * @todo: If you do not want to use the primary key you should be able to 
 * override it and set a different one
 * @todo: permissions need to be checked on the server!
 * @todo: CActiverecords should be used.
 * @todo: namespace the notes table to be nii_notes
 *
 * @author matthewturner
 * @version 0.1
 */
class NNotes extends NAttributeWidget
{
	/**
	 * Whether or not to display a user picture in the add section
	 * @var boolean 
	 */
	public $displayUserPic = true;
	
	/**
	 * The text that gets displayed if there are no notes present.
	 * @var String 
	 */
	public $emptyText = 'None';
	
	/**
	 * Whether the user can add notes
	 * @var boolean 
	 */
	public $canAdd = true;
	
	/**
	 * The location to ajax to
	 * @var string 
	 */
	public $ajaxLocation = '';
	
	/**
	 * Whether the user can edit notes
	 * @var boolean 
	 */
	public $canEdit = true;
	
	public $canEditMine = true;
	
	/*
	 * Whether the user can delete notes
	 * @var boolean
	 */
	public $canDelete = true;
	
	public $userNameFunction = 'getUsername()';
	
	/**
	 * The message to display in the add new text box when no text is present
	 * @var text 
	 */
	public $newNoteText = 'New note...';
	
	/**
	 * Whether to hide the text box if no text is present
	 * @todo Code this in so it works!
	 * @var boolean 
	 */
	public $hideTextBoxOnEmpty = false;
	
	/**
	 * the html that when clicked will enable the user to add a note
	 * @var string 
	 */
	public $addNoteButtonHtml = '<div class="fakebox">New Note...</div>';
	
	public function run(){
		
		 
		// If no ajax location set then use default
		if(!$this->ajaxLocation)
			$this->ajaxLocation = Yii::app()->createAbsoluteUrl('/nii/index/notes');
		
		//The id of the item the notes should relate to
		$model = $this->getModelClass();
		$id = $this->getId();
		$modelId = $this->model->getPrimaryKey();
		// Store session information for each instance of the plugin
		/*
		$session=new CHttpSession;
		$session['test'] = array(
			'canEdit'=>$this->canEdit,
			'canDelete'=>$this->canDelete,
			'canAdd'=>$this->canAdd);
		*/
		// Includes the style sheet
		$assetFolder = $this->getAssetsDir();
		Yii::app()->clientScript->registerCssFile("$assetFolder/style.css");
		Yii::app()->clientScript->registerScriptFile("$assetFolder/notes.js");

		// this javascript support multiple note widgets on one page and 
		// therefore must obtain the specific information from the data 
		// attributes of the notes wrapper div
		$js = '$("#'.$id.'").NNotes({ajaxLocation:"'.$this->ajaxLocation.'",itemId:"'.$id.'",model:"'.$model.'"});';
		Yii::app()->clientScript->registerScript($id, $js, CClientScript::POS_READY);
		
		$notesTable = NNote::model()->tableName();
		
		$dataProvider=new CActiveDataProvider("NNote",array(
		'criteria'=>array(
			'order'=>'id DESC',
			'condition'=>'model_id = :itemId AND model = :itemmodel',
			'params'=>array(':itemId'=>$modelId, ':itemmodel'=>$model)
		)));
		
		$this->render('overall',array(
			'emptyText'=>$this->emptyText,
			'displayUserPic'=>$this->displayUserPic,
			'profilePic'=>$this->getProfilePic(),
			'canAdd'=>$this->canAdd,
			'dataProvider'=>$dataProvider,
			'canEdit'=>$this->canEdit,
			'canDelete'=>$this->canDelete,
			'id'=>$id,
			'model'=>$model,
			'modelId'=>$modelId,
			'newNoteText'=>$this->newNoteText
		));
	}
	
	public function getAssetsDir()
	{
		$assetLocation = Yii::getPathOfAlias('nii.widgets.notes.assets');
		return Yii::app()->getAssetManager()->publish($assetLocation);
	}
	
	public function getProfilePic()
	{
		return $this->getAssetsDir().'/profilePic.png';
	}
	
	public function getNote($n)
	{
		return $this->render('_line',array(
			'line'=>$n,
			'profilePic'=>$this->getProfilePic()),
			true);
	}
	
	public static function install(){
		NNote::install();
	}
	
}