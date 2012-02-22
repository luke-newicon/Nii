<?php

Yii::import('zii.widgets.grid.CDataColumn');
Yii::import('nii.widgets.grid.NDateColumn');
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
	protected function renderDataCellContent($row,$data)
	{
		if($this->value!==null){
			$value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
		}else if($this->name!==null){
			if(strpos($this->name,'.')) {
				list($relation,$attribute) = explode('.',$this->name);
				$model = $data->$relation;
			} else {
				$attribute = $this->name;
				$model = $data;
			}
//			$value=CHtml::value($data,$this->name);
			$value=$model->getDefinition($attribute)->renderGridValue();
		}
		echo $value===null ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value,$this->type);
	}
	
	protected function renderFilterCellContent(){	
		if(is_string($this->filter))
			echo $this->filter;
		else if($this->filter!==false && $this->grid->filter!==null && $this->name!==null)
		{
			if(is_array($this->filter))
				echo CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, array('id'=>false,'prompt'=>''));
			else if($this->filter===null){
				if(strpos($this->name,'.')){
					list($relation,$attribute) = explode('.',$this->name);
					$model = $this->grid->filter->$relation;
					if(is_object($model)){
						$type = $model->getDefinition($attribute);
						$name = get_class($this->grid->filter).'['.$relation.']['.$attribute.']';
						echo $type->renderGridFilter(array('name'=>$name));
					} else {
						echo $this->grid->blankDisplay;
					}
				} else {
					$type = $this->grid->filter->getDefinition($this->name);
					echo $type->renderGridFilter();
				}
			}
		}
		else
			echo $this->grid->blankDisplay;
	}
	
	/**
	 * Renders the data cell content.
	 * This method evaluates {@link value} or {@link name} and renders the result.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
//	protected function renderDataCellContent($row, $data)
//	{
//		if($this->value!==null)
//			$value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
//		else if($this->name!==null)
//			$value=CHtml::value($data,$this->name);
//		if($value===null){
//			echo $this->grid->nullDisplay;
//		} else {
//			// THIS BREAKS THE PERMISSION GRID, NEEDS MORE WORK FOR HIGHLIGHTING SEARCH RESULTS
//			// SO: should be fixed now.
//			if($this->type == 'text' && $this->grid->filter != null ) {
//				// get search result
//				$search = $this->grid->filter->{$this->name};
//				
//				echo NHtml::hilightText($this->grid->getFormatter()->format($value,$this->type), $search);
//			} else			
//				echo $this->grid->getFormatter()->format($value,$this->type);
//			// TODO: implement hilighting for other column data types. e.g. raw
//		}
//	}
	
}