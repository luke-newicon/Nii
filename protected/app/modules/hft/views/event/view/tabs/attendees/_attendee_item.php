<div class="line attendee_list-item attendee_<?php echo $data->id?>" data-attendee-id="<?php echo $data->id; ?>">
	<div class="unit profilePic prm"><?php echo $data->contactProfileImage;?></div>
	<div class="lastUnit">
		<?php echo CHtml::link('<span class="icon fam-delete"></span>','#',
			array(
				'id'=>'attendee-delete-'.$data->id,
				'class'=>'attendee_list_delete_button',
				'style'=>'float:right;',
			)
		);?>
		<span class="attendee_list-name"><?php echo $data->attendeeNameLink; ?></span>
		<?php if ($data->additional_attendees > 0) { ?>
			<span class="attendee_list-guests">+ <?php echo $data->additional_attendees; ?> guest<?php echo $data->additional_attendees==1?'':'s'; ?></span>
		<?php } ?>
	</div>
</div>