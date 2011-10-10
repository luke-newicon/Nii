<?php
class KashCustomer extends KashRow
{
	public $CustomerID;
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
    public $Postcode;
    public $Website;
    public $EC;
    public $OutsideEC;
    public $Notes;
    public $Source;
    public $Discount;
    public $ShowDiscount;
    public $PaymentTerms;
    public $ExtraText1;
    public $ExtraText2;
    public $ExtraText3;
    public $ExtraText4;
    public $ExtraText5;
    public $ExtraText6;
    public $CheckBox1;
    public $CheckBox2;
    public $Created;
    public $Updated;
    public $CurrencyID;
    
    protected $XMLPrefix="custr";
    
    public function save(){
    	$interface = new KashConnection();
    	if($this->CustomerID){
    		$retr = $interface->CallFunction("UpdateCustomer",$this->outXML(),1);
    	} else {
    		$this->Source = $this->getCustomerSource('Web Site');
    		$retr = $interface->CallFunction("InsertCustomer",$this->outXML(),1);
    		$this->getCustomerByEmail($this->Email);
    	}
    	return $this->CustomerID;
    }

}