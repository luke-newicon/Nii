<?php

/**
 * This is the model class for table "attachment".
 *
 * The followings are the available columns in table 'attachment':
 * @property integer $id
 * @property string $file_id
 * @property string $model
 * @property string $model_id
 * @property string $inserted
 * @property string $updated
 */
class NAttachment extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Attachment the static model class
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
		return '{{nii_attachment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('file_id, model_id', 'length', 'max'=>11),
		array('model', 'length', 'max'=>255),
		array('added, type, description', 'safe'),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, file_id, model, model_id, added, type, description', 'safe', 'on'=>'search'),
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
			'file' => array(self::BELONGS_TO, 'NFile', 'file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'file_id' => 'File',
            'model' => 'Model',
            'model_id' => 'Model',
			'type' => 'Type',
            'added' => 'Added',
            'description' => 'Description',
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
		$criteria->compare('file_id',$this->file_id,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('model_id',$this->model_id,true);
		$criteria->compare('added',$this->added,true);
		$criteria->compare('type',$this->type,true);

		return new NActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
		));
	}

	public function deleteFile(){
		if($this->file)
		Yii::app()->fileManager->deleteFiles($this->file->id,true);
	}
	
	public function getDownloadLink() {
		$iconClass = NHtml::getMimeTypeIcon($this->file->mime);
		$label = '<span class="'.$iconClass.'"></span>'.$this->file->original_name;
		return CHtml::link($label, array(
				'/nii/index/file', 'id'=>$this->file->id,'name'=>$this->file->original_name,'makeDownload'=>true
			),
			array('style'=>'display:block; position:relative')
		);
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'model' => "varchar(255)",
				'model_id' => "int(11) NOT NULL",
				'file_id' => "int(11) NOT NULL",
				'type' => "varchar(255)",
				'description' => "text",
				'added' => "timestamp",
				'trashed' => "int(11) unsigned NOT NULL",
			),
			'keys' => array(
				array('file','file_id'),
				array('model','model_id'),
			)
		);
	}
		
	public static function countAttachments($model, $model_id) {
		$attributes = array('model'=>$model,'model_id'=>$model_id);
		return self::model()->countByAttributes($attributes);
	}

}