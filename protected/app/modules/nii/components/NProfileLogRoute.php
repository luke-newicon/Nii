<?php
/**
 * CProfileLogRoute class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * NProfileLogRoute displays the profiling results in firePHP
 *
 * The profiling is done by calling {@link YiiBase::beginProfile()} and {@link YiiBase::endProfile()},
 * which marks the begin and end of a code block.
 *
 * CProfileLogRoute supports two types of report by setting the {@link setReport report} property:
 * <ul>
 * <li>summary: list the execution time of every marked code block</li>
 * <li>callstack: list the mark code blocks in a hierarchical view reflecting their calling sequence.</li>
 * </ul>
 *
 * @author Steven O'Brien, Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CProfileLogRoute.php 3204 2011-05-05 21:36:32Z alexander.makarow $
 * @package system.logging
 * @since 1.0
 */
class NProfileLogRoute extends CProfileLogRoute
{
	
	
	/**
	 * Displays the log messages.
	 * @param array $logs list of log messages
	 */
	public function processLogs($logs)
	{
		$app=Yii::app();
		if(!($app instanceof CWebApplication))
			return;

		if($this->getReport()==='summary')
			$this->displaySummary($logs);
		else
			$this->displayCallstack($logs);
	}
	
	/**
	 * Displays the summary report of the profiling result.
	 * @param array $logs list of logs
	 */
	protected function displaySummary($logs)
	{
		$stack=array();
		foreach($logs as $log)
		{
			if($log[1]!==CLogger::LEVEL_PROFILE)
				continue;
			$message=$log[0];
			if(!strncasecmp($message,'begin:',6))
			{
				$log[0]=substr($message,6);
				$stack[]=$log;
			}
			else if(!strncasecmp($message,'end:',4))
			{
				$token=substr($message,4);
				if(($last=array_pop($stack))!==null && $last[0]===$token)
				{
					$delta=$log[3]-$last[3];
					if(!$this->groupByToken)
						$token=$log[2];
					if(isset($results[$token]))
						$results[$token]=$this->aggregateResult($results[$token],$delta);
					else
						$results[$token]=array($token,1,$delta,$delta,$delta);
				}
				else
					throw new CException(Yii::t('yii','CProfileLogRoute found a mismatching code block "{token}". Make sure the calls to Yii::beginProfile() and Yii::endProfile() be properly nested.',
						array('{token}'=>$token)));
			}
		}

		$now=microtime(true);
		while(($last=array_pop($stack))!==null)
		{
			$delta=$now-$last[3];
			$token=$this->groupByToken ? $last[0] : $last[2];
			if(isset($results[$token]))
				$results[$token]=$this->aggregateResult($results[$token],$delta);
			else
				$results[$token]=array($token,1,$delta,$delta,$delta);
		}

		$entries=array_values($results);
		$func=create_function('$a,$b','return $a[4]<$b[4]?1:0;');
		usort($entries,$func);

		$table   = array();
		$table[] = array('count','total', 'average', 'min', 'max');
		$totalTime = 0;$noQs=0;
		foreach($entries as $index=>$entry){
			$proc=CJavaScript::quote($entry[0]);
			$count=sprintf('%5d',$entry[1]);
			$min=sprintf('%0.5f',$entry[2]);
			$max=sprintf('%0.5f',$entry[3]);
			$total=sprintf('%0.5f',$entry[4]);
			$average=sprintf('%0.5f',$entry[4]/$entry[1]);
			$table[] = array($count, $total, $average, $min, $max, $proc);
			$totalTime += $total;
			$noQs += $count;
		}
		// $totalExecutiontime for the app = Yii::getLogger()->getExecutionTime()
		$pTitle = "Profiling Summary Report ($noQs Queries, Time: " 
			. sprintf('%0.5f',$totalTime) . "s," 
            . " Memory: " . number_format(Yii::getLogger()->getMemoryUsage()/1024) . "KB)";

		FB::table($pTitle, $table);
		
	}

}