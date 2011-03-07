<div class="pageTitle">
	<h1>Kashflow</h1>
</div>
<div class="tabs wp-tabs">
	<div class="hd">
		<ul class="tabControl">
			<li><a href="<?php echo NHtml::url('/kashflow') ?>"><span>Overview</span></a></li>
			<li><a href="<?php echo NHtml::url('/kashflow/customers') ?>"><span>Customers</span></a></li>
			<li><a href="<?php echo NHtml::url('/kashflow/invoices') ?>"><span>Invoices</span></a></li>
			<li class="current"><a href="<?php echo NHtml::url('/kashflow/quotes') ?>"><span>Quotes</span></a></li>
			<li><a href="<?php echo NHtml::url('/kashflow/suppliers') ?>"><span>Suppliers</span></a></li>
			<li><a href="<?php echo NHtml::url('/kashflow/receipts') ?>"><span>Receipts</span></a></li>
		</ul>
	</div>
	<div class="bd">
		<ul>
			<li class="current">
				<table class="data">
					<tbody>
					<?php foreach($quotes as $quote) : ?>
						<tr>
							<td><?php echo $quote->InvoiceNumber; ?></td>
							<td><?php echo $quote->CustomerName; ?></td>
							<td><?php echo $quote->InvoiceDate; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</li>
		</ul>
	</div>
</div>

