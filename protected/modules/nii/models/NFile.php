<?php

/**
 * This is the model class for table "file".
 *
 * These properties are the columns available in table 'file':
 * @property int id
 * @property int uploaded_by
 * @property string description
 * @property string uploaded timestamp date time
 * @property string original_name
 * @property string filed_name
 * @property string size
 * @property string mime
 * @property string file_path
 * @property string category
 * @property boolean deleted
 */
class NFile extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Files the static model class
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
		return 'file';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uploaded_by, size', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('original_name, filed_name', 'length', 'max'=>200),
			array('mime', 'length', 'max'=>45),
			array('file_path', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, description, uploaded_by, uploaded, original_name, filed_name, size, mime, file_path', 'safe'),
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
			'uploadedBy' => array(self::BELONGS_TO, 'UserUser', 'uploaded_by'),
			'filetotables' => array(self::HAS_MANY, 'Filetotable', 'file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => 'Description',
			'uploaded_by' => 'Uploaded By',
			'uploaded' => 'Uploaded',
			'original_name' => 'Original Name',
			'filed_name' => 'Filed Name',
			'size' => 'Size',
			'mime' => 'Mime',
			'file_path' => 'File Path',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('uploaded_by',$this->uploaded_by);
		$criteria->compare('uploaded',$this->uploaded,true);
		$criteria->compare('original_name',$this->original_name,true);
		$criteria->compare('filed_name',$this->filed_name,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('file_path',$this->file_path,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'uploaded_by'=>'int',
				'description'=>'text',
				'uploaded'=>'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP',
				'original_name'=>'string',
				'filed_name'=>'string',
				'size'=>'string',
				'mime'=>'string',
				'file_path'=>'string',
				'category'=>'string',
				'deleted'=>'boolean'
			),
			'keys'=>array(
				array('uploaded_by')
			)
		);
	}
	
	
	/**
	 * Adds information on a new file to the database.
	 * NOTE: This function does not handle the storage of the file.
	 *
	 * EXAMPLES:
	 * addNewFile('test description','origionalName.txt','filledName.txt',2,'c://mytext.txt','area');
	 *
	 * @param string $description The description of the file.
	 * @param string $original_name The name the file was stored as before being uploaded.
	 * @param string $filed_name The name the file was recorded as when stored.
	 * @param string $size The size of the file (mb)
	 * @param string $mime Mime type of the file.
	 * @param string $file_path The pat to the file on the file system.
	 * @param string $category
	 * @return int/boolean the id of the file on sucess or false on faliure.
	 */
	public function addNewFile($description,$original_name,$filled_name,$size,$mime,$category){
		$this->description = $description;
		$this->original_name = $original_name;
		$this->filed_name = $filled_name;
		$this->mime = $mime;
		$this->file_path = 'xxx';
		$this->category = $category;
		$this->uploaded_by = Yii::app()->user->getId();
		$this->save();
		return $this->id;
	}
	
	/**
	 * convienience method to get the files path
	 * @return string system path to the file
	 */
	public function getPath(){
		return NFileManager::get()->getFilePath($this);
	}
	
}