<?php

class NLog extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Accomm the static model class
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
		return '{{nii_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, description', 'required'),
			array('model, model_id, controller, action', 'safe'),
			array('id, model, model_id, user_id, controller, action, description, username, datetime, path', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'User',
			'description' => 'Description of action',
			'path' => 'URL Path',
			'datetime' => 'Log Date'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('model',$this->model);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('description',$this->description, true);
		$criteria->compare('datetime',$this->datetime, true);
		$criteria->compare('user.username',$this->username, true);
		$criteria->compare('CONCAT(t.controller,"/",t.action)',$this->path, true);
		
		$criteria->with = array('user');
		
		$criteria->order = 'datetime DESC';

		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,	
			'pagination'=>array(
				'pageSize'=>100,
            ),
		));
	}
	
	public function columns() {
		return array(
			array(
				'name' => 'description',
				'htmlOptions'=>array('width'=>'500px'),
			),
			array(
				'name'=>'username',
				'type'=>'raw',
				'value'=>'$data->displayUsername',
				'htmlOptions'=>array('width'=>'60px'),
			),
			array(
				'name'=>'path',
				'type'=>'raw',
				'value'=>'$data->displayPath',
				'htmlOptions'=>array('width'=>'140px'),
			),
			array(
				'name'=>'datetime',
				'htmlOptions'=>array('width'=>'80px'),
			),
		);
	}
	
	/**
	 *
	 * @param mixed $model - Model object for the saved item
	 * @param string $description - Text description of the change
	 */
	public static function insertLog($description, $model=null) {
		
		$log = new NLog;
		
		if ($model) {
			if (is_object($model)) {
				$log->model = get_class($model);
				$log->model_id = $model->id;
			}
		}
		$log->user_id = Yii::app()->user->record->id;
		$log->controller = Yii::app()->controller->uniqueId;
		$log->action = Yii::app()->controller->action->id;
		$log->description = $description;
		$log->datetime = date('Y-m-d H:i:s');
		
		$log->save();
		return $log->id;
		
	}
	
	public function getDisplayUsername() {
		return $this->user->username;
	}
	
	public function getDisplayPath() {
		return $this->controller . '/' . $this->action;
	}
	
	public $path;
	public $username;
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'model' => "varchar(50)",
				'model_id' => "int(10) unsigned",
				'controller' => "varchar(100)",
				'action' => "varchar(100)",
				'user_id' => "int(10) unsigned",
				'description' => "text",
				'datetime' => "timestamp",
				'trashed' => "int(1) unsigned NOT NULL",
			),
			'keys' => array(),
		);
	}

}