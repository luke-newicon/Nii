
<h4>Billing Information (<a id="changeBillingInfo" href="#">change</a>)</h4>
<style>
	.data.billing table {border:0px;font-family: arial;}
	.data.billing table td,.data.billing table th{padding:5px;border:0px;}
	.data.billing table th{color:#999;width:100px;}
</style>
<div class="line">
	<div class="unit size1of2">
		<div class="data billing">
			<table>
				<tr>
					<th>Card Name:</th>
					<td><?php echo $billing->first_name; ?> <?php echo $billing->last_name; ?></td>
				</tr>
				<tr>
					<th>Card Type:</th>
					<td>
						<div class="unit">
							<div class="sprite <?php echo $billing->getCardTypeImageClass(); ?>">&nbsp;</div>
						</div>
						<div class="lastUnit">
							<span class="plm"><?php echo ($billing->card_type) ? $billing->card_type : '<span class="hint">unknown</span>'; ?></span>
						</div>
					</td>
				</tr>
				<tr>
					<th>Card Number:</th>
					<td>
						<span>************<strong><?php echo $billing->card_last_four; ?></strong></span>
					</td>
				</tr>
				<tr>
					<th>Card Expiry:</th>
					<td><?php echo date('m',mktime(0,0,0,$billing->card_expires_month)); ?> / <?php echo $billing->card_expires_year; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="lastUnit">
		<div class="data billing">
			<table>
				<tr>
					<th style="width:75px;">Billing Address:</th>
					<td>
						<address>
							<?php echo $billing->address1; ?><br />
							<?php echo $billing->address2; ?><br />
							<?php echo $billing->city; ?><br />
							<?php echo $billing->zip; ?><br />
							<?php echo ($billing->state)?$billing->state.'<br />':''; ?>
							<?php echo $billing->getCountryName(); ?><br />
						</address>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>


<hr class="mln mrn" />


<h4>Next Payment</h4>
<div class="line">
	<div class="unit size1of2">
		<?php if ($billing->current_period_ends_at) : ?>
			Next Payment: <?php echo date('d M, y',$billing->current_period_ends_at); ?>
		<?php endif; ?>
	</div>
	<div class="lastUnit">
		Invoices are sent to <?php echo Yii::app()->user->email; ?>
	</div>
</div>

<hr class="mln mrn" />

<h4>Billing History</h4>
<?php $this->renderPartial('_billing-history',array('invoices'=>$invoices)); ?>