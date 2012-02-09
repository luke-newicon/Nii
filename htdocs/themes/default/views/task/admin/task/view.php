<?php //$model = new TaskTask; ?>
<?php if(!Yii::app()->request->isAjaxRequest) : ?>
	<?php $this->pageTitle = Yii::app()->name . ' - Task: ' . $model->name; ?>
	<div class="page-header">
		<h1><?php echo $model->name ?></h1>
		<div class="action-buttons">
			<a href="<?php echo CHtml::normalizeUrl(array('tasks')) ?>" class="btn">Back to All Tasks</a>
			<?php if(Yii::app()->user->checkAccess('task/admin/editTask')) : ?>
				<a href="<?php echo CHtml::normalizeUrl(array('editTask','id'=>$model->id())) ?>" class="btn primary">Edit</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<fieldset>
	<?php if(!Yii::app()->request->isAjaxRequest) : ?>
		<div class="container pull-left">
	<?php endif; ?>
	<div class="field">
		<?php echo NHtml::activeLabel($model, 'name') ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo CHtml::activeTextField($model, 'name', array('disabled'=>'disabled')); ?>
			</div>
		</div>
	</div>
	<div class="field">
		<?php echo NHtml::activeLabel($model, 'description') ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo CHtml::activeTextArea($model, 'description', array('disabled'=>'disabled')); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo NHtml::activeLabel($model, 'project_id'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo CHtml::activeDropDownList($model, 'project_id', $model->projectList(), array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo NHtml::activeLabel($model, 'customer_id'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo CHtml::activeDropDownList($model, 'customer_id', $model->customerList(), array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo NHtml::activeLabel($model, 'priority') ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo CHtml::activeTextField($model, 'priority', array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo NHtml::activeLabel($model, 'importance') ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo CHtml::activeTextField($model, 'importance', array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo NHtml::activeLabel($model, 'finish_date') ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo CHtml::activeTextField($model, 'finish_date', array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo NHtml::activeLabel($model, 'owner') ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo CHtml::activeTextField($model, 'owner', array('disabled'=>'disabled')); ?>
				</div>
			</div>
		</div>
	</div>
	<?php if(!Yii::app()->request->isAjaxRequest) : ?>
	</div>
	<?php endif; ?>
</fieldset>