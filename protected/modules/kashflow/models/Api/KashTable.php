<?php
class KashTable
{
	public function api($action,$xml=''){
		$results = KashConnection::get()->callFunction($action,$xml);
		$rowset = new KashRowset($results[$this->resultWrapper]);
		$rowset->setRowClass($this->rowClass);
		return $rowset;
	}
}