<?php

/**
 * KashflowBalanceSheet
 * 
 * Returned by the GetBalanceSheet Method
 * 
 * @property string $Date The date for this Balance Sheet
 * @property float $FixedAssetsTotal Total value of Fixed Assets
 * @property float $CurrentAssetsTotal Total value of Current Assets
 * @property float $CurrentLiabiltiesTotal Total value of Current Liabilties
 * @property float $CapitalReservesTotal Total value of Capital Reserves
 * @property KashflowNominalCode $FixedAssets  An array of type NominalCode containing each code that makes up the FixedAssetsTotal figure
 * @property KashflowNominalCode $CurrentAssets An array of type NominalCode containing each code that makes up the CurrentAssetsTotal figure
 * @property KashflowNominalCode $CurrentLiabilities An array of type NominalCode containing each code that makes up the CurrentLiabiltiesTotal figure
 * @property KashflowNominalCode $CapitalReserves An array of type NominalCode containing each code that makes up the CapitalReservesTotal figure
 */
class KashflowBalanceSheet extends KashflowModel {
	
}