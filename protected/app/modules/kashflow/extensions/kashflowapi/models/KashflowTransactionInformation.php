<?php

/**
 * KashflowTransactionInformation
 *
 * @property string $Date The date of the transaction
 * @property int $nomid The unique id number for the nominal code involved in this transaction
 * @property float $Value The value of this transaction
 * @property int $Type The transaction type.
 * 1 = Sales Invoice
 * 2 = Purchase Invoice
 * 3 = Bank Transaction
 * 4 = Journal Entry
 * @property int $id The id number (Could be for an invoice, purchase, etc, dependent on the 'type' above.
 * @property int $id2 For future use
 * @property int $id3 For future use
 * @property string $Ref1 The Invoice or Purchase number, or the name of the bank account
 * @property string $Ref2 The customer or supplier name, or the comment entered if 'type' is 3 or 4.
 * @property string $Ref3 For future use
 * @property string $Narrative The description of the transaction
 * @property int $ProjID The project associated with the nominal
 */
class KashflowTransactionInformation extends KashflowModel {
	
}