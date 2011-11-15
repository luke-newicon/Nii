<?php

/**
 * NEavColumn
 *
 * Allows to display EAV columns in NGridView.
 *
 * @author Robin Williams
 *
 * @version 0.8
 *
 */
Yii::import('nii.widgets.grid.NDataColumn');

class NEavColumn extends NDataColumn 
{
	
	/**
   ﻿  * @var array the HTML options for the data cell tags.
	*/
	public $htmlOptions = array('class' => 'image-column');
	/**
	  * @var array the HTML options for the header cell tag.
	*/
	
	public $headerHtmlOptions = array('class' => 'image-column');
	/**
	  ﻿* @var array the HTML options for the footer cell tag.
	*/
	
	public $footerHtmlOptions = array('class' => 'image-column');
	
	/**
	  * @var array the HTML options for the image tag.
	*/
	
	public $emptyText = '';

	/**
	 *	Renders the filter cell content
	 *  This method will render a filter based on the EAV object
	 */
	protected function renderFilterCellContent() {
		
		echo '<div class="field"><div class="input">';
		echo CHtml::textField($this->name,null);
		echo '</div></div>';
	}

	/**
	 * Renders the header cell content.
	 * This method will render a link that can trigger the sorting if the column is sortable.
	 */
	protected function renderHeaderCellContent() {
		$header = $this->header ? $this->header : $this->name;
		echo CHtml::encode($header);
	}

	/**
	 * Renders the data cell content.
	 * This method evaluates {@link value} or {@link name} and renders the result.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row, $data) {
		$value = $data->getEavAttribute('test');
		echo $value === null ? $this->emptyText : $value;
//		if ($this->value !== null)
//			$value = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
//		else if ($this->name !== null)
//			$value = CHtml::value($data, $this->name);
//		echo $value === null ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value, $this->type);
	}

}