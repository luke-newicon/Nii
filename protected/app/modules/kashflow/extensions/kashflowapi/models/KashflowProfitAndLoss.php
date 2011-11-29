<?php

/**
 * KashflowProfitAndLoss
 * 
 * Returned by the GetProfitAndLoss Method
 * 
 * @property float $TurnoverTotal The total turnover for this period
 * @property float $CostofSalesTotal The total cost of sales for this period
 * @property float $ExpensesTotal The total expenses for this period
 * @property float $NetProfit The net profit for this period
 * @property float $GrossProfit The gross profit for this period
 * @property string $Code The code for this Nominal Code
 * @property int $Name The name for this Nominal Code
 * @property KashflowNominalCode $Turnover An array of type NominalCode containing each code that makes up the TurnoverTotal figure
 * @property KashflowNominalCode $CostofSales An array of type NominalCode containing each code that makes up the CostofSalesTotal figure
 * @property KashflowNominalCode $Expenses An array of type NominalCode containing each code that makes up the ExpensesTotal figure
 */
class KashflowProfitAndLoss extends KashflowModel {
	
}