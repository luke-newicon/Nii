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
	public $size = 32;

	/**
	 * @var CrmContact 
	 */
	public $contact;

	public function run(){
	
		if($this->contact->isPerson()){
			$email = empty($this->contact->emails) ? '' : $this->contact->emails[0]->address;
			echo $this->widget('crm.components.Gravatar',array('size'=>$this->size,'email'=>$email),true);
		}else{
			$orgImg = CrmModule::get()->getAssetsUrl().'/images/mistery-org.png';
			echo NHtml::image($orgImg,'Compnay Image',array('width'=>$this->size));
		}
	}

}