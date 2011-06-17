<?php $display = (!empty($w->address))?'block':'none'; ?>
<div class="field replicate" style="display:<?php echo $display; ?>;">
	<div class="line">
		<div class="unit size23of25 inputBox multiInput">
			<div class="line noHighlight">
				<div class="unit noBorder size1of6 txtC">
					<a id="selectTitle" href="#website" class="btn btnN btnDropDown ui-corner-l-only" style="display:block;border-right:0px;padding:0.52em;">
						<span class="data"><?php echo NData::param($w->label,'&nbsp;'); ?></span>
						<span class="icon fam-bullet-arrow-down" style="float:right;">&nbsp;</span>
					</a>
					<?php echo CHtml::activeHiddenField($w, "[$i]label"); ?>
					<?php echo CHtml::activeHiddenField($w, "[$i]id"); ?>
				</div>
				<div class="lastUnit leftBorderOnly cornerLeftOff">
					<div class="inputBox">
						<?php echo CHtml::activeTextField($w, "[$i]address",array('class'=>'input')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="lastUnit" style="padding-top:6px;"><a href="#" class="icon ni-minus  removeRow showTipLive" title="Remove"></a></div>
	</div>
	<span class="formGuide"></span>
</div>