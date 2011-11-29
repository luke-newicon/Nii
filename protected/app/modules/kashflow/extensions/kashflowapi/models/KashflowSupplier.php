<?php

/**
 * KashflowSupplier
 * 
 * All of the fields below should be self explanatory when viewed in conjunction with the supplier page in a KashFlow account.
 * 
 * @property int $SupplierID The system-wide, unique ID number for this supplier
 * @property string $Code Supplier Code
 * @property string $Name The suppliers name
 * @property string $Contact Contact Name
 * @property string $Telephone
 * @property string $Mobile
 * @property string $Fax
 * @property string $Email
 * @property string $Address1
 * @property string $Address2
 * @property string $Address3
 * @property string $Address4
 * @property string $PostCode
 * @property string $Website
 * @property string $Email
 * @property int $EC Is set to 1 if the supplier is based in another EC country
 * @property string $VATNumber The suppliers' VAT number
 * @property string $Notes
 * @property string $Created The date this supplier was created
 * @property string $Updated The date the supplier was updated.
 * @property int $PaymentTerms The payment terms for the supplier
 */
class KashflowSupplier extends KashflowModel {
	
}