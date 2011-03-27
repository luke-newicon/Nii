<?php if (count($taskTimeOverview) > 0): ?>

<h2 style="text-align: center;">Time Overview</h2>
<div class="time_stats">
    <table>
    <?php foreach ($taskTimeOverview as $tests): ?>
        <tr>
    	<td class="label"><?php echo $tests->name ?></td>
	<td class="value"> <?php echo$tests->recorded_time ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>