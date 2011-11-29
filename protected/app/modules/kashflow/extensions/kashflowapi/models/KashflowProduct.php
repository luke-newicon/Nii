<?php

/**
 * KashflowProduct
 * 
 * @property int $ProductID System-wide unique number for this product (used internally only)
 * @property string $ProductName The name of the product
 * @property int $ProductCode The code for this product
 * @property string $ProductDescription Description of the product
 * @property int $ManageStockLevels Indicate wether or not the stock levels for this product are to be tracked or not.
 * @property int $QtyInStock The quantity of this item that is in stock
 * @property float $ProductPrice The price of the product
 */
class KashflowProduct extends KashflowModel {
	
}