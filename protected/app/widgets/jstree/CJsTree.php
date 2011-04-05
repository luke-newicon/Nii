<?php
/**
 * CJsTree displays a tree view of hierarchical data.
 *
 * It encapsulates the excellent jsTree component based on CTreeView widget.
 * ({@link http://www.jstree.com/}).
 *
 * To use CJsTree, simply sets {@link data} to the data that you want
 * to present and you are there.
 * @link http://www.yiiframework.com/extension/jstree/#doc Documentation

 *
 * @author Shocky Han <shockyhan@gmail.com>
 * @author Dimitrios Meggidis <tydeas.dr@gmail.com>
 *
 * @version 1.1
 * @package application.extensions

 * @license http://www.yiiframework.com/license/
 */
/**
 * Revision history.
 * 2010-05-14: Dimitrios Meggidis <tydeas.dr@gmail.com>
 * * Add jsTree data property
 * 2009-06-06: Shocky Han <shokyhan@gmail.com>
 * * initial release
*/
class CJsTree extends CWidget
{

	public $id;

	/**
	 * @var array the data that can be used to generate the tree view content or used
	 * for the jstree data property.
	 * Each array element corresponds to a tree view node with the following structure:
	 * <ul>
	 * <li>text: string, required, the HTML text associated with this node.</li>
	 * <li>expanded: boolean, optional, whether the tree view node is in expanded.</li>
	 * <li>id: string, optional, the ID identifying the node. This is used
	 *   in dynamic loading of tree view (see {@link url}).</li>
	 * <li>hasChildren: boolean, optional, defaults to false, whether clicking on this
	 *   node should trigger dynamic loading of more tree view nodes from server.
	 *   The {@link url} property must be set in order to make this effective.</li>
	 * <li>children: array, optional, child nodes of this node.</li>
	 * </ul>
	 * Note, anything enclosed between the beginWidget and endWidget calls will
	 * also be treated as tree view content, which appends to the content generated
	 * from this data.
	 */
	public $data;

	/**
	 * @var string|array the URL to which the treeview can be dynamically loaded (in AJAX).
	 * See {@link CHtml::normalizeUrl} for possible URL formats.
	 * Setting this property will enable the dynamic treeview loading.
	 * When the page is displayed, the browser will request this URL with a GET parameter
	 * named 'source' whose value is 'root'. The server script should then generate the
	 * needed tree view data corresponding to the root of the tree (see {@link saveDataAsJson}.)
	 * When a node has a CSS class 'hasChildren', then expanding this node will also
	 * cause a dynamic loading of its child nodes. In this case, the value of the 'source' GET parameter
	 * is the 'id' property of the node.
	 */
	public $url;

	/**
	 * @var array additional options that can be passed to the constructor of the treeview js object.
	 */
	public $options=array();
	/**
	 * @var array additional HTML attributes that will be rendered in the UL tag.
	 * The default tree view CSS has defined the following CSS classes which can be enabled
	 * by specifying the 'class' option here:
	 * <ul>
	 * <li>treeview-black</li>
	 * <li>treeview-gray</li>
	 * <li>treeview-red</li>
	 * <li>treeview-famfamfam</li>
	 * <li>filetree</li>
	 * </ul>
	 */
	public $htmlOptions;

	/*
	 * internal data for jsTree
	 */
	public $baseUrl;	// jsTree install folder. registering scripts & css's under this folder.   
	public $body;		// jsTree Html data source. 

	public $plugins;

	public $core;
	public $themes;
	public $ui;
	public $html_data;
	public $json_data;
	/**
	 * Initializes the widget.
	 * This method registers all needed client scripts and renders
	 * the tree view content.
	 */
    public function init()
    {
		if($this->id !==null )
			$this->htmlOptions['id'] = $this->id;
        if(isset($this->htmlOptions['id']))
            $id=$this->htmlOptions['id'];
        else
            $id=$this->htmlOptions['id']=$this->getId();
        if($this->url!==null)
            $this->url=CHtml::normalizeUrl($this->url);

        $dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'source';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $cs=Yii::app()->getClientScript();
        //$cs->registerScriptFile($this->baseUrl.'/jquery.jstree.js');
        $cs->registerScriptFile($this->baseUrl.'/jquery.jstree.js');
		$cs->registerScriptFile($this->baseUrl.'/_lib/jquery.cookie.js');
        // jstree should make this automatically (see line 211),
        // but this does not work if script is loaded
        // dynamically with renderPartial into jQuery/UI dialog
        //if (!isset($this->options['ui'])) $this->options['ui'] = array();

        if (!isset($this->themes['theme'])) $this->themes['theme'] = 'default';
        if (!isset($this->themes['url'])) $this->themes['url'] =
             $this->baseUrl.'/themes/'.$this->themes['theme'].'/style.css';

        $options=$this->getClientOptions();
        $options=$options===array()?'{}' : CJavaScript::encode($options);


		$cs->registerCssFile($this->baseUrl.'/themes/'.$this->themes['theme'].'/style.css');
        $cs->registerScript('Yii.CJsTree#'.$id,"jQuery(\"#{$id}\").jstree($options);");
    }


	/**
	 * Ends running the widget.
	 */
	public function run()
	{ 
		//$this->body = "<ul>\n";
		//$this->body=$this->body.self::saveDataAsHtml($this->data);
		//$this->body=$this->body.self::saveDataAsJson($this->data);
		//$this->body=$this->body."\n</ul>";

		echo CHtml::tag('div', $this->htmlOptions, $this->body)."\n";
	}
	/**
	 * @return array the javascript options
	 */
	protected function getClientOptions()
	{
		$options=$this->options;      
		//$optionsParams=array('selected','opened','languages','path','cookies','ui','rules','lang','callback');
		$optionsParams=array('core','ui','themes', 'plugins', 'html_data', 'json_data');

		foreach( $optionsParams as $name )
		{
			if($this->$name!==null)
				$options[$name]=$this->$name;
		}

		return $options;
	}

	/**
	 * Generates tree view nodes in HTML from the data array.
	 * @param array the data for the tree view (see {@link data} for possible data structure).
	 * @return string the generated HTML for the tree view
	 */
	public static function saveDataAsHtml($data)
	{
		$html='';
		if(is_array($data))
		{
			foreach($data as $node)
			{
				if(!isset($node['text']))
					continue;
				//$node['data']=$node['text'];
				$id=isset($node['id']) ? (' id="'.$node['id'].'"') : '';
				if(isset($node['expanded']))
					$css=$node['expanded'] ? 'open' : 'closed';
				else
					$css='';
				if(isset($node['hasChildren']) && $node['hasChildren'])
				{
					if($css!=='')
						$css.=' ';
					$css.='hasChildren';
				}
				if($css!=='')
					$css=' class="'.$css.'"';
				if(isset($node['rel']))
					$css=$css.' rel="'.$node['rel'].'"';
				$html.="<li{$id}{$css}>{$node['text']}";
				if(isset($node['children']))
				{
					$html.="\n<ul>\n";
					$html.=self::saveDataAsHtml($node['children']);
					$html.="</ul>\n";
				}
				$html.="</li>\n";
			}
		}
		return $html;
	}

	/**
	 * Saves tree view data in JSON format.
	 * This method is typically used in dynamic tree view loading
	 * when the server code needs to send to the client the dynamic
	 * tree view data.
	 * @param array the data for the tree view (see {@link data} for possible data structure).
	 * @return string the JSON representation of the data
	 */
	public static function saveDataAsJson($data)
	{
		if(empty($data))
			return '[]';
		else
			return CJavaScript::jsonEncode($data);

	}
}
