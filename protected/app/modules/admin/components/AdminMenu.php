<?php

class AdminMenu extends CApplicationComponent {
	
	private $_items;
	
	public function addItem($label,$url,$parent=null,$options=array()){
		if($parent){
			$this->_items[$parent]['items'][$label] = array('label' => $label, 'url' => $url);
		} else {
			$this->_items[$label] = array('label' => $label, 'url' => $url);
		}
		return $this;
	}
	
	public function getItems(){
		foreach($this->_items as $label => $item){
			if($label != 'Admin')
				$items[$label] = $item;
		}
		$items['Admin'] = $this->_items['Admin'];
		return $items;
	}
	
}