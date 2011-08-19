<?php

/**
 * This is the model class for table "note".
 *
 * The followings are the available columns in table 'note':
 * @property string $id
 * @property string $user_id
 * @property string $added
 * @property string $area
 * @property integer $item_id
 * @property string $note
 */
class NNote extends NAppRecord
{
	
	public $username;
    /**
     * Returns the static model of the specified AR class.
     * @return Note the static model class
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
        return '{{nii_note}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'length', 'max'=>10),
            array('added, note, model, model_id, model_cat', 'safe'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'added' => 'Added',
            'area' => 'Area',
            'item_id' => 'Item',
            'note' => 'Note',
        );
    }


	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'model'=>'string',
				'model_id'=>'string',
				'model_cat'=>'string',
				'user_id'=>'int',
				'added'=>'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
				'note'=>'text',
			),
			'keys'=>array(
				array('user_id'),
				array('model_id')
			)
		);
	}
}