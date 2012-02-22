<?php

/**
 * NHtml class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NHtml
 *
 * @author steve
 */
class NHtml extends CHtml {

	/**
	 * Format a route into a url a shorthand method of calling normalizeUrl
	 * 
	 * For convienience the $route parameter can be a string
	 * A yii route is defined array('/moduleId/controllerId/actionId', 'getParam1'=>'getParamVal1')
	 * This function allows route to be a string as well for example
	 * NHtml::url('/crm/contact/show', array('id'=>3))
	 * however you can also use this the same as calling Yii::app()->createUrl
	 * If you use NHtml::url() and pass no parameters the base url of the application will be returned
	 * 
	 * @see CWebApplication::createUrl
	 * @param mixed (string|array) $route if route is an array the $getArray parameter is ignored
	 * @param array $getArray additional get parameters
	 * @return type 
	 */
	public static function url($route='', $getArray=array()) {
		// if route is a string convert it to the array format
		if (is_string($route)) {
			$getArray[0] = $route;
			$route = $getArray;
		}
		return Yii::app()->createUrl($route[0], array_splice($route, 1));
	}

	public static function urlAbsolute($route, $params=array(), $schema=null) {
		if (is_array($route)) {
			$params = $route;
			$route = $params[0];
			unset($params[0]);
		}
		return Yii::app()->createAbsoluteUrl($route, $params);
	}
	
	/**
	 * returen the theme base url
	 */
	public function themeUrl(){
		echo Yii::app()->theme->baseUrl;
	}
	
	public static function baseUrl() {
		if (isset(Yii::app()->params['baseUrl'])) {
			return Yii::app()->params['baseUrl'];
		}
		return Yii::app()->request->baseUrl;
	}

	/**
	 * Lowercase the first leter of a string
	 * 
	 * @param $str
	 * @return string
	 */
	public static function lcFirst($str) {
		if (function_exists('lcfirst'))
			return lcfirst($str);
		return strtolower(substr($str, 0, 1)) . substr($str, 1);
	}

	/**
	 * Takes some text and finds all occurances of $searchTerm and highlights it with 
	 * <span class="$hilightClass"></span> 
	 *
	 * @param string $textToHilight
	 * @param string $searchTerm
	 * @param string $hilightClass
	 * @param array $htmlOptions
	 * @return string with highlighted text
	 */
	public static function hilightText($textToHilight, $searchTerm, $hilightClass='searchHilite', $htmlOptions=array()) {
		if (is_array($searchTerm))
			return '';
		//if search term is empty then return the string do not perform the search
		if (empty($searchTerm))
			return $textToHilight;
		if (!isset($htmlOptions['class']))
			$htmlOptions['class'] = $hilightClass;
		$search = preg_quote($searchTerm, '/');
		return preg_replace("/($search)/i", '<span ' . CHtml::renderAttributes($htmlOptions) . '>$1</span>', $textToHilight);
	}

	/**
	 * breaks a large string into a smaller preview string of a defined character length
	 * (defined by $charactersLong)
	 *
	 * It also breaks words longer than $wordBreakLength (defaults to 15 characters) with the $wordBreakChar
	 * (defaults to "-")
	 *
	 * @param string $subject The large text to form a preview of
	 * @param string $charactersLong The maximum number of characters to preview
	 * @param string $wordBreakLength The maximum number of characters allowed for any one word
	 * @param string $wordBreakChar The character to break words longer than $wordBreakLength into
	 * @return string the formatted preview text
	 */
	public static function previewText($subject, $charactersLong, $wordBreakLength=15, $wordBreakChar='-') {
		// strip silly long strings
		$totalTxt = substr($subject, 0, $charactersLong);
		// break words longer than 14 characters
		$patrn = '/([^\s]{' . $wordBreakLength . '})/';
		$txt = preg_replace($patrn, $wordBreakChar, $totalTxt);
		return $txt;
	}

	// CAN DELETE THIS I THINK.
	public static function popupForm($id, $title, $open, $width='400px', $onSave='', $dialogOptions=array()) {
		$v = Yii::app()->controller;
		$options = CMap::mergeArray(array(
					'title' => $title,
					'autoOpen' => false,
					'width' => $width,
					'open' => $open,
					'buttons' => array(
						'save' => array(
							'text' => 'Save',
							'click' => $onSave,
						),
						'cancel' => array(
							'text' => 'Cancel',
							'click' => 'js:function() { $(this).dialog("close"); }'
						),
					),
						), $dialogOptions);
		$v->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id' => $id,
			// additional javascript options for the dialog plugin
			'options' => $options
		));

		echo '<div class="content">Loading...</div>';

		$v->endWidget('zii.widgets.jui.CJuiDialog');
	}

	/**
	 * Gets the application wide button class
	 * 
	 * @return string 
	 */
	public static function btnClass() {
		if (isset(Yii::app()->params->buttonClass))
			return Yii::app()->params->buttonClass;
		return 'btn';
	}

	/**
	 * Draws a button using default button class
	 * 
	 * @param type $label
	 * @param type $iconClass
	 * @param string $class 
	 */
	public static function btn($label, $iconClass=null, $class=null) {
		$class = NHtml::btnClass() . ' ' . $class;
		if ($iconClass !== null)
			$label = "<span class=\"$iconClass\"></span>$label";
		echo CHtml::htmlButton($label, array('class' => $class));
	}

	/**
	 * Get the url address to show the imagh or use in the img src attribute
	 * 
	 * @param int $id fileManager NFile id
	 * @param string $size thumbSize key name or string in the form xy-100-130
	 * @return string url
	 */
	public static function urlImageThumb($id, $type='small') {
		return NImage::get()->url($id, $type);
	}

	/**
	 * Get the width from an image type
	 * @param string $type
	 * @return string width 
	 */
	public static function nImageWidth($type) {
		$actions = NImage::get()->getType($type);
		if (array_key_exists('resize', $actions)) {
			if (array_key_exists('width', $actions['resize'])) {
				return $actions['resize']['width'];
			} else {
				return '';
			}
		}
	}

	/**
	 * Get the height from an image type
	 * @param string $type
	 * @return string height 
	 */
	public static function nImageHeight($type) {
		$actions = NImage::get()->getType($type);
		if (array_key_exists('resize', $actions)) {
			if (array_key_exists('height', $actions['resize'])) {
				return $actions['resize']['height'];
			} else {
				return '';
			}
		}
	}
	// DOCUMENTATION PLEASE! ??
	public static function nImageSizeAttr($type) {
		return ' width="' . NHtml::nImageWidth($type) . '" height="' . NHtml::nImageHeight($type) . '" ';
	}

	/**
	 * Function to generate a link to a file controlled by the fileManager 
	 * component
	 * 
	 * @param int $id the filemanager id for the file
	 * @param string $name the name of the file
	 * @param boolean $downloadable wheather to create a download link.
	 * @return string url
	 * @see NFileManager::getUrl
	 */
	public static function urlFile($id, $name='', $downloadable=false) {
		return NFileManager::get()->getUrl($id, $name, $downloadable);
	}

	/**
	 * Generates a user friendly attribute label.
	 * This is done by replacing underscores or dashes with blanks and
	 * changing the first letter of each word to upper case.
	 * For example, 'department_name' or 'DepartmentName' becomes 'Department Name'.
	 * @param string $name the column name
	 * @return string the attribute label
	 */
	public static function generateAttributeLabel($name) {
		return ucwords(trim(strtolower(str_replace(array('-', '_', '.'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name)))));
	}
	// DOCUMENTATION PLEASE!
	public static function generateAttributeId($label) {
		return strtolower(str_replace(array(' '), '_', $label));
	}

	/**
	 *	Returns an array of enum values from an enum column on the given model
	 * @param model $model
	 * @param string $attribute - column/field name containing the enum info
	 * @return array 
	 */
	public static function enumItem($model, $attribute) {
		$attr = $attribute;
		self::resolveName($model, $attr);
		$enum = $model->tableSchema->columns[$attr]->dbType;
		$off = strpos($enum, "(");
		$enum = substr($enum, $off + 1, strlen($enum) - $off - 2);
		$keys = str_replace("'", null, explode(",", $enum));
		for ($i = 0; $i < sizeof($keys); $i++)
			$values[$keys[$i]] = Yii::t('enumItem', $keys[$i]);
		return $values;
	}
	// DOCUMENTATION PLEASE!
	public static function btnLink($label, $url, $iconClass=null, $attributes=array()) {
		if ($iconClass !== null)
			$label = "<span class=\"icon $iconClass\"></span>$label";
		return CHtml::link($label, $url, $attributes);
	}

	/**
	 * Return the class for a particular mime type
	 * To use this, you need to populate a sprite folder named 'mime' with PNGs named similarly the following example translations...
	 * 		MIME TYPE				Class								Created file name (with .png extension)
	 * 		image/jpeg			mime-image_jpg			image-jpeg
	 * 		application/pdf		mime-application_pdf	application-pdf
	 * 		application/vnd.openxmlformats-officedocument.wordprocessingml.document... Seriously, Word?!
	 * 
	 * @param string $mimeType 
	 */
	public static function getMimeTypeByExtension($file) {

		static $extensions;
		if ($extensions === null) {
			$extensions = require(Yii::getPathOfAlias('system.utils.mimeTypes') . '.php');
			$extensions['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
			$extensions['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
			$extensions['odt'] = 'application/vnd.oasis.opendocument.text';
			$extensions['ods'] = 'application/vnd.oasis.opendocument.spreadsheet';
		}
		if (($ext = pathinfo($file, PATHINFO_EXTENSION)) !== '') {
			$ext = strtolower($ext);
			if (isset($extensions[$ext]))
				return $extensions[$ext];
		}
		return null;
	}

	/**
	 * Returns an OOCSS icon class representing the mime icon.
	 * The defualt icon type if no match is found is a 'fam-page-white'.
	 * @param $mimetype The mime type you would like to get the icon for
	 * @return string
	 */
	static public function getMimeTypeIcon($mimetype) {
		$icon = '';

		switch ($mimetype) {
			case 'application/visio':
			case 'application/x-visio':
			case 'application/vnd.visio':
			case 'application/visio.drawing':
			case 'application/vsd':
			case 'application/x-vsd':
			case 'image/x-vsd':
			case 'zz-application':
			case 'zz-winassoc-vsd':
			case 'application/x-visio':
			case 'application/visio':
			case 'application/vnd.ms-office':
				$icon = 'fam-page-white-office';
				break;
			case 'application/msword':
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			case 'application/vnd.oasis.opendocument.text':
				$icon = 'fam-page-white-word';
				break;
			case 'text/css':
				$icon = 'fam-css';
				break;
			case 'text/plain':
				$icon = 'fam-page-white-text';
				break;
			case 'text/html':
				$icon = 'fam-page-world';
				break;
			case 'application/pdf':
				$icon = 'fam-page-white-acrobat';
				break;
			case 'application/mspowerpoint':
				$icon = 'fam-page-white-powerpoint';
				break;
			case 'text/rtf':
			case 'text/richtext':
				$icon = 'fam-page-white-text';
				break;
			case 'application/x-shockwave-flash':
				$icon = 'fam-page-white-flash';
				break;
			case 'application/vnd.ms-excel':
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
			case 'application/vnd.oasis.opendocument.spreadsheet':
				$icon = 'fam-page-white-excel';
				break;
			case 'text/xml':
				$icon = 'fam-page-white-code';
				break;
			case 'application/zip':
			case 'application/x-tar':
			case 'application/x-gtar':
			case 'application/x-gzip':
				$icon = 'fam-page-white-zip';
				break;
			case 'image/jpeg':
			case 'image/bmp':
			case 'image/png':
			case 'image/gif':
				$icon = 'fam-page-white-picture';
				break;
			default:
				//set up some defaults
				//if mimetype contains application text
				if (strpos($mimetype, 'application')) {
					//default application icon
					$icon = 'fam-application';
				} elseif (strpos($mimetype, 'audio')) {
					$icon = 'fam-sound';
				} elseif (strpos($mimetype, 'video')) {
					$icon = 'fam-film';
				} elseif (strpos($mimetype, 'image')) {
					$icon = 'fam-picture';
				} elseif (strpos($mimetype, 'text')) {
					$icon = 'fam-page-white-text';
				}
				$icon = 'fam-page-white';
				break;
		}

		return 'icon ' . $icon;
	}
	/**
	 *	Returns a properly formatted date, using PHP date format
	 * @param string $date - original value from model
	 * @param string $format - PHP date format
	 * @param type $noDateText - alternative text for if there is no date set; can also be set to false to hide
	 * @return string formatted date 
	 */
	public static function formatDate($date, $format=null, $noDateText=null) {
		if ($format == '' || !$format)
			$format = 'jS F Y';
		if ($date && $date != '0000-00-00')
			if (strstr($date, '-'))
				return date($format, strtotime($date));
			else
				return date($format, $date);
		else
			if ($noDateText !== false)
				return (isset($noDateText)) ? $noDateText : '<span class="noDate">No date set</span>';
	}
	
	/**
	 *	Returns a properly formatted date for use in a grid
	 * @param string $date - original value from model
	 * @param string $format - PHP date format
	 * @param type $noDateText - alternative text for if there is no date set; can also be set to false to hide
	 * @return function formatDate
	 */
	public static function formatGridDate($date, $format=null, $noDateText=null) {
		if ($format == '' || !$format)
			$format = 'd/m/Y';
		return self::formatDate($date, $format, $noDateText);
	}
	
	/**
	 *	Returns human readable text from a boolean value
	 * @param string $value - original boolean
	 * @param string $true - true value
	 * @param string $false - false value
	 * @param bool $blank - whether to return blank on false
	 * @return string 
	 */
	public static function formatBool($value, $true=1, $false=0, $blank=false) {
		if ($value == $true)
			return 'Yes';
		else if ($value === $false || $blank === false)
			return 'No';
		else
			return;
	}
	
	
	/**
	 *	Returns human readable text from a boolean value
	 * @param string $value - original boolean
	 * @param string $true - true value
	 * @param string $false - false value
	 * @param bool $blank - whether to return blank on false
	 * @return string 
	 */
	public static function boolImage($value, $true=1, $false=0, $blank=false) {
		if ($value == $true)
			return '<span class="icon fam-accept">&nbsp;</span>';
		else if ($value === $false || $blank === false)
			return '<span class="icon fam-delete">&nbsp;</span>';
		else
			return;
	}
	
	/**
	 * Returns a properly formatted price based on an integer or float
	 * @param int/float $value
	 * @param string $currency - the character, html-encoded, to place before the price
	 * @param int $decimals - number of decimals to display
	 * @return string
	 */
	public static function formatPrice($value, $currency='&pound;', $decimals=2, $showZeroDecimals=false) {
		$decimals = (strstr($value,'.') && $showZeroDecimals==true) ? 2 : 0;
		return '<span class="currency">'.$currency . '</span>'. number_format($value, $decimals);
	}
	
	/**
	 * Returns a properly formatted mailto link from an email address
	 * @param string $email - email address
	 * @return string 
	 */
	public static function emailLink($email) {
		return '<a href="mailto:' . $email . '" class="emailLink" title="Send an email to ' . $email . '">' . $email . '</a>';
	}

	/**
	 * Overrides the default CHtml::activeLabel and adds an additional class .lbl if no htmlOptions are specified.
	 * @see CHtml::activeLabel
	 * @param CActiveRecord $model
	 * @param string $attribute
	 * @param array $htmlOptions
	 * @return string html 
	 */
	public static function activeLabel($model, $attribute, $htmlOptions=array()) {
		if (empty($htmlOptions)) {
			$htmlOptions = array('class' => 'lbl');
		}
		return parent::activeLabel($model, $attribute, $htmlOptions);
	}
	
	/**
	 *	Trash button for generic trashing of model objects. To be used in views...
	 * @param string $model
	 * @param string $modelName
	 * @param mixed $returnUrl the return route string/array.
	 * @param string $successMsg
	 * @return button 
	 */
	public static function trashButton ($model, $modelName, $returnUrl, $successMsg=null) {

		$label = AController::t('Delete this '.ucwords($modelName));
		$className = get_class($model);
		
		$params = array(
			'model'=>$className,
			'model_id'=>$model->id,
			'name'=>$modelName,
			'returnUrl'=> str_replace('/', '.', NHtml::url($returnUrl)),
		);
		if ($successMsg)
			$params['successMsg'] = $successMsg;
		
		$url = NHtml::url(array_merge(array('/nii/index/trash'),$params));
		
		return NHtml::btnLink('<i class="icon-trash icon-white"></i> '.$label,'#', null,
			array(
				'onclick'=> '
					var answer = confirm("Are you sure you wish to delete this '.$modelName.'?");
					if(!answer) { return; }
					window.location = "'.$url.'";
				',
				'class'=>'trash-link btn btn-danger'
			)
		);
	}
	
	public static function confirmLink($label, $url, $confirmMessage=null, $htmlOptions=array()) {
		if ($confirmMessage==null)
			$confirmMessage = 'Are you sure?';
		return NHtml::link($label,'#', array_merge(
				$htmlOptions,
				array('onclick'=> '
					var answer = confirm("'.$confirmMessage.'");
					if(!answer) { return; }
					window.location = "'.NHtml::url($url).'";
				')
			)
		);
	}
	
	public static function confirmAjaxLink($label, $url, $confirmMessage=null, $gridId=null, $htmlOptions=array()) {
		if ($confirmMessage==null)
			$confirmMessage = 'Are you sure?';
		
		$url['ajax']=true;
		
		return NHtml::link($label, '#', array_merge($htmlOptions, array(
			'onclick' => "js:$(function(){ 
				var answer = confirm('".$confirmMessage."');
				if (!answer) {
					return;
				} 
				$.ajax({
					url: '".  NHtml::url($url)."',
					dataType: 'json',
					type: 'get',
					success: function(response){ 
						if (response.success) {
							".($gridId!==null ? "$.fn.yiiGridView.update('".$gridId."', {updateAll:true});" : "")."
							nii.showMessage(response.success);
							return false;
						}
					}
				}); 
			});")
		));
	}
	
	
	// DOCUMENTATION PLEASE!
	public static function hexLighter($hex, $factor = 8) {
		$new_hex = '';

		if ($hex[0] == '#')
			$hex = substr($hex, 1);

		$base['R'] = hexdec($hex{0} . $hex{1});
		$base['G'] = hexdec($hex{2} . $hex{3});
		$base['B'] = hexdec($hex{4} . $hex{5});

		foreach ($base as $k => $v) {
			$amount = 255 - $v;
			$amount = $amount / 100;
			$amount = round($amount * $factor);
			$new_decimal = $v + $amount;

			$new_hex_component = dechex($new_decimal);
			if (strlen($new_hex_component) < 2) {
				$new_hex_component = "0" . $new_hex_component;
			}
			$new_hex .= $new_hex_component;
		}

		return '#'.$new_hex;
	}
	
	// DOCUMENTATION PLEASE!
	public static function hexDarker($hex, $factor = 8) {
		$new_hex = '';

		if ($hex[0] == '#')
			$hex = substr($hex, 1);

		$base['R'] = hexdec($hex{0} . $hex{1});
		$base['G'] = hexdec($hex{2} . $hex{3});
		$base['B'] = hexdec($hex{4} . $hex{5});

		foreach ($base as $k => $v) {
			$amount = 255 - $v;
			$amount = $amount / 100;
			$amount = round($amount / $factor);
			$new_decimal = $v + $amount;

			$new_hex_component = dechex($new_decimal);
			if (strlen($new_hex_component) < 2) {
				$new_hex_component = "0" . $new_hex_component;
			}
			$new_hex .= $new_hex_component;
		}

		return '#'.$new_hex;
	}
	
	/**
     * Remove any illegal characters, accents, etc.
     *
     * @param string $string String to unaccent
     *
     * @return string $string Unaccented string
     */
    public static function unaccent($string)
    {
        if ( ! preg_match('/[\x80-\xff]/', $string) ) {
            return $string;
        }

        if (self::seemsUtf8($string)) {
            $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
            chr(195).chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R', chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R', chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R', chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S', chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S', chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S', chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
            // Euro Sign
            chr(226).chr(130).chr(172) => 'E',
            // GBP (Pound) Sign
            chr(194).chr(163) => '',
            'Ä' => 'Ae', 'ä' => 'ae', 'Ü' => 'Ue', 'ü' => 'ue',
            'Ö' => 'Oe', 'ö' => 'oe', 'ß' => 'ss',
            // Norwegian characters
            'Å'=>'Aa','Æ'=>'Ae','Ø'=>'O','æ'=>'a','ø'=>'o','å'=>'aa'
            );

            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                .chr(252).chr(253).chr(255);

            $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYa'
              . 'aaaaaceeeeiiiinoooooouuuuyy';

            $string = strtr($string, $chars['in'], $chars['out']);
            $doubleChars['in'] = array(
                chr(140), chr(156), chr(198),
                chr(208), chr(222), chr(223),
                chr(230), chr(240), chr(254));
            $doubleChars['out'] = array(
              'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th'
            );
            $string = str_replace(
                $doubleChars['in'],
                $doubleChars['out'],
                $string
            );
        }

        return $string;
    }
	
	/**
	 * Taken from doctorine_inflector
     * Convert any passed string to a url friendly string.
     * Converts 'My first blog post' to 'my-first-blog-post'
     *
     * @param string $text Text to urlize
     *
     * @return string $text Urlized text
     */
    public static function urlize($text)
    {
		// Remove all non url friendly characters with the unaccent function
		$text = self::unaccent($text);

		if (function_exists('mb_strtolower')) {
			$text = mb_strtolower($text);
		} else {
			$text = strtolower($text);
		}

		// Remove all none word characters
		$text = preg_replace('/\W/', ' ', $text);

		// More stripping. Replace spaces with dashes
		$text = strtolower(
			preg_replace(
				'/[^A-Z^a-z^0-9^\/]+/', '-', preg_replace(
					'/([a-z\d])([A-Z])/', '\1_\2', preg_replace(
						'/([A-Z]+)([A-Z][a-z])/', '\1_\2', preg_replace(
							'/::/', '/', $text
						)
					)
				)
			)
		);

		return trim($text, '-');
	}


}