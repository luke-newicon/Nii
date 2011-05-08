<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of UserDomain
 *
 * @author steve
 */
class AppUserDomain extends NActiveRecord
{
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'domain'=>'string',
				'user_id'=>'int',
			),
			'keys'=>array(
				array('domain'),
				array('user_id')
			)
		);
	}
}
