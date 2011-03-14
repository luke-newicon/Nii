<?php

/**
 * This is the model class for table "project_task_history".
 *
 * The followings are the available columns in table 'project_task_history':
 * @property string $id
 * @property string $issue_id
 * @property string $status
 * @property integer $updated_by
 * @property string $updated
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property ProjectTask $issue
 * @property UserUser $updatedBy0
 */
class ProjectTaskHistory extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectTaskHistory the static model class
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
		return 'project_task_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('updated_by', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('issue_id, status', 'length', 'max'=>11),
			array('updated, comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, issue_id, status, updated_by, updated, comment', 'safe', 'on'=>'search'),
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
			'issue' => array(self::BELONGS_TO, 'ProjectTask', 'issue_id'),
			'updatedBy0' => array(self::BELONGS_TO, 'UserUser', 'updated_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'issue_id' => 'Issue',
			'status' => 'Status',
			'updated_by' => 'Updated By',
			'updated' => 'Updated',
			'comment' => 'Comment',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('issue_id',$this->issue_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}