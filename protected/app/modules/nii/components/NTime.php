<?php
class NTime {
	/**
	* Returns a nicely formatted date string for given Datetime string.
	*
	* @param string $dateString Datetime string
	* @param int $format Format of returned date
	* @return string Formatted date string
	*/
	public static function nice($dateString = null, $format = 'D, M jS Y, H:i') {

		return date($format, self::getUnix($dateString));
	}
	
	/**
	 * Takes a string or timestamp and returns a unix timestamp
	 * if $dateVarient is empty return the current time
	 * @param varient $dateVarient
	 * @return int unix timestamp
	 */
	public static function getUnix($dateVarient=null){
		if($dateVarient === null)
			return time();
		return is_string($dateVarient) ? strtotime($dateVarient) : $dateVarient;
	}
	
	/**
	* Returns a formatted descriptive date string for given datetime string.
	*
	* If the given date is today, the returned string could be "Today, 6:54 pm".
	* If the given date was yesterday, the returned string could be "Yesterday, 6:54 pm".
	* If $dateString's year is the current year, the returned string does not
	* include mention of the year.
	*
	* @param string $dateString Datetime string or Unix timestamp
	* @return string Described, relative date string
	*/
	public static function niceShort($dateString = null) {
		
		$date = self::getUnix($dateString);
		
		$y = (self::isThisYear($date)) ? '' : ' Y';

		if (self::isToday($date)) {
			$ret = sprintf('Today, %s', date("g:i a", $date));
		} elseif (self::wasYesterday($date)) {
			$ret = sprintf('Yesterday, %s', date("g:i a", $date));
		} else {
			$ret = date("M jS{$y}", $date);
		}

		return $ret;
	}
	
	
	/**
	 * Returns a formatted descriptive date string for given datetime string.
	 * 
	 * If the given date is today the returned string will be like: "2:34 pm"
	 * If the given date is yesterday then the returned string will just state: "Yesterday"
	 * If the given date is laster than yesterday it will just show a date like: 13/02/2010
	 * 
	 * @param string $dateString
	 * @return string 
	 */
	public static function niceShorter($dateString = null, $class='faded'){
		$date = self::getUnix($dateString);
		$y = (self::isThisYear($date)) ? '' : ' Y';
		if (self::isToday($date)) {
			$ret = sprintf('<span class="time">%s</span> <span class="'.$class.'">%s</span>', date("g:i", $date), date("A", $date));
		} elseif (self::wasYesterday($date)) {
			$ret = '<span class="'.$class.'">Yesterday</span>';
		} else {
			$ret = '<span class="'.$class.'">'.date("d/m/y", $date).'</span>';
		}
		return $ret;
	}
	
	/**
	* Returns true if given date is today.
	*
	* @param string $date Unix timestamp
	* @return boolean True if date is today
	*/
	public static function isToday($date) {
		return date('Y-m-d', $date) == date('Y-m-d', time());
	}
	
	/**
	* Returns true if given date was yesterday
	*
	* @param string $date Unix timestamp
	* @return boolean True if date was yesterday
	*/
	public static function wasYesterday($date) {
		return date('Y-m-d', $date) == date('Y-m-d', strtotime('yesterday'));
	}
	
	/**
	* Returns true if given date is in this year
	*
	* @param string $date Unix timestamp
	* @return boolean True if date is in this year
	*/
	public static function isThisYear($date) {
		return date('Y', $date) == date('Y', time());
	}
	
	/**
	* Returns true if given date is in this week
	*
	* @param string $date Unix timestamp
	* @return boolean True if date is in this week
	*/
	public static function isThisWeek($date) {
		return date('W Y', $date) == date('W Y', time());
	}
	
	/**
	* Returns true if given date is in this month
	*
	* @param string $date Unix timestamp
	* @return boolean True if date is in this month
	*/
	public static function isThisMonth($date) {
		return date('m Y',$date) == date('m Y', time());
	}
	
	
	
	/**
	* Returns either a relative date or a formatted date depending
	* on the difference between the current time and given datetime.
	* $datetime should be in a <i>strtotime</i>-parsable format, like MySQL's datetime datatype.
	*
	* Options:
	*  'format' => a fall back format if the relative time is longer than the duration specified by end
	*  'end' =>  The end of relative time telling
	*
	* Relative dates look something like this:
	*	3 weeks, 4 days ago
	*	15 seconds ago
	* Formatted dates look like this:
	*	on 02/18/2004
	*
	* The returned string includes 'ago' or 'on' and assumes you'll properly add a word
	* like 'Posted ' before the function output.
	*
	* @param string $dateString Datetime string or unix timestamp
	* @param array $options Default format if timestamp is used in $dateString
	* @return string Relative time string.
	*/
	public static function timeAgoInWordsShort($dateString, $options = array()) {
		$now = time();

		$inSeconds = self::getUnix($dateString);
		
		$backwards = ($inSeconds > $now);

		$format = 'j/n/y';
		$end = '+1 month';

		if (is_array($options)) {
			if (isset($options['format'])) {
				$format = $options['format'];
				unset($options['format']);
			}
			if (isset($options['end'])) {
				$end = $options['end'];
				unset($options['end']);
			}
		} else {
			$format = $options;
		}

		if ($backwards) {
			$futureTime = $inSeconds;
			$pastTime = $now;
		} else {
			$futureTime = $now;
			$pastTime = $inSeconds;
		}
		$diff = $futureTime - $pastTime;

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			$current = array();
			$date = array();

			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
			$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

			if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
				$months = 0;
				$years = 0;
			} else {
				if ($future['Y'] == $past['Y']) {
					$months = $future['m'] - $past['m'];
				} else {
					$years = $future['Y'] - $past['Y'];
					$months = $future['m'] + ((12 * $years) - $past['m']);

					if ($months >= 12) {
						$years = floor($months / 12);
						$months = $months - ($years * 12);
					}

					if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
						$years --;
					}
				}
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $pastTime);
				$daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

				if (!$backwards) {
					$days = ($daysInPastMonth - $past['d']) + $future['d'];
				} else {
					$days = ($daysInFutureMonth - $past['d']) + $future['d'];
				}

				if ($future['m'] != $past['m']) {
					$months --;
				}
			}

			if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years --;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$years = $months = $weeks = 0;
			$days = floor($diff / 86400);

			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);
			$seconds = $diff;
		}
		$relativeDate = '';
		$diff = $futureTime - $pastTime;

		if ($diff > abs($now - strtotime($end))) {
			return sprintf('on %s', date($format, $inSeconds));
		} else {
			if ($years > 0) {
				// years
				$relativeDate = ($relativeDate ? ', ' : '') . $years . ' ' . ($years==1 ? 'year':'years');
			} elseif (abs($months) > 0) {
				// months
				$relativeDate = ($relativeDate ? ', ' : '') . $months . ' ' . ($months==1 ? 'month':'months');
			} elseif (abs($weeks) > 0) {
				// weeks
				$relativeDate = ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks');
			} elseif (abs($days) > 0) {
				// days
				$relativeDate = ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days');
			} elseif (abs($hours) > 0) {
				// hours
				$relativeDate = ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours==1 ? 'hour':'hours');
			} elseif (abs($minutes) > 0) {
				// minutes only
				$relativeDate = ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes==1 ? 'minute':'minutes');
			} else {
				// seconds only
				if($seconds==0){
					return 'Just now';
				}else{
					$relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . ($seconds==1 ? 'second':'seconds');
				}
			}

			if (!$backwards) {
				$relativeDate = sprintf('%s ago', $relativeDate);
			}
			return 'About ' . $relativeDate;
		}
	}
	
	
   /**
	* Returns either a relative date or a formatted date depending
	* on the difference between the current time and given datetime.
	* $datetime should be in a <i>strtotime</i>-parsable format, like MySQL's datetime datatype.
	*
	* Options:
	*  'format' => a fall back format if the relative time is longer than the duration specified by end
	*  'end' =>  The end of relative time telling
	*
	* Relative dates look something like this:
	*	3 weeks, 4 days ago
	*	15 seconds ago
	* Formatted dates look like this:
	*	on 02/18/2004
	*
	* The returned string includes 'ago' or 'on' and assumes you'll properly add a word
	* like 'Posted ' before the function output.
	*
	* @param string $dateString Datetime string or unix timestamp
	* @param array $options Default format if timestamp is used in $dateString
	* @return string Relative time string.
	*/
	public static function timeAgoInWords($dateString, $options = array()) {
		$now = time();

		$inSeconds = self::getUnix($dateString);
		
		$backwards = ($inSeconds > $now);

		$format = 'j/n/y';
		$end = '+1 month';

		if (is_array($options)) {
			if (isset($options['format'])) {
				$format = $options['format'];
				unset($options['format']);
			}
			if (isset($options['end'])) {
				$end = $options['end'];
				unset($options['end']);
			}
		} else {
			$format = $options;
		}

		if ($backwards) {
			$futureTime = $inSeconds;
			$pastTime = $now;
		} else {
			$futureTime = $now;
			$pastTime = $inSeconds;
		}
		$diff = $futureTime - $pastTime;

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			$current = array();
			$date = array();

			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
			$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

			if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
				$months = 0;
				$years = 0;
			} else {
				if ($future['Y'] == $past['Y']) {
					$months = $future['m'] - $past['m'];
				} else {
					$years = $future['Y'] - $past['Y'];
					$months = $future['m'] + ((12 * $years) - $past['m']);

					if ($months >= 12) {
						$years = floor($months / 12);
						$months = $months - ($years * 12);
					}

					if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
						$years --;
					}
				}
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $pastTime);
				$daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

				if (!$backwards) {
					$days = ($daysInPastMonth - $past['d']) + $future['d'];
				} else {
					$days = ($daysInFutureMonth - $past['d']) + $future['d'];
				}

				if ($future['m'] != $past['m']) {
					$months --;
				}
			}

			if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years --;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$years = $months = $weeks = 0;
			$days = floor($diff / 86400);

			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);
			$seconds = $diff;
		}
		$relativeDate = '';
		$diff = $futureTime - $pastTime;

		if ($diff > abs($now - strtotime($end))) {
			$relativeDate = sprintf('on %s', date($format, $inSeconds));
		} else {
			if ($years > 0) {
				// years and months and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $years . ' ' . ($years==1 ? 'year':'years');
				$relativeDate .= $months > 0 ? ($relativeDate ? ', ' : '') . $months . ' ' . ($months==1 ? 'month':'months') : '';
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks') : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days') : '';
			} elseif (abs($months) > 0) {
				// months, weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $months . ' ' . ($months==1 ? 'month':'months');
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks') : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days') : '';
			} elseif (abs($weeks) > 0) {
				// weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks');
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days') : '';
			} elseif (abs($days) > 0) {
				// days and hours
				$relativeDate .= ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days');
				$relativeDate .= $hours > 0 ? ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours==1 ? 'hour':'hours') : '';
			} elseif (abs($hours) > 0) {
				// hours and minutes
				$relativeDate .= ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours==1 ? 'hour':'hours');
				$relativeDate .= $minutes > 0 ? ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes==1 ? 'minute':'minutes') : '';
			} elseif (abs($minutes) > 0) {
				// minutes only
				$relativeDate .= ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes==1 ? 'minute':'minutes');
			} else {
				// seconds only
				$relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . ($seconds==1 ? 'second':'seconds');
			}

			if (!$backwards) {
				$relativeDate = sprintf('%s ago', $relativeDate);
			}
		}
		return $relativeDate;
	}
	

	/**
	 * convert a string mysql date to unix timestamp
	 * 
	 * @param string $date format: 2012-01-30
	 * @return int seconds unix timestamp 
	 */
	public static function dateToUnix($date)
	{
		if (!is_string($date) || $date=='')
			throw new CException('the $date parameter must be a string representation of a date, 2012-01-30');
		list($year, $month, $day) = explode('-', $date);
		return mktime(0, 0, 0, $month, $day, $year);
	}
	
	/**
	 * convert a unix timestamp into a mysql string datetime format
	 * @param int $unixTimestamp seconds since 1 ,1 1970
	 * @return string mydql datetime e.g.  2004-01-02 13:00:00 
	 */
	public static function unixToDatetime($unixTimestamp)
	{
		return date('Y-m-d H:i:s', $unixTimestamp);
	}
	
	/**
	 * convert a string mysql datetime to unix timestamp
	 * 
	 * @param string $datetime format: 2012-01-30 12:30:00
	 * @return int seconds unix timestamp 
	 */
	public static function datetimeToUnix($datetime)
	{
		if (!is_string($datetime) || $datetime=='')
			throw new CException('The $datetime parameter must be a string representation of a date, 2012-01-30');
		list($date, $time) = explode(' ',$datetime);
		list($year, $month, $day) = explode('-', $date);
		list($hours, $minutes, $seconds) = explode(':', $time);
		return mktime($hours, $minutes, $seconds, $month, $day, $year);
	}
	
	/**
	 * Transform time format string like "1:45" into the total number of minutes "105".
	 * @param int $hours
	 * @return string 
	 */
	public static function timeToMinutes($hours) 
	{ 
		$minutes = 0; 
		if (strpos($hours, ':') !== false) 
		{ 
			// Split hours and minutes. 
			list($hours, $minutes) = explode(':', $hours); 
		} 
		return $hours * 60 + $minutes; 
	} 
	
	/**
	 * Converts total minutes to time format
	 * e.g. 105 minutes becomes 1:45
	 * @param int $minutes
	 * @return string 
	 */
	public static function minutesToTime($minutes) 
	{ 
		$hours = (int)($minutes / 60); 
		$minutes -= $hours * 60;
		return sprintf("%d:%02.0f", $hours, $minutes); 
	} 
	
	/**
	 * converts total minutes into string "D:H:M"
	 * To get individual values for days, hours and minutes use the following code
	 * on the result of this function.
	 * <code>
	 * list($days, $hours, $mins) = explode(':', $result)
	 * </code>
	 * @param integer $minutes
	 * @param float $hoursPerDay the number of hours in the working day, defaults to 7.5
	 * @return string
	 */
	public static function minutesToDays($minutes, $hoursPerDay=7.5)
	{
		$minsPerDay = $hoursPerDay*60;
		$days = floor($minutes / $minsPerDay);
		
		$remainMinutes = $minutes % $minsPerDay;
		$hours = floor($remainMinutes / 60);
		$mins = floor($remainMinutes % 60);
		
		return $days . ":" . $hours . ":" . $mins;
	}
	
	/**
	 * formats the result of minutesToDays into a nice string like:
	 * 3 Days, 2 hours, 4 minutes
	 * 
	 * @see self::minutesToDays
	 * @param integer $minutes
	 * @param float $hoursPerDay the number of hours in the working day, defaults to 7.5
	 * @return string
	 */
	public static function minutesToDaysNice($minutes, $hoursPerDay=7.5)
	{
		list($days,$hours,$mins) = explode(':',self::minutesToDays($minutes, $hoursPerDay));
		$dLabal = ($days==1) ? 'Day':'Days';
		$hLabal = ($hours==1) ? 'Hour':'Hours';		
		$mLabal = ($mins==1) ? 'Minute':'Minutes';
		
		$ret = "";
		if ($days > 0)
			$ret .= "$days $dLabal";
		if ($hours > 0)
			$ret .= ($ret != '') ? ", $hours $hLabal" : "$hours $hLabal";
		if ($mins > 0)
			$ret .= ($ret != '') ? " and $mins $mLabal" : "$mins $mLabal";
		return $ret;
	}
	
}