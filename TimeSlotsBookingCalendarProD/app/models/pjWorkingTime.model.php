<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjWorkingTimeModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'working_times';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'monday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'monday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'monday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'monday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'monday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'monday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'monday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'monday_dayoff', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'tuesday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'tuesday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'tuesday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'tuesday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'tuesday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'tuesday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'tuesday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'tuesday_dayoff', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'wednesday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'wednesday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'wednesday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'wednesday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'wednesday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'wednesday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'wednesday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'wednesday_dayoff', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'thursday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'thursday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'thursday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'thursday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'thursday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'thursday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'thursday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'thursday_dayoff', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'friday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'friday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'friday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'friday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'friday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'friday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'friday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'friday_dayoff', 'type' => 'enum', 'default' => 'F'),
		array('name' => 'saturday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'saturday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'saturday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'saturday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'saturday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'saturday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'saturday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'saturday_dayoff', 'type' => 'enum', 'default' => 'T'),
		array('name' => 'sunday_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'sunday_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'sunday_lunch_from', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'sunday_lunch_to', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'sunday_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'sunday_limit', 'type' => 'smallint', 'default' => 1),
		array('name' => 'sunday_length', 'type' => 'smallint', 'default' => 60),
		array('name' => 'sunday_dayoff', 'type' => 'enum', 'default' => 'T')
	);
	
	public static function factory($attr=array())
	{
		return new pjWorkingTimeModel($attr);
	}
	
	public function getDaysOff($calendar_id)
	{
		$_arr = array();

		$arr = $this->reset()
				 ->where('foreign_id', $calendar_id)
				 ->findAll()
				 ->getData();
		if(!empty($arr))
		{
			foreach ($arr[0] as $k => $v)
			{
				if (strpos($k, "_dayoff") !== false && $v == 'T')
				{
					list($key) = explode("_", $k);
					$_arr[$key] = 1;
				}
			}
		}
		return $_arr;
	}
	
	public function getWorkingTime($calendar_id)
	{
		$arr = $this->reset()
			 ->where('foreign_id', $calendar_id)
			 ->findAll()
			 ->getData();
		return !empty($arr) ? $arr[0] : array();
	}
	
	public function filterDate($arr, $date)
	{
		$day = strtolower(date("l", strtotime($date)));

		if (empty($arr))
		{
			return false;
		}
	
		$wt = array();
		foreach ($arr as $k => $v)
		{
			if (strpos($k, $day . '_dayoff') !== false)
			{
				$wt['is_dayoff'] = $v;
				continue;
			}
						
			if (strpos($k, $day . '_limit') !== false && !is_null($v))
			{
				$wt['slot_limit'] = $v;
				continue;
			}
			
			if (strpos($k, $day . '_length') !== false && !is_null($v))
			{
				$wt['slot_length'] = $v;
				continue;
			}
			
			if (strpos($k, $day . '_price') !== false)
			{
				$wt['price'] = (float) $v;
				continue;
			}
			
			if (strpos($k, $day . '_lunch_from') !== false && !is_null($v))
			{
				$d = getdate(strtotime($v));
				$wt['lunch_start_hour'] = $d['hours'];
				$wt['lunch_start_minutes'] = $d['minutes'];
				$wt['lunch_start_ts'] = strtotime($date . " " . $v);
				continue;
			}
			
			if (strpos($k, $day . '_lunch_to') !== false && !is_null($v))
			{
				$d = getdate(strtotime($v));
				$wt['lunch_end_hour'] = $d['hours'];
				$wt['lunch_end_minutes'] = $d['minutes'];
				$wt['lunch_end_ts'] = strtotime($date . " " . $v);
				continue;
			}
			
			if (strpos($k, $day . '_from') !== false && strpos($k, $day . '_lunch_from') === false && !is_null($v))
			{
				$d = getdate(strtotime($v));
				$wt['start_hour'] = $d['hours'];
				$wt['start_minutes'] = $d['minutes'];
				$wt['start_ts'] = strtotime($date . " " . $v);
				continue;
			}
		
			if (strpos($k, $day . '_to') !== false && strpos($k, $day . '_lunch_to') === false && !is_null($v))
			{
				$d = getdate(strtotime($v));
				$wt['end_hour'] = $d['hours'];
				$wt['end_minutes'] = $d['minutes'];
				$wt['end_ts'] = strtotime($date . " " . $v);
				continue;
			}
		}
		return $wt;
	}
	
	public function init($calendar_id)
	{
		$data['foreign_id'] = $calendar_id;
		$weekdays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
		foreach ($weekdays as $day)
		{
			$data[$day . '_from']       = '08:00:00';
			$data[$day . '_to']         = '18:00:00';
			$data[$day . '_lunch_from'] = '00:00:00';
			$data[$day . '_lunch_to']   = '00:00:00';
			$data[$day . '_price']      = 0.00;
		}
		return $this->reset()->setAttributes($data)->insert()->getInsertId();
	}
}