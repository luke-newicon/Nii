<?php
/**
 * NiiWebModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NiiWebModule
 *
 * @author steve
 */
class NiiWebModule extends CWebModule
{
    public $defaultController = 'index';
	
	public static $items = array();

	/**
	 *
	 * @param $label string, required, specifies the menu item label. When {@link encodeLabel} is true, the label
	 * will be HTML-encoded.
	 * @param $url string url route
	 * @param $options array of additional options (key=>value pairs) items: array, optional, specifies the sub-menu items. Its format is the same as the parent items.</li>
	 * active: boolean, optional, whether this menu item is in active state (currently selected).
	 * If a menu item is active and {@link activeClass} is not empty, its CSS class will be appended with {@link activeClass}.
	 * If this option is not set, the menu item will be set active automatically when the current request
	 * is triggered by {@link url}. Note that the GET parameters not specified in the 'url' option will be ignored.
	 * template: string, optional, the template used to render this menu item.
	 * In this template, the token "{menu}" will be replaced with the corresponding menu link or text.
	 * Please see {@link itemTemplate} for more details. This option has been available since version 1.1.1.
	 * linkOptions: array, optional, additional HTML attributes to be rendered for the link or span tag of the menu item.
	 * itemOptions: array, optional, additional HTML attributes to be rendered for the container tag of the menu item.
	 * @return void
	 */
	public static function addMenuItem($label, $url, $options=array()){
		$arr = array_merge(array('label'=>$label,'url'=>$url), $options);
		self::$items = array_merge(self::$items, array($arr));
	}


}