<?php

class KashflowQuote extends KashflowModel {

	public function DeleteQuote() {
		
	}

	public function DeleteQuoteByID($id) {
		
	}

	public function DeleteQuoteLine() {
		
	}

	public function DeleteQuoteLineWithQuoteID() {
		
	}

	public function GetQuoteByNumber() {
		
	}

	public function GetQuoteByID() {
		
	}

	public function GetQuotes() {
		return $this->request('GetQuotes')->GetQuotesResult->Invoice;
	}

	public function GetQuotesForCustomer() {
		
	}

	public function InsertQuote() {
		
	}

	public function InsertQuoteLine() {
		
	}

	public function isStillQuote() {
		
	}

	public function UpdateQuote() {
		
	}

	public function UpdateQuoteHeader() {
		
	}

	public function ConvertQuoteToInvoice() {
		
	}

}