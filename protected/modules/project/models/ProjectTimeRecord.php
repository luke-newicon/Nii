<?php

/**
 * This is the model class for table "project_time_record".
 *
 * The followings are the available columns in table 'project_time_record':
 * @property string $id
 * @property string $time_started
 * @property string $time_finished
 * @property string $task_id
 * @property string $description
 * @property string $added
 * @property integer $added_by
 * @property string $type
 *
 * The followings are the available model relations:
 * @property ProjectTask $issue
 * @property UserUser $addedBy0
 * @property ProjectTimeRecordtype $type0
 */
class ProjectTimeRecord extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectTimeRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'project_time_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('added_by', 'numerical', 'integerOnly' => true),
			array('task_id, type', 'length', 'max' => 11),
			array('time_started,time_finished','length','max' => 20),
			array(array('type','description'),'required'),
			array('description, added', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time_started,time_finished, task_id, description, added, added_by, type', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'issue' => array(self::BELONGS_TO, 'ProjectTask', 'task_id'),
			'addedByUser' => array(self::BELONGS_TO, 'User', 'added_by'),
			'typeInfo' => array(self::BELONGS_TO, 'ProjectTimeRecordtype', 'type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'task_id' => 'Issue',
			'description' => 'Description',
			'added' => 'Added',
			'added_by' => 'Added By',
			'type' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($issueId) {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('task_id', $issueId);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('added', $this->added, true);
		$criteria->compare('added_by', $this->added_by);
		$criteria->compare('type', $this->type, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	/**
	 *
	 * @return array
	 */
	public function getTypes($includeBlankItem) {
		$typeArray = array();

		if($includeBlankItem)
			$typeArray[''] = '-';
		
		$types = Yii::app()->db->createCommand()
						->select('id, name')
						->from('project_time_recordtype')
						->queryAll();

		foreach ($types as $type)
			$typeArray [$type['id']] = $type['name'];

		return $typeArray;
	}

}