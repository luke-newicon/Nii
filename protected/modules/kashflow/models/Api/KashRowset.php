<?php
class KashRowset extends KashIterator
{

	private $_rowClass;
	
	private $_r = array();



	public function current()
	{
//dp($this->_d);
		if(empty($this->_r[$this->_i])){
			$this->_r[$this->_i] = new $this->_rowClass();
			$this->_r[$this->_i]->setData($this->_d[$this->_i]);

			foreach($this->_d[$this->_i] as $name => $value){
				if(is_array($value) && empty($value)){
					$value = '';
				}
				$this->_r[$this->_i]->$name = $value;
			}
		}
		return $this->_r[$this->_i];
	}
	
	public function setRowClass($rowClass){
		$this->_rowClass = $rowClass;
	}
	
	/**
	 * Resets the row data array
	 * 
	 * @param string $var
	 * @param $order
	 * @return Nworx_Kashflow_Model_Api_Rowset
	 */
	public function orderBy($var,$order='ASC'){
		$_temp = array();
		// Loop and get the variable to sort by in a temp array
		foreach($this->_d as $key => $row){
			$_temp[$key] = $row[$var];
		}
		// Sort the arrays depending on direction
		if($order == 'DESC'){
			array_multisort($_temp,SORT_DESC,$this->_d,SORT_DESC);
		} else {
			array_multisort($_temp,SORT_ASC,$this->_d,SORT_ASC);
		}
		// Reset the rowset
		$this->_i = 0;
		$this->_r = array();
		return $this;
	}
	
}