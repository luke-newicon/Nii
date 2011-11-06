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
		;
	}

	public static function urlAbsolute($route, $params=array(), $schema=null) {
		if (is_array($route)) {
			$params = $route;
			$route = $params[0];
			unset($params[0]);
		}
		return Yii::app()->createAbsoluteUrl($route, $params);
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

	public static function generateAttributeId($label) {
		return strtolower(str_replace(array(' '), '_', $label));
	}

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

	public static function formatDate($date, $format=null, $noDateText=null) {
		if ($format == '' || !$format)
			$format = 'jS F Y';
		if ($date && $date != '0000-00-00')
			if (strstr($date, '-'))
				return date($format, strtotime($date));
			else
				return date($format, $date);
		else
			return (isset($noDateText)) ? $noDateText : '<span class="noDate">No date set</span>';
	}

	public static function formatGridDate($date, $format=null, $noDateText=null) {
		if ($format == '' || !$format)
			$format = 'd/m/Y';
		return self::formatDate($date, $format, $noDateText);
	}

	public static function formatBool($value, $true=1, $false=0, $blank=false) {
		if ($value == $true)
			return 'Yes';
		else if ($value === $false || $blank === false)
			return 'No';
		else
			return;
	}

	public static function formatPrice($value, $currency='&pound;', $decimals=2) {
		return $currency . ' ' . number_format($value, $decimals);
	}

	public static function emailLink($email) {
		return '<a href="mailto:' . $email . '" class="emailLink" title="Send an email to ' . $email . '">' . $email . '</a>';
	}

	public static function activeLabel($model, $attribute, $htmlOptions=array()) {
		if (empty($htmlOptions)) {
			$htmlOptions = array('class' => 'lbl');
		}
		return parent::activeLabel($model, $attribute, $htmlOptions);
	}

}