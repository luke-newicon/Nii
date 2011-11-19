<?php

class KashflowInvoice extends KashflowModel {

	public function GetInvoices() {
		$params = array(
			'StartDate' => '2011-01-01',
			'EndDate' => date('Y-m-d'),
		);
		return $this->request('GetInvoicesByDateRange',$params)->GetInvoicesByDateRangeResult->Invoice;
	}

}