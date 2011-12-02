<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NTabs
 *
 * @author robinwilliams
 */
Yii::import('zii.widgets.jui.CJuiTabs');

class NTabs extends CJuiTabs {

	/**
	 * @var array list of tabs (tab title=>tab content).
	 * Note that the tab title will not be HTML-encoded.
	 * The tab content can be either a string or an array. When it is an array, it can
	 * be in one of the following two formats:
	 * <pre>
	 * array('id'=>'myTabID', 'content'=>'tab content')
	 * array('id'=>'myTabID', 'ajax'=>URL)
	 * </pre>
	 * where the 'id' element is optional. The second format allows the tab content
	 * to be dynamically fetched from the specified URL via AJAX. The URL can be either
	 * a string or an array. If an array, it will be normalized into a URL using {@link CHtml::normalizeUrl}.
	 */
	public $tabs=array();
	/**
	 * @var string the name of the container element that contains all panels. Defaults to 'div'.
	 */
	public $tagName='div';
	/**
	 * @var string the template that is used to generated every panel title.
	 * The token "{title}" in the template will be replaced with the panel title and
	 * the token "{url}" will be replaced with "#TabID" or with the url of the ajax request.
	 */
	public $headerTemplate='<li data-id="{id}"><a href="{url}" title="{title}">{title}{count}</a></li>';
	/**
	 * @var string the template that is used to generated every tab content.
	 * The token "{content}" in the template will be replaced with the panel content
	 * and the token "{id}" with the tab ID.
	 */
	public $contentTemplate='<div id="{id}">{content}</div>';
		
	public $title;
	public $titleTemplate='<li class="heading"><h2>{title}</h2></li>';
	
	public $countOkClass = 'notice';
	
	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		$id=$this->getId();
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

		$tabsOut = "";
		$contentOut = "";
		$tabCount = 0;
		
		if ($this->title)
			$tabsOut .= strtr($this->titleTemplate, array('{title}'=>$this->title))."\n";

		foreach($this->tabs as $title=>$content)
		{
			$tabId = (is_array($content) && isset($content['id']))?$content['id']:$id.'_tab_'.$tabCount++;
			
			// Add the count span, if defined
			if (isset($content['count']) && isset($content['id']))
				$count = '<span class="'.$content['id'].'_count pull-right label tab_count_label'.(isset($content['count_class'])?' '.$content['count_class']:($content['count']>0?' '.$this->countOkClass:'')).'">'.$content['count'].'</span>';
			else $count = '';

			if (!is_array($content))
			{
				$tabsOut .= strtr($this->headerTemplate, array('{title}'=>$title, '{url}'=>'#'.$tabId, '{id}'=>'#' . $tabId))."\n";
				$contentOut .= strtr($this->contentTemplate, array('{content}'=>$content,'{id}'=>$tabId))."\n";
			}
			elseif (isset($content['ajax']))
			{
				$tabsOut .= strtr($this->headerTemplate, array('{title}'=>$title, '{url}'=>CHtml::normalizeUrl($content['ajax']), '{id}'=>$tabId, '{count}'=>$count))."\n";
			}
			else
			{
				$tabsOut .= strtr($this->headerTemplate, array('{title}'=>$title, '{url}'=>'#'.$tabId, '{id}'=>$tabId, '{count}'=>$count))."\n";
				if(isset($content['content']))
					$contentOut .= strtr($this->contentTemplate, array('{content}'=>$content['content'],'{id}'=>$tabId))."\n";
			}
		}
		echo "<ul>\n" . $tabsOut . "</ul>\n";
		echo $contentOut;

		echo CHtml::closeTag($this->tagName)."\n";

		$options=empty($this->options) ? '' : CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').tabs($options);");
	}
}