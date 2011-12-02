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
        return '{{nii_attachment}}';
    }
		
	public static function countAttachments($model, $model_id) {
		$attributes = array('model'=>$model,'model_id'=>$model_id);
		return self::model()->countByAttributes($attributes);
	}
	
	public function getTotalAttachments() {
		return $this->countByAttributes(array('model'=>$this->model,'model_id'=>$this->model_id));
	}
	
}