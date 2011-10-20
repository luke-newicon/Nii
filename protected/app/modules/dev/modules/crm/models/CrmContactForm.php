<?php

/**
 * CrmContactForm class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of CrmContactForm
 *
 * @author steve
 */
class CrmContactForm extends CrmContact 
{

	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return CMap::mergeArray(
			array(
				//array('first_name, last_name, company', 'NOneRequiredValidator','message'=>'At least one is required')
			),
			parent::rules()
		);
	}

}