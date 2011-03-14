<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * FBComplete Class
 * 
 * json_url         - url to fetch json object
 * cache            - use cache
 * height           - maximum number of element shown before scroll will apear
 * newel            - show typed text like a element
 * firstselected    - automaticly select first element from dropdown
 * filter_case      - case sensitive filter
 * filter_selected  - filter selected items from list
 * complete_text    - text for complete page
 * maxshownitems    - maximum numbers that will be shown at dropdown list (less better performance)
 * onselect         - fire event on item select
 * onremove         - fire event on item remove
 * maxitimes        - maximum items that can be added
 * delay            - delay between ajax request (bigger delay, lower server time request)
 * addontab         - add first visible element on tab or enter hit
 * attachto         - after this element fcbkcomplete insert own elements
 *
 * @property mixed value can be a string of the one item selected or an array of selected values.
 * 
 */
class FBComplete extends CInputWidget {

	public $baseUrl;
	/**
	 * the option items for the list box
	 */
	public $dataOptions;
	
	/**
	 * fcbk options
	 * cache            - use cache
	 * height           - maximum number of element shown before scroll will apear
	 * newel            - show typed text like a element
	 * firstselected    - automaticly select first element from dropdown
	 * filter_case      - case sensitive filter
	 * filter_selected  - filter selected items from list
	 * complete_text    - text for complete page
	 * maxshownitems    - maximum numbers that will be shown at dropdown list (less better performance)
	 * onselect         - fire event on item select
	 * onremove         - fire event on item remove
	 * maxitimes        - maximum items that can be added
	 * delay            - delay between ajax request (bigger delay, lower server time request)
	 * addontab         - add first visible element on tab or enter hit
	 * attachto         - after this element fcbkcomplete insert own elements
	 */
	public $options;

	public function init() {
		$this->publishAssets();
	}

	public function run() {
		list($name, $id) = $this->resolveNameID();
		echo '<div>';
		echo CHtml::listBox($name, $this->value, $this->dataOptions, array('style'=>'display:none;'));

		$options = CJavaScript::encode($this->options);
		echo '</div>';
		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, "jQuery('#{$id}').fcbkcomplete($options);");
	}

	public function publishAssets() {
		$assets = dirname(__FILE__) . '/assets';
		if ($this->baseUrl === null)
			$this->baseUrl = Yii::app()->getAssetManager()->publish($assets);
		Yii::app()->getClientScript()->registerCssFile($this->baseUrl . '/style.css');
		Yii::app()->getClientScript()->registerScriptFile($this->baseUrl . '/jquery.fcbkcomplete.js');
	}

}
