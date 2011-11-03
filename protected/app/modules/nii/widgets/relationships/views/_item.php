<div class="line widget_item relationship_item relationship_<?php echo $data->id; ?>" data-relationship-id="<?php echo $data->id; ?>">
	<div class="unit size1of4">
		<?php echo Contact::model()->getContactLinkById($data->contact_id);?>
	</div>
	<div class="lastUnit" style="vertical-align: middle;">
		<?php echo CHtml::link('<span class="icon fam-delete"></span>','#',
				array(
					'id'=>'relationship-delete-'.$data->id,
					'class'=>'relationship_delete_button',
					'style'=>'float:right;',
				)
			);?>
		<?php echo $data->label ?>
	</div>
</div>