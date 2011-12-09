<?php

/**
 * NTagInput class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
Yii::import('nii.widgets.tokeninput.NTokenInput');
/**
 * This widget is an extension of NTokenInput that is designed to work with 
 * a model that has the NTaggable behavior
 *
 * @see NTokenInput
 */
class NTagInput extends NTokenInput
{


	
	/**
	 * run the wdget overides the parent implementation to modify the widget for use with NTaggable plugin
	 */
	public function run(){

		list($name,$id)=$this->resolveNameID();

		// set defaults
		if (isset($this->htmlOptions['id'])) $id=$this->htmlOptions['id']; else	$this->htmlOptions['id']=$id;
		if (isset($this->htmlOptions['name'])) $name=$this->htmlOptions['name']; else $this->htmlOptions['name']=$name;

		$this->options['theme'] = isset($this->options['theme']) ? $this->options['theme'] : $this->theme;
		$this->options['hintText'] = isset($this->options['hintText']) ? $this->options['hintText'] : '';
		$this->options['addNewTokens'] = isset($this->options['addNewTokens']) ? $this->options['addNewTokens'] : true;
		$this->options['animateDropdown'] = isset($this->options['animateDropdown']) ? $this->options['animateDropdown'] : false;
				
		if(!$this->hasModel())
			throw new CHttpException ('You must supply the NTagInput widget with a valid model that has the NTaggable behavior applied');
		
		// pre populate the input (typically calls $model->tags)
		$value = CHtml::resolveValue($this->model, $this->attribute);
		if ($value!==null){
			// sort the array into id=>name and name=>name as we want the tag name to be the id
			$this->options['prePopulate'] = $this->model->tagWidgetFormat($value);
		}
				
		// add lookup automcomplete data
		if($this->data === null)
			$this->data = $this->model->getModelTags();
		if(is_array($this->data)){
			$this->data = $this->model->tagWidgetFormat($this->data);
		}
		
		echo '<div class="'.$this->inputClass.'">'.CHtml::textField($this->htmlOptions['name'],'',$this->htmlOptions).'</div>';
		
		if ($this->url !== null)
			$data = CJavaScript::encode(NHtml::url($this->url));
		else
			$data =  CJavaScript::encode($this->data);
		
		$options=CJavaScript::encode($this->options);

		$js = "jQuery('#{$this->htmlOptions['id']}').tokenInput($data,$options);";
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->htmlOptions['id'], $js, CClientScript::POS_READY);
	}

	
}