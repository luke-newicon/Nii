<?php

class AdminDashboard extends CApplicationComponent {

	private $_portlets = array();

	public function addPortlet($name, $widget, $position='main') {
		$this->_portlets[$name] = array(
			'name' => $name,
			'widget' => $widget,
			'position' => $position,
		);
	}
	
	public function getPortlets(){
		return $this->_portlets;
	}

}