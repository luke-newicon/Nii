<?php

/**
 * This is the model class for table "support_Attachment".
 *
 * The followings are the available columns in table 'support_Attachment':
 * @property string $attachment_id
 * @property string $attachment_name
 * @property string $attachment_type
 * @property string $attachment_mail_id
 * @property string $attachment_file_id
 */
class SupportAttachment extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SupportAttachment the static model class
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
		return '{{support_attachment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attachment_name, attachment_type, attachment_mail_id, attachment_file_id', 'required'),
			array('attachment_name, attachment_type', 'length', 'max'=>255),
			array('attachment_mail_id, attachment_file_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('attachment_id, attachment_name, attachment_type, attachment_mail_id, attachment_file_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'attachment_id' => 'Attachment',
			'attachment_name' => 'Attachment Name',
			'attachment_type' => 'Attachment Type',
			'attachment_mail_id' => 'Attachment Mail',
			'attachment_file_id' => 'Attachment File',
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

		$criteria->compare('attachment_id',$this->attachment_id,true);
		$criteria->compare('attachment_name',$this->attachment_name,true);
		$criteria->compare('attachment_type',$this->attachment_type,true);
		$criteria->compare('attachment_mail_id',$this->attachment_mail_id,true);
		$criteria->compare('attachment_file_id',$this->attachment_file_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}