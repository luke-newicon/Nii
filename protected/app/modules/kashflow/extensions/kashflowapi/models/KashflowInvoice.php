<?php

/**
 * KashflowInvoice
 * 
 * Note that properties relating to payments and totals are read-only.
 * The Net Amount and Vat Amount are calculated based on the Lines.
 * The 'Paid' status is set by adding an invoice payments.
 * 
 * @property int $InvoiceDBID System-wide unique number for this invoice (used internally only)
 * @property int $InvoiceNumber Unique  invoice Reference Number
 * @property string $InvoiceDate Invoice  Date
 * @property string $DueDate Payment  Due Date
 * @property int $SuppressTotal 1 to suppress the quote/estimate total
 * @property int $ProjectID The project ID for this invoice. See GetProjects
 * @property string $CurrencyCode The currency code to be used for the invoice e.g. USD, GBP, ZAR
 * @property float $ExchangeRate The exchange rate for the currency used.
 * @property int $Paid, 1 for Paid, 0 for Unpaid (Please set default to 0 when calling insert functions)
 * @property int $CustomerID CustomerID  of Customer
 * @property string $CustomerReference Customer  Reference
 * @property string $EstimateCategory The name of the estimate category
 * @property float $NetAmount The  total net amount of the invoice (Please set default to 0 when calling insert functions)
 * @property float $VatAmount The  total VAT amount of the invoice (Please set default to 0 when calling insert functions)
 * @property float $AmountPaid The  sum of all payments made to this invoice (Please set default to 0 when calling insert functions)
 * @property KashflowInvoiceLine $Lines Collection
 */
class KashflowInvoice extends KashflowModel {
	
}