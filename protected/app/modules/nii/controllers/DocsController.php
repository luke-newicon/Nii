<?php

/**
 * DocsController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of DocsController
 *
 * @author steve
 */
class DocsController extends AController 
{
	
	
	public function actionIndex(){
		$this->render('index');
	}
	
	public function actionTag(){
		
		$t = TaskTask::model()->findByPk(1);
		
		$t->attachBehavior('tag', array(
			'class' => 'nii.components.behaviors.NTaggable',
		));
		
				
		$rows = $t->tag->searchAllRows(array('bum'));
		
		//$rows = $t->tag->searchRows(array('bum'), $t);
		
		
		
		foreach($rows as $r){
			dp($r->getAttributes());
		}
		
		// get this model rows tags
		dp($t->getTags());
		
		
		// get all tags for model type
		dp('get al tags');
		dp($t->getAllTags());
		
		
		$this->render('tag');
	}
	
	
	
}