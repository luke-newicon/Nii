v<?php
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
	public $action = 'nii/index/markdownPreview';

	/**
	 * The classes to be applied to the edit button
	 * @var string
	 */
	public $editButtonClass = 'btn btnN btnToolbar btnToolbarLeft';

	/**
	 * The classes to be applied to the preview button
	 * @var string
	 */
	public $previewButtonClass = 'btn btnN btnToolbar btnToolbarRight';

	/**
	 * Options to be applied to the text area
	 * @var array
	 */
	public $htmlOptions = array('style'=>'width:100%;height:160px;border:1px solid #ccc;margin:0px;border:0px;');

	public function run() {
		// The location of the markdown widgets asset folder
		$assetLocation = dirname(__FILE__) . DIRECTORY_SEPARATOR. 'assets';

		// The location the system ajax's to for its prview
		$ajaxLocation = yii::app()->createUrl($this->action);

		// Includes the markdown style sheet
		$assetManager = yii::app()->getAssetManager();
		$assetFolder = $assetManager->publish($assetLocation);
		yii::app()->clientScript->registerCssFile("$assetFolder/style.css");

		// Handles the ajaxing of the preview
		$jsPreviewClick = '
				// Gets the specified field
				function nTextAreaMarkDownGetField(callingItem,name){
					return $(callingItem).parent().parent().children(name);
				}
				function nTextAreaMarkDownGetTextArea(callingItem,name){
					return $(callingItem).parent().parent().children().children(name);
				}

				// Sets the slected button to appear as Active
				function nTextAreaMarkDownSetButtonState(button){
					$(button).parent().children(".active").removeClass("active");
					$(button).addClass("active");
				}

				// Loads the preview window
				$(".NTextareaMarkdown .preview").click(function(){
					var textArea = $(this).parent().parent().children(\'textarea\');
					nTextAreaMarkDownSetButtonState(this);
					var textArea = nTextAreaMarkDownGetTextArea(this,"textarea");
					var previewBox = nTextAreaMarkDownGetField(this,".previewBox");
					var update = $(this).parent().children(\'.updated\');
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
				});

				// Updates the status of the updated status
				$(".NTextareaMarkdown textarea").change(function(){
					var update = $(this).parent().parent().children(\'.buttons\').children(\'.NTextareaMarkdown .updated\');
					update.val("1");
					console.log(update.val());
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
}?>