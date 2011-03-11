<?php

/**
 * This is the model class for table "projects_sprint".
 *
 * The followings are the available columns in table 'projects_sprint':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $duration
 * @property integer $created_by
 * @property string $created
 * @property string $project_id
 * @property string $status
 * @property integer $sprint_order
 * @property integer $out_of_scope
 *
 * The followings are the available model relations:
 * @property ProjectsAction[] $projectsActions
 * @property UserUser $createdBy0
 * @property ProjectsProject $project
 */
class ProjectsSprint extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectsSprint the static model class
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
		return 'projects_sprint';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('duration, created_by, sprint_order, out_of_scope', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('code', 'length', 'max'=>45),
			array('project_id', 'length', 'max'=>11),
			array('status', 'length', 'max'=>8),
			array('description, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, description, duration, created_by, created, project_id, status, sprint_order, out_of_scope', 'safe', 'on'=>'search'),
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
			'projectsActions' => array(self::HAS_MANY, 'ProjectsAction', 'sprint_id'),
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
			'name' => 'Name',
			'code' => 'Code',
			'description' => 'Description',
			'duration' => 'Duration',
			'created_by' => 'Created By',
			'created' => 'Created',
			'project_id' => 'Project',
			'status' => 'Status',
			'sprint_order' => 'Sprint Order',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('project_id',$this->project_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('sprint_order',$this->sprint_order);
		$criteria->compare('out_of_scope',$this->out_of_scope);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}