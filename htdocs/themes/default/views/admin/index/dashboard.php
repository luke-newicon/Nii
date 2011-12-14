<?php
/*$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'items' => array(
		array('label'=>'Home', 'url'=>'#', 'active' => true),
		array('label'=>'Tab 1', 'url'=>'#'),
		array('label'=>'Tab 2', 'url'=>'#'),
		array('label'=>'Tab 3', 'url'=>'#'),
	),
	'heading' => 'Dashboard',
));*/ ?>
<div class="page-header">
	<h1>Dashboard</h1>
</div>
<div class="row">
<!--	<div class="span9">
		<?php // $this->widget('hft.widgets.GoogleBugsPortlet'); ?>
	</div>-->
	<div class="span8">
		<?php $this->widget('contact.widgets.ContactLatestPortlet'); ?>
	</div>
	<div class="span8">
		<?php $this->widget('hft.widgets.EventUpcomingPortlet'); ?>
	</div>
	<div class="span8">
		<?php $this->widget('hft.widgets.DonationLatestPortlet'); ?>
	</div>
</div>