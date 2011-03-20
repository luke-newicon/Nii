<?php
$this->breadcrumbs = array(
    'Projects' => array('index/index'),
    $model->project->name => array('index/view', 'id' => $model->project->id),
    $model->name,
);

$this->menu = array(
    array('label' => 'Task',
	'items' => array(
	    array('label' => 'Create', 'url' => array('create', 'projectId' => $model->project_id)),
	    array('label' => 'Update', 'url' => array('update', 'id' => $model->id)),
	    array('label' => 'Delete', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    )),
    array('label' => 'Time Record',
	'items' => array(
	    array('label' => 'Create', 'url' => array('timeRecord/create', 'issueId' => $model->id)),
    )),
);
?>


<h1><?php echo $model->name; ?></h1>

<?php
//Created by column
$createdUser = $model->createdByUserName->username;

//Assigned user column
$assignedUser = ' ';
if ($model->assigned_user)
    $assignedUser = $model->assignedToUser->username;

$sprint_name = null;
if (isset($model->sprint->name))
    $sprint_name = $model->sprint->name;

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
	'id',
	array('label' => 'Type', 'value' => $model->getType()),
	'description',
	array('label' => 'Project', 'value' => $model->project->name),
	'created',
	array('label' => 'Created By', 'value' => $createdUser),
	'estimated_time',
	array('value' => $model->getRecordedTime(), 'label' => 'Total Recorded Time'),
	array('name' => 'out_of_scope', 'value' => $model->outOfScopeCol()),
	array('label' => 'Assigned User', 'value' => $assignedUser),
	array('label' => 'Sprint', 'value' => $sprint_name),
    ),
));
?>
<?php if(count($taskTimeOverview)>0):?>
<h2>Time Overview</h2>
<table>
    <?php foreach ($taskTimeOverview as $tests): ?>
        <tr>
    	<td><?php echo $tests->name ?></td><td style="text-align:right;"> <?php echo$tests->recorded_time ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif;?>
    <h2>Time Record</h2>
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider' => $ProjectTimeRecord->search($model->id),
	    'filter' => $ProjectTimeRecord,
	    'columns' => array(
		'id',
		array('name' => 'added_by', 'value' => '$data->addedByUser->username'),
		'description',
		array('name' => 'type', 'value' => '$data->typeInfo->name', 'filter' => $ProjectTimeRecord->getTypes(false)),
		'time_started',
		array('name' => 'time_finished', 'value' => '$data->time_finished'),
		array('name' => 'recorded_time'),
		array('class' => 'CButtonColumn', 'template' => '{update}{delete}', 'updateButtonUrl' => '"project/TimeRecord/update/id/".$data->id'),
	    )
	)); ?>

