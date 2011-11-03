<?php
/**
 * BootDataColumn class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Thanks to Simo Jokela <rBoost@gmail.com> for writing the original version of this class.
 */

Yii::import('nii.widgets.grid.NDataColumn');
class BootDataColumn extends NDataColumn
{
//	/**
//	 * Initializes the column.
//	 */
//	public function init()
//	{
//		if (isset($this->headerHtmlOptions['class']))
//			$this->headerHtmlOptions['class'] .= ' header';
//		else
//			$this->headerHtmlOptions['class'] = 'header';
//
//		parent::init();
//	}

	/**
	 * Renders the header cell.
	 */
	public function renderHeaderCell()
	{
		if ($this->grid->enableSorting && $this->sortable && $this->name !== null)
		{
			
			if (isset($this->headerHtmlOptions['class']))
				$this->headerHtmlOptions['class'] .= ' header';
			else
				$this->headerHtmlOptions['class'] = 'header';
			
			$sortDir = $this->grid->dataProvider->getSort()->getDirection($this->name);

			if ($sortDir !== null)
			{
				$sortCssClass = $sortDir ? 'headerSortDown' : 'headerSortUp';
				$this->headerHtmlOptions['class'] .= ' '.$sortCssClass;
			}
		}

		parent::renderHeaderCell();
	}
	
		/**
	 * Renders the filter cell content.
	 * This method will render the {@link filter} as is if it is a string.
	 * If {@link filter} is an array, it is assumed to be a list of options, and a dropdown selector will be rendered.
	 * Otherwise if {@link filter} is not false, a text field is rendered.
	 * @since 1.1.1
	 */
	protected function renderFilterCellContent()
	{
		if(is_string($this->filter))
			echo $this->filter;
		else if($this->filter!==false && $this->grid->filter!==null && $this->name!==null && strpos($this->name,'.')===false)
		{
			if(is_array($this->filter))
				echo '<div class="field"><div class="input">'.CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, array('id'=>false,'prompt'=>'')).'</div></div>';
			else if($this->filter===null)
				echo '<div class="field"><div class="input">'.CHtml::activeTextField($this->grid->filter, $this->name, array('id'=>false)).'</div></div>';
		}
		else
			parent::renderFilterCellContent();
	}
}
