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
class NActiveForm extends CActiveForm
{
	
	public $enableAjaxValidation=true;
	public $enableClientValidation=true;

	
	/**
	 * options passed to javascript validation
	 * @see CActiveForm::clientOptions this
	 * sets the default to set error message class onto the .field html object
	 * @var type 
	 */
	public $clientOptions = array('inputContainer'=>'.field');
	
	public function init(){
		// add small script to add focus class to parent .field element
		$cs = Yii::app()->clientScript;
		$cs->registerScript('NActiveForm#focusfields','
			$(":input").focus(function(){$(this).closest(".field").addClass("focus");})
				.blur(function(){$(this).closest(".field").removeClass("focus");});
		');
		parent::init();
	}
	
	public function markdown(){
		// todo add nii input widgets
	}
	
	public function wysiwyg(){
		// todo add nii input widget
	}
	
}