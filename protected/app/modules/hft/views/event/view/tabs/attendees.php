<h3>Attendees<?php echo NHtml::link('','#',
	array(
		'class'=>'icon fam-add',
		'style' => 'position: relative; height: 16px; line-height: 16px; display: inline-block; margin-left: 8px; top: 3px;',
		'onclick'=>$model->addAttendee(),
	)); ?></h3>
<?php
if ($attendees) { ?>
	<ul>
	<?php foreach ($attendees as $a) { ?>
		<li><span class="attendee_list-name"><?php echo $a->attendeeNameLink; ?></span><span class="attendee_list-guests"><?php echo $a->additional_attendees; ?> guest<?php echo $a->additional_attendees==1?'':'s'; ?></span></li>
	<?php } ?>
	</ul>
<?php 
} else {
	echo '<span class="noData">No attendees have been listed against this event</span>';
}