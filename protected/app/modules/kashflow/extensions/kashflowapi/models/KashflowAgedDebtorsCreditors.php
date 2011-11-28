<?php

/**
 * KashflowAgedDebtorsCreditors
 * 
 * This class  is used by a number of functions to return sets of id numbers, names, descriptions and values
 * 
 * @property int $ID The customer id
 * @property string $Name The customer name
 * @property string $Code The customer code
 * @property float $Balance The total owed by the customer
 * @property float $Current Amount of owing amount that falls into the current month
 * @property string $Period1_name The month name for period 1
 * @property float $Period1_val Amount of owing amount that falls into period 1
 * @property string $Period2_name
 * @property float $Period2_val
 * @property string $Period3_name
 * @property float $Period3_val
 * @property float $Older Amount of owing amount that is prior to the periods shown
 */
class KashflowAgedDebtorsCreditors extends KashflowModel {
	
}