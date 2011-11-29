<?php

/**
 * KashflowJournalEntry
 * 
 * The journal entry class
 * 
 * @property int $DBID The system-wide, unique ID number for the journal entry
 * @property int $JournalNumber The number assigned to the journal entry
 * @property string $JournalDate The date when the journal entry was created
 * @property float $Comment The comment added to the journal entry
 * @property KashflowJournalLine $Lines Collection
 */
class KashflowJournalEntry extends KashflowModel {
	
}