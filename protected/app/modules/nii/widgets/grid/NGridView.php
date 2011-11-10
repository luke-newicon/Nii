<?php

Yii::setPathOfAlias('nii-grid', dirname(__FILE__));
Yii::import('zii.widgets.grid.CGridView');
Yii::import('nii-grid.scopes.NScopeList');
Yii::import('nii-grid.NDataColumn');

class NGridView extends CGridView {

//	public $template = "{scopes}\n{summary}\n{items}\n{pager}";
	/*
	 * Example of scopes array in configuration
	 * 'scopes' => array(
	  'items' => array(
	  'default' => 'All',
	  'published' => 'Published',
	  'draft' => 'Draft',
	  'published.alpha' => 'Published (Alphabetical)',
	  'published.alpha.recent' => 'Published (Recent, Alphabetical)',
	  ),
	  ),
	 */
	public $template = "{scopes}\n{buttons}<div class='grid-top-summary'>{summary} {pager}</div>{items}\n{pager}";
	public $scopes;
	public $enableCustomScopes;
	public $defaultColumnClass = 'NDataColumn';
	public $defaultScopeListClass = 'NScopeList';
	public $selectableRows = 2;
	public $enableButtons = false;
	public $buttons = array('export', 'print', 'update');
	public $buttonModelId = null;
	public $defaultExportButton = 'exportGrid';
	public $defaultPrintButton = 'printGrid';
	public $defaultUpdateButton = 'updateGridColumns';
	// ajax in only the bits we need.  should modify to be id's for performance
	public $ajaxUpdate = '#ContactAllGrid .grid-top-summary, #ContactAllGrid thead .header, #ContactAllGrid tbody';

	public function init() {

		if (isset($this->scopes['default']))
			$this->dataProvider->defaultScope = $this->scopes['default'];
		// Configuring grid columns...
		if ($this->columns==null)
			$this->columns = $this->gridColumns($this->filter);
		parent::init();
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
	 *	Almighty function to return the columns to the grid view, including their visible status, as defined in NData
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
		return $columns;
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
				$("#'.$dialog_id.'").load("'.$url.'");
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
									showMessage(response.success);
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

}