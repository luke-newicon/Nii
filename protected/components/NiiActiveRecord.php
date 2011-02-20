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
 * Description of NiiActiveRecord
 *
 * @author steve
 */
class NiiActiveRecord extends CActiveRecord {
	
	
	public function query(){
		return Yii::app()->db->createCommand()
			->from(self::model()->tableName());
	}
}
