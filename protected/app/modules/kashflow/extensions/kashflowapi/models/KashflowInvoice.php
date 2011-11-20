<?php

class KashflowInvoice extends KashflowModel {

	/**
	 * @var int System-wide unique number for this invoice (used internally only)
	 */
	public $InvoiceDBID = 0;

	/**
	 * @var int Unique invoice Reference Number
	 */
	public $InvoiceNumber = 0;

	/**
	 * @var string Invoice Date
	 */
	public $InvoiceDate = "";

	/**
	 * @var string Payment Due Date
	 */
	public $DueDate = "";

	/**
	 * @var int 1 to suppress the quote/estimate total
	 */
	public $SuppressTotal = 0;

	/**
	 * @var int The project ID for this invoice. See GetProjects
	 */
	public $ProjectID = 0;

	/**
	 * @var string The currency code to be used for the invoice e.g. USD, GBP, ZAR
	 */
	public $CurrencyCode = "";

	/**
	 * @var float The exchange rate for the currency used.
	 */
	public $ExchangeRate = 0;

	/**
	 * @var int 1 for Paid, 0 for Unpaid (Please set default to 0 when calling insert functions)
	 */
	public $Paid = 0;

	/**
	 * @var int CustomerID of Customer
	 */
	public $CustomerID = 0;

	/**
	 * @var string Customer Reference
	 */
	public $CustomerReference = "";

	/**
	 * @var string The name of the estimate category
	 */
	public $EstimateCategory = "";

	/**
	 * @var float The total net amount of the invoice (Please set default to 0 when calling insert functions)
	 */
	public $NetAmount = 0;

	/**
	 * @var float The total VAT amount of the invoice (Please set default to 0 when calling insert functions)
	 */
	public $VATAmount = 0;

	/**
	 * @var float The sum of all payments made to this invoice (Please set default to 0 when calling insert functions)
	 */
	public $AmountPaid = 0;

	/**
	 * @var array Array of KashflowInvoiceLines
	 */
	public $Lines = array();
	
	public $Customer;
	public $ReadableString;
	public $CustomerName;

}