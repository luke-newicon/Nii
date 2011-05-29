<?php
class Newicon_Db_Query {

	/**
	 * @var Newicon_Db_Table
	 */
	private $_table;

	private $_select = null;
	private $_calcTotalRows = false;
	private $_from = array();
	private $_joins = array();
	private $_where = array();
	private $_order = array();
	private $_limit = null;
	private $_offset = 0;
	private $_set = array();
	private $_update = null;
	private $_inserts = null;
	private $_multiInserts = null;
	private $_delete = null;
	private $_groupBy = array();
	private $_ignore = '';

	public function __construct($table)
	{
		$this->_table = $table;
	}

	/**
	 * @return Newicon_Db_Table
	 */
	public function getTableName(){
		return $this->_table->getTableName();
	}

	/**
	 *
	 * @param $cols string of comma delimited database columns null = *
	 * @return Newicon_Db_Query
	 */
	public function select($cols = null)
	{
		if ($this->_update !== null || $this->_inserts !== null || $this->_delete !== null)
			throw Newicon_Exception('Error: this select query is already being used for update, insert or delete.');

		if($cols !== null) {
			$this->_select .= $cols;
		} else {
			$this->_select = '*';
		}

		return $this;
	}

	/**
	 * @param $table | name of the table
	 * @param $tableRef | letter reference to the table
	 * @return Newicon_Db_Query
	 */
	public function from($table, $tableRef=null) {
		if ($tableRef !== null)
			$table = "`$table` $tableRef";
		$this->_from[] = $table;
		return $this;
	}

	/**
	 *
	 * @return Newicon_Db_Query
	 */
	public function update(){
		if($this->_select !== null || $this->_inserts !== null || $this->_delete !== null)
			throw Newicon_Exception('Error: query already set for select, insert or delete. Cannot use for update.');

		$this->_update = 'UPDATE ' . $this->_table->getTableName() . ' ';
		return $this;
	}

	/**
	 * Add a set of field-value pairs for separate insert queries. Multiple rows with different fields and values
	 * can be set using repeated calls of this method. If you are inserting multiple rows with the same fields
	 * in each case then you can use the multiInsert method instead.
	 *
	 * @param array $row | 'field'=>'value'
	 * @param ignore adds the ignore keyword to sql query
	 * @return Newicon_Db_Query
	 */
	public function insert($row, $ignore=false){
		if($this->_select !== null || $this->_delete !== null || $this->_update !== null)
			throw Newicon_Exception('Error: query already set for select, delete or update. Cannot use for insert.');

		$this->_inserts[] = array('inserts' => $row, 'ignore'=>$ignore);
		return $this;
	}

	/**
	 * Verbose way of calling insert($row,true)
	 * @param $row
	 * @return unknown_type
	 */
	public function insertIgnore($row){
		$this->insert($row,true);
	}

	/**
	 * insert multiple rows in to the database at once. Add values using the values method below.
	 * @param $fields  the names of the fields you want to insert as [n]=>name
	 * @param $ignore  set to true if you want to do an INSERT IGNORE rather than just INSERT
	 * @return unknown_type
	 */
	public function multiInsert($fields, $ignore=false) {
		if($this->_select !== null || $this->_delete !== null || $this->_update !== null || $this->_inserts !== null)
			throw Newicon_Exception('Error: query already set for select, insert, delete or update. Cannot use for multiInsert.');

		$this->_multiInsert['fields'] = $fields;
		$this->_multiInsert['ignore'] = $ignore;
		return $this;
	}

	/**
	 * add another row of values to a multiInsert query. These MUST be in the same order as the
	 * set of fields initially given in the multiInsert query
	 * @param $row array of values
	 * @return unknown_type
	 */
	public function values($row) {
		if ($this->_multiInsert === null)
			throw Newicon_Exception('Error: adding values to a multi-insert without having set the fields first');
		$row = is_array($row)?$row:array($row);
		$this->_multiInsert['rows'][] = $row;
		return $this;
	}

	/**
	 *
	 * @return Newicon_Db_Query
	 */
	public function delete(){
		if($this->_select !== null || $this->_inserts !== null || $this->_update !== null)
			throw Newicon_Exception('Error: this delete query is already being used for select, insert or update.');

		$this->_delete = 'DELETE FROM ' . $this->_table->getTableName() . ' ';
		return $this;
	}

	/**
	 * Performs a join on two tables
	 * @param $tableForeign  the foreign table (Right Hand Side) we're joining to
	 * @param $columnForeign  the foreign column on the table
	 * @param $columnLocal  the local column if not the same as the foreign column
	 * @param $tableLocal  the local table (Left hand side) if not the one we're doing the query on
	 * @param $tableForeignRef  a letter reference to the foreign table in the join
	 * @param $tableLocalRef  a letter reference to the local table in the join
	 * @return Newicon_Db_Query
	 */
	public function join($tableForeign, $columnForeign, $columnLocal=null, $tableLocal=null, $tableForeignRef=null) {
			return $this->_setJoin('JOIN', $tableForeign, $columnForeign, $columnLocal, $tableLocal, $tableForeignRef);
	}

	/**
	 * 
	 * @param $tableForeign
	 * @param $columnForeign
	 * @param $columnLocal
	 * @param $tableLocal
	 * @param $tableForeignRef
	 * @param $tableLocalRef
	 * @return Newicon_Db_Query
	 */
	public function joinLeft($tableForeign, $columnForeign, $columnLocal=null, $tableLocal=null, $tableForeignRef=null, $tableLocalRef=null)	{
		return $this->_setJoin('LEFT JOIN', $tableForeign, $columnForeign, $columnLocal, $tableLocal, $tableForeignRef, $tableLocalRef);
	}
	/**
	 * Performs a join on two tables
	 * @param $tableForeign  the foreign table (Right Hand Side) we're joining to
	 * @param $columnForeign  the foreign column on the table
	 * @param $columnLocal  the local column if not the same as the foreign column
	 * @param $tableLocal  the local table (Left hand side) if not the one we're doing the query on
	 * @param $tableForeignRef  a letter reference to the foreign table in the join
	 * @param $tableLocalRef  a letter reference to the local table in the join
	 * @return Newicon_Db_Query
	 */
	public function joinLeftOuter($tableForeign, $columnForeign, $columnLocal=null, $tableLocal=null, $tableForeignRef=null, $tableLocalRef=null) {
		return $this->_setJoin('LEFT OUTER JOIN', $tableForeign, $columnForeign, $columnLocal, $tableLocal, $tableForeignRef, $tableLocalRef);
	}

	public function joinRight($tableForeign, $columnForeign, $columnLocal=null, $tableLocal=null, $tableForeignRef=null, $tableLocalRef=null) {
		return $this->_setJoin('RIGHT JOIN', $tableForeign, $columnForeign, $columnLocal, $tableLocal, $tableForeignRef, $tableLocalRef);
	}

	public function joinRightOuter($tableForeign, $columnForeign, $columnLocal=null, $tableLocal=null, $tableForeignRef=null, $tableLocalRef=null) {
		return $this->_setJoin('RIGHT OUTER JOIN', $tableForeign, $columnForeign, $columnLocal, $tableLocal, $tableForeignRef, $tableLocalRef);
	}

	private function _setJoin($joinType, $tableForeign, $columnForeign, $columnLocal=null, $tableLocal=null, $tableForeignRef=null, $tableLocalRef=null) {
		if ($columnLocal===null)
			$columnLocal = $columnForeign;
		if ($tableLocal===null)
			$tableLocal = $this->_table->getTableName();

		$this->_joins[] = array(
			'tableForeign'       => $tableForeign,
			'columnForeign'      => $columnForeign,
			'columnLocal'        => $columnLocal,
			'tableLocal'         => $tableLocal,
			'tableForeignRef'    => $tableForeignRef,
			'tableLocalRef'      => $tableLocalRef,
			'type'				 => $joinType
		);
		return $this;
	}

	/**
	 *
	 * @param $col string Column name
	 * @return Newicon_Db_Query
	 */
	public function groupBy($col){
		$this->_groupBy[] = $col;
		return $this;
	}

	/**
	 * Adds a where clause if multiple where clause uses AND
	 *
	 * @param $where
	 * @param $value
	 * @return Newicon_Db_Query
	 */
	public function where($where, $value=null, $level=0)
	{
		$this->_whereAdd($where, $value, 'AND', $level);
		return $this;
	}

	/**
	 * 
	 * @param $where
	 * @param $value
	 * @param $level
	 * @return Newicon_Db_Query
	 */
	public function orWhere($where, $value=null, $level=0){
		$this->_whereAdd($where, $value, 'OR', $level);
		return $this;
	}

	private function _whereAdd($where, $value=null, $type, $level=0){

		//need to find column in string to correctly quote the value
		$cols = $this->getTable()->getColumns();
		//loop through columns to see which column the where clause concerns
		preg_match('/([a-z_]*)/', $where ,$matches);
		foreach($matches as $whereCol){
			//for each potential column name see if there is a matching defined column
			if(array_key_exists($whereCol, $cols)){
				//found column definition run conversion
				$value = $cols[$whereCol]->php2db($value);
				break;
			}
		}

		if(strpos($where, '?')){
			$where = $this->quoteInto($where, $value);
		}

		$this->_where[] = array('condition' => '' . $where . '',
								'type'      => $type,
								'level'     => $level);
	}
	
	public function appendWheres(Newicon_Db_Query $query) {
		foreach ($query->_where as $w)
			$this->_where[] = $w;
	}

	public function clear(){
		$this->_where = array();
		$this->_order = array();
		$this->_limit = null;
		$this->_groupBy = array();
		$this->_offset = 0;
		return $this;
	}

	public function clearWhere(){
		$this->_where = array();
		return $this;
	}
	/**
	 *
	 * @param string $field
	 * @param varient $value
	 * @return Newicon_Db_Query
	 */
	public function set($field, $value, $literal=false) {
		//convert php value to db value
		if ($literal) {
			$this->_set[] = '`' . $field . '` = ' . $value;
		} else {
			if($this->getTable()->columnDefinitionExists($field)){
				$col = $this->getTable()->$field;
				$value = $col->php2db($value);
			}
			$this->_set[] = '`' . $field . '` = ' . $this->_quote($value);
		}
		return $this;
	}


	public function quoteInto($string, $value) {

		return str_replace('?', $this->_quote($value), $string);
	}

	public function escape($value){
		return $this->_table->getDb()->escape($value);
	}

	/**
	 * @param $order string order statement
	 * @param $type string ASC | DESC default ASC
	 * @return Newicon_Db_Query
	 */
	public function order($order, $type='ASC')
	{
		$this->_order[] = $order . ' ' . $type;
		return $this;
	}
	public function clearOrder(){
		$this->_order = array();
		return $this;
	}

	/**
	 *
	 * @param $int
	 * @return Newicon_Db_Query
	 */
	public function limit($limit, $offset=null)
	{
		$this->_limit = $limit;
		if ($offset!==null)
			$this->offset($offset);
		return $this;
	}
	public function clearLimit(){
		$this->_limit = null;
		$this->offset(null);
		return $this;
	}

	public function offset($offset)
	{
		$this->_offset = $offset;
		return $this;
	}


	/**
	 * return the sql statement as a string
	 * @return string| sql statement
	 */
	private function _generateSql()
	{

		// build select
		if ($this->_select !== null) {
			$sql = $this->_buildSelect();
		}

		// build insert
		elseif(!empty($this->_inserts)){
			$sql = $this->_buildInsert();
		}

		// build multiInsert
		elseif (!empty($this->_multiInsert)) {
			$sql = $this->_buildMultiInsert();
		}

		// build update
		elseif($this->_update !== null ){
			$sql = $this->_buildUpdate();
		}

		// build delete
		elseif($this->_delete !== null ){
			$sql = $this->_delete;
		}

		$sql .= $this->_buildWhere();

		// group by
		$sql .= $this->_groupBy();

		// build order
		if(!empty($this->_order)) {
			$sql .= ' ORDER BY ' . implode(',',$this->_order);
		}

		// build limit
		if ($this->_limit !== null) {
			$sql .= ' LIMIT ';

			if ($this->_select !== null ) {
				$sql .= $this->_offset . ', ';
			}

			$sql .= $this->_limit;
		}
		return $sql;

	}

	private function _groupBy(){
		$sql = '';
		if(!empty($this->_groupBy)) {
			$sql .= ' GROUP BY ' . implode(',',$this->_groupBy);
		}
		return $sql;
	}

	/**
	 * create a set of insert queries that each insert a single row in to the database.
	 * (c.f. _buildMultiInsert which can insert multiple rows in a single insert query)
	 * @return string
	 */
	private function _buildInsert(){
		$sql = '';
		foreach($this->_inserts as $inData){
			if ($sql != '') $sql .= '; ';
			$fieldList = array(); $valueList = array();
			foreach ($inData['inserts'] as $field=>$value){
				if ($value !== null) {
					if ($this->getTable()->columnDefinitionExists($field)) {
						$col = $this->getTable()->$field;
						$value = $col->php2db($value);
					}
					$fieldList[] = $field;
					$valueList[] = $this->_quote($value);
				}
			}
			$sql .= 'INSERT '.($inData['ignore']?'IGNORE ':'').'INTO ' . $this->_table->getTableName() . ' ';
			$sql .= " (`" . implode('`,`',$fieldList) . '`) ';
			$sql .= "VALUES (" . implode(",",$valueList) . ")";
		}
		return $sql;
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
		foreach ($m['fields'] as $i=>$c)
			$cols[$i] = $this->getTable()->$c;

		// now sort owt the query
		$sql = '';
		$sql = 'INSERT '.($m['ignore']?'IGNORE ':'').'INTO '.$this->_table->getTableName().' ';
		$sql .= '(`'.implode('`,`',$m['fields']).'`) VALUES ';
		$values = array();
		foreach ($m['rows'] as $n=>$row) {
			$vs = array();
			foreach ($row as $i=>$v)
				$vs[$i] = $this->_quote($cols[$i]->php2db($v));
			$values[] = '('.implode(',',$vs).')';
		}
		$sql .= implode(',',$values);
		return $sql;
	}

	private function _buildUpdate(){
		$sql = $this->_update;

		$sql .= 'SET ' . implode(',',$this->_set);
		//build set

		return $sql;
	}

	private function _buildSelect(){
		$sql  = 'SELECT '.($this->_calcTotalRows?' SQL_CALC_FOUND_ROWS ':'').$this->_select;

		//build from
		$sql .= ' FROM ';
		if (empty($this->_from)) {
			 $sql .= $this->_table->getTableName();
		} else {
			$sql .= implode(', ', $this->_from);
		}

		//join
		foreach($this->_joins as $join){
			$sql .= $this->_buildJoin($join, $join['type']);
		}

		return $sql;
	}

	private function _buildJoin($join, $type=null) {
		if (is_object($join['tableForeign']))
			$join['tableForeign'] = $join['tableForeign']->getTableName();

		if (is_object($join['tableLocal']))
			$join['tableLocal'] = $join['tableLocal']->getTableName();

		if ($join['tableForeignRef']===null)
			$sql = " $type " . $join['tableForeign'] . ' ON ';
		else
			$sql = " $type " . $join['tableForeign'] . ' '. $join['tableForeignRef'] . ' ON ';

		if ($join['tableLocalRef'])
			$sql .= $join['tableLocalRef'] . '.' . $join['columnLocal'] . ' = ';
		else
			$sql .= $join['tableLocal'] . '.' . $join['columnLocal'] . ' = ';

		if ($join['tableForeignRef'])
			$sql .= $join['tableForeignRef'] . '.' . $join['columnForeign'];
		else
			$sql .= $join['tableForeign'] . '.' . $join['columnForeign'];
		return $sql;
	}

	private function _buildWhere(){
		//build where
		$sql='';
		$lastLevel = 0;
		foreach ($this->_where as $key => $where){

			//close brackets
			$brackets = $lastLevel - $where['level'];
			if($brackets>0) $sql .= str_repeat(' ) ', $brackets);

			$sql .= ' ';
			$sql .= ($key == 0) ? 'WHERE' : $where['type'];

			//open brackets
			$brackets = $where['level'] - $lastLevel;
			if($brackets>0) $sql .= str_repeat(' ( ', $brackets);

			$sql .= ' ' . $where['condition'] . ' ';

			$lastLevel = $where['level'];

		}
		if ($lastLevel>0) {
			$sql .= str_repeat(' ) ', $lastLevel);
		}

		return $sql;
	}

	public function getJoinTableObjects(){

	}

	/**
	 * Execute the sql statement
	 * @return Newicon_Db_Rowset
	 */
	public function go()
	{
		if ($this->_select !== null){
			$rowset = $this->getTable()->getDb()->query($this->_generateSql());
			if ($this->_calcTotalRows) {
				$fr = $this->getTable()->getDb()->query('SELECT FOUND_ROWS() as foundRows')->current();
				$rowset->foundRows = $fr->foundRows;
			}
			$rowset->setTable($this->getTable());

			//build an array of classes used by the select query
			$rowClasses = array();
			foreach($this->_joins as $join){
				if(is_object($join['tableForeign'])){
					$tblObj = $join['tableForeign'];
					$rowClasses[] = $tblObj->getRowClass();
				}
			}
			//tell the rowset what row class context to use when creating row objects, also
			//pass in an array of additional classes used in the query to add as row behaviours
			$rowset->setRowClass($this->_table->getRowClass(), $rowClasses);
			return $rowset;
		}

		if ($this->_inserts !== null || $this->_update !== null || $this->_delete !== null || $this->_multiInsert !== null)
			return $this->getTable()->getDb()->dbQuery($this->_generateSql());
		return null;
	}
	
	/**
	 * Expects to get one row from the database
	 * If extactly one row is returned it returns the row.
	 * Otherwise it returns false
	 * @return Newicon_Db_Row
	 */
	public function goGetRow(){
		$res = $this->go();
		if($res->count() == 1)
			return $res->current();
		return false;
	}

	/**
	 * Calculate the number of rows that would have been returned in a select query with a limit clause
	 * To get the total, access the rowset->foundRows method.
	 */
	public function calculateTotalRows($calc=true) {
		$this->_calcTotalRows = $calc;
		return $this;
	}

	/**
	 * A more efficient mysql count of total rows in the table
	 * @return integer
	 */
	public function count() {
		$oldSelect = $this->_select;
		$oldLimit = $this->_limit;
		$oldOffset = $this->_offset;
		$oldCalcTotalRows = $this->_calcTotalRows;
		// if there is a groupBy clause in the query, the count(*) fails
		// as each groupBy counts as a separate count. So in this case use
		// the total number of rows found
		if (count($this->_groupBy)>0) {
			$this->_calcTotalRows = true;
			$this->_limit=1;
			$this->_offset=0;
		} else {
			$this->_select = 'COUNT(*) as count';
		}
		$rowset = $this->_table->getDb()->query($this->_generateSql());
		$count = 0;
		if (count($this->_groupBy)>0) {
			$fr = $this->getTable()->getDb()->query('SELECT FOUND_ROWS() as foundRows')->current();
			$count = $fr->foundRows;
			$this->_calcTotalRows = $oldCalcTotalRows;
			$this->_limit = $oldLimit;
			$this->_offset = $oldOffset;
		} else {
			$count = $rowset->current()->count;
			$this->_select = $oldSelect;
		}
		return $count;
	}

	/**
	 * Quote a raw string.
	 *
	 * @param string $value Raw string
	 * @return string Quoted string
	 */
	protected function _quote($value)
	{
		if (is_int($value)) {
			return $value;
		} elseif (is_float($value)) {
			return sprintf('%F', $value);
		}
		return "'" . $this->escape($value) . "'";
	}


	public function getSqlString()
	{
		return $this->_generateSql();
	}

	public function __toString()
	{
		return $this->_generateSql();
	}
	/**
	 * @return Newicon_Db_Table
	 */
	public function getTable(){
		return $this->_table;
	}
}