<script type="text/javascript">
/*<![CDATA[*/
if(typeof(console)=='object')
{
	<?php 
		$pTitle = "Profiling Summary Report (Time: " 
			. sprintf('%0.5f',Yii::getLogger()->getExecutionTime()) . "s," 
			. "Memory: " . number_format(Yii::getLogger()->getMemoryUsage()/1024) . "KB)";
	?>
	console.group("<?php echo $pTitle; ?>");
		
	console.log(" count   total   average    min      max   ");
<?php
foreach($data as $index=>$entry)
{
	$proc=CJavaScript::quote($entry[0]);
	$count=sprintf('%5d',$entry[1]);
	$min=sprintf('%0.5f',$entry[2]);
	$max=sprintf('%0.5f',$entry[3]);
	$total=sprintf('%0.5f',$entry[4]);
	$average=sprintf('%0.5f',$entry[4]/$entry[1]);
	echo "\tconsole.log(\" $count  $total  $average  $min  $max    {$proc}\");\n";
}
?>
	console.groupEnd();
}
/*]]>*/
</script>
