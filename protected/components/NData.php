<?php

/**
 * Description of NData
 *
 * @author steve
 */
class NData
{
    public static function param($param, $defaultVal, $appendIfExists='', $prependIfExists=''){
		return empty($param)?$defaultVal:$prependIfExists.$param.$appendIfExists;
	}
}
