<?php
/**
 * This is the model class for table "projects_project".
 *
 * The followings are the available columns in table 'projects_project':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $code
 * @property string $description
 * @property string $created
 * @property integer $created_by
 * @property integer $tree_lft
 * @property integer $tree_rgt
 * @property integer $tree_level
 * @property integer $tree_parent
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property ProjectsIssue[] $projectsIssues
 * @property User $createdBy0
 */
class ProjectsProject extends NActiveRecord
{

	const DRAFT = 'Draft';
	const STARTED = 'Started';
	const COMPLETED= 'Completed';

	public static function statusTypes(){
		return array('DRAFT'=>DRAFT,'STARTED'=>STARTED,'COMPLETED'=>COMPLETED);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectsProject the static model class
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
		return 'projects_project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_by, tree_lft, tree_rgt, tree_level, tree_parent, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('code', 'length', 'max'=>50),
			array('description, created', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code,status, description,created,deleted','safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'projectsIssues' => array(self::HAS_MANY, 'ProjectsIssue', 'project_id'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'code' => 'Code',
			'description' => 'Description',
			'created' => 'Created',
			'created_by' => 'Created By',
			'tree_lft' => 'Tree Lft',
			'tree_rgt' => 'Tree Rgt',
			'tree_level' => 'Tree Level',
			'tree_parent' => 'Tree Parent',
			'deleted' => 'Deleted',
			'status' =>'Status',
			'createdBy.username'=>'Created By'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('status', $this->status,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider(get_class($this), array('criteria'=>$criteria,));
	}

	/**
	 * The content for the project name cell
	 * @return <type>
	 */
	public function projectNameFilter(){
		$n = NHtml::hilightText($this->name, $_REQUEST['ProjectsProject']['name']);
		return '<a href="'.yii::app()->createUrl('projects/index/view/id/'.$this->id).'">'.$n.'</a>';
	}

	public function statusDropdown(){
		return self::statusTypes();
	}
}