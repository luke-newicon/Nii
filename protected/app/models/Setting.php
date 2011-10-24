<?php

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property integer $id
 * @property integer $user_id
 * @property string $setting_name
 * @property string $setting_value
 */
class Setting extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Setting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id', 'numerical', 'integerOnly'=>true),
			array('setting_name', 'length', 'max'=>255),
			array('type, setting_name, setting_value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, type, setting_name, setting_value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'setting_name' => 'Setting Name',
			'setting_value' => 'Setting Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('setting_name',$this->setting_name,true);
		$criteria->compare('setting_value',$this->setting_value,true);

		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function visibleColumns($model=null, $controller=null, $action=null) {
		if ($controller==null) $controller = Yii::app()->controller->uniqueid;
		if ($action==null) $action = Yii::app()->controller->action->Id;
		
		$controllerPath =  $controller. '/' .$action ;
		$columns = new Setting;
		
		$cols = array();
		
		$attributes = array('type'=>'grid_columns','setting_name'=>$controllerPath, 'user_id'=>Yii::app()->user->record->id);
		$visibleColumns = $columns->findByAttributes($attributes)->setting_value;
		if ($visibleColumns) {
			$cols = CJSON::decode($visibleColumns);
		} else {
			$attributes = array('type'=>'grid_columns','setting_name'=>$controllerPath, 'user_id'=>'0');
			$visibleColumns = $columns->findByAttributes($attributes)->setting_value;
			if ($visibleColumns) {
				$cols = CJSON::decode($visibleColumns);
			}
		}	
				
		$model = new $model;
		$allcolumns = $model->columns(array());
		$columns = array();
		foreach ($allcolumns as $col) {
			if ($col['name']) {
				if (array_key_exists($col['name'], $cols)) {
					$columns[$col['name']] = $cols[$col['name']];
				} else {
					$columns[$col['name']] = '1';
				}
			}
		}
		return $columns;
		
	}	
	
	public static function exportColumns($model=null, $controller=null, $action=null) {
		if ($controller==null) $controller = Yii::app()->controller->uniqueid;
		if ($action==null) $action = Yii::app()->controller->action->Id;
		
		$controllerPath =  $controller. '/' .$action ;
		$columns = new Setting;
		
		$cols = array();
		
		$attributes = array('type'=>'export_columns','setting_name'=>$controllerPath, 'user_id'=>Yii::app()->user->record->id);
		$visibleColumns = $columns->findByAttributes($attributes)->setting_value;
		if ($visibleColumns) {
			$cols = CJSON::decode($visibleColumns);
		} else {
			$attributes = array('type'=>'export_columns','setting_name'=>$controllerPath, 'user_id'=>'0');
			$visibleColumns = $columns->findByAttributes($attributes)->setting_value;
			if ($visibleColumns) {
				$cols = CJSON::decode($visibleColumns);
			}
		}	
				
		$model = new $model;
		$allcolumns = $model->columns(array());
		$columns = array();
		foreach ($allcolumns as $col) {
			if ($col['name'] && $col['export']!==false) {
				if (array_key_exists($col['name'], $cols)) {
					$columns[$col['name']] = $cols[$col['name']];
				} else {
					$columns[$col['name']] = '1';
				}
			}
		}
		return $columns;
	}
	
	public static function exportColumnsSql($model, $controller=null, $action=null) {
		$allCols = self::exportColumns($model, $controller, $action);
		$cols = array();
		$check = new $model;
		foreach ($allCols as $col => $value) {
			if ($value == '1' || $value == true) {
				$cols[$col] = $col; //Controller::checkExportCols($model, $col);
			}
		}
		return $cols;
	}
			
	public static function gridSettingsDialog($params=array()) {
		
		$dialog_id = 'gridSettingsDialog';
		$url = CHtml::normalizeUrl(array('/users/gridSettingsDialog/','controller'=>$params['controller'],'action'=>$params['action'],'model'=>$params['model']));
		return '$("#'.$dialog_id.'").dialog({
			open: function(event, ui){
				$("#'.$dialog_id.'").load("'.$url.'");
			},
			minHeight: 100, position: ["center", 100],
			width: 400,
			autoOpen: true,
			title: "Update Visible Columns",
			modal: true,
		});
		return false;';
	}
			
	public static function exportGridDialog($params=array()) {
		
		$dialog_id = 'exportGridDialog';
		$url = CHtml::normalizeUrl(array('/csv/exportDialog/','controller'=>$params['controller'],'action'=>$params['action'],'model'=>$params['model'],'model_id'=>$params['model_id'],'scope'=>$params['scope']));
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
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'user_id' => "int(11) NOT NULL",
				'type' => "varchar(50)",
				'setting_name' => "varchar(255)",
				'setting_value' => "text",
				'trashed' => "int(1) unsigned NOT NULL",
			),
			'keys' => array(
				array('user','user_id')
			)
		);
	}
	
	public function getTabs(){
		$tabs = array('general' => array('ajax' => array('/admin/settingsTab','module'=>'admin')));
		foreach(Yii::app()->niiModules as $name => $module){
			$tabs[$module->name] = array('ajax' => $module->settingsPage);
		}
		return $tabs;
	}
}