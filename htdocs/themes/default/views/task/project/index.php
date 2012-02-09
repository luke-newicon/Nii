<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
?>

<div class="page-header">
	<h1><span style="color:#ccc;">Project:</span> <?php echo $project->name; ?></h1>
	<div class="action-buttons">
		<a href="<?php echo CHtml::normalizeUrl(array('/task/admin/projects')) ?>" class="btn">Back to All Projects</a>
		<a href="#" class="btn" >Team View</a>
		<a href="#" class="btn" >Client View</a>
	</div>
</div>

<div class="row">
	<div class="span2">
		<p class="hint">Manager:</p>
		<!-- widgetise into contact card thingyum -->
		<ul class="media-grid">
			<li><a href="#" title="Luke Spencer" data-content="Contact details?" rel="popover" id="spencagay" style="padding:3px;"><?php $this->widget('nii.widgets.Gravatar',array('email'=>'luke.spencer@newicon.net', 'size'=>25)); ?></a></li>
		</ul>
		<!-- fin -->
	</div>
	<div class="span3">
		<p class="hint">Members:</p>
		<ul class="media-grid">
			<li><a id="dandecock" href="#" title="Dan De Luca" data-content="Contact details?" rel="popover" style="padding:3px;" ><?php $this->widget('nii.widgets.Gravatar',array('email'=>'dan.deluca@newicon.net', 'size'=>25)); ?></a></li>
			<li><a id="robinwill" href="#" title="Robin Williams" data-content="Contact details?" rel="popover" style="padding:3px;"><?php $this->widget('nii.widgets.Gravatar',array('email'=>'robin.williams@newicon.net', 'size'=>25)); ?></a></li>
		</ul>
	</div>
	<div class="span3">
		<p class="hint">Shared:</p>
		<ul class="media-grid">
			<li><a id="steveo" href="#" title="Steve O'Brien" data-content="Contact details?" rel="popover" style="padding:3px;" ><?php $this->widget('nii.widgets.Gravatar',array('email'=>'steve@newicon.net', 'size'=>25)); ?></a></li>
		</ul>
	</div>
</div>
<script>
	$(function(){
		$('#spencagay').popover();
		$('#dandecock').popover();
		$('#robinwill').popover();
		$('#steveo').popover();
	});
</script>
<?php
$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'id' => 'TaskTabs',
	'items' => array(
		array('label'=>'Dashboard', 'url'=>'#mytasks', 'active' => true),
		array('label'=>'Messages', 'url'=>'#mytasks'),
		array('label'=>'Meetings', 'url'=>'#mytasks'),
		array('label'=>'To-Dos', 'url'=>'#grouptasks'),
		array('label'=>'Calendar', 'url'=>'#grouptasks'),
		array('label'=>'white borard', 'url'=>'#grouptasks'),
		array('label'=>'Files', 'url'=>'#grouptasks'),
	),
//	'htmlOptions' => array('class' => 'tabs vertical'),
//	'heading' => 'Developer Tools',
));
?>

<div class="alert-message block-message info">
	<a href="#" class="close">×</a>
	<h3>Welcome to your new project</h3>

	<p>This Overview screen will show you the latest activity in your project. But before we can show you activity, you'll need to get the project started.</p>

	<ul>
		<li><a href="#">Post the first message</a></li>
		<li><a href="#">Create the first to-do list</a></li>
		<li><a href="#">Add an event to the calendar</a></li>
		<li><a href="#">Upload the first file</a></li>
	</ul>

	<div class="alert-actions">
	  <a href="#" class="btn small">Take this action</a> <a href="#" class="btn small">Or do this</a>
	</div>
</div>

<!-- script to move into footer or generic startup script -->
<script>

$(function(){
	$(".alert-message").alert();
})
</script>