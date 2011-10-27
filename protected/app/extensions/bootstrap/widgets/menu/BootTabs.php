<?php
/**
 * BootTabs class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @since 0.9.3
 */

Yii::import('zii.widgets.CMenu');
class BootTabs extends CMenu
{
	/**
	 * @property array the HTML options used for {@link tagName}
	 */
	public $htmlOptions=array('class'=>'tabs');
	
	public $heading;
	
	/**
	 * Renders the menu items.
	 * @param array $items menu items. Each menu item will be an array with at least two elements: 'label' and 'active'.
	 * It may have three other optional elements: 'items', 'linkOptions' and 'itemOptions'.
	 */
	protected function renderMenu($items)
	{
		if(count($items))
		{
			echo CHtml::openTag('ul',$this->htmlOptions)."\n";
			if($this->heading)
				echo CHtml::tag('li',array(),CHtml::tag('h2',array('style'=>'margin-right:20px'),$this->heading));
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('ul');
		}
	}
	
}
