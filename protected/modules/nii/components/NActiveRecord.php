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
class NActiveRecord extends CActiveRecord
{
 
   
	
	/**
	 * Shorthand method to Yii::app()->db->createCommand()
	 *
	 * @return CDbCommand
	 */
	public function cmd(){
		return Yii::app()->db->createCommand()->from($this->tableName());
	}

	public function cmdSelect($select='*'){
		return Yii::app()->db->createCommand()->select($select)->from($this->tableName());
	}
	
	/**
	 * proxies to getPrimaryKey method
	 * @see CActiveRecord::getPrimaryKey
	 * @return mixed primary key value 
	 */
	public function id(){
		return $this->getPrimaryKey();
	}
	
	/**
	 * return the table schema
	 */
	public function schema(){
		return array();
	}

	
	public static function install($className){
		$t = new $className(null);
		$exists = Yii::app()->getMyDb()->getSchema()->getTable($t->tableName());
		$realTable = $t->getRealTableName();
		if(!$exists){ 
			Yii::app()->getMyDb()->createCommand()->createTable(
				$realTable,
				$t->schema()
			);
		}else{
			// adds columns that dont exist in the database
			$schema = $t->schema();
			$missingCols = array_diff(array_keys($schema), array_keys($exists->columns));
			foreach($missingCols as $col){
				Yii::app()->getMyDb()->createCommand()->addColumn($realTable, $col, $schema[$col]);
			}
		}
		$this->onAfterInstall(new CEvent($this));
	}
	
	/**
	 * an event called after installing the table, may be used to add rows as part
	 * of the install, you will want to check the table has been created successfully
	 * Yii::app()->getMyDb()->getSchema()->getTable($sender->tableName());
	 * 
	 * @param CEvent $event 
	 */
	public function onAfterInstall($event){
		$this->raiseEvent('onAfterInstall', $event);
	}
	
	/**
	 * Adds tablePrefix to tableName if necessary
	 * returns the raw string table name used by the database
	 * @return string 
	 */
	public function getRealTableName(){
		$realName = $this->tableName();
		if(Yii::app()->getMyDb()->tablePrefix!==null && strpos($realName,'{{')!==false)
			$realName=preg_replace('/\{\{(.*?)\}\}/',Yii::app()->getMyDb()->tablePrefix.'$1',$realName);
		return $realName;
	}
	
}
