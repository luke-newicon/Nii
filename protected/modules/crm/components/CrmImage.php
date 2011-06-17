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
	
	/**
	 * html options for the image tag
	 * @var array 
	 */
	public $htmlOptions = array();
	
	/**
	 * Allows the user to edit the image displayed.
	 * @var boolean 
	 */
	public $edit = false;
	
	

	public function run(){
		$this->htmlOptions['width'] = $this->size;
		if($this->contact===null){
			$img = CrmModule::get()->getAssetsUrl().'/images/mistery-img.png';
			$img = NHtml::image($img,'Mystery person Image',$this->htmlOptions);
		}elseif($this->contact->isPerson()){
			$email = $this->contact->getPrimaryEmail();
			$img = $this->widget('crm.components.Gravatar',array('size'=>$this->size,'email'=>$email, 'htmlOptions'=>$this->htmlOptions),true);
		}else{
			$orgImg = CrmModule::get()->getAssetsUrl().'/images/mistery-org.png';
			$img = NHtml::image($orgImg,'Compnay Image',$this->htmlOptions);
		}
		$this->render('crm-image',array('img'=>$img));
	}

}