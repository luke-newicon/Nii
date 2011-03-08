<?php
class KashSupplier extends KashRow
{
	public $SupplierID;
    public $Code;
    public $Name;
    public $Contact;
    public $Telephone;
    public $Mobile;
    public $Fax;
    public $Email;
    public $Address1;
    public $Address2;
    public $Address3;
    public $Address4;
    public $PostCode;
    public $Website;
    public $EC;
    public $VATNumber;
    public $Notes;
    public $Created;
    public $Updated;
    public $PaymentTerms;
    public $CurrencyID;
    
    protected $XMLPrefix="supl";
    
    public function save(){
    	
    }

}