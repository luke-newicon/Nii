<?php

class KashflowSupplier extends KashflowModel {

	public function GetSuppliers() {
		return $this->request('GetSuppliers')->GetSuppliersResult->Supplier;
	}

}