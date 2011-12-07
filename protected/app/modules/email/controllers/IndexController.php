<?php

class IndexController extends AController
{
	
	public function actionIndex()
	{
		$model = new EmailCampaign;
		$this->render('index', array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionContacts($q){
		$q = urldecode($_GET['q']);
		// escape % and _ characters
		$q = strtr($q, array('%'=>'\%', '_'=>'\_'));
		$data = array();
//		$data[] = array('id'=>'', 'name'=>'Groups','type'=>'header');
		$groups = ContactGroup::model()->findAll(
			array(
				'condition'=>"name LIKE '%".$q."%' OR label LIKE '%".$q."%'",
				'limit'=>30,
			)
		);
		foreach($groups as $g){
			$data[] = array('id'=>$g->id, 'name'=>$g->label);
		}
//		$data[] = array('id'=>'', 'name'=>'Contacts','type'=>'header');
		$contacts = Contact::model()->findAll(
			array(
				'condition'=>"name LIKE '%".$q."%'",
				'limit'=>30,
			)
		);
		foreach($contacts as $c){
			$data[] = array('id'=>$c->id, 'name'=>$c->name);
		}		
		echo CJSON::encode($data);
	}
	
}

