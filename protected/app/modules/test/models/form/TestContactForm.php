<?php

class TestContactForm extends TestContact {

	public function relations() {
		return array(
			'extra' => array(self::BELONGS_TO, 'TestExtra', 'id'),
		);
	}
	
	public function fields(){
		return array(
			'title'=>'Test Auto Form',
 
			'elements'=>array(
				
				'contact'=>array(
					'title'=>'Contact form',
					'active'=>true,
					'type'=>'form',
					'elements'=>array(
						'name'=>array(),
					),
				),
				
				'extra'=>array(
					'title'=>'Extra form',
					'type'=>'form',
					'elements'=>array(
						'comments'=>array(),
						'number'=>array(
							'type'=>'dropdownlist',
							'items'=>TestExtra::numberData(),
							'prompt'=>'Please select',
						),
					),
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