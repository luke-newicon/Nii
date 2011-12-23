<?php

/**
 * This is the model class for table "email_template".
 *
*/
class HostingServer extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{hosting_server}}';
	}

	public function getModule() {
		return Yii::app()->getModule('hosting');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, server_name', 'required'),
			array('ip_address, root_password, created_date', 'safe'),
			array('ip_address, root_password, created_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
//			'template' => array(self::BELONGS_TO, 'EmailCampaignTemplate', 'template_id'),
		);

//		foreach ($this->relations as $name => $relation) {
//			if (isset($relation['relation']))
//				$relations[$name] = $relation['relation']; 
//		}
		return $relations;
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'editLink' => '',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('server_name', $this->server_name, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('ip_address', $this->ip_address, true);

		$sort = new CSort;
		$sort->defaultOrder = 'id DESC';

		return new NActiveDataProvider($this, array(
					'criteria' => $criteria,
					'sort' => $sort,
					'pagination' => array(
						'pageSize' => 20,
					),
				));
	}

	public function columns() {
		return array(
			array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '$data->viewNameLink',
				'exportValue' => '$data->name',
			),
			array(
				'name' => 'server_name',
				'type' => 'raw',
				'value' => '$data->viewLink',
				'exportValue' => '$data->server_name',
			),
			array(
				'name' => 'ip_address',
			),
			array(
				'name' => 'root_password',
			),
			array(
				'name' => 'created_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->created_date, "d M Y")',
			),
			array(
				'name' => 'editLink',
				'type' => 'raw',
				'value' => '$data->editLink',
				'export' => false,
				'filter' => false,
			),
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'server_name' => "varchar(255)",
				'ip_address' => "varchar(255)",
				'name' => "varchar(255)",
				'root_password' => "varchar(255)",
				'created_date' => "datetime",
				'updated_date' => "datetime",
				'trashed' => 'TINYINT(1) NOT NULL DEFAULT 0',
			),
			'keys' => array());
	}
	
	public function getEditLink() {
		return NHtml::link('Edit', array('/hosting/server/edit', 'id'=>$this->id));
	}
	
	public function getViewLink() {
		return NHtml::link($this->server_name, array('/hosting/server/view', 'id'=>$this->id));
	}
	
	public function getViewNameLink() {
		return NHtml::link($this->name, array('/hosting/server/view', 'id'=>$this->id));
	}
	
	function behaviors() {
		return array(
			'trash'=>array(
				'class'=>'nii.components.behaviors.ETrashBinBehavior',
				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
			),
			'tag'=>array(
               'class'=>'nii.components.behaviors.NTaggable'
           )
		);
	}
	
}