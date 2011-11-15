<?php

/**
 * Description of HftModule
 *
 * @author robinwilliams
 */
class HftModule extends NWebModule 
{
	public $name = 'Hope for Tomorrow';
	public $description = 'Module to manage contacts and donations';
	public $version = '0.0.1';
	
	public function init() {
		Yii::import('hft.models.*');
	}
	
	public function setup() {
		Yii::app()->menus->addItem('main', 'Donations', array('/hft/donations/index'));

		Yii::app()->getModule('contact')->contactModel = 'HftContact';
		
		Yii::app()->getModule('contact')->onRenderContactAfterHeader = array($this, 'handleOnRenderAfterHeader');
		Yii::app()->getModule('contact')->onRenderContactAfterComment = array($this, 'handleOnRenderAfterComment');
		
		Yii::app()->getModule('contact')->onRenderContactBeforeTypeDetailsEdit = array($this, 'handleOnRenderBeforeTypeDetailsEdit');
		Yii::app()->getModule('contact')->onRenderContactAfterCommentEdit = array($this, 'handleOnRenderAfterCommentEdit');
		/**
		 *	Change configuration of contacts module
		 * Add fields/columns to contacts module dynamically 
		 */
	}
	
	
	public function handleOnRenderAfterHeader($event){
		$event->sender->renderPartial('hft.views.contact.view.top', $event->params);
	}
	
	public function handleOnRenderAfterComment($event){
		$event->sender->renderPartial('hft.views.contact.view.after_comment', $event->params);
	}
	
	public function handleOnRenderBeforeTypeDetailsEdit($event){
		$event->sender->renderPartial('hft.views.contact.edit.before_type_details', $event->params);
	}
	
	public function handleOnRenderAfterCommentEdit($event){
		$event->sender->renderPartial('hft.views.contact.edit.after_comment', $event->params);
	}	
	
//	public function settings() {
//		return array(
//			'hft' => '/hft/settings/index',
//		);
//	}
	
	public function install() {
		HftContact::install('HftContact');
		HftContactSource::install('HftContactSource');
		$this->installPermissions();
	}
	
}