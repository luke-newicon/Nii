<?php

/**
 * KashflowSubProduct
 * 
 * The SubProduct class is used to represent what is referred to within the application as "Products" or "Sub-Outgoing Types".
 * 
 * @property int $id The system-wide, unique ID number for this SubProduct
 * @property int $ParentID The ID of the parent NominalCode to which this SubProduct belongs
 * @property string $Name The name for this SubProduct
 * @property string $Code The code for this SubProduct. Unlike a NominalCode, this doesn't need to be numeric.
 * @property string $Description A description for this SubProduct
 * @property float $Price The default price of the sub-product
 * @property float $VatRate The default VAT Rate of the sub-product
 * @property float $WholesalePrice The wholesale price of the sub-product
 * @property int $Managed A flag indicating whether a sub-products' stock is managed. Set to 1 if you want the sub-product managed
 * @property int $QtyInStock The current stock quantity of the sub-product
 * @property int $StockWarnQty The current configured stock warning quantity of the sub-product
 */
class KashflowSubProduct extends KashflowModel {
	
}