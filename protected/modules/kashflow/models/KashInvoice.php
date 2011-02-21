<?php
class KashInvoice extends KashRow
{
	public $InvoiceDBID;
    public $InvoiceNumber;
    public $InvoiceDate;
    public $DueDate;
    public $Paid;
    public $CustomerID;
    public $Customer;
    public $CustomerName;
    public $CustomerReference;
    public $NetAmount;
    public $VatAmount;
    public $AmountPaid;
    public $Notes;
    public $CurrencyCode;
    public $ExchangeRate;
    public $SuppressTotal;
    public $ProjectID;
    public $ReadableString;
    public $VATAmount;
    
    public $PaymentMethod;
    public $PaymentAccount;
    public $PaymentMethods = array();
    public $SalesTypes = array();
    
    protected $XMLPrefix="Inv";
    protected $LineObject="Nworx_Kashflow_Model_InvoiceLine";
    
    public $Lines=array();
    
    public function save(){
    	$interface = new Nworx_Kashflow_Model_Interface();
    	if($this->InvoiceNumber){
    		$retr = $interface->CallFunction("UpdateInvoice",$this->outXML(),1);
    	} else {
    		$retr = $interface->CallFunction("InsertInvoice",$this->outXML(),1);
    		$this->InvoiceNumber = (int)$retr[0];
    	}
    	return $this->InvoiceNumber;
    }
    
}