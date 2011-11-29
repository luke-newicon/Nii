<?php

/**
 * KashflowPayment
 * 
 * @property int $PayID System-wide unique number for this payment
 * @property int $PayInvoice Invoice number
 * @property string $PayDate Date of payment
 * @property string $PayNote Comments about this payment
 * @property int $PayMethod  Method of payment (from GetInvPayMethods)
 * @property int $PayAccount The Bank Account to which the payment is assgined (from GetBankAccounts)
 * @property float $PayAmount The amount paid
 */
class KashflowPayment extends KashflowModel {
	
}