<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjDateModel extends pjAppModel
{
	protected $primaryKey = 'id';

	protected $table = 'dates';

	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'date', 'type' => 'date', 'default' => ':NULL'),
		array('name' => 'slot_length', 'type' => 'smallint', 'default' => ':NULL'),
		array('name' => 'slot_limit', 'type' => 'smallint', 'default' => ':NULL'),
		array('name' => 'start_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'end_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'start_lunch', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'end_lunch', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'is_dayoff', 'type' => 'enum', 'default' => 'F')
	);

	public static function factory($attr=array())
	{
		return new pjDateModel($attr);
	}

	public function getDailyWorkingTime($foreign_id, $date)
	{
		$arr = $this
			->reset()
			->where('t1.foreign_id', $foreign_id)
			->where('t1.date', $date)
			->limit(1)
			->orderBy('t1.start_time ASC')
			->findAll()
			->getData();
			
		if (empty($arr))
		{
			return false;
		}
		
		$arr = $arr[0];
		
		$wt = array();
		$wt['is_dayoff'] = $arr['is_dayoff'];
		$wt['slot_length'] = $arr['slot_length'];
		$wt['slot_limit'] = $arr['slot_limit'];
		$wt['price'] = $arr['price'];
		$d = getdate(strtotime($arr['start_time']));
		$wt['start_hour'] = $d['hours'];
		$wt['start_minutes'] = $d['minutes'];
	
		$d = getdate(strtotime($arr['end_time']));
		$wt['end_hour'] = $d['hours'];
		$wt['end_minutes'] = $d['minutes'];
		
		$wt['start_ts'] = strtotime($date . " " . $arr['start_time']);
		$wt['end_ts'] = strtotime($date . " " . $arr['end_time']);
		
		# Lunch
		$d = getdate(strtotime($arr['start_lunch']));
		$wt['lunch_start_hour'] = $d['hours'];
		$wt['lunch_start_minutes'] = $d['minutes'];
	
		$d = getdate(strtotime($arr['end_lunch']));
		$wt['lunch_end_hour'] = $d['hours'];
		$wt['lunch_end_minutes'] = $d['minutes'];
		
		$wt['lunch_start_ts'] = strtotime($date . " " . $arr['start_lunch']);
		$wt['lunch_end_ts'] = strtotime($date . " " . $arr['end_lunch']);
		
		return $wt;
	}
	
	public function getWeeklyWorkingTime($foreign_id, $iso_first_date)
	{
		return $this->getWorkingTime($foreign_id, $iso_first_date, 7);
	}
	
	public function getWorkingTime($foreign_id, $iso_first_date, $total_days)
	{
		list($year, $month, $day) = explode('-', $iso_first_date);
		
		$_arr = array();
		foreach (range(0, $total_days-1) as $i)
		{
			$_arr[date("Y-m-d", mktime(0, 0, 0, $month, $day + $i, $year))] = array();
		}
		
		$arr = $this
			->reset()
			->where('t1.foreign_id', $foreign_id)
			->where(sprintf("(t1.date BETWEEN '%1\$s' AND DATE_ADD('%1\$s', INTERVAL '%2\$u' DAY))", $iso_first_date, $total_days))
			->orderBy('t1.start_time ASC')
			->findAll()
			->getData();
			
		foreach ($arr as $item)
		{
			$_arr[$item['date']] = $item;
			
			$d = getdate(strtotime($item['start_time']));
			$_arr[$item['date']]['start_hour'] = $d['hours'];
			$_arr[$item['date']]['start_minutes'] = $d['minutes'];
		
			$d = getdate(strtotime($item['end_time']));
			$_arr[$item['date']]['end_hour'] = $d['hours'];
			$_arr[$item['date']]['end_minutes'] = $d['minutes'];
			
			$_arr[$item['date']]['start_ts'] = strtotime($item['date'] . " " . $item['start_time']);
			$_arr[$item['date']]['end_ts'] = strtotime($item['date'] . " " . $item['end_time']);
			
			# Lunch
			$d = getdate(strtotime($item['start_lunch']));
			$_arr[$item['date']]['lunch_start_hour'] = $d['hours'];
			$_arr[$item['date']]['lunch_start_minutes'] = $d['minutes'];
		
			$d = getdate(strtotime($item['end_lunch']));
			$_arr[$item['date']]['lunch_end_hour'] = $d['hours'];
			$_arr[$item['date']]['lunch_end_minutes'] = $d['minutes'];
			
			$_arr[$item['date']]['lunch_start_ts'] = strtotime($item['date'] . " " . $item['start_lunch']);
			$_arr[$item['date']]['lunch_end_ts'] = strtotime($item['date'] . " " . $item['end_lunch']);
		}
		
		return $_arr;
	}
	
	public function getMonthlyWorkingTime($foreign_id, $month, $year)
	{
		$numOfDays = date("t", mktime(0, 0, 0, $month, 1, $year));
		$_arr = array();
		foreach (range(1, $numOfDays) as $i)
		{
			$_arr[date("Y-m-d", mktime(0, 0, 0, $month, $i, $year))] = array();
		}
		
		$arr = $this
			->reset()
			->where('t1.foreign_id', $foreign_id)
			->where('MONTH(t1.date)', $month)
			->where('YEAR(t1.date)', $year)
			->orderBy('t1.start_time ASC')
			->findAll()
			->getData();
			
		foreach ($arr as $item)
		{
			$_arr[$item['date']] = $item;
			
			$d = getdate(strtotime($item['start_time']));
			$_arr[$item['date']]['start_hour'] = $d['hours'];
			$_arr[$item['date']]['start_minutes'] = $d['minutes'];
		
			$d = getdate(strtotime($item['end_time']));
			$_arr[$item['date']]['end_hour'] = $d['hours'];
			$_arr[$item['date']]['end_minutes'] = $d['minutes'];
			
			$_arr[$item['date']]['start_ts'] = strtotime($item['date'] . " " . $item['start_time']);
			$_arr[$item['date']]['end_ts'] = strtotime($item['date'] . " " . $item['end_time']);
			
			# Lunch
			$d = getdate(strtotime($item['start_lunch']));
			$_arr[$item['date']]['lunch_start_hour'] = $d['hours'];
			$_arr[$item['date']]['lunch_start_minutes'] = $d['minutes'];
		
			$d = getdate(strtotime($item['end_lunch']));
			$_arr[$item['date']]['lunch_end_hour'] = $d['hours'];
			$_arr[$item['date']]['lunch_end_minutes'] = $d['minutes'];
			
			$_arr[$item['date']]['lunch_start_ts'] = strtotime($item['date'] . " " . $item['start_lunch']);
			$_arr[$item['date']]['lunch_end_ts'] = strtotime($item['date'] . " " . $item['end_lunch']);
		}
		
		return $_arr;
	}
		
	public function getDatesOff($foreign_id, $month, $year)
	{
		$numOfDays = date("t", mktime(0, 0, 0, $month, 1, $year));
		$_arr = array();
		foreach (range(1, $numOfDays) as $i)
		{
			$_arr[date("Y-m-d", mktime(0, 0, 0, $month, $i, $year))] = array();
		}
		
		//'t1.is_dayoff' => 'T',
		$arr = $this
			->reset()
			->where('t1.foreign_id', $foreign_id)
			->where('MONTH(t1.date)', $month)
			->where('YEAR(t1.date)', $year)
			->orderBy('t1.date ASC')
			->findAll()
			->getData();

		foreach ($arr as $v)
		{
			$_arr[$v['date']] = $v;
			$_arr[$v['date']]['start_ts'] = strtotime($v['date'] . " " . $v['start_time']);
			$_arr[$v['date']]['end_ts'] = strtotime($v['date'] . " " . $v['end_time']);
		}
		
		return $_arr;
	}
}
?>