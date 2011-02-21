<div class="pageTitle">
	<h1>Kashflow</h1>
</div>
<div class="tabs wp-tabs">
	<div class="hd">
		<ul class="tabControl">
			<li><a href="<?php echo NHtml::url('/') ?>"><span>Overview</span></a></li>
			<li class="current"><a href="<?php echo NHtml::url('customers/index') ?>"><span>Customers</span></a></li>
			<li><a href="<?php echo NHtml::url('invoices/index') ?>"><span>Invoices</span></a></li>
			<li><a href="<?php echo NHtml::url('quotes/index') ?>"><span>Quotes</span></a></li>
			<li><a href="<?php echo NHtml::url('suppliers/index') ?>"><span>Suppliers</span></a></li>
			<li><a href="<?php echo NHtml::url('receipts/index') ?>"><span>Receipts</span></a></li>
		</ul>
	</div>
	<div class="bd">
		<ul>
			<li class="current">
				<table class="data">
					<tbody>
					<?php foreach($customers as $customer) : ?>
						<tr>
							<td><?php echo $customer->CustomerID; ?></td>
							<td><?php echo $customer->Name; ?></td>
							<td><?php echo $customer->Created; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</li>
		</ul>
	</div>
</div>

