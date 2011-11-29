<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Class NTokenInput extends CInputWidget
{

	/**
	 * The class to apply to the surrounding widgets div. 
	 * Typically <div class="input pan"><!-- widget --></div>
	 * @var string 
	 */
	public $inputClass = 'input pan';

	/**
	 * hintText: 
	 *   The text to show in the dropdown label which appears when 
	 *   you first click in the search field. default: “Type in a search term” (demo).
	 * noResultsText: 
	 *   The text to show in the dropdown label when no results 
	 *   are found which match the current query. default: “No results” (demo).
	 * searchingText:
	 *   The text to show in the dropdown label when a search is currently in 
	 *   progress. default: “Searching…” (demo).
	 * deleteText: 
	 *   The text to show on each token which deletes the token when
	 *   clicked. default: × (demo).
	 * theme:
	 *   Set this to a string, eg “facebook” when including theme css files to set the css class suffix (demo).
	 * animateDropdown:
	 *   Set this to false to disable animation of the dropdown default: true (demo).
	 * searchDelay:
	 *   The delay, in milliseconds, between the user finishing typing and the search being performed. default: 300 (demo).
	 * minChars:
	 *   The minimum number of characters the user must enter before a search is performed. default: 1 (demo).
	 * tokenLimit:
	 *   The maximum number of results allowed to be selected by the user. Use null to allow unlimited selections. default: null (demo).
	 * prePopulate:
	 *   Prepopulate the tokeninput with existing data. Set to an array of JSON objects, eg: [{id: 3, name: "test", id: 5, name: "awesome"}] to pre-fill the input. default: null (demo).
	 * preventDuplicates:
	 *   Prevent user from selecting duplicate values by setting this to true. default: false (demo).
	 * jsonContainer:
	 *   The name of the json object in the response which contains the search results. Use null to use the top level response object. default: null.
	 * method:
	 *   The HTTP method (eg. GET, POST) to use for the server request. default: “GET”.
	 * queryParam:
	 *   The name of the query param which you expect to contain the search term on the server-side. default: “q”.
	 * crossDomain:
	 *   Use JSONP cross-domain communication to the server instead of a normal ajax request. default: false.
	 * addNewTokens:
	 *   enables input text not in the list to be added as a token
	 * onResult:
	 *   A function to call whenever we receive results back from the server. You can use this function to pre-process results from the server before they are displayed to the user. default: null (demo).
	 * onAdd:
	 *   A function to call whenever the user adds another token to their selections. defaut: null (demo).
	 * onDelete:
	 *   A function to call whenever the user removes a token from their selections. default: null
	 * @var array 
	 */
	public $options;

	/**
	 * url to look up the data
	 * normalise url will be called on this NHtml::url() -> CHtml::normalizeUrl
	 * @var string
	 */
	public $url;

	/**
	 * array of search data Or define url to load data by ajax
	 * @var array
	 */
	public $data;

	public $theme = 'nii';


	public function init() {
		$this->publishAssets();
	}

	public function run(){

		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
		else
			$this->htmlOptions['name']=$name;

		//$value = null;
		if($this->hasModel()){
			$value = CHtml::resolveValue($this->model, $this->attribute);
		}else{
			$value = $value = $this->value;
		}
		

		echo '<div class="'.$this->inputClass.'">'.CHtml::textField($name,'',$this->htmlOptions).'</div>';
		if($value!==null){
			$prepopulate = array();
			foreach($value as $k=>$v)
				$prepopulate[] = array('id'=>$v, 'name'=>$v);
			$this->options['prePopulate'] = $prepopulate;
		}
		if($this->url === null && $this->data === null)
			throw new CException('you must specify the data for the tokens by specifing the data property as an array
				of tokens or the url to ajax the data in.');

		if($this->url !== null)
			$data = CJavaScript::encode(NHtml::url($this->url));
		else
			$data =  CJavaScript::encode($this->data);
		
		
		// sort options array out
		if(!isset($this->options['theme']))
			$this->options['theme'] = $this->theme;
		
		$options=CJavaScript::encode($this->options);

		$js = "jQuery('#{$id}').tokenInput($data,$options);";
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$id, $js, CClientScript::POS_READY);
	}

	public function publishAssets(){
		$localPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetUrl = Yii::app()->getAssetManager()->publish($localPath);

		Yii::app()->clientScript->registerScriptFile($assetUrl . '/src/jquery.tokeninput.js');
		Yii::app()->clientScript->registerCssFile($assetUrl . '/styles/token-input.css');
		// other themes:
		// Yii::app()->clientScript->registerCssFile($assetUrl . '/styles/token-input-facebook.css');
		// Yii::app()->clientScript->registerCssFile($assetUrl . '/styles/token-input-mac.css');
		$theme = $this->theme;
		Yii::app()->clientScript->registerCssFile($assetUrl . "/styles/token-input-$theme.css");
	}

}