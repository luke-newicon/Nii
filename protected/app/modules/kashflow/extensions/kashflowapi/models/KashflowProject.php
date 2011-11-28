<?php

/**
 * KashflowProject
 * 
 * @property int $ID System-wide unique number for this project
 * @property int $Number The project number
 * @property string $Name Project name
 * @property string $Reference The reference for this project
 * @property string $Description The long description for this project
 * @property string $Date1 The first date field for the project as configured in Settings > Project Options
 * @property string $Date2 The second date field (see above)
 * @property int $CustomerID The customer to which this project is assigned. Use 0 for none
 * @property int $Status The status of the project
 * 0 = Completed
 * 1 = Active
 * 2 = Archived
 */
class KashflowProject extends KashflowModel {
	
}