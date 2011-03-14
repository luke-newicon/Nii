<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'files':
 * @property string $id
 * @property string $fileId
 * @property string $description
 * @property integer $uploaded_by
 * @property string $uploaded
 * @property string $original_name
 * @property string $filed_name
 * @property integer $size
 * @property string $mime
 * @property string $file_path
 *
 * The followings are the available model relations:
 * @property UserUser $uploadedBy0
 * @property Filetotable[] $filetotables
 */
class NFiles extends NActiveRecord
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
			array('fileId', 'length', 'max'=>10),
			array('original_name, filed_name', 'length', 'max'=>200),
			array('mime', 'length', 'max'=>45),
			array('file_path', 'length', 'max'=>250),
			array('description, uploaded', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fileId, description, uploaded_by, uploaded, original_name, filed_name, size, mime, file_path', 'safe', 'on'=>'search'),
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
			'uploadedBy0' => array(self::BELONGS_TO, 'UserUser', 'uploaded_by'),
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
			'fileId' => 'File',
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
		$criteria->compare('fileId',$this->fileId,true);
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

	/**
	 * Adds information on a new file to the database.
	 * NOTE: This function does not handle the storage of the file.
	 *
	 * EXAMPLES:
	 * addNewFile(1,'test description','origionalName.txt','filledName.txt',2,'c://mytext.txt');
	 *
	 * @param int $fileId The Id of the file to be added.
	 * @param string $description The description of the file.
	 * @param string $original_name The name the file was stored as before being uploaded.
	 * @param string $filed_name The name the file was recorded as when stored.
	 * @param integer $size The size of the file (mb)
	 * @param string $mime Mime type of the file.
	 * @param string $file_path The pat to the file on the file system.
	 * @return int/boolean the id of the file on sucess or false on faliure.
	 */
	public function addNewFile($fileId,$description,$original_name,$filled_name,$size,$mime,$file_path){
		$this->fileId= $fileId;
		$this->description = $description;
		$this->original_name = $original_name;
		$this->filled_name = $filled_name;
		$this->size = $size;
		$this->file_pathe = $file_path;
		$this->save();
	}

}