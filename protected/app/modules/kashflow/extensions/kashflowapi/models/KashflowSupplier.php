<?php

class KashflowSupplier extends KashflowModel {

	/**
	 * @var int The system-wide, unique ID number for this supplier
	 */
	public $SupplierID = 0;

	/**
	 * @var string Supplier Code 
	 */
	public $Code = "";

	/**
	 * @var string The supplier name
	 */
	public $Name = "";

	/**
	 * @var string Contact Name
	 */
	public $Contact = "";

	/**
	 * @var string Telephone number
	 */
	public $Telephone = "";

	/**
	 * @var string Mobile number
	 */
	public $Mobile = "";

	/**
	 * @var string Fax number
	 */
	public $Fax = "";

	/**
	 * @var string Email address
	 */
	public $Email = "";

	/**
	 * @var string Address line 1
	 */
	public $Address1 = "";

	/**
	 * @var string Address line 2
	 */
	public $Address2 = "";

	/**
	 * @var string Address line 3
	 */
	public $Address3 = "";

	/**
	 * @var string Address line 4
	 */
	public $Address4 = "";

	/**
	 * @var string Postcode
	 */
	public $PostCode = "";

	/**
	 * @var string Website
	 */
	public $Website = "";

	/**
	 * @var int Is set to 1 if the supplier is based in another EC country
	 */
	public $EC = 0;
	
	/**
	 * @var string The supplier VAT number
	 */
	public $VATNumber = "";

	/**
	 * @var string Supplier notes
	 */
	public $Notes = "";

	/**
	 * @var datetime The date this supplier was created
	 */
	public $Created = 0;

	/**
	 * @var datetime The date this supplier was updated
	 */
	public $Updated = 0;

	/**
	 * @var string The payment terms for the supplier
	 */
	public $PaymentTerms = "";
	
	public $CurrencyID;

}