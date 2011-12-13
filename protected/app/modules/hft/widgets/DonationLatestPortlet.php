<?php

class DonationLatestPortlet extends NPortlet {

	public $title = '<h3>New Donations</h3>';
	public $limit = 10;

	protected function renderContent() {
		$donations = HftDonation::model()->findAll(array('limit' => $this->limit));
		if($donations){
			echo '<table class="condensed-table mbn">';
			echo '<thead><tr><th>Donator</th><th>Donation</th></tr></thead><tbody>';
			foreach ($donations as $donation) {
				echo '<tr><td>'.$donation->getContactLink(null,true).'</td>';
				echo '<td>'.$donation->donationAmountLink.'</td></tr>';
			}
			echo '</tbody></table>';
		}
	}

}