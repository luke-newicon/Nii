<?php
/**
 * UserSelect class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

Yii::import('zii.widgets.jui.*');
/**
 * create a nice user select input
 *
 * @author steve
 */
class UserSelect extends CJuiAutoComplete
{
	public function run()
	{
		
		$this->themeUrl = Yii::app()->getModule('nii')->juiThemeUrl;
		
		list($name,$id)=$this->resolveNameID();
		
		$users = array();
		foreach(User::model()->findAll() as $u)
			$users[] = array($u->email);
		
		$this->source = User::model()->findAll();
		$this->options['source']=$this->source;

		$options=CJavaScript::encode($this->options);

		$js = "jQuery('#{$id}').autocomplete($options);";

		$cs = Yii::app()->getClientScript();
		$cs->registerScript(__CLASS__.'#'.$id, $js);
	}
}
