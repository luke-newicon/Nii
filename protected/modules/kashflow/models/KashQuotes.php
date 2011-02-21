<?php
class KashQuotes extends KashTable
{
	
	public $rowClass = 'KashInvoice';
	public $resultWrapper = 'Invoice';

	public function getQuotes(){
		return $this->api('GetQuotes');
	}
	
}