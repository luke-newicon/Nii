<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends NController {

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/site';

	public function init() {
		$this->menu = array(
			array('label' => 'Websites', 'url' => array('/site/websites')),
			array('label' => 'Hosting', 'url' => array('/hosting/domain/lookup')),
			array('label' => 'Systems', 'url' => array('/site/systems')),
			array('label' => 'Blog', 'url' => array('/site/blog')),
			array('label' => 'Resources', 'url' => array('/site/resources')),
			array('label' => 'Support', 'url' => array('/site/support')),
		);
	}

}