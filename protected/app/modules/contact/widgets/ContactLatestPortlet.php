<?php

class ContactLatestPortlet extends NPortlet {
	
	public $title = '<h3>New Contacts</h3>';
	public $limit = 10;
//	public $contentCssClass='portlet-body h250 overflow-scroll mbs';
	
	public function __construct() {
		$this->title = NHtml::link('View All',array('/contact/admin'),array('class'=>'widget-rightlink')) . $this->title;
	}
	
	protected function renderContent() {
		$contacts = Contact::model()->findAll(array('limit' => $this->limit, 'order'=>'id DESC'));
		if($contacts){
			echo '<table class="condensed-table mbn">';			
//			echo '<thead><tr><th>Contact</th></tr></thead><tbody>';
			echo '<tbody>';
			$count=0;
			foreach ($contacts as $contact) {
				echo '<tr'.($count==0?' class="first"' : '').'>';
				echo '<td>'.$contact->contactLink.'</td>';
				echo '</tr>';
				$count++;
			}
			echo '</tbody></table>';
		}
	}
}