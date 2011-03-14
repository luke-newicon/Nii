<?php

/**
 * This is the model class for table "project_action_assigned".
 *
 * The followings are the available columns in table 'project_action_assigned':
 * @property string $id
 * @property string $issue_id
 * @property integer $user_id
 * @property string $project_role
 * @property string $added
 * @property integer $assigned_by
 *
 * The followings are the available model relations:
 * @property UserUser $user
 * @property ProjectTask $issue
 */
class ProjectActionAssigned extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectActionAssigned the static model class
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
		return 'project_action_assigned';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, assigned_by', 'numerical', 'integerOnly'=>true),
			array('issue_id', 'length', 'max'=>11),
			array('project_role', 'length', 'max'=>8),
			array('added', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, issue_id, user_id, project_role, added, assigned_by', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'UserUser', 'user_id'),
			'issue' => array(self::BELONGS_TO, 'ProjectTask', 'issue_id'),
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
			'user_id' => 'User',
			'project_role' => 'Project Role',
			'added' => 'Added',
			'assigned_by' => 'Assigned By',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('project_role',$this->project_role,true);
		$criteria->compare('added',$this->added,true);
		$criteria->compare('assigned_by',$this->assigned_by);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}