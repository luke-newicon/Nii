<div class="line">
	<div class="unit gMail">
		<?php if(Yii::app()->getModule('user')->useCrm):?>
			<?php $this->widget('crm.components.CrmCard',array('contact'=>$u->contact,'size'=>50)); ?>
		<?php endif;?>
	</div>
	<div class="lastUnit">
		<h2>Your Feed!</h2>
	</div>
</div>
