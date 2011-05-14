<div class="field replicate">
	<div class="line">
		<div class="unit size23of25 inputBox multiInput">
			<div class="line noHighlight">
				<div class="unit size1of6 noBorder txtC">
					<a id="selectTitle" href="#phone" class="btn btnN btnDropDown ui-corner-l-only" style="display:block;border-right:0px;padding:0.52em;"><?php echo NData::param($p->label,'&nbsp;'); ?></a>
					<?php echo CHtml::activeHiddenField($p, "[$i]label"); ?>
					<?php echo CHtml::activeHiddenField($p, "[$i]id"); ?>
				</div>
				<div class="lastUnit leftBorderOnly cornerLeftOff">
					<div class="inputBox">
						<?php echo CHtml::activeTextField($p, "[$i]number",array('class'=>'input')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="lastUnit" style="padding-top:6px;"><a href="#" class="icon ni-minus  removeRow showTipLive" title="Remove"></a></div>
	</div>
</div>