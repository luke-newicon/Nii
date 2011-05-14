<?php

/**
 * This is the model class for table "notes".
 *
 * The followings are the available columns in table 'notes':
 * @property string $id
 * @property string $user_id
 * @property string $added
 * @property string $area
 * @property integer $item_id
 * @property string $note
 */
class NNote extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Notes the static model class
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
        return '{{notes}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_id', 'numerical', 'integerOnly'=>true),
            array('user_id', 'length', 'max'=>10),
            array('area', 'length', 'max'=>50),
            array('added, note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, added, area, item_id, note', 'safe', 'on'=>'search'),
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
            'id' => 'ID',
            'user_id' => 'User',
            'added' => 'Added',
            'area' => 'Area',
            'item_id' => 'Item',
            'note' => 'Note',
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
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('added',$this->added,true);
        $criteria->compare('area',$this->area,true);
        $criteria->compare('item_id',$this->item_id);
        $criteria->compare('note',$this->note,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
}