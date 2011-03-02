<?php $this->breadcrumbs=array($this->module->id); ?>

<h1>Support</h1>
<style>
	.listItem{border-bottom:1px solid #ECECEC;padding:5px;}
	.listItem .body{overflow:hidden;height:30px;}
	.listItem .from{font-weight:bold;font-size:15px;}
	.faded{color:#787878;}
	.leftPanel{border-right:1px solid #ccc;}
</style>
<div class="line">
	<div class="unit size1of6 leftPanel">
		<?php foreach($tickets as $i=>$ticket): ?>
			<div class="listItem line">
				<div class="line">
					<div class="unit size3of4 from">
						<?php echo $ticket->getFrom(); ?>
					</div>
					<div class="lastUnit">2:34 <span class="faded">PM</span></div>
				</div>
				<div class="line subject">
					<?php echo $ticket->subject .'<br/>' ?>
				</div>
				<div class="line body faded">
					<?php echo $ticket->subject .'<br/>' ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="lastUnit"></div>
</div>
