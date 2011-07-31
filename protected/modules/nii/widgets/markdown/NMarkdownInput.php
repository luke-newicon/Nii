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
	public $editButtonAttrs = array('class'=>'mrs');

	/**
	 * The classes to be applied to the preview button
	 * @var string
	 */
	public $previewButtonAttrs = array('class'=>'mrs');

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
	
	
	public function run() {
		// The location of the markdown widgets asset folder
		$assetLocation = dirname(__FILE__) . DIRECTORY_SEPARATOR. 'assets';

		// The location the system ajax's to for its prview
		$ajaxLocation = NHtml::url($this->action);
		
		$nameId = $this->resolveNameID();
		$id = $nameId[1];

		// Includes the markdown style sheet
		$assetManager = yii::app()->getAssetManager();
		$assetFolder = $assetManager->publish($assetLocation);
		yii::app()->clientScript->registerCssFile("$assetFolder/style.css");
		yii::app()->clientScript->registerScriptFile("$assetFolder/markdown.js");
		// Handles the ajaxing of the preview
		$script = "jQuery('#md-$id').markdown({ajaxAction:'".NHtml::url($this->action)."'});";
		
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('maskedinput');
		$cs->registerScript('MarkdownEditor', $script);
		
		// If I have a model then display an active text area.
		if ($this->hasModel())
			$inputElement = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		else
			$inputElement = CHtml::textArea($this->name, $this->value, $this->htmlOptions);
		$this->render('markdown', array('inputElement' => $inputElement,'id'=>$id));
	}
	
	/**
	 * echos out the buttons for edit and preview as well as the help link
	 */
	public function displayButtons(){
		$this->editButtonAttrs['class'] = $this->editButtonAttrs['class'] . ' edit active';
		$this->previewButtonAttrs['class'] = $this->previewButtonAttrs['class'] . ' preview';
		echo '<div class="unit size1of2">';
		echo CHtml::link('Edit', '#', $this->editButtonAttrs);
		echo CHtml::link('Preview', '#', $this->previewButtonAttrs);
		echo '</div>';
		echo '<div class="lastUnit txtR">';
		echo CHtml::link('Help', 'http://daringfireball.net/projects/markdown/syntax', array('target' => 'blank', 'class' => 'help_button'));
		echo '</div>';
	}
	
}