<?php

/**
 * NBreadCrumbs class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

Yii::import('zii.widgets.CBreadcrumbs');
/**
 * extends of CBreadCrumbs
 * 
 * @see CBreadCrumbs
 * @author steve
 */
class NBreadcrumbs extends CBreadcrumbs {

	public $tagName = 'ul';
	
	public $htmlOptions = array('class'=>'breadcrumbApple breadcrumbAppleWhite noBull');
	
	public $separator = '';
	/**
	 * need slightly different html so override this method
	 * @return void
	 */
	public function run() {
		if(empty($this->links))
			return;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]='<li>'.CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl).'</li>';
		else if($this->homeLink!==false)
			$links[]='<li>'.$this->homeLink.'</li>';
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]='<li>'.CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url).'</li>';
			else
				$links[]='<li class="current">'.($this->encodeLabel ? CHtml::encode($url) : $url).'</li>';
		}
		echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	}

}