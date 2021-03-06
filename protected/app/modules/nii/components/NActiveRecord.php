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
 * Description of NActiveRecord
 *
 * @author steve
 */
class NActiveRecord extends CActiveRecord
{
	
	/**
	 * automatically return the table name based on the active record class name
	 * Splits the class name by camel case with an underscore, 
	 * sets as lower case, 
	 * and wraps with {{}}
	 * So class of ProjectTask becomes {{project_task}}
	 * @return string 
	 */
	public function tableName()
	{
		require_once 'Zend/Filter/Word/CamelCaseToUnderscore.php';
		$z = new Zend_Filter_Word_CamelCaseToUnderscore;
		return '{{'.strtolower($z->filter(__class__)).'}}';
	}
	
	/**
	 * Shorthand method to Yii::app()->db->createCommand()
	 *
	 * @return CDbCommand
	 */
	public function cmd()
	{
		return Yii::app()->db->createCommand();
	}
	
	/**
	 * Shorthand method to Yii::app()->db->createCommand()->select()->from
	 *
	 * @return CDbCommand
	 */
	public function cmdSelect($select='*')
	{
		return Yii::app()->db->createCommand()->select($select)->from($this->tableName());
	}
	
	
	
	/**
	 * proxies to getPrimaryKey method
	 * @see CActiveRecord::getPrimaryKey
	 * @return mixed primary key value 
	 */
	public function id()
	{
		return $this->getPrimaryKey();
	}
	
	/**
	 * return an array of the table schema,
	 * you can use Yii's abstract column names as defined in 
	 * yii.db.ar.schema.mysql.CMysqlSchema $columnTypes
	 * 
	 * For mysql the columnTypes are as follows: (as of Yii 1.1.7)
	 * 'pk' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
     * 'string' => 'varchar(255)',
     * 'text' => 'text',
	 * 'integer' => 'int(11)',
	 * 'float' => 'float',
	 * 'decimal' => 'decimal',
	 * 'datetime' => 'datetime',
	 * 'timestamp' => 'timestamp',
	 * 'time' => 'time',
	 * 'date' => 'date',
	 * 'binary' => 'blob',
	 * 'boolean' => 'tinyint(1)',
	 * 
	 * You can also specify table indexs.
	 * 'keys'=>array(
	 *		array('string: index name', 'string: index table column name', 'boolean: unique (defaults to false)')
	 * )
	 * 
	 * You can also specify foreign key relationships
	 * @see CDbCommand->aaddForeignKey() 
	 * 'foreignKeys'=>array(
	 *		array(
	 *			'string: name of relation',
	 *			'string: column',
	 *			'string: ref table name',
	 *			'string: ref columns separate with commas for multiple columns',
	 *			'string: the ON DELETE command string (e.g. CASCADE)',
	 *			'string: the ON UPDATE command string (e.g. NO ACTION)'
	 *	)
	 * 
	 * A typical example to create a contact table
	 * return array(
	 *		'columns'=>array(
	 *			'id'=>'pk',
	 *			'title'=>'string',
	 *			'first_name'=>'string NOT NULL',
	 *			'last_name'=>'string',
	 *			'company'=>'string',
	 *			'type'=>"enum('CONTACT','COMPANY','USER')",
	 *			'company_id'=>'int',
	 *			'user_id'=>'int'
	 *		),
	 *		'keys'=>array(
	 *			array('index_company_id', 'company_id'),
	 *			array('user_id')
	 *			array('username_key', 'username', true) // create a unique index
	 *		)
	 *		'foreignKeys'=>array(
	 *			array('user_to_contact','user_id','tbl_user','id','CASCADE','CASCADE')
	 *		)
	 *	);
	 */
	public function schema()
	{
		return array();
	}

	/**
	 * install the table from its defined schema, the child active record model
	 * must implement the schema function.
	 * The install can be called on existing tables, if the schema defined in the php
	 * class file is different from the mysql table the function will attempt to merge them.
	 * It will ONLY ADD columns, indexs or foreign key constraints
	 * 
	 * @param string $className 
	 */
	public static function install($className=__CLASS__)
	{
		FB::log('install ');
		$t = new $className(null);
		
		$t->attachBehaviors($t->behaviors());
		
		FB::log($className);
		
		$db = $t->getDbConnection();
		$exists = $db->getSchema()->getTable($t->tableName());
		
		$realTable = $t->getRealTableName();
		
		$s = $t->getSchemaComplete();
		
		if(!array_key_exists('columns', $s))
			throw new CException('The schema array must contain the array key "columns" with an array of the columns');
		// add table columns
		if(!$exists){ 
			$options = array_key_exists('options', $s)?$s['options']:'ENGINE=InnoDB DEFAULT CHARSET=utf8';
			$db->createCommand()->createTable(
				$realTable,
				$s['columns'],
				$options
			);
			$exists = $db->getSchema()->getTable($t->tableName());
		}else{
			// adds columns that dont exist in the database
			// a column can also be a sql statement and so the key is not a column
			// lets remove these (all columns where the key is not a string must be a statement and not a column
			$cols=array();
			foreach($s['columns'] as $key=>$c)
				if(is_string($key))$cols[$key]=$c;
			$missingCols = array_diff(array_keys($cols), array_keys($exists->columns));
			foreach($missingCols as $col){
				$db->createCommand()->addColumn($realTable, $col, $s['columns'][$col]);
			}
		}
		
		// add table keys / indexs
		if(array_key_exists('keys', $s)) {
			// see what keys the current table has
			$curtKeysRes = $db->createCommand("show keys from $realTable")->queryAll();
			// build a flat quick access array
			$curKeys = array();
			foreach($curtKeysRes as $keyRow)
				$curKeys[] = $keyRow['Key_name'];
			
			foreach($s['keys'] as $k){
				$name = $k[0];
				$unique = array_key_exists(2, $k) ? $k[2] : false;
				$column =  array_key_exists(1, $k) ? $k[1] : $name;
				// check if key is already in the table
				if(!in_array($name, $curKeys))
					$db->createCommand()->createIndex($name, $realTable, $column, $unique);
			}
		}
		
		// add foriegn keys
		if(array_key_exists('foreignKeys', $s)) {
			foreach($s['foreignKeys'] as $f){
				$delete = array_key_exists(4, $f) ? $f[4] : NULL;
				$update = array_key_exists(5, $f) ? $f[5] : NULL;
				// if the key is not already in on the table add it.
				if ($exists && !array_key_exists($f[1], $exists->foreignKeys))
					$db->createCommand()->addForeignKey($f[0], $realTable, $f[1], $f[2], $f[3], $delete, $update);
			}
		}
		$t->onAfterInstall(new CEvent($t));
	}
	
	/**
	 * removes the table from the database and destroys all data
	 * BE CAREFUL!
	 */
	public static function uninstall($className)
	{
		$tbl = NActiveRecord::model($className)->getRealTableName();
		Yii::app()->db->createCommand()->dropTable($tbl);
		
	}
	
	/**
	 * an event called after installing the table, may be used to add rows as part
	 * of the install, you will want to check the table has been created successfully
	 * 
	 * <code>
	 * Yii::app()->getMyDb()->getSchema()->getTable($sender->tableName());
	 * </code>
	 * 
	 * @param CEvent $event 
	 */
	public function onAfterInstall($event)
	{
		$this->raiseEvent('onAfterInstall', $event);
	}
	
	
	/**
	 * an event called before installing the table, may be used to modify the schema 
	 * with addiontal columns $event->schema
	 * 
	 * @param CEvent $event 
	 */
	public function onBeforeInstall($event)
	{
		$this->raiseEvent('onAfterInstall', $event);
	}
	
	/**
	 * tries to determine the standard datatype of the attribute
	 * @param string $attribute 
	 */
	public function getAttributeDataType($attribute)
	{
		$dataType = 'string';
		$schema = $this->schema();
		if(!empty($schema) && array_key_exists('columns', $schema)){
			$cols = $schema['columns'];
			if(array_key_exists($attribute, $cols)){
				$dataType = $cols[$attribute];
			}
		}
		return $dataType;
	}
	
	/**
	 * Binds the schema array
	 * @see NActiveRecord::shema with results in attached behaviors 
	 * @see NActiveRecordBahevior::schema
	 * @return array schema
	 */
	public function getSchemaComplete()
	{
		$schema = $this->schema();
		foreach($this->behaviors() as $behavior=>$config){
			if($this->asa($behavior) instanceof NActiveRecordBehavior)
				$schema = CMap::mergeArray($schema, $this->asa($behavior)->schema());
		}
		return $schema;
	}
	
	/**
	 * Adds tablePrefix to tableName if necessary
	 * returns the raw string table name used by the database
	 * @return string 
	 */
	public function getRealTableName()
	{
		$realName = $this->tableName();
		if($this->getDbConnection()->tablePrefix!==null && strpos($realName,'{{')!==false)
			$realName=preg_replace('/\{\{(.*?)\}\}/',$this->getDbConnection()->tablePrefix.'$1',$realName);
		return $realName;
	}
	
	/**
	 * Generic parent function for displaying a model's columns in a grid (or exporting)
	 * This function should be set in every model extending NActiveRecord and follow the structure that NGridView expects
	 * 
	 * @return array 
	 */
	public function columns() {
		return array();
	}
	
	
	public function dateRangeCriteria(&$criteria, $field) {
		$from = $field.'_from';
		$to = $field.'_to';
		
		if((isset($this->$from) && trim($this->$from) != "") && (isset($this->$to) && trim($this->$to) != ""))
			$criteria->addBetweenCondition($field, ''.$this->$from.'', ''.$this->$to.'');
	}
	
	/**
	 *	Returns an array of available scopes to list as buttons above the grid view
	 *	Currently only items is in use, but this could easily be extended to set the default etc.
	 *	@return array - uses formatting like 'scopes' in NScopeList and NGridView
	 * 
	 *	Example array to be returned:
	 *	array(
	 *		'items' => array(
	 *			'scope' => array(
	 *				'label' => 'Scope Name',
	 *				'description' => 'Description of the scope',
	 *			),
	 *		)
	 *	)
	 * 
	 */
	public function getGridScopes() {
		return array();
	}
	
	/**
	 * Get the model in the search scenario state. Populate with search attributes
	 * $_GET[$className];
	 * @param string $className
	 * @return NActiveRecord in scenario search
	 */
	public function searchModel()
	{
		$className = get_class($this);
		$model = new $className('search');
		$model->unsetAttributes();
		if(isset($_GET[$className]))
			$model->attributes = $_GET[$className];
		return $model;
	}
	
}
