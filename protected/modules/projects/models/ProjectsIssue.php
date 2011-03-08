<?php

/**
 * This is the model class for table "projects_issue".
 *
 * The followings are the available columns in table 'projects_issue':
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $project_id
 * @property string $created
 * @property integer $created_by
 * @property string $completed
 * @property integer $completed_by
 * @property integer $deleted
 * @property integer $estimated_time
 * @property integer $out_of_scope
 *
 * The followings are the available model relations:
 * @property UserUser $completedBy0
 * @property UserUser $createdBy0
 * @property ProjectsProject $project
 */
class ProjectsIssue extends NActiveRecord
{

	/**
	 * The id of the project which the issue/s belong to.
	 * @var int $projectId
	 */
	public $projectId = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectsIssue the static model class
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
		return 'projects_issue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, created_by, completed_by, deleted, estimated_time, out_of_scope', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>12),
			array('name', 'length', 'max'=>50),
			array('status', 'length', 'max'=>18),
			array('description, created, completed', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, name, description, status, project_id, created, created_by, completed, completed_by, deleted, estimated_time, out_of_scope', 'safe', 'on'=>'search'),
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
			'completedBy0' => array(self::BELONGS_TO, 'UserUser', 'completed_by'),
			'createdBy0' => array(self::BELONGS_TO, 'UserUser', 'created_by'),
			'project' => array(self::BELONGS_TO, 'ProjectsProject', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'name' => 'Name',
			'description' => 'Description',
			'status' => 'Status',
			'project_id' => 'Project',
			'created' => 'Created',
			'created_by' => 'Created By',
			'completed' => 'Completed',
			'completed_by' => 'Completed By',
			'deleted' => 'Deleted',
			'estimated_time' => 'Estimated Time',
			'out_of_scope' => 'Out Of Scope',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('project_id',$this->projectId);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('completed',$this->completed,true);
		$criteria->compare('completed_by',$this->completed_by);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('estimated_time',$this->estimated_time);
		$criteria->compare('out_of_scope',$this->out_of_scope);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}