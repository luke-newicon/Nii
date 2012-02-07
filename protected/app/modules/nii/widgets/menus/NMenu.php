<?php

Yii::import('zii.widgets.CMenu');

class NMenu extends CMenu {

	private $assetUrl;
	public $cssFile;
	public $activateParents = true;

	public $linkLabelWrapper = 'span';
	public $firstItemCssClass = 'first';
	public $lastItemCssClass = 'last';
	/**
	 * click anebales the menu to only open on click
	 * default is false which means sub menus will show on hover
	 * @var type 
	 */
	public $click = false;

	/**
	 * Initialize the widget
	 */
	public function init() 
	{
		parent::init();
		$this->assetUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
		Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile($this->assetUrl.'/jquery.menu.js');
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = '';
		$this->htmlOptions['class'] .= 'nmenu_dropdown';
		if($this->click){
			Yii::app()->clientScript->registerScript('nmenuclick','menuClick(jQuery("#'.$this->getId().'.nmenu_dropdown"));');
		}else{
			Yii::app()->clientScript->registerScript('nmenuhover','menuHover(jQuery("#'.$this->getId().'.nmenu_dropdown"));');
		}
		if($this->cssFile)
			Yii::app()->clientScript->registerCssFile($this->cssFile, 'screen');
		else
			Yii::app()->clientScript->registerCssFile($this->assetUrl.'/menu.css', 'screen');
	}

	/**
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 * @since 1.1.6
	 */
	protected function renderMenuItem($item)
	{
		$label=$this->linkLabelWrapper===null ? $item['label'] : '<'.$this->linkLabelWrapper.'>'.$item['label'].'</'.$this->linkLabelWrapper.'>';
		if(isset($item['url']))
			return CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		else
			return CHtml::link($label,"javascript:void(0);",isset($item['linkOptions']) ? $item['linkOptions'] : array());
	}

}