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
class NActiveRecord extends CActiveRecord {
	
	
	/**
	 * Shorthand method to Yii::app()->db->createCommand()
	 *
	 * @return CDbCommand
	 */
	public function q(){
		return Yii::app()->db->createCommand()->from($this->tableName());
	}

	public function qSelect($select='*'){
		return Yii::app()->db->createCommand()->select($select)->from($this->tableName());
	}


}
