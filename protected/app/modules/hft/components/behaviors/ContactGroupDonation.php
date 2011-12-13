<?php
/**
 * ContactGroupDonation class file.
 *
 *	Adds donation functions to contact group
 *
 * @author Robin Williams <robin.williams@newicon.net>
 *
 * @version 0.1
 */
class ContactGroupDonation extends CActiveRecordBehavior {
	
	public function recentDonations() {
		
		return new CDbCriteria(
			array('condition'=>'(SELECT COUNT(rd.id) FROM hft_donation rd WHERE rd.date_received >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH) AND rd.contact_id = t.id) > 0')
		);
	}

	public function majorDonations() {
		
		return new CDbCriteria(
			array('condition'=>'(SELECT COUNT(rd.id) FROM hft_donation rd WHERE rd.donation_amount >= 2000 AND rd.contact_id = t.id) > 0')
		);
	}
	
}