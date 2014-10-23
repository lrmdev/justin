<?php
if (isset($tpl['status']))
{
	$status = __('status', true);
	switch ($tpl['status'])
	{
		case 2:
			pjUtil::printNotice(NULL, $status[2]);
			break;
	}
} else {
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	if (isset($_GET['err']))
	{
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	include_once PJ_VIEWS_PATH . 'pjLayouts/elements/optmenu.php';
	if (!in_array(@$_GET['tab'], array(1,2)))
	{
		include_once dirname(__FILE__) . '/elements/submenu.php';
	}
	switch (@$_GET['tab'])
	{
		case 5:
			pjUtil::printNotice(@$titles['AO25'], @$bodies['AO25'], false);
			include dirname(__FILE__) . '/elements/confirmation.php';
			break;
		case 6:
			pjUtil::printNotice(@$titles['AO26'], @$bodies['AO26']);
			include dirname(__FILE__) . '/elements/terms.php';
			break;
		default:
			switch ($_GET['tab'])
			{
				case 1:
					pjUtil::printNotice(@$titles['AO21'], @$bodies['AO21']);
					break;
				case 3:
					pjUtil::printNotice(@$titles['AO23'], @$bodies['AO23']);
					break;
				case 4:
					pjUtil::printNotice(@$titles['AO24'], @$bodies['AO24']);
					break;
				case 7:
					pjUtil::printNotice(@$titles['AO27'], @$bodies['AO27']);
					break;
				case 8:
					pjUtil::printNotice(@$titles['AO28'], @$bodies['AO28']);
					break;
			}
			include dirname(__FILE__) . '/elements/tab.php';
	}
}
?>