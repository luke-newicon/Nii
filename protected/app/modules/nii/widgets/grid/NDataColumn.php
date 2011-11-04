<?php

Yii::import('zii.widgets.grid.CDataColumn');
/**
 * Description of NDataColumn
 *
 * @author robinwilliams
 */
class NDataColumn extends CDataColumn {

	public $export;
	public $exportValue;

	public function renderDataCsvCell($row)
	{
		$data=$this->grid->dataProvider->data[$row];
		if($this->exportValue!==null)
			$value=$this->evaluateExpression($this->exportValue,array('data'=>$data,'row'=>$row));
		else if($this->name!==null)
			$value=CHtml::value($data,$this->name);
		return $value===null ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value,$this->type);
	}
	
	public function renderDataExcelCell($row)
	{
		$data=$this->grid->dataProvider->data[$row];
		if($this->exportValue!==null)
			$value=$this->evaluateExpression($this->exportValue,array('data'=>$data,'row'=>$row));
		else if($this->name!==null)
			$value=CHtml::value($data,$this->name);
		return $value===null ? $this->grid->nullDisplay : $value;
	}
	
	public function renderDataOdsCell($row)
	{
		$data=$this->grid->dataProvider->data[$row];
		if($this->exportValue!==null)
			$value=$this->evaluateExpression($this->exportValue,array('data'=>$data,'row'=>$row));
		else if($this->name!==null)
			$value=CHtml::value($data,$this->name);
		return $value===null ? $this->grid->nullDisplay : str_replace('&','&amp;',$this->grid->getFormatter()->format($value,$this->type));
	}
	
}