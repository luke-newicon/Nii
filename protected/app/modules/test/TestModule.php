<?php

class TestModule extends NWebModule {

	public function settings() {
		return array(
//			'name' => 'this is a default value',
//			'color' => array('label' => 'What colour?', 'default' => 'blue'),
//			'size' => array('label' => 'What Size?','type' => 'dropdown', 'items' => array('small','medium','large'), 'default' => 'medium'),
//			'complex' => array('label' => 'This is a complex setting', 'route' => array('/admin/testSetting')),
			'username'=>array(
				'label' => 'Username',
                'type' => 'text',
				'visible' => true,
			),
			'password'=>array(
				'label' => 'Username',
				'type'=>'password',
				'visible' => true,
			),
			'email'=>array(
				'label' => 'Username',
				'type'=>'text',
				'visible' => true,
			)
		);
	}

}