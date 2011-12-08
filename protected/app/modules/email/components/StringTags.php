<?php

/**
 * StringTags class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Registers a list of tags and converts the tags to their string values
 * by calling replaceTags.
 *
 * @author steve
 */
class StringTags extends CComponent 
{
	/**
	 * an array of tag names
	 * @var array
	 */
    private $_tagNames = array();

	/**
	 * an array of tag properties to call on the object
	 * @var type 
	 */
    private $_tagFunctions = array();

	/**
	 * store an array of processed tag results. (converted tags)
	 * @var array 
	 */
    private $_tagValues = array();
    
	/**
	 * Store the object to process tags against
	 * @var mixed 
	 */
    private $_obj = null;

	/**
	 * tag template the tag keyword is replaced by your tag name
	 * @var string 
	 */
	public $tagTemplate = '[tag]';
	
	
    public function __construct(){
        $this->addTag('first_name', 'first_name');
        $this->addTag('last_name' , 'last_name');
    }

    /**
     * Add a tag
	 * 
     * @param string $tagName
     * @param string $tagProperty
     * @return void
     */
    public function addTag($tagName, $tagFun=null, $tagClass='Contact', $htmlEncode=true){
        $tag = str_replace('tag', $tagName, $this->tagTemplate);
        $this->_tagNames[]     = $tag;
		$tagFun = ($tagFun===null) ? $tagName : $tagFun;
        $this->_tagFunctions[] = array('function'=>$tagFun, 'class'=>$tagClass, 'tag' => $tag, 'encode'=>$htmlEncode);
    }

    
	/**
	 * This function is called for every tag and processes the tag function again the contact object 
	 * stored in $this->_obj
	 * 
	 * @param $function array containing function names and the class
	 * @return string | converted tag
	 */
    public function callObjFun($tagFunctions){
		
		$function = $tagFunctions['function'];
    	$class    = $tagFunctions['class'];
		$encode   = $tagFunctions['encode'];
    	
    	if($this->_obj instanceof $class)
			$ret = $this->_obj->$function;
			// could change this to use evaluate expression
			// then tag function strings can refer to the contact object directly like: 
			// "$this->something->something" the $this being the $obj on which to call the tag function 
			// typically the Contact object
			// $ret = $this->_obj->evaluateExpression()

		if($encode)
			$ret = htmlentities($ret,ENT_QUOTES,'UTF-8');
		
    	return $ret;
    }

    /**
     * process the tags on the $obj param.
	 * 
     * @param mixed $obj
     * @return void
     */
    private function _setTagValues($obj){
        $this->_obj = $obj;
        $this->_tagValues = array_map(array($this, 'callObjFun'), $this->_tagFunctions);
    }

    public function getTagNames(){
        return $this->_tagNames;
    }

    public function getTagValues() {
        return $this->_tagValues;
    }


    /**
     * convert tags to values
	 * 
     * @param string $textToReplace | text with tags to replace
     * @param Contact | contact object to populate tags
     * @return text with tags replaced
     */
    public function replaceTags($textToReplace, $obj){
        $this->_setTagValues($obj);
        return str_replace($this->getTagNames(),
                           $this->getTagValues(),
                           $textToReplace);
    }

        



}