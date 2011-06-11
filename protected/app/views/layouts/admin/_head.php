<div class="head">
	<div class="bigHead">
		<div class="mainMenu">
			<?php
			$items = array(
				array('label' => CHtml::image(Yii::app()->baseUrl . '/images/house.png', 'Dashboard'), 'url' => array('/user/dashboard')),
			);
			$items = CMap::mergeArray($items, NWebModule::$items);
			$this->widget('zii.widgets.CMenu', array('items' => $items, 'encodeLabel' => false));
			?>
			<script>
							var menuWidth = jQuery('.mainMenu li').size();
							jQuery(function($){
								$('.mainMenu ul').hover(
									function(){
										$('.mainMenu ul').css('width',menuWidth*56);
									},
									function(){
										$('.mainMenu ul').css('width',56);
									});
							});
			</script>
		</div>
		<div class="loginMenu">
			<?php $this->widget('user.widgets.NLoginInfo'); ?>
		</div>
	</div>
</div>