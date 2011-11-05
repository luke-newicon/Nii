<?php

class SiteModule extends NWebModule {

	public $name = 'Website CMS';
	public $description = 'Module that generates CMS pages';
	public $version = '0.0.1';

	public function init() {
		Yii::app()->menus->addItem('main','Website', array('/site/admin/index'));
		Yii::app()->menus->addItem('main','Pages', array('/site/admin/pages'), 'Website');
	}
	
	public function settings(){
		return array(
			'website' => '/site/admin/settings',
		);
	}

}