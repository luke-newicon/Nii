<?php

class TestContactForm extends TestContact {

	public function relations() {
		return array(
			'extra' => array(self::BELONGS_TO, 'TestExtra', 'id'),
		);
	}
	
	public function fields(){
		return array(
			'title'=>'Please provide your login credential',
 
			'elements'=>array(
				'name'=>array(
					'type'=>'text',
				),
			),
			
			'buttons'=>array(
				'save'=>array(
					'type'=>'htmlSubmit',
					'label'=>'Save',
					'class'=>'btn btn-primary',
				),
				'cancel'=>array(
					'type'=>'htmlButton',
					'label'=>'Cancel',
					'class'=>'btn',
				),
			),
		);
	}

}