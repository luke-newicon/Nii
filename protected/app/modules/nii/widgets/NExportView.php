<?php
/**
 * CGridView class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::setPathOfAlias('nii-widgets', dirname(__FILE__));
Yii::import('zii.widgets.CBaseListView');
Yii::import('nii.widgets.grid.NDataColumn');


class NExportView extends CBaseListView
{
	private $_formatter;
	/**
	 * @var array grid column configuration. Each array element represents the configuration
	 * for one particular grid column which can be either a string or an array.
	 *
	 * When a column is specified as a string, it should be in the format of "name:type:header",
	 * where "type" and "header" are optional. A {@link CDataColumn} instance will be created in this case,
	 * whose {@link CDataColumn::name}, {@link CDataColumn::type} and {@link CDataColumn::header}
	 * properties will be initialized accordingly.
	 *
	 * When a column is specified as an array, it will be used to create a grid column instance, where
	 * the 'class' element specifies the column class name (defaults to {@link CDataColumn} if absent).
	 * Currently, these official column classes are provided: {@link CDataColumn},
	 * {@link CLinkColumn}, {@link CButtonColumn} and {@link CCheckBoxColumn}.
	 */
	public $columns=array();
	/**
	 * @var string the text to be displayed in a data cell when a data value is null. This property will NOT be HTML-encoded
	 * when rendering. Defaults to an HTML blank.
	 */
	public $nullDisplay='';
	/**
	 * @var string the text to be displayed in an empty grid cell. This property will NOT be HTML-encoded when rendering. Defaults to an HTML blank.
	 * This differs from {@link nullDisplay} in that {@link nullDisplay} is only used by {@link CDataColumn} to render
	 * null data values.
	 * @since 1.1.7
	 */
	public $blankDisplay='';
	/**
	 * @var boolean whether to hide the header cells of the grid. When this is true, header cells
	 * will not be rendered, which means the grid cannot be sorted anymore since the sort links are located
	 * in the header. Defaults to false.
	 * @since 1.1.1
	 */
	public $hideHeader=false;
	
	public $delimiter=",";
	
	public $enclosure='"';
	
	public $template = '{items}';
	
	public $fileType = 'csv';

	/**
	 * Initializes the grid view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function init()
	{
		if ($this->dataProvider)
			$this->dataProvider->pagination = false;

		$this->initColumns();
	}
	

	/**
	 * Renders the view.
	 * This is the main entry of the whole view rendering.
	 * Child classes should mainly override {@link renderContent} method.
	 */
	public function run()
	{

		$this->renderItems($this->fileType);

	}

	/**
	 * Creates column objects and initializes them.
	 */
	protected function initColumns()
	{
		if($this->columns===array())
		{
			if($this->dataProvider instanceof NActiveDataProvider)
				$this->columns=$this->dataProvider->model->attributeNames();
			else if($this->dataProvider instanceof IDataProvider)
			{
				// use the keys of the first row of data as the default columns
				$data=$this->dataProvider->getData();
				if(isset($data[0]) && is_array($data[0]))
					$this->columns=array_keys($data[0]);
			}
		}
		$id=$this->getId();
		foreach($this->columns as $i=>$column)
		{
			if ($column['name'] && (!isset($column['export']) || @$column['export']!=false)) {
				if(is_string($column))
					$column=$this->createDataColumn($column);
				else
				{
					if(!isset($column['class']))
						$column['class']='NDataColumn';
					$column=Yii::createComponent($column, $this);
				}
				if(!$column->visible)
				{
					unset($this->columns[$i]);
					continue;
				}
				if($column->id===null)
					$column->id=$id.'_c'.$i;
				$this->columns[$i]=$column;
			} else {
				unset($this->columns[$i]);
				continue;
			}
		}

		foreach($this->columns as $column)
				$column->init();
	}

	/**
	 * Creates a {@link CDataColumn} based on a shortcut column specification string.
	 * @param string $text the column specification string
	 * @return CDataColumn the column instance
	 */
	protected function createDataColumn($text)
	{
		if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$text,$matches))
			throw new CException(Yii::t('zii','The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
		$column=new CDataColumn($this);
		$column->name=$matches[1];
		if(isset($matches[3]) && $matches[3]!=='')
			$column->type=$matches[3];
		if(isset($matches[5]))
			$column->header=$matches[5];
		return $column;
	}

	

	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems($type=null)
	{
		$this->dataProvider->setPagination(false);
		$data = $this->dataProvider->getData();
		
		switch ($type) {
			
			case "excel" :
				
				if (!$this->hideHeader && $this->columns) {
				foreach($this->columns as $column) {
						if ($column->header)
							$d[] = $column->header;
						else
							$d[] = $this->dataProvider->model->getAttributeLabel($column->name);
					}
					$rowData[1]=$d;
				}

				$n=count($data);

				if($n>0)
				{
					for($row=0;$row<$n;++$row) {
		//				print_r($this->columns);
						$d = array();
						foreach($this->columns as $column) {
							$d[] = $column->renderDataExcelCell($row);
						} 
						$rowData[] = $d;
					}
				}

				return $rowData; 
				
			break;
			
			case "ods" :
				
				require_once (Yii::getPathOfAlias('nii.extensions').DIRECTORY_SEPARATOR.'phpods'.DIRECTORY_SEPARATOR.'ods.php');
				$object = newOds(); //create a new ods file		

				$c = 0;
				if (!$this->hideHeader && $this->columns) {
					foreach($this->columns as $column) {
						if ($column->header)
							$object->addCell(0,0,$c,$this->dataProvider->model->getAttributeLabel($column->name),'string');
						else
							$object->addCell(0,0,$c,$this->header,'string');
						$c++;
					}
				}

				$n=count($data);

				if($n>0)
				{
					for($row=1;$row<$n;++$row) {
		//				print_r($this->columns);
						$d = array(); $c = 0;
						foreach($this->columns as $column) {
							$object->addCell(0,$row,$c,$column->renderDataOdsCell($row),'string');
							$c++;
						} 
					}
				}

				return $object;  
		
			break;
			
			default :
				
				$fp = fopen("php://temp/maxmemory:".(5 * 1024 * 1024), 'w');

				if (!$this->hideHeader && $this->columns) {
					foreach($this->columns as $column) {
						if ($column->header)
							$d[] = $column->header;
						else
							$d[] = $this->dataProvider->model->getAttributeLabel($column->name);
					}
					fputcsv($fp, $d, $this->delimiter, $this->enclosure);
				}

				$n=count($data);

				if($n>0)
				{
					for($row=0;$row<$n;++$row) {
		//				print_r($this->columns);
						$d = array();
						foreach($this->columns as $column) {
							$d[] = $column->renderDataCsvCell($row);
						} 
						fputcsv($fp, $d, $this->delimiter, $this->enclosure);
					}
				}

						rewind($fp);

				echo stream_get_contents($fp);  
				
			break;
		}
		
			
	}

	/**
	 * @return CFormatter the formatter instance. Defaults to the 'format' application component.
	 */
	public function getFormatter()
	{
		if($this->_formatter===null)
			$this->_formatter=Yii::app()->format;
		return $this->_formatter;
	}

	/**
	 * @param CFormatter $value the formatter instance
	 */
	public function setFormatter($value)
	{
		$this->_formatter=$value;
	}
	
}
