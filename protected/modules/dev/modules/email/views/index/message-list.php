<?php
/**
 * Displays the list of of messages
 */
?>
<?php $dataPos = ($offset*$limit); ?>
<div class="mesageContainer" data-offset="<?php echo $offset; ?>" style="position:absolute;top:<?php echo ($dataPos*86); ?>px;">
<?php foreach($emails as $i => $email): ?>
	<?php $dataPos = $i + ($offset*$limit); ?>
	<?php $this->renderPartial('_message-list-item', array('email'=>$email,'dataPos'=>$dataPos)); ?>
<?php endforeach; ?>
</div>