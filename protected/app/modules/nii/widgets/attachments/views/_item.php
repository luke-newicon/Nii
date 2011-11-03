<div class="line widget_item attachment_item attachment_<?php echo $data->id; ?>" data-attachment-id="<?php echo $data->id; ?>">
	<div class="unit size2of5">
		<?php echo $data->downloadLink ?>
	</div>
	<div class="lastUnit">
		<?php echo CHtml::link('<span class="icon fam-delete"></span>','#',
				array(
					'id'=>'attachment-delete-'.$data->id,
					'class'=>'attachment_delete_button',
					'style'=>'float:right;',
				)
			);?>
		<?php echo $data->description ?>
	</div>
</div>