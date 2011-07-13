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
	
	/**
	 * ajax: adds a new template
	 */
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
	
	/**
	 * ajax: applies a template to a screen
	 * expects: 
	 * template: id of the template to apply
	 * screen: id of the screen to apply to
	 */
	public function actionApplyTemplate(){
		$tid = $_POST['template'];
		$st = new ProjectScreenTemplate();
		$st->template_id = $tid;
		$st->screen_id = $_POST['screen'];
		$st->save();
		// need to get template hotspot info.
		$hotspotRecords = ProjectHotSpot::model()->findAllByAttributes(array('template_id'=>$tid));
		$hotspots = array();
		foreach($hotspotRecords as $hs){
			$hotspots[] = $hs->getAttributes();
		}
		echo json_encode($hotspots);
	}
	
	
	public function actionRemoveTemplate(){
		$tid = $_POST['template'];
		$sid = $_POST['screen'];
		$t = ProjectScreenTemplate::model()->findByPk(array('template_id'=>$tid,'screen_id'=>$sid));
		$t->delete();
	}
	
	public function actionAddTemplateSpot(){
		$sid = $_POST['spot'];
		$tid = $_POST['template'];
		$s = ProjectHotSpot::model()->findByPk($sid);
		$s->template_id = $tid;
		// unlink from the screen as its now a template??
		$s->save();
	}
	
}