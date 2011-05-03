<?php
/**
 * Show a markdown input textarea,
 * Transforms a typical textarea to have a preview button displaying markdown rendered
 * output for the textarea's text.
 * 
 * !!! TODO: add view to tidy up code.
 * !!! TODO: indentation?!?
 * !!! TODO: console.log statements will break all browsers except firefox!
 * !!! TODO: make containing foler lowercase
 */
class NMarkdownInput extends CInputWidget {

	public $htmlOptions;

	public function run() {
			echo $this->value;
			list($name,$id) = $this->resolveNameID();
			echo '<div class="NTextareaMarkdown" style="padding:10px;border:1px solid #ccc;">';
				echo '<div class="buttons" style="margin-bottom:2px;">';
					echo cHtml::button('Edit', array('style'=>'margin:0px;','class'=>'btn btnN btnToolbar btnToolbarLeft NTextareaMarkdown edit active'));
					echo cHtml::button('Preview', array('style'=>'margin:0px;','class'=>'btn btnN btnToolbar btnToolbarRight NTextareaMarkdown preview'));
					echo cHtml::hiddenField('textAreaStatus',1, array('class'=>'NTextareaMarkdown updated'));
					echo cHtml::link('Help', 'http://daringfireball.net/projects/markdown/syntax',array('target'=>'blank','style'=>'margin: 7px;'));
				echo '</div>';

				echo '<div style="border:1px solid #ccc;">';
					if ($this->hasModel())
						echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
					else
						echo CHtml::textArea($name, $this->value, $this->htmlOptions);
				echo '</div>';

				echo '<div class="NTextareaMarkdown previewBox" style="display:none;">Please Load a preview</div>';
				echo '<div class="NTextareaMarkdown helpBox" style="display:none;border:1px solid #ccc;">
				<h2>Help</h2>
				<a href="http://daringfireball.net/projects/markdown/syntax"  target="_blank">Click here for help on formatting your text</a>';
				$jsPreviewClick = '
				// Gets the specified field
				function nTextAreaMarkDownGetField(callingItem,name){
					return $(callingItem).parent().parent().children(name);
				}
				function nTextAreaMarkDownGetTextArea(callingItem,name){
					return $(callingItem).parent().parent().children().children(name);
				}

				// Loads the preview window
				$(".NTextareaMarkdown.preview").click(function(){
				var textArea = $(this).parent().parent().children(\'textarea\');
				nTextAreaMarkDownSetButtonState(this);
					var textArea = nTextAreaMarkDownGetTextArea(this,"textarea");
					var previewBox = nTextAreaMarkDownGetField(this,".NTextareaMarkdown.previewBox");
					var helpBox = nTextAreaMarkDownGetField(this,".NTextareaMarkdown.helpBox");
					var update = $(this).parent().children(\'.NTextareaMarkdown .updated\');
					previewBox.show();
					textArea.parent().hide();
					helpBox.hide();
					if(update.val()==1){
						previewBox.html("<p>Loading...</p>");
						$.ajax({
						   type: "POST",
						   url: "'.yii::app()->createUrl('nii/index/markdownPreview').'",
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

				// Sets the slected button to appear as Active
				function nTextAreaMarkDownSetButtonState(button){
					$(".btn.active").removeClass("active");
					$(button).addClass("active");
				}

				// Displays the help file for the widget
				$(".NTextareaMarkdown.edit").click(function(){
				nTextAreaMarkDownSetButtonState(this);
					var textArea = nTextAreaMarkDownGetTextArea(this,"textarea");
					var previewBox = nTextAreaMarkDownGetField(this,".NTextareaMarkdown.previewBox");
					var helpBox = nTextAreaMarkDownGetField(this,".NTextareaMarkdown.helpBox");
					previewBox.hide();
					textArea.parent().show();
					helpBox.hide();
				});';
			$cs=Yii::app()->getClientScript();
			$cs->registerCoreScript('maskedinput');
			$cs->registerScript('Test',$jsPreviewClick);
		echo '</div>';
	}
}
?>