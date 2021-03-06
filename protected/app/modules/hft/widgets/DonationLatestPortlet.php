<?php

class DonationLatestPortlet extends NPortlet {

	public $title = '<h3>New Donations</h3>';
	public $limit = 5;
	
	public function __construct() {
		$this->title = NHtml::btnLink('View All',array('/hft/donation'), 'fam-money', array('class'=>'widget-rightlink')) . $this->title;
	}

	protected function renderContent() {
		$donations = HftDonation::model()->findAll(array('limit' => $this->limit, 'order' => 'date_received DESC'));
		if($donations){
			echo '<table class="condensed-table mbn">';
			echo '<thead><tr><th>Donor</th><th>Donation</th><th>Date</th></tr></thead><tbody>';
			foreach ($donations as $donation) {
				echo '<tr><td>'.$donation->getContactLink(null,false).'</td>';
				echo '<td>'.$donation->donationAmountLink.'</td>';
				echo '<td>'. NHtml::formatDate($donation->date_received, 'd-m-y').'</td></tr>';
			}
			echo '</tbody></table>';
		}
	}

}