<div class="page-header"> 
	<h3>Supplier Details</h3>
</div>
<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'add-supplier-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
		));
?>
<p>There are no additional fields for this relation.</p>
<fieldset>
	<div class="actions">
		<a href="#" class="btn">Cancel</a>
		<input type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>