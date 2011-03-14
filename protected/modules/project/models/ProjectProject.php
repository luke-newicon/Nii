<?php

/**
 * This is the model class for table "project_project".
 *
 * The followings are the available columns in table 'project_project':
 * @property string $id
 * @property string $logo
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $completion_date
 * @property integer $tree_lft
 * @property integer $tree_rgt
 * @property integer $tree_level
 * @property integer $tree_parent
 * @property integer $estimated_time
 * @property string $created
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property UserUser $createdBy0
 * @property ProjectProjectAssigned[] $projectProjectAssigneds
 * @property ProjectProjectHistory[] $projectProjectHistories
 * @property ProjectSprint[] $projectSprints
 * @property ProjectTask[] $projectTasks
 */
class ProjectProject extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectProject the static model class
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
		return 'project_project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tree_lft, tree_rgt, tree_level, tree_parent, estimated_time, created_by', 'numerical', 'integerOnly'=>true),
			array('logo', 'length', 'max'=>11),
			array('name', 'length', 'max'=>100),
			array('code', 'length', 'max'=>50),
			array('description, completion_date, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, logo, name, code, description, completion_date, tree_lft, tree_rgt, tree_level, tree_parent, estimated_time, created, created_by', 'safe', 'on'=>'search'),
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
			'createdBy0' => array(self::BELONGS_TO, 'UserUser', 'created_by'),
			'projectProjectAssigneds' => array(self::HAS_MANY, 'ProjectProjectAssigned', 'project_id'),
			'projectProjectHistories' => array(self::HAS_MANY, 'ProjectProjectHistory', 'project_id'),
			'projectSprints' => array(self::HAS_MANY, 'ProjectSprint', 'project_id'),
			'projectTasks' => array(self::HAS_MANY, 'ProjectTask', 'project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'logo' => 'Logo',
			'name' => 'Name',
			'code' => 'Code',
			'description' => 'Description',
			'completion_date' => 'Estimated Completion Date',
			'tree_lft' => 'Tree Lft',
			'tree_rgt' => 'Tree Rgt',
			'tree_level' => 'Tree Level',
			'tree_parent' => 'Tree Parent',
			'estimated_time' => 'Estimated Time (hours)',
			'created' => 'Created',
			'created_by' => 'Created By',
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
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('completion_date',$this->completion_date,true);
		$criteria->compare('tree_lft',$this->tree_lft);
		$criteria->compare('tree_rgt',$this->tree_rgt);
		$criteria->compare('tree_level',$this->tree_level);
		$criteria->compare('tree_parent',$this->tree_parent);
		$criteria->compare('estimated_time',$this->estimated_time);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * The content for the project name cell
	 * @return <type>
	 */
	public function nameFilter(){
		$n = null;
		$projectName = null;
		if(isset($_REQUEST['ProjectsProject']['name']))
			$projectName = $_REQUEST['ProjectsProject']['name'];

		if($projectName){
			$_REQUEST['ProjectsProject']['name'];
			$n = NHtml::hilightText($this->name, $_REQUEST['ProjectsProject']['name']);
		}else{
			$n = $this->name;
		}
		return '<a href="'.yii::app()->createUrl('project/index/view/id/'.$this->id).'">'.$n.'</a>';
	}
}