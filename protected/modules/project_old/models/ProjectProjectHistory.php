<?php

/**
 * This is the model class for table "project_project_history".
 *
 * The followings are the available columns in table 'project_project_history':
 * @property string $id
 * @property string $project_id
 * @property string $status
 * @property string $comment
 * @property integer $updated_by
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property ProjectProject $project
 * @property UserUser $updatedBy0
 */
class ProjectProjectHistory extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectProjectHistory the static model class
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
		return 'project_project_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('updated_by', 'numerical', 'integerOnly'=>true),
			array('project_id', 'length', 'max'=>11),
			array('status', 'length', 'max'=>18),
			array('comment, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, project_id, status, comment, updated_by, updated', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'ProjectProject', 'project_id'),
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
			'project_id' => 'Project',
			'status' => 'Status',
			'comment' => 'Comment',
			'updated_by' => 'Updated By',
			'updated' => 'Updated',
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
		$criteria->compare('project_id',$this->project_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}