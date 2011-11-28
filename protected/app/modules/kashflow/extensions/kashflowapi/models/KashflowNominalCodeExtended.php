<?php

/**
 * KashflowNominalCodeExtended
 * 
 * This is an extended version of the NominalCode class.
 * The difference being that this class provides extra information so you can tell where on the P&amp;L or Balance sheet the codes belongs as well as where in the application it appears (ie, Sales Types, Outgoing Types)
 * The Debit, Credit and Balance members may or my not contain data, dependent on the Method that returns the object
 * 
 * @property int $ID The system-wide, unique ID number for this nominal code
 * @property string $Code The code for this Nominal Code
 * @property int $Name The name for this Nominal Code
 * @property float $Debit The total value of debits to this code
 * @property float $Credit The total value of credits to this code
 * @property float $balance The balance of this Nominal Code
 * @property int $TypeID Provides an ID number to tell you where on the P&amp;L on Balance sheet this code belongs
 * @property string $TypeName A human-friendly version of TypeID
 * @property int $ClassificationID This property tells you where in the application the code is listed (ie as a "Sales Type")
 * @property string $ClassificationName A human-friendly version of ClassificationID
 * @property int $AutoFill 1 if the nominal is configured to autofill and 0 if not.
 * @property float $Price The configure price for the nominal.
 * @property float $VATRate The configure VAT rate for the nominal.
 * @property string $Description The configure description for the nominal.
 */
class KashflowNominalCodeExtended extends KashflowModel {
	
}