<?php

/**
 * KashflowInvoiceLine
 * 
 * @property int $LineID System-wide unique number for this line
 * @property float $Quantity Quantity invoiced
 * @property string $Description Description of item invoiced
 * @property float $Rate Rate per item
 * @property int $ChargeType
 * For Sales: Related ID of Sales Type (from GetNominalCodes or GetProducts).
 * For Purchases: Related Nominal ID From GetNominalCodes.
 * Set to 0 to select 'Other'.
 * @property int $ProjID The Project to which this line should be assigned. Leave as 0 if in doubt
 * @property float $VatAmount The VAT amount for this  line
 * @property float $VatRate The VAT rate applied to this line (e.g. 15 for 15%)
 * @property int $Sort Sort order value
 * @property int $ProductID An integer value representing the ID of a SubProduct (from GetSubProducts).
 * Set to 0 for "None"
 * @property mixed $ValuesInCurrency Set to "1" if the Rate and VATAmount is already in foreign currency
 */
class KashflowInvoiceLine extends KashflowModel {
	
}