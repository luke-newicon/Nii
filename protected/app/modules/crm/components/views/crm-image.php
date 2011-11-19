<div class="crm-image" style="position:relative;">
	<?php if ($this->edit): ?>
	<div class="crm-image-link" style="height:<?php echo $this->size; ?>px;border:1px solid #ddd;position:absolute;display:none;background-color:#fff;opacity:0.8;">
		<p style="padding-top:<?php echo $this->size/2-25; ?>px;" class="txtC">Change Image</p>
	</div>
	<script>
		jQuery(function($){
			$('.crm-image').hover(function(){
				$(this).find('.crm-image-link').show();
			},function(){
				$(this).find('.crm-image-link').hide();
			});
			$('.crm-image-link').click(function(){
				alert('show popup');
			});
		});
		
	</script>
	<?php endif; ?>
<?php echo $img; ?>
</div>

