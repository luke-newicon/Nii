<?php

/**
 * NActiveForm class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * NActive form applies frequently used defaults to the CActiveForm widget
 * 
 * it asssumes you have used the following oocss form field structure for form elements
 * <div class="field"> // this element will recieve error and validation classes
 *     // labels and other elements
 *     <div class="inputBox">
 *         // input element
 *     </div>
 *     // error messages
 * </div>
 * 
 *  
 * @author steve
 */
class NActiveForm extends CActiveForm {

	public $enableAjaxValidation = true;
	public $enableClientValidation = true;

	/**
	 * options passed to javascript validation
	 * @see CActiveForm::clientOptions this
	 * sets the default to set error message class onto the .field html object
	 * @var type 
	 */
	public $clientOptions = array('inputContainer' => '.field');

	public function init() {
		// add small script to add focus class to parent .field element
		$cs = Yii::app()->clientScript;
		parent::init();
	}

	public function markdown() {
		// todo add nii input widgets
	}

	public function wysiwyg() {
		// todo add nii input widget
	}

	/**
	 * Renders an HTML label for a model attribute.
	 * This method is a wrapper of {@link CHtml::activeLabelEx}.
	 * Please check {@link CHtml::activeLabelEx} for detailed information
	 * about the parameters for this method.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes.
	 * @return string the generated label tag
	 */
	public function labelEx($model, $attribute, $htmlOptions=array()) {
		if (empty($htmlOptions)) {
			$htmlOptions = array('class' => 'lbl');
		}
		return parent::labelEx($model, $attribute, $htmlOptions);
	}

	public function field($model, $attribute, $type='textField', $data=null, $htmlOptions=array()) {
		$return = '<div class="field">';
		$return .= $this->labelEx($model, $attribute);
		$return .= '<div class="input">';
		if($type == 'dropDownList'){
			$return .= $this->dropDownList($model, $attribute, $data);
		} else
			$return .= $this->$type($model, $attribute);
		$return .= '</div>';
		$return .= $this->error($model, $attribute);
		$return .= '</div>';
		return $return;
	}

}