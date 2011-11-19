<?php

/**
 * helper class to aid sql writing
 */
Class NQuery extends CComponent
{
	
	private $_multiInsert = null;
	private $_params;
	private $_tableName;
	
	/**
	 * the database connection
	 * @var CDbConnection
	 */
	private $_db;
	
	public function __construct($model){
		$this->_tableName = $model->tableName();
		$this->_db = $model->getDbConnection();
	}
	
	/**
	 * insert multiple rows in to the database at once. Add values using 
	 * the multiInsertValues method below.
	 * 
	 * @param array $fields the names of the fields you want to insert as array('col_name_1,col_name_2,col_name_3)
	 * @param boolean $ignore set to true if you want to do an INSERT IGNORE rather than just INSERT
	 * @return NQuery
	 */
	public function multiInsert($fields, $ignore=false){
		$this->_multiInsert['table'] = $this->_tableName;
		$this->_multiInsert['fields'] = $fields;
		$this->_multiInsert['ignore'] = $ignore;
		return $this;			
	}
	
	/**
	 * add another row of values to a multiInsert query. 
	 * These MUST be in the same order as the
	 * set of fields initially given in the multiInsert query
	 * @param array $rowValues array of values
	 * @return NQuery
	 */
	public function multiInsertValues($rowValues){
		if ($this->_multiInsert === null)
			throw new CException('Error: adding values to a multi-insert without having set the fields first');
		$this->_multiInsert['rows'][] = $rowValues;
		return $this;
	}
	
	
	
	/**
	 * create an insert query that inserts multiple rows for the same set of fields
	 * in one go. (C.f. _buildInsert that can handle multiple insert queries each of which
	 * inserts a single row with potentially other fields.)
	 * @return string
	 */
	private function _buildMultiInsert() {
		// find out what the columns are we're inserting
		$m = $this->_multiInsert;
		if (count($m['rows'])==0) // nothing to do
			return '';
		$cols = array();

		// now sort out the query
		$sql = 'INSERT '.($m['ignore']?'IGNORE ':'').'INTO '.$m['table'].' ';
		$sql .= '(`'.implode('`,`',$m['fields']).'`) VALUES ';
		$values = array();
		foreach ($m['rows'] as $n=>$row) {
			$rowValues = array();
			foreach ($row as $i=>$v){
				$col = $m['fields'][$i];
				//generate a param key name
				$col = ":$col".'_'.$n;
				$rowValues[] = $col;
				$this->_params[$col] = $v;
			}
			$values[] = '('.implode(',',$rowValues).')';
		}
		$sql .= implode(',',$values);
		return $sql;
	}
	
	private function _buildSql(){
		// build multiInsert
		if (!empty($this->_multiInsert)) {
			$sql = $this->_buildMultiInsert();
		}
		return $sql;
	}
	
	public function getSql()
	{
		return $this->_buildSql();
	}

	public function __toString()
	{
		return $this->_buildSql();
	}
	
	public function execute(){
		$this->_db->createCommand($this->getSql())
			->bindValues($this->_params)
			->execute();
	}
	
}