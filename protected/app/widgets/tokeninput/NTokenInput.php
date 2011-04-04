<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Class NTokenInput extends CInputWidget
{

	public $assetUrl;

	public $options;

	/**
	 * url to look up the data
	 * normalise url will be called on this NHtml::url() -> CHtml::normalizeUrl
	 * @var string
	 */
	public $url;

	/**
	 * array of search data Or define url to load data by ajax
	 * @var array
	 */
	public $data;

	public $theme = 'nii';


	public function init() {
		$this->publishAssets();
	}

	public function run(){

		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
		else
			$this->htmlOptions['name']=$name;

		if($this->hasModel())
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);

		

		if($this->url === null && $this->data === null)
			throw new CException('you must specify the data for the tokens by specifing the data property as an array
				of tokens or the url to ajax the data in.');

		if($this->url !== null)
			$data = CJavaScript::encode($this->url);
		else
			$data =  CJavaScript::encode($this->data);

		
		// sort options array out
		if(!isset($this->options['theme']))
			$this->options['theme'] = $this->theme;
		
		$options=CJavaScript::encode($this->options);

		$js = "jQuery('#{$id}').tokenInput($data,$options);";
		//$cs = Yii::app()->getClientScript();
		echo '<script>jQuery(function($){'.$js.'});</script>';
		//$cs->registerScript(__CLASS__.'#'.$id, $js);
	}

	public function publishAssets(){
		$localPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this->assetUrl = Yii::app()->getAssetManager()->publish($localPath);

		Yii::app()->clientScript->registerScriptFile($this->assetUrl . '/src/jquery.tokeninput.js');
		Yii::app()->clientScript->registerCssFile($this->assetUrl . '/styles/token-input.css');
		Yii::app()->clientScript->registerCssFile($this->assetUrl . '/styles/token-input-facebook.css');
		Yii::app()->clientScript->registerCssFile($this->assetUrl . '/styles/token-input-mac.css');
	}

}