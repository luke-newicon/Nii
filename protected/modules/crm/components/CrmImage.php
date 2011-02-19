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

	public $contact;

	public function run(){
	
		if($this->contact->isPerson()){
			$email = empty($this->contact->emails) ? '' : $this->contact->emails[0]->address_address;
			echo $this->widget('crm.components.Gravatar',array('size'=>$this->size,'email'=>$email),true);
		}else{
			$orgImg = NHtml::baseUrl().'/app/Nworx/Crm/theme/assets/mistery-org.png';
			return NHtml::image($orgImg,'Compnay Image',array('width'=>$this->size));
		}
	}

}