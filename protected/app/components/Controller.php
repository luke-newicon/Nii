<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends NController 
{

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/site';

	public function init() {
		
		$this->menu = array(
			array('label' => 'Newicon', 'url' => array('/site/index'), 'template'=>'<a style="padding:3px 8px;margin-left:0px;" href="'.NHtml::url('/site/index').'"><img style="padding-top:3px;" alt="Newicon" src="'.Yii::app()->request->baseUrl.'/images/newicon.png" /></a>'),
			array('label' => 'Services', 'url' => array('/site/websites')),
			array('label' => 'Hosting', 'url' => array('/hosting/domain/lookup')),
			array('label' => 'Blog', 'url' => array('/site/blog')),
			array('label' => 'Resources', 'url' => array('/site/resources')),
			array('label' => 'Support', 'url' => array('/site/support')),
		);
	}

}