<?php

/**
 * This is the model class for table "email_template".
 *
*/
class EmailTemplate extends NActiveRecord {

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
		return '{{email_template}}';
	}

	public function getModule() {
		return Yii::app()->getModule('email');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('content, default_template, description', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			
		);

		return $relations;
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'content' => 'Template Content',
			'editLink' => 'Edit',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);

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
				'value' => '$data->viewLink',
				'exportValue' => '$data->name',
			),
			array(
				'name' => 'description',
			),
			array(
				'name' => 'default_template',
				'type' => 'raw',
				'value' => 'NHtml::formatBool($data->default_template)',
				'htmlOptions' => array('width'=>'60px'),
			),
			array(
				'name' => 'editLink',
				'type' => 'raw',
				'value' => '$data->editLink',
				'export' => false,
				'filter' => false,
				'htmlOptions' => array('width'=>'40px'),
			),
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'name' => "varchar(255)",
				'description' => "text",
				'content' => "text",
				'default_template' => 'tinyint(1)',
				'trashed' => "tinyint(1) NOT NULL DEFAULT 0",
			),
			'keys' => array());
	}
	
	/**
	 *	Get groups as array to use in drop down lists
	 * @return array - [id]=>name 
	 */
	public static function getTemplates() {
		$t=array();
		$templates = self::model()->findAll();
		foreach ($templates as $template) {
			$t[$template->id] = $template->name;
		}
		return $t;
	}
	
	public function getEditLink() {
		return NHtml::link('Edit', array('/email/template/edit', 'id'=>$this->id));
	}
	
	public function getViewLink() {
		return NHtml::link($this->name, array('/email/template/view', 'id'=>$this->id));
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	function behaviors() {
		return array(
			'trash'=>array(
				'class'=>'nii.components.behaviors.ETrashBinBehavior',
				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
			)
		);
	}
	
}