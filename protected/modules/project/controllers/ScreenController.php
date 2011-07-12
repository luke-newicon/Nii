<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of DetailsController
 *
 * @author steve
 */
class ScreenController extends AController 
{
	
	public function actionAddTemplate(){
		$pid = $_POST['project'];
		$template = $_POST['template'];
		$t = new ProjectTemplate();
		$t->name = $template;
		$t->project_id = $pid;
		$t->save();
		
		$itemInfo = $this->renderPartial('_template-item', array('template'=>$t), true);
		echo json_encode(array('template_id'=>$t->id,'item'=>$itemInfo));
	}
	
	
}