<?php

/**
 * KashflowNominalCode
 * 
 * The Debit, Credit and Balance members may or my not contain data, dependent on the Method that returns the object
 * 
 * @property int $ID The system-wide, unique ID number for this nominal code
 * @property int $Code The code for this Nominal Code
 * @property string $Name The name for this Nominal Code
 * @property float $Debit The total value of debits to this code
 * @property float $Credit The total value of credits to this code
 * @property float $balance The balance of this Nominal Code
 */
class KashflowNominalCode extends KashflowModel {
	
}