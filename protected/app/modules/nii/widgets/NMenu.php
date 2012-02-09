<?php

Yii::import('zii.widgets.CMenu');

class NMenu extends CMenu {
	
	public $enableNotifications = true;
	
	public $noticeHtmlOptions = array('class'=>'label warning');
	
	/**
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 * @return string
	 * @since 1.1.6
	 */
	protected function renderMenuItem($item)
	{
		$dropdown = '';
		if(isset($item['items']) && count($item['items']))
		{
			$item['linkOptions']['data-toggle'] = 'dropdown';
			$item['linkOptions']['class'] = 'dropdown-toggle';
			$dropdown = ' <b class="caret"></b>';
		}
		
		$icon = isset($item['linkOptions']['icon']) ? '<i class="'.$item['linkOptions']['icon'].'"></i> ' : '';
		
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : '<'.$this->linkLabelWrapper.'>'.$item['label'].'</'.$this->linkLabelWrapper.'>';
			
			if($this->enableNotifications && isset($item['notice'])){
				$noticeHtmlOptions = isset($item['noticeHtmlOptions']) ? $item['noticeHtmlOptions'] : $this->noticeHtmlOptions;
				$label = $label . ' <span class="menu-notice">' . CHtml::tag('span',$noticeHtmlOptions,$item['notice']) . '</span>';
			}
			return CHtml::link($icon.$label.$dropdown,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $icon.$item['label'].$dropdown);
	}
	
	/**
	 * Recursively renders the menu items.
	 * @param array $items the menu items to be rendered recursively
	 */
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			
			if(isset($item['items']) && count($item['items']))
			{
				$class[] = 'dropdown';
			}
			
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}

			echo CHtml::openTag('li', $options);

			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if(isset($item['items']) && count($item['items']))
			{
				echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo CHtml::closeTag('ul')."\n";
			}

			echo CHtml::closeTag('li')."\n";
		}
	}
}