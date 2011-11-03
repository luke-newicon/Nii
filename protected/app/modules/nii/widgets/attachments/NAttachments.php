<?php

/**
 * Description of NAttachments
 *
 * @author robinwilliams
 */
class NAttachments extends NAttributeWidget {
	
	
	/**
	 * Whether the user can add attachments
	 * @var boolean 
	 */
	public $canAdd = false;
	
	/**
	 * Whether the user can edit attachments
	 * @var boolean 
	 */
	public $canEdit = false;
	
	public $canEditMine = false;
	
	/*
	 * Whether the user can delete attachments
	 * @var boolean
	 */
	public $canDelete = false;
	
	/**
	 * The location to ajax to
	 * @var string 
	 */
	public $ajaxLocation = '';
	
	public $attachmentType = 'attachment';
	
	public $displayTitle = true;
	
	public $titleWrapperTag = 'h3';
	
	public $titleClass = '';
	
	public $title = 'Attachments';
	
	public $addAttachmentButtonClass = 'fam-add';
	
	public $emptyText = 'There are currently no available attachments';
	
	public function run(){
			 
		// If no ajax location set then use default
		if(!$this->ajaxLocation)
			$this->ajaxLocation = Yii::app()->createAbsoluteUrl('/nii/index/attachments');
		
		// Includes the style sheet
		$assetsDir = $this->getAssetsDir();
		Yii::app()->clientScript->registerCssFile($assetsDir.'/attachments.css');
		
		//The id of the item the notes should relate to
		$model = $this->model;
		$model_name = $this->getModelClass();
		$id = $this->model->getPrimaryKey();
		
		$dataProvider=new CActiveDataProvider("NAttachment",array(
		'criteria'=>array(
			'order'=>'id DESC',
			'condition'=>'model_id = :modelid AND type = :type',
			'params'=>array(':modelid'=>$id, ':type'=>$this->attachmentType)
		)));
		
		$this->render('widget',array(
			'canAdd'=>$this->canAdd,
			'dataProvider'=>$dataProvider,
			'canEdit'=>$this->canEdit,
			'canDelete'=>$this->canDelete,
			'model'=>$model,
			'model_name'=>$model_name,
			'id'=>$id,
			'displayTitle'=>$this->displayTitle,
			'titleWrapperTag'=>$this->titleWrapperTag,
			'title'=>$this->title,
			'titleClass'=>$this->titleClass,
			'addButton'=>$this->getAddButton($id),
			'ajaxLocation'=>$this->ajaxLocation,
			'type'=>$this->attachmentType,
			'emptyText'=>$this->emptyText,
		));
	
	}
	
	public function getAssetsDir()
	{
		$assetLocation = Yii::getPathOfAlias('nii.widgets.attachments.assets');
		return Yii::app()->getAssetManager()->publish($assetLocation);
	}
	
	public function getAddButton($id=null) {
		if ($this->canAdd) {
			$id = ($id)?'-'.$id:'';

			$attributes = array(
				'title'=>'Add an Attachment',
				'id' => 'attachments-add'.$id,
				'class' => 'icon fam-add',
				'style' => 'position: relative; height: 16px; line-height: 16px; display: inline-block; margin-left: 8px; top: 3px;'
			);
			return CHtml::link('', '#', $attributes);
		}
	}
}