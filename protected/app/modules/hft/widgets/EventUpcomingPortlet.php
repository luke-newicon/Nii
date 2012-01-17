<?php

class EventUpcomingPortlet extends NPortlet {

	public $title = '<h3>Upcoming Events</h3>';
	public $limit = 10;
	
	public function __construct() {
		$this->title = NHtml::btnLink('View All',array('/hft/event'), 'fam-calendar', array('class'=>'widget-rightlink')) . $this->title;
	}
	
	protected function renderContent() {
		$events = HftEvent::model()->findAll(array('condition'=>'start_date >= CURDATE()','limit' => $this->limit, 'order'=>'start_date ASC'));
		if($events){
			echo '<table class="condensed-table mbn">';
			echo '<thead><tr><th>Event</th><th>Date</th></tr></thead><tbody>';
			foreach ($events as $event) {
				echo '<tr>';
				echo '<td>'.$event->getNameLink(null,true).'</td>';
				echo '<td>'. NHtml::formatDate($event->start_date, 'd-m-y').'</td>';
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
	}

}