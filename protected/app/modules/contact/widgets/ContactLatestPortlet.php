<?php

class ContactLatestPortlet extends NPortlet {
	
	public $title = '<h3>New Contacts</h3>';
	public $limit = 10;

	protected function renderContent() {
		$contacts = Contact::model()->findAll(array('limit' => $this->limit));
		if($contacts){
			echo '<table class="condensed-table mbn">';
			echo '<thead><tr><th>Contact</th></tr></thead><tbody>';
			foreach ($contacts as $contact) {
				echo '<tr><td>'.$contact->contactLink.'</td>';
			}
			echo '</tbody></table>';
		}
	}
}