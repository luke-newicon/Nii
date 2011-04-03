<?php
$this->pageTitle = 'Domains - ' . Yii::app()->name;
$this->breadcrumbs = array(
	'Hosting' => array('/'),
	'Domains',
);
?>
<h1>Domains</h1>

<?php
$form = $this->beginWidget('CActiveForm', array(
			'id' => 'domain-lookup-form',
			'enableAjaxValidation' => true,
		));
?>
<?php echo $form->textField($model, 'domain'); ?>
<?php echo $form->error($model, 'domain'); ?>

<?php echo CHtml::submitButton('Lookup Domain'); ?>

<?php $this->endWidget(); ?>

<?php if ($results) : ?>
	<table class="data">
		<thead>
			<tr>
				<th>Domain</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<?php //print_r($results); ?>
		<?php foreach ($results as $result) : ?>
			<tr>
				<td><?php echo $result->domain; ?></td>
				<td><?php echo $result->status; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>