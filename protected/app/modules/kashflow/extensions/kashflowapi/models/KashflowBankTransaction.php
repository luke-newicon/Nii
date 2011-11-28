<?php
/**
 * KashflowBankTransaction
 * 
 * @property int $ID System-wide unique number for this Transaction
 * @property int $accid The account number (from GetBankAccounts). St to zero for default account
 * @property string $TransactionDate The date of this transaction
 * @property float $moneyin The amount  paid in
 * @property float $moneyout The amount paid out
 * @property int $Vatable Whether or not the transaction involves VAT
 * @property float $VatRate The VAT rate (e.g. 15 for 15%)
 * @property float $VatAmount The VAT amount
 * @property int $TransactionType The type of transaction (from GetBankTXTypes). Set to zero for 'Other'
 * @property string $Comment Any comment to be recorded with the transaction
 * @property int $ProjectID The project associated with the bank transaction
 * @property int $CustomerId The customer that you're creating an advance payment for (NB: Please make sure the you specify the Debtors Control Account for the TransactionType)
 * @property int $SupplierId The supplier that you're creating an advance payment for (NB: Please make sure the you specify the Creditors Control Account for the TransactionType)
 */
class KashflowBankTransaction extends KashflowModel {

}