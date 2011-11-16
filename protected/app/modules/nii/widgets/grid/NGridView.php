<?php

Yii::setPathOfAlias('nii-grid', dirname(__FILE__));
Yii::import('zii.widgets.grid.CGridView');
Yii::import('nii-grid.scopes.NScopeList');
Yii::import('nii-grid.NDataColumn');
Yii::import('nii-grid.NEavColumn');

class NGridView extends CGridView 
{

	
	public $template = "{scopes}\n{buttons}<div class='grid-top-summary'>{summary} {pager}</div>{items}\n<div class=\"grid-bottom-summary\">{pager}</div>";
	/**
	 * ??
	 * @var array 
	 */
	public $scopes;
	public $enableCustomScopes;
	public $defaultColumnClass = 'NDataColumn';
	public $defaultScopeListClass = 'NScopeList';
	/**
	 * allow by default multiple rows to be selected
	 * @var int 
	 */
	public $selectableRows = 2;
	public $enableButtons = false;
	public $buttons = array('export', 'print', 'update');
	public $buttonModelId = null;
	public $defaultExportButton = 'exportGrid';
	public $defaultPrintButton = 'printGrid';
	public $defaultUpdateButton = 'updateGridColumns';
	
	/**
	 * A string of jquery selectors to update separated by commas.
	 * to refer to the grid id use '{grid_id}' (it is a good idea to use id's so that jquery runs faster, especially on IE)
	 * @var string 
	 */
	public $ajaxUpdate = "#{grid_id} .grid-top-summary, #{grid_id} .grid-bottom-summary, #{grid_id}-head, #{grid_id}-body";

	/**
	 * 
	 * @return string 
	 */
	public function getAjaxUpdate(){
		if($this->_ajaxUpdate===null)
			return "#{$this->id} .grid-top-summary, #{$this->id}-head, #{$this->id}-body";
	}
	
	public function init() {

		if (isset($this->scopes['default']))
			$this->dataProvider->defaultScope = $this->scopes['default'];
		// Configuring grid columns...
		if ($this->columns==null)
			$this->columns = $this->gridColumns($this->filter);
		parent::init();
		
		// override default javascript
//		if($this->baseScriptUrl===null)
//			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('nii.widgets.assets')).'/gridview';
//		
	}
	
	

	/**
	 * Creates column objects and initializes them.
	 */
	protected function initColumns() {
		if ($this->columns === array()) {
			if ($this->dataProvider instanceof NActiveDataProvider)
				$this->columns = $this->dataProvider->model->attributeNames();
			else if ($this->dataProvider instanceof IDataProvider) {
				// use the keys of the first row of data as the default columns
				$data = $this->dataProvider->getData();
				if (isset($data[0]) && is_array($data[0]))
					$this->columns = array_keys($data[0]);
			}
		}
		$id = $this->getId();
		foreach ($this->columns as $i => $column) {
			if (is_string($column))
				$column = $this->createDataColumn($column);
			else {
				if (!isset($column['class']))
					$column['class'] = $this->defaultColumnClass;
				$column = Yii::createComponent($column, $this);
			}
			if (!$column->visible) {
				unset($this->columns[$i]);
				continue;
			}
			if ($column->id === null)
				$column->id = $id . '_c' . $i;
			$this->columns[$i] = $column;
		}

		foreach ($this->columns as $column)
			$column->init();
	}
	
	
	

	protected function createDataColumn($text) {
		if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches))
			throw new CException(Yii::t('zii', 'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
		$column = new $this->defaultColumnClass($this);
		$column->name = $matches[1];
		if (isset($matches[3]))
			$column->type = $matches[3];
		if (isset($matches[5]))
			$column->header = $matches[5];
		return $column;
	}

	/**
	 * Renders the scopes.
	 */
	public function renderScopes() {
		$this->widget($this->defaultScopeListClass, array(
			'dataProvider' => $this->dataProvider,
			'scopes' => $this->scopes,
			'gridId' => $this->id,
			'enableCustomScopes' => $this->enableCustomScopes,
		));
	}

	public function renderBulk() {
		if ($this->bulkActions) {
			echo '<div class="alignleft actions">';
			echo CHtml::dropDownList('action', '-1', $this->bulkActions);
			echo ' <input type="submit" value="Apply" class="button-secondary action" id="doaction"></div>';
		}
	}
	
	/*
	 *	@begin button functions
	 */

	/**
	 *	Render buttons in grid view. This function relies on $this->buttons, which is an array of the buttons to be displayed. 
	 */
	public function renderButtons() {

		if ($this->enableButtons && $this->buttons) {
			echo '<span class="grid-buttons">';

			foreach ($this->buttons as $button) {

				if (!is_array($button)) {
					$buttonVar = 'default' . ucfirst($button) . 'Button';
					if ($this->$buttonVar) {
						$function = $this->$buttonVar;
						$button = $this->{$function}();
					}
				}

				$options = ($button['htmlOptions']) ? $button['htmlOptions'] : array();
				$options['data-gridId'] = $this->id;
				$label = $button['label'];
				$url = $button['url'];

				if (is_array($button))
					echo NHtml::link($label, $url, $options);
			}
			echo '</span>';
		}
	}
	
	
	/**
	 *	Return options for the export columns button
	 * @return array 
	 */
	public function exportGrid() {
		$model_id = null;

		if ($this->buttonModelId)
			$model_id = $this->buttonModelId;

		$controller = Yii::app()->controller->uniqueid;
		$action = Yii::app()->controller->action->id;
		$model = get_class($this->dataProvider->model);
		$gridId = $this->id;

		$label = '';

		return array(
			'label' => $label, 'url' => '#',
			'htmlOptions' => array(
				'onclick' => self::exportGridDialog(
						array('controller' => $controller, 'action' => $action, 'model' => $model, 'model_id' => $model_id, 'gridId'=>$gridId, 'scope' => $this->dataProvider->currentScope)
				),
				'title' => 'Export to CSV, Excel or ODS',
				'class' => 'icon fam-table-go block-icon',
			),
		);
	}
	
	/**
	 *	Return options for the print grid button
	 * @return array
	 */
	public function printGrid() {
		return array('label' => '', 'url' => 'javascript:window.print()', 'htmlOptions' => array('title' => 'Print', 'class' => 'icon fam-printer block-icon'));
	}

	/**
	 *	Return options for the grid columns update button
	 * @return array 
	 */
	public function updateGridColumns() {

		$model = get_class($this->dataProvider->model);
		$gridId = $this->id;

		$label = '';

		return array(
			'label' => $label, 'url' => '#',
			'htmlOptions' => array(
				'onclick' => self::gridSettingsDialog(array('model' => $model, 'gridId'=>$gridId)),
				'title' => 'Update Visible Columns',
				'class' => 'icon fam-cog block-icon',
			),
		);
	}
	
	/**
	 *	@end button functions 
	 */
	
	/**
	 * Almighty function to return the columns to the grid view, including their visible status, as defined in NData
	 * @param model $model
	 * @return type 
	 */
	public function gridColumns($model) {
		$model = $this->filter;
		$visibleColumns = NData::visibleColumns($this->filter, $this->id);
		$columns = $model->columns();
		
		foreach($columns as $key=>$col) {
			$columns[$key]['visible'] = (array_key_exists($col['name'], $visibleColumns) ? $visibleColumns[$col['name']] : null);
		}
		
		// reorder the columns to follow the same order returned by visible columns
		$columnOrder = array_flip(array_keys($visibleColumns));
		$ordered = array();
		foreach($columns as $key=>$col){
			$orderPos = $columnOrder[$col['name']];
			$ordered[$orderPos] = $col;
		}
		ksort($ordered);
		
		
		return $ordered;
	}	
	
	/**
	 *	Return javascript to be used in the updateGridColumns button (above)
	 * @param array $params
	 * @return string Javascript for 'onclick' of grid settings button
	 */		
	public static function gridSettingsDialog($params=array()) {
		
		$dialog_id = 'gridSettingsDialog';
		$url = CHtml::normalizeUrl(array('/nii/grid/gridSettingsDialog/','model'=>$params['model'], 'gridId'=>$params['gridId']));
		return '$("#'.$dialog_id.'").dialog({
			open: function(event, ui){
				$("#'.$dialog_id.'").load("'.$url.'", function(){
					$("#gridSettingsForm").sortable({axis:"y"});
				});
			},
			minHeight: 100, position: ["center", 100],
			width: 400,
			autoOpen: true,
			title: "Update Visible Columns",
			modal: true,
			buttons: [
				{
					text: "Save",
					class: "btn primary",
					click: function() {
						pageUrl = "'.CHtml::normalizeUrl(array('/nii/grid/updateGridSettings/', 'key'=>$params['gridId'])).'";
						$.ajax({
							url: pageUrl,
							data: jQuery("#gridSettingsForm").serialize(),
							dataType: "json",
							type: "post",
							success: function(response){ 
								if (response.success) {
									$("#gridSettingsDialog").dialog("close");
									$.fn.yiiGridView.update("'.$params['gridId'].'");
									nii.showMessage(response.success);
								}
							},
							error: function() {
								alert ("JSON failed to return a valid response");
							}
						}); 
						return false;
					},
				}
			],
		});
		return false;';
	}
			
	/**
	 * Return javascript to be used in the exportGrid button (above)
	 * @param array $params
	 * @return string Javascript for 'onclick' of export grid button
	 */		
	public static function exportGridDialog($params=array()) {
		
		$dialog_id = 'exportGridDialog';
		$url = CHtml::normalizeUrl(array('/nii/grid/exportDialog/','model'=>$params['model'],'gridId'=>$params['gridId'],'model_id'=>$params['model_id'],'scope'=>$params['scope']));
		return '$("#'.$dialog_id.'").dialog({
			open: function(event, ui){
				$("#'.$dialog_id.'").load("'.$url.'");
			},
			minHeight: 100, position: ["center", 100],
			width: 400,
			autoOpen: true,
			title: "Select Columns to Export",
			modal: true,
		});
		return false;';
	}
	
	
	
	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table class=\"{$this->itemsCssClass}\">\n";
			$this->renderTableHeader();
			ob_start();
			$this->renderTableBody();
			$body=ob_get_clean();
			$this->renderTableFooter();
			echo $body; // TFOOT must appear before TBODY according to the standard.
			echo "</table>";
		}
		else
			$this->renderEmptyText();
	}

	/**
	 * Renders the table header.
	 */
	public function renderTableHeader()
	{
		if(!$this->hideHeader)
		{
			echo "<thead>\n";

			if($this->filterPosition===self::FILTER_POS_HEADER)
				$this->renderFilter();

			echo "<tr id=\"".$this->id.'-head'."\">\n";
			foreach($this->columns as $column)
				$column->renderHeaderCell();
			echo "</tr>\n";

			if($this->filterPosition===self::FILTER_POS_BODY)
				$this->renderFilter();

			echo "</thead>\n";
		}
		else if($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
		{
			echo "<thead>\n";
			$this->renderFilter();
			echo "</thead>\n";
		}
	}

	/**
	 * Renders the filter.
	 * @since 1.1.1
	 */
	public function renderFilter()
	{
		if($this->filter!==null)
		{
			echo "<tr class=\"{$this->filterCssClass}\">\n";
			foreach($this->columns as $column)
				$column->renderFilterCell();
			echo "</tr>\n";
		}
	}

	/**
	 * Renders the table footer.
	 */
	public function renderTableFooter()
	{
		$hasFilter=$this->filter!==null && $this->filterPosition===self::FILTER_POS_FOOTER;
		$hasFooter=$this->getHasFooter();
		if($hasFilter || $hasFooter)
		{
			echo "<tfoot>\n";
			if($hasFooter)
			{
				echo "<tr>\n";
				foreach($this->columns as $column)
					$column->renderFooterCell();
				echo "</tr>\n";
			}
			if($hasFilter)
				$this->renderFilter();
			echo "</tfoot>\n";
		}
	}

	/**
	 * Copy of the parent renderTableBody
	 * Renders the table body.
	 */
	public function renderTableBody()
	{
		$data=$this->dataProvider->getData();
		$n=count($data);
		echo "<tbody id=\"" . $this->getId() . '-body' . "\">\n";

		if($n>0)
		{
			for($row=0;$row<$n;++$row)
				$this->renderTableRow($row);
		}
		else
		{
			echo '<tr><td colspan="'.count($this->columns).'">';
			$this->renderEmptyText();
			echo "</td></tr>\n";
		}
		echo "</tbody>\n";
	}

	/**
	 * Renders a table body row.
	 * @param integer $row the row number (zero-based).
	 */
	public function renderTableRow($row)
	{
		if($this->rowCssClassExpression!==null)
		{
			$data=$this->dataProvider->data[$row];
			echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
		}
		else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
			echo '<tr class="'.$this->rowCssClass[$row%$n].'">';
		else
			echo '<tr>';
		foreach($this->columns as $column)
			$column->renderDataCell($row);
		echo "</tr>\n";
	}

}