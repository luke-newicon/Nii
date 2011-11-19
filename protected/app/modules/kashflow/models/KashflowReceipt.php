<?php

class KashflowReceipt extends KashflowModel {

	public function GetReceipts() {
		return $this->request('GetReceipts')->GetReceiptsResult->Invoice;
	}

}