<?php
$month = $year = array();

if (isset($_GET['year']) && isset($_GET['month']))
{
	$y = $_GET['year'];
	$m = $_GET['month'];
} else {
	list($y, $m) = explode("-", date("Y-m"));
}

$month[1] = intval($m);
foreach (range(2, 12) as $i)
{
	$month[$i] = ($month[1] + $i - 1) > 12 ? $month[1] + $i - 1 - 12 : $month[1] + $i - 1;
}

$year[1] = intval($y);
foreach (range(2, 12) as $i)
{
	$year[$i] = ($month[1] + $i - 1) > 12 ? $year[1] + 1 : $year[1];
}

echo $tpl['TSBCalendar']->getMonthView($month[1], $year[1]);
?>