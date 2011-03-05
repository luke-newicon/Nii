<?php
/**
 * CrmImage class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of CrmImage
 *
 * @author steve
 */
class CrmImage extends CWidget
{
	/**
	 * Image size
	 * @var type 
	 */
	public $size = 32;

	/**
	 * @var CrmContact 
	 */
	public $contact;
	
	/**
	 * Additional html options for the image tag
	 * @var array
	 */
	public $htmlOptions = array();

	public function run()
	{
		if($this->contact->isPerson()){
			$email = empty($this->contact->emails) ? '' : $this->contact->emails[0]->address;
			echo $this->widget('crm.components.Gravatar',array(
				'size'=>$this->size,
				'email'=>$email,
				'htmlOptions'=>$this->htmlOptions),true);
		}else{
			$orgImg = CrmModule::get()->getAssetsUrl().'/images/mistery-org.png';
			$this->htmlOptions['width'] = $this->size;
			echo NHtml::image($orgImg,'Compnay Image',$this->htmlOptions);
		}
	}

}