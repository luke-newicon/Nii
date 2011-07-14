<?php
/**
 * Show a markdown input textarea,
 * Transforms a typical textarea to have a preview button displaying markdown rendered
 * output for the textarea's text.
 *
 * @version 0.2
 */
class NMarkdownInput extends CInputWidget
{
	/**
	 * Route to a controller action that implements the markdownPreview action
	 * @var array
	 */
	public $action = '/nii/index/markdownPreview';

	/**
	 * The classes to be applied to the edit button
	 * @var string
	 */
	public $editButtonAttrs = array('class'=>'btn btnN btnToolbar btnToolbarLeft');

	/**
	 * The classes to be applied to the preview button
	 * @var string
	 */
	public $previewButtonAttrs = array('class'=>'btn btnN btnToolbar btnToolbarRight');

	/**
	 * Options to be applied to the text area
	 * @var array
	 */
	public $htmlOptions = array('style'=>'width:100%;margin:0px;border:0px;');

	/**
	 * turn off displaying the buttons
	 * @var boolean 
	 */
	public $displayButtons = true;
	
	/**
	 * top, bottom
	 * @var string
	 */
	public $buttonPosition = 'top';
	
	public function run() {
		// The location of the markdown widgets asset folder
		$assetLocation = dirname(__FILE__) . DIRECTORY_SEPARATOR. 'assets';

		// The location the system ajax's to for its prview
		$ajaxLocation = NHtml::url($this->action);

		// Includes the markdown style sheet
		$assetManager = yii::app()->getAssetManager();
		$assetFolder = $assetManager->publish($assetLocation);
		yii::app()->clientScript->registerCssFile("$assetFolder/style.css");

		// Handles the ajaxing of the preview
		$jsPreviewClick = '
				// Gets the specified field
				function nTextAreaMarkDownGetField(callingItem,name){
					return $(callingItem).closest(".NTextareaMarkdown").find(name);
				}
				function nTextAreaMarkDownGetTextArea(callingItem,name){
					return $(callingItem).closest(".NTextareaMarkdown").find(name);
				}

				// Sets the slected button to appear as Active
				function nTextAreaMarkDownSetButtonState(button){
					$(button).closest(".NTextareaMarkdown").find(".active").removeClass("active");
					$(button).addClass("active");
				}

				// Loads the preview window
				$(".NTextareaMarkdown .preview").click(function(){
					var textArea = $(this).closest(".NTextareaMarkdown").find("textarea");
					nTextAreaMarkDownSetButtonState(this);
					var textArea = nTextAreaMarkDownGetTextArea(this,"textarea");
					var previewBox = nTextAreaMarkDownGetField(this,".previewBox");
					var update = $(this).closest(".NTextareaMarkdown").find(".updated");
					previewBox.show();
					textArea.parent().hide();
					if(update.val()==1){
						previewBox.html("<p>Loading...</p>");
						$.ajax({
						   type: "POST",
						   url: "' . $ajaxLocation . '",
						   data: "text="+textArea.val(),
						   success: function(msg){
							 previewBox.html(msg);
							 update.val("0");
						   }
						 });
					}
					return false;
				});

				// Updates the status of the updated status
				$(".NTextareaMarkdown textarea").change(function(){
					var update = $(this).closest(".NTextareaMarkdown").find(".updated");
					update.val("1");
				});

				// Displays the help file for the widget
				$(".NTextareaMarkdown .edit").click(function(){
					nTextAreaMarkDownSetButtonState(this);
					var textArea = nTextAreaMarkDownGetTextArea(this,"textarea");
					var previewBox = nTextAreaMarkDownGetField(this,".previewBox");
					previewBox.hide();
					textArea.parent().fadeIn("fast",function() {
						textArea.focus();
					});
					return false;
				});';
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('maskedinput');
		$cs->registerScript('MarkdownEditor', $jsPreviewClick);

		// If I have a model then display an active text area.
		if ($this->hasModel())
			$inputElement = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		else
			$inputElement = CHtml::textArea($this->name, $this->value, $this->htmlOptions);
		$this->render('markdown', array('inputElement' => $inputElement));
	}
	
	/**
	 * echos out the buttons for edit and preview as well as the help link
	 */
	public function displayButtons(){
		echo '<div class="buttons">';
		$this->editButtonAttrs['class'] = $this->editButtonAttrs['class'] . ' edit active';
		$this->previewButtonAttrs['class'] = $this->previewButtonAttrs['class'] . ' preview';
		echo CHtml::link('Edit', '#', $this->editButtonAttrs);
		echo CHtml::link('Preview', '#', $this->previewButtonAttrs);
		echo CHtml::hiddenField('textAreaStatus', 1, array('class' =>'updated'));
		echo CHtml::link('Help', 'http://daringfireball.net/projects/markdown/syntax', array('target' => 'blank', 'class' => 'help_button'));
		echo '</div>';
	}
	
}