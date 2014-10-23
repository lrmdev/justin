<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBookingSlotModel extends pjAppModel
{
	protected $primaryKey = 'id';

	protected $table = 'bookings_slots';

	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'booking_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'booking_date', 'type' => 'date', 'default' => ':NULL'),
		array('name' => 'start_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'end_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'start_ts', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'end_ts', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'price', 'type' => 'decimal', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
		return new pjBookingSlotModel($attr);
	}
	
	public function getBookings($calendar_id, $month, $year)
	{
		$numOfDays = date("t", mktime(0, 0, 0, $month, 1, $year));
		$_arr = array();
		foreach (range(1, $numOfDays) as $i)
		{
			$_arr[date("Y-m-d", mktime(0, 0, 0, $month, $i, $year))] = array();
		}
		
		$arr = $this->reset()
			->join('pjBooking', 't2.id=t1.booking_id', 'inner')
			->where('MONTH(t1.booking_date)', $month)
			->where('YEAR(t1.booking_date)', $year)
			->where('t2.calendar_id', $calendar_id)
			->where('t2.booking_status !=', 'cancelled')
			->findAll()
			->getData();

		foreach ($arr as $v)
		{
			$_arr[$v['booking_date']][] = $v;
		}
		
		return $_arr;
	}

	public function checkBooking($calendar_id, $start_ts, $end_ts, $pjBookingModel = null, $offset = 0)
	{
		$start_ts += $offset;
		$end_ts += $offset;

		return $this
			->reset()
			->join('pjBooking', sprintf("t2.id=t1.booking_id AND t2.calendar_id = '%1\$u' AND t2.booking_status IN ('pending', 'confirmed')", $calendar_id), 'inner')
			->where(sprintf("('%1\$s' >= t1.start_ts AND '%1\$s' < t1.end_ts)", $start_ts))
			->orWhere(sprintf("('%1\$s' > t1.start_ts AND '%1\$s' <= t1.end_ts)", $end_ts))
			->findCount()
			->getData();
	}
}
?>