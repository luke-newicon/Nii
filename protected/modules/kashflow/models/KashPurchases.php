<?php
class KashPurchases extends KashTable
{
	
	public $rowClass = 'KashInvoice';
	public $resultWrapper = 'Invoice';

	public function getReceipts(){
		return $this->api('GetReceipts')->orderBy('InvoiceDate','DESC');
	}
	
}