<ul>
	<?php foreach($invoices as $in) : ?>
	<li><a href="<?php echo NHtml::url(array('account/index/invoice', 'id'=>$in->id)); ?>">Invoice #<?php echo $in->invoice_number;	?>: &pound;<?php echo NData::penceToPounds($in->total_in_cents); ?> on <?php echo NTime::nice($in->date, 'd/m/Y'); ?> </a></li>
	<?php endforeach; ?>
</ul> 



