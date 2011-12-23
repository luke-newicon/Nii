<?php

class ContactLatestPortlet extends NPortlet {
	
	public $title = '<h3>New Contacts</h3>';
	public $limit = 10;
//	public $contentCssClass='portlet-body h250 overflow-scroll mbs';

	protected function renderContent() {
		$contacts = Contact::model()->findAll(array('limit' => $this->limit, 'order'=>'id DESC'));
		if($contacts){
			echo '<table class="condensed-table mbn">';
			echo '<thead><tr><th>Contact</th></tr></thead><tbody>';
			foreach ($contacts as $contact) {
				echo '<tr>';
				echo '<td>'.$contact->contactLink.'</td>';
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
	}
}