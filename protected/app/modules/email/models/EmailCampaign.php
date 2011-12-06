<?php

/**
 * This is the model class for table "email_template".
 *
*/
class EmailCampaign extends NActiveRecord {

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
		return '{{email_campaign}}';
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
			array('id', 'required'),
			array('template_id, content, subject', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'template' => array(self::BELONGS_TO, 'EmailTemplate', 'template_id'),
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
			'template_id' => 'Select a Template',
			'recipients' => 'Recipients',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('template.name', $this->template_id, true);

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
			'id',
			'template_id',
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'template_id' => "int(11)",
				'recipients' => "text",
			),
			'keys' => array());
	}
	
//	function behaviors() {
//		return array(
//			'trash'=>array(
//				'class'=>'nii.components.behaviors.ETrashBinBehavior',
//				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
//			),
//			'tag'=>array(
//               'class'=>'nii.components.behaviors.NTaggable'
//           )
//		);
//	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
}