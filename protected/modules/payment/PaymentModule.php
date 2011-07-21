<?php
/**
 * PaymentModule class file.
 *
 * @author Robin Williams <robin.williams@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of PaymentModule
 *
 * @author rob
 */


class PaymentModule extends NWebModule
{
	
public function init(){
		
		$this->setImport(array(
			'payment.models.*',
			'payment.components.*',
		));
		
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(!Yii::app()->getRequest()->getIsAjaxRequest()){
				
			}
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function install(){
		// install models for module e.g. Payment::install();

	}
	
}
