<?php

/**
 * KashflowJournalLine
 * 
 * The amount is a Debit/Credit value for the journal line.
 * 
 * @property int $NominalID The system-wide, unique ID number for the nominal code used for the journal line
 * @property float $Amount The credit/debit value for the journal line
 * NB: A negative amount will be treated as Credit and a positive amount will be treated as Debit
 * @property int $Comment The comment added for the journal line
 * @property int $ProjId The project associated with the journal line
 */
class KashflowJournalLine extends KashflowModel {
	
}