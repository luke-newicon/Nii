<?php

/**
 * This is the model class for table "project_task".
 *
 * The followings are the available columns in table 'project_task':
 * @property string $id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $project_id
 * @property string $created
 * @property integer $created_by
 * @property integer $estimated_time
 * @property integer $out_of_scope
 * @property integer $assigned_user
 * @property string $sprint_id
 *
 * The followings are the available model relations:
 * @property MeetingToTask[] $meetingToTasks
 * @property ProjectActionAssigned[] $projectActionAssigneds
 * @property ProjectProject $project
 * @property UserUser $createdBy0
 * @property UserUser $assignedUser0
 * @property ProjectSprint $sprint
 * @property ProjectTaskHistory[] $projectTaskHistories
 * @property ProjectTimeRecord[] $projectTimeRecords
 */
class ProjectTask extends NActiveRecord {
	const TYPE_ISSUE = 'Issue';
	const TYPE_BUG = 'Bug';
	const TYPE_FEATURE = 'Feature';
	const TYPE_ACTION = 'Action';

	public $recorded_time;
	public $total_recorded_time;
	public $types = array(
		'TYPE_ISSUE' => self::TYPE_ISSUE,
		'TYPE_BUG' => self::TYPE_BUG,
		'TYPE_FEATURE' => self::TYPE_FEATURE,
		'TYPE_ACTION' => self::TYPE_ACTION
	);

	public function getType($type = null) {
		if (!$type)
			return constant('self::' . $this->type);
		else
			return constant('self::' . $type);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectTask the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'project_task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_by, estimated_time, out_of_scope, assigned_user', 'numerical', 'integerOnly' => true),
			array(array('name', 'description'), 'required'),
			array('type', 'length', 'max' => 12),
			array('name', 'length', 'max' => 50),
			array('project_id, sprint_id', 'length', 'max' => 11),
			array('description, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, name, description, project_id, created, created_by, estimated_time, out_of_scope, assigned_user, sprint_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'meetingToTasks' => array(self::HAS_MANY, 'MeetingToTask', 'action_id'),
			'projectActionAssigneds' => array(self::HAS_MANY, 'ProjectActionAssigned', 'issue_id'),
			'project' => array(self::BELONGS_TO, 'ProjectProject', 'project_id'),
			'createdByUserName' => array(self::BELONGS_TO, 'User', 'created_by'),
			'assignedToUser' => array(self::BELONGS_TO, 'User', 'assigned_user'),
			'sprint' => array(self::BELONGS_TO, 'ProjectSprint', 'sprint_id'),
			'projectTaskHistories' => array(self::HAS_MANY, 'ProjectTaskHistory', 'issue_id'),
			'projectTimeRecords' => array(self::HAS_MANY, 'ProjectTimeRecord', 'issue_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'name' => 'Name',
			'description' => 'Description',
			'project_id' => 'Project',
			'created' => 'Created',
			'created_by' => 'Created By',
			'estimated_time' => 'Estimated Time',
			'out_of_scope' => 'Out Of Scope',
			'assigned_user' => 'Assigned User',
			'sprint_id' => 'Sprint',
		);
	}

	/**
	 * The tasks search data
	 * @param int $project_Id The id of the project which the tasks relate to
	 * @return CActiveDataProvider
	 */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->join = 'left join project_time_record on
		t.id = project_time_record.task_id';
		$criteria->select = array('t.type',
			't.id',
			't.name',
			'SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_finished,time_started)))) as recorded_time',
			't.description',
			't.created',
			't.estimated_time',
			't.out_of_scope');
		$criteria->group = 't.id';
		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.type', $this->type, true);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.recorded_time', $this->recorded_time);
		$criteria->compare('t.project_id', $this->project_id);
		$criteria->compare('t.created', $this->created, true);
		$criteria->compare('t.created_by', $this->created_by);
		$criteria->compare('t.estimated_time', $this->estimated_time);
		$criteria->compare('t.out_of_scope', $this->out_of_scope);
		$criteria->compare('t.assigned_user', $this->assigned_user);
		$criteria->compare('t.sprint_id', $this->sprint_id, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getTaskTypes() {
		return $this->types;
	}

	public function getProjectSprints() {
		return array('' => 'None');
	}

	/**
	 * Returns the recorded time against a project.
	 * @return string The time in Hours:Minutes:Seconds which has been recorded against a project
	 */
	public function getRecordedTime() {
		$condition = array(
			'join' => 'left join project_time_record on
		 t.id = project_time_record.task_id',
			'select' => 'SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_finished,time_started)))) as recorded_time',
		);
		//$test = $this->model()->find('id = '.$this->id, $params);
		$test = $this->model()->findByPk($this->id, $condition);
		return $test->recorded_time;
	}


	/**
	 * The name column grid contents
	 * @return string
	 */
	public function nameCol() {
		$n = null;
		$projectName = null;
		if (isset($_REQUEST['ProjectsProject']['name']))
			$projectName = $_REQUEST['ProjectsProject']['name'];

		if ($projectName) {
			$_REQUEST['ProjectsProject']['name'];
			$n = NHtml::hilightText($this->name, $_REQUEST['ProjectsProject']['name']);
		} else {
			$n = $this->name;
		}
		return '<a href="' . yii::app()->createUrl('project/task/view/taskId/' . $this->id) . '">' . $n . '</a>';
	}

	public function outOfScopeCol() {
		if ($this->out_of_scope == 1)
			return 'Yes';
		else
			return 'No';
	}

}