<?php $this->breadcrumbs=array($this->module->id); ?>

<h1>Support</h1>
<style>
	
</style>
<div class="line">
	<div class="unit size1of6">
		<?php foreach($tickets as $i=>$ticket): ?>
			<?php echo $ticket->subject .'<br/>'?>
		<?php endforeach; ?>
	</div>
	<div class="lastUnit"></div>
</div>
