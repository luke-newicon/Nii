<?php
/**
 * Mod class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Mod
 *
 * @author steve
 */
class Mod extends CWidget
{
	public $class;
	public $id;
	public $htmlOptions = array();

	public function init(){
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = $this->class;
		
		echo '<div '.CHtml::renderAttributes($this->htmlOptions).' >
			<b class="top"><b class="tl"></b><b class="tr"></b></b>
			<div class="inner">';
	}
    public function run(){
		echo '</div>
			<b class="bottom"><b class="bl"></b><b class="br"></b></b>
			</div>';
	}
}