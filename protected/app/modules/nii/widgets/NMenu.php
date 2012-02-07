<?php

Yii::import('zii.widgets.CMenu');

class NMenu extends CMenu {
	
	public $enableNotifications = true;
	
	public $noticeHtmlOptions = array('class'=>'label warning');
	
	public $firstItemCssClass = 'dropdown-toggle';
	
	/**
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 * @return string
	 * @since 1.1.6
	 */
	protected function renderMenuItem($item)
	{
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : '<'.$this->linkLabelWrapper.'>'.$item['label'].'</'.$this->linkLabelWrapper.'>';
			
			if($this->enableNotifications && isset($item['notice'])){
				$noticeHtmlOptions = isset($item['noticeHtmlOptions']) ? $item['noticeHtmlOptions'] : $this->noticeHtmlOptions;
				$label = $label . ' <span class="menu-notice">' . CHtml::tag('span',$noticeHtmlOptions,$item['notice']) . '</span>';
			}
			return CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}
}