<?php

class AdminMenu extends CApplicationComponent {
	
	private $_menus = array();
	
	public function addItem($menu,$label,$url,$parent=null,$options=array()){
		if($parent){
			$this->_menus[$menu][$parent]['linkOptions']['class'] = 'menu';
			$this->_menus[$menu][$parent]['items'][$label] = array('label' => $label, 'url' => $url);
		} else {
			$this->_menus[$menu][$label] = array('label' => $label, 'url' => $url);
		}
		return $this;
	}
	
	public function addMenu($menu){
		if(!array_key_exists($menu, $this->_menus))
			$this->_menus[$menu] = array();
		return $this;
	}
	
	public function getItems($menu){
		return $this->_menus[$menu];
	}
	
}