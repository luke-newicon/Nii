<?php

class SiteModule extends NWebModule {

	public $name = 'Website CMS';
	public $description = 'Module that generates CMS pages';
	public $version = '0.0.1';

	public function init() {
		Yii::app()->getModule('admin')->menu->addItem('Website', array('/site/admin/index'));
		Yii::app()->getModule('admin')->menu->addItem('Pages', array('/site/admin/pages'), 'Website');
	}
	
	public function settings(){
		return array(
			'Website' => array('/site/admin/settings'),
		);
	}

}