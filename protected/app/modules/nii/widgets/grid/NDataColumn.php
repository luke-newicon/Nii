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
	
	
	/**
	 * Renders the data cell content.
	 * This method evaluates {@link value} or {@link name} and renders the result.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row, $data)
	{
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
		else if($this->name!==null)
			$value=CHtml::value($data,$this->name);
		if($value===null){
			echo $this->grid->nullDisplay;
		} else {
			// THIS BREAKS THE PERMISSION GRID, NEEDS MORE WORK FOR HIGHLIGHTING SEARCH RESULTS
			// SO: should be fixed now.
			if($this->type == 'text')
				echo NHtml::hilightText($this->grid->getFormatter()->format($value,$this->type), $this->grid->filter->{$this->name});
			else			
				echo $this->grid->getFormatter()->format($value,$this->type);
			// TODO: implement hilighting for other column data types. e.g. raw
		}
	}
	
}