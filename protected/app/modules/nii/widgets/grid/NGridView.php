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

	public function init() {

		if (isset($this->scopes['default']))
			$this->dataProvider->defaultScope = $this->scopes['default'];
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

	public function exportGrid() {
		$model_id = null;

		if ($this->buttonModelId)
			$model_id = $this->buttonModelId;

		$controller = Yii::app()->controller->uniqueid;
		$action = Yii::app()->controller->action->id;
		$model = get_class($this->dataProvider->model);

		$label = '';

		return array(
			'label' => $label, 'url' => '#',
			'htmlOptions' => array(
				'onclick' => Setting::exportGridDialog(
						array('controller' => $controller, 'action' => $action, 'model' => $model, 'model_id' => $model_id, 'scope' => $this->dataProvider->currentScope)
				),
				'title' => 'Export to CSV, Excel or ODS',
				'class' => 'icon fam-table-go block-icon',
			),
		);
	}

	public function printGrid() {
		return array('label' => '', 'url' => 'javascript:window.print()', 'htmlOptions' => array('title' => 'Print', 'class' => 'icon fam-printer block-icon'));
	}

	public function updateGridColumns() {

		$controller = Yii::app()->controller->uniqueid;
		$action = Yii::app()->controller->action->id;
		$model = get_class($this->dataProvider->model);
		$gridId = $this->id;

		$label = '';

		return array(
			'label' => $label, 'url' => '#',
			'htmlOptions' => array(
				'onclick' => Setting::gridSettingsDialog(array('controller' => $controller, 'action' => $action, 'model' => $model, 'gridId'=>$gridId)),
				'title' => 'Update Visible Columns',
				'class' => 'icon fam-cog block-icon',
			),
		);
	}

}