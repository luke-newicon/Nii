<?php

/**
 * Description of NAttachment
 *
 * @author robinwilliams
 */
class NAttachment extends NAppRecord {
	
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
        return '{{attachment}}';
    }
		
	public static function countAttachments($model, $model_id) {
		$attributes = array('model'=>$model,'model_id'=>$model_id);
		return NAttachment::model()->countByAttributes($attributes);
	}
	
}