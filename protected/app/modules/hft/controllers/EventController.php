<?php

/**
 * Description of EventsController
 *
 * @author robinwilliams
 */
class EventController extends AController 
{
	
	/**
	 *	Action to display the default events grid view 
	 */
	public function actionIndex() {
		
		$this->pageTitle = Yii::app()->name . ' - Events';
		$eventModel = 'HftEvent';
	
		$model = new $eventModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$eventModel]))
			$model->attributes = $_GET[$eventModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	/**
	 * View event details
	 * @param int $id
	 */
	public function actionView($id=null) {
		
		$this->pageTitle = Yii::app()->name . ' - View Event Details';
		
		$eventModel = 'HftEvent';
		$model = NActiveRecord::model($eventModel)->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No event exists for ID: ".$id."</strong>");
		
		$viewData = array(
			'model'=>$model,
		);
		
		$this->render('view',array(
			'model'=>$model,
		));
		
	}
	
	/**
	 *	Action to create a new event in the database 
	 */
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - Add a Event';
		$eventModel = 'HftEvent';
		
		$model = new $eventModel;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$eventModel])) {
			$model->attributes = $_POST[$eventModel];
			
			if($model->save()) {
				
				NLog::insertLog('Inserted new event details: '.$model->name.' (id: '.$model->id.')', $model);
				$this->redirect(array("event/view","id"=>$model->id));		
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
		
	}
	
	
	/**
	 *	Action to create a new event in the database 
	 */
	public function actionEdit($id) {
		
		$this->pageTitle = Yii::app()->name . ' - Edit a Event';
		$eventModel = 'HftEvent';
		
		$model = HftEvent::model()->findByPk($id);

		$this->checkModelExists($model, "<strong>No contact exists for ID: ".$id."</strong>");
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$eventModel])) {
			$model->attributes = $_POST[$eventModel];
			
			if($model->save()) {
				
				NLog::insertLog('Updated event details: '.$model->name.' (id: '.$model->id.')', $model);
				$this->redirect(array("event/view","id"=>$model->id));		
				
			}
		}
		
		$this->render('edit',array(
			'model'=>$model,
		));
		
	}
	
	
	public function actionGeneralInfo($id) {

		$model = HftEvent::model()->findByPk($id);
		
		$this->render('view/tabs/general',array(
			'model'=>$model,
		));

	}
	
	/**
	 * @param type $id
	 */
	public function actionAttendees($id) {

		$model = HftEvent::model()->findByPk($id);
		
		if ($model) {
			
			$dataProvider=new NActiveDataProvider("HftEventAttendee",array(
				'criteria'=>array(
					'order'=>'id DESC',
					'condition'=>'event_id = :modelid',
					'params'=>array(':modelid'=>$model->id)
			)));
						
			$fields = array(
				'model'=>$model,
				'id'=>$model->id,
				'dataProvider'=>$dataProvider,
				'attendees'=>null,
			);
			
			$attendees = HftEventAttendee::model()->findAllByAttributes(array('event_id'=>$id));
			if ($attendees)
				$fields['attendees'] = $attendees;
		
			$this->render('view/tabs/attendees',$fields);
		}
	}
	
	public function actionAddAttendee($id) {
		
		$className = 'HftEventAttendee';
		$model = new $className;

		if (isset($_POST[$className])) {
			
			$model->attributes = $_POST[$className];
			
			if ($model->save()) {
				$event = HftEvent::model()->findByPk($id);
				echo CJSON::encode(array('success'=>'Attendee(s) added','id'=>$model->id,'count'=>$event->totalAttendees));
			} else
				$model->validate();
		
		} else {

			$this->render('view/tabs/attendees/_add_attendee',array(
				'id'=>$id,
				'model'=>$model,
			));
		}
	}
	
	public function actionDeleteAttendee() {
		if ($_POST) {
			HftEventAttendee::model()->deleteByPk($_POST['id']);
			$model = HftEvent::model()->findByPk($_POST['modelid']);
			$count = $model->totalAttendees;
			echo CJSON::encode(array('count'=>$count));
		} else {
			return false;
		}
	}
	
	/**
	 * @param type $id
	 */
	public function actionNotes($id) {

		$model = HftEvent::model()->findByPk($id);
		if ($model) {
			$this->render('view/tabs/notes',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}

	/**
	 * @param type $id
	 */
	public function actionAttachments($id) {

		$model = HftEvent::model()->findByPk($id);
		if ($model) {
			$this->render('view/tabs/attachments',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='event')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}