<?php

/**
 * NTimestampable class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Adds and updates a created_at and updated_at column with a mysql datetime
 *
 * @author steve
 */
class NTimestampable extends NActiveRecordBehavior
{
	
	/**
     * @param string $columnCreatedBy Name of the column store the user id who created the record
     */
    public $columnCreatedBy = 'created_by';

    /**
     * @param string $columnUpdatedBy Name of the column store id of the user who updated the record
     */
    public $columnUpdatedBy = 'updated_by';
	
	/**
     * @param string $columnCreatedAt Name of the column to store the created at time
     */
    public $columnCreatedAt = 'created_at';
	
	/**
     * @param string $columnUpdatedAt Name of the column to store the update time
     */
    public $columnUpdatedAt = 'updated_at';
	
	
	/**
	 * define additonal columns to add to the table
	 * @return array 
	 */
	public function schema()
	{
		return array(
			'columns'=>array(
				"{$this->columnCreatedBy}" => 'int',
				"{$this->columnUpdatedBy}" => 'int',
				"{$this->columnCreatedAt}" => 'datetime',
				"{$this->columnUpdatedAt}" => 'datetime',
			)
		);
	}

	/**
	 * 
	 * @param CEvent $event
	 */
	public function beforeSave($event)
	{
		if(isset(Yii::app()->user)) {
			if($this->owner->isNewRecord && empty($this->owner->{$this->columnCreatedBy}))
				$this->owner->{$this->columnCreatedBy} = Yii::app()->user->id;
            if(empty($this->owner->{$this->columnUpdatedBy}))
				$this->owner->{$this->columnUpdatedBy} = Yii::app()->user->id;
		}
		if($this->owner->isNewRecord && empty($this->owner->{$this->columnCreatedAt}))
			$this->owner->{$this->columnCreatedAt} = date('Y-m-d H:i:s');
		if(empty($this->owner->{$this->columnUpdatedAt}))
			$this->owner->{$this->columnUpdatedAt} = date('Y-m-d H:i:s');
	}
}