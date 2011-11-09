<?php
/**
 * 
 */
class NMenuManager extends CApplicationComponent {
	
	private $_menus = array();
	
	/**
	 * Adds an item to a menu already defined in addMenu()
	 * @param string $menu The menu name the item should be added to
	 * @param string $label The text label the menu item will show 
	 * @param mixed $url The url the menu item will have when clicked, can be an arrray
	 * @param string $parent If the menu item is a submenu item this is the name of the parent to attach it to
	 * @param array $options Additional options to be added to the menu item
	 * @return NMenuManager 
	 */
	public function addItem($menu,$label,$url=null,$parent=null,$options=array()){
		if($parent){
			$this->_menus[$menu][$parent]['itemOptions']['class'] = 'menu';
			$this->_menus[$menu][$parent]['linkOptions']['class'] = 'menu';
			$this->_menus[$menu][$parent]['items'][$label] = $options;
			$this->_menus[$menu][$parent]['items'][$label]['label'] = $label;
			if(isset($options['notice'])){
				$this->_menus[$menu][$parent]['items'][$label]['notice'] = $options['notice'];
				if(isset($this->_menus[$menu][$parent]['notice'])){
					$this->_menus[$menu][$parent]['notice'] += ((int)$options['notice'] ? $options['notice'] : 1);
				} else {
					$this->_menus[$menu][$parent]['notice'] = ((int)$options['notice'] ? $options['notice'] : 1);
				}
			}
			if($url)
				$this->_menus[$menu][$parent]['items'][$label]['url'] = $url;
		} else {
			$this->_menus[$menu][$label] = $options;
			$this->_menus[$menu][$label]['label'] = $label;
			if($url)
				$this->_menus[$menu][$label]['url'] = $url;
		}
		return $this;
	}
	/**
	 * Adds a divider to the menu
	 * @param string $menu The menu name the divider should be added to
	 * @param string $parent The parent item the divider should be added to
	 * @return NMenuManager 
	 */
	public function addDivider($menu,$parent){
		$this->_menus[$menu][$parent]['items'][]['itemOptions']['class'] = 'divider';
		return $this;
	}
	/**
	 * Adds a menu
	 * @param string $menu The identifier name for the menu
	 * @return NMenuManager 
	 */
	public function addMenu($menu){
		if(!array_key_exists($menu, $this->_menus))
			$this->_menus[$menu] = array();
		return $this;
	}
	/**
	 * Get all menu items for a particular menu
	 * @param string $menu The menu name as supplied in addMenu()
	 * @return void
	 */
	public function getItems($menu){
		return $this->_menus[$menu];
	}
	/**
	 * Updates the user menu label to have the logged in user's username displayed
	 * @param string $username The string to replace the label for the user menu
	 */
	public function setUsername($username){
		$this->_menus['user']['User']['label'] = $username;
	}
	
}