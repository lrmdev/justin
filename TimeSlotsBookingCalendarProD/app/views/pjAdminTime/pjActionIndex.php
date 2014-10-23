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
	include dirname(__FILE__) . '/elements/menu_options.php';

	pjUtil::printNotice(@$titles['AT04'], @$bodies['AT04']);
	$time_slot_length = __('time_slot_length', true);
	ksort($time_slot_length);
	?>
	<style type="text/css">
	.pj-form p{
		margin: 0 0 5px !important;
	}
	.pj-form-field{
		padding: 7px 2px;
	}
	select.pj-form-field{
		padding: 6px 2px;
	}
	</style>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTime&amp;action=pjActionIndex" method="post" class="form pj-form">
		<input type="hidden" name="working_time" value="1" />
		<?php
		if ($controller->isAdmin())
		{
			?><input type="hidden" name="id" value="<?php echo (int) $tpl['wt_arr']['id']; ?>" /><?php
		}
		?>
		<table class="pj-table" cellpadding="0" cellspacing="0" style="width: 100%">
			<thead>
				<tr>
					<th><?php __('time_day'); ?></th>
					<th><?php __('time_tbl_wtime'); ?></th>
					<th><?php __('time_tbl_break'); ?></th>
					<th><?php __('time_tbl_price'); ?></th>
					<th><?php __('time_tbl_length'); ?></th>
					<th><?php __('time_tbl_limit'); ?></th>
					<th><?php __('time_tbl_dayoff'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i = 1;
			$days = __('days', true);
			$w_days = array(
				'monday' => $days[1],
				'tuesday' => $days[2],
				'wednesday' => $days[3],
				'thursday' => $days[4],
				'friday' => $days[5],
				'saturday' => $days[6],
				'sunday' => $days[0]
			);
			foreach ($w_days as $k => $day)
			{
				$step = 5;
				
				$pjTime_hf = pjTime::factory()
					->attr('name', $k . '_hour_from')
					->attr('id', $k . '_hour_from')
					->attr('class', 'pj-form-field w45');
					
				$pjTime_mf = pjTime::factory()
					->attr('name', $k . '_minute_from')
					->attr('id', $k . '_minute_from')
					->attr('class', 'pj-form-field w45')
					->prop('step', $step);
					
				$pjTime_lhf = pjTime::factory()
					->attr('name', $k . '_lunch_hour_from')
					->attr('id', $k . '_lunch_hour_from')
					->attr('class', 'pj-form-field w45');
					
				$pjTime_lmf = pjTime::factory()
					->attr('name', $k . '_lunch_minute_from')
					->attr('id', $k . '_lunch_minute_from')
					->attr('class', 'pj-form-field w45')
					->prop('step', $step);
					
				$pjTime_ht = pjTime::factory()
					->attr('name', $k . '_hour_to')
					->attr('id', $k . '_hour_to')
					->attr('class', 'pj-form-field w45');
					
				$pjTime_mt = pjTime::factory()
					->attr('name', $k . '_minute_to')
					->attr('id', $k . '_minute_to')
					->attr('class', 'pj-form-field w45')
					->prop('step', $step);
					
				$pjTime_lht = pjTime::factory()
					->attr('name', $k . '_lunch_hour_to')
					->attr('id', $k . '_lunch_hour_to')
					->attr('class', 'pj-form-field w45');
					
				$pjTime_lmt = pjTime::factory()
					->attr('name', $k . '_lunch_minute_to')
					->attr('id', $k . '_lunch_minute_to')
					->attr('class', 'pj-form-field w45')
					->prop('step', $step);
					
				if (isset($tpl['wt_arr']) && !empty($tpl['wt_arr']))
				{
					$hour_from = substr($tpl['wt_arr'][$k.'_from'], 0, 2);
					$hour_to = substr($tpl['wt_arr'][$k.'_to'], 0, 2);
					$minute_from = substr($tpl['wt_arr'][$k.'_from'], 3, 2);
					$minute_to = substr($tpl['wt_arr'][$k.'_to'], 3, 2);
					
					$lunch_hour_from = substr($tpl['wt_arr'][$k.'_lunch_from'], 0, 2);
					$lunch_hour_to = substr($tpl['wt_arr'][$k.'_lunch_to'], 0, 2);
					$lunch_minute_from = substr($tpl['wt_arr'][$k.'_lunch_from'], 3, 2);
					$lunch_minute_to = substr($tpl['wt_arr'][$k.'_lunch_to'], 3, 2);
					
					$price = $tpl['wt_arr'][$k.'_price'];
					$limit = $tpl['wt_arr'][$k.'_limit'];
					$length = $tpl['wt_arr'][$k.'_length'];
					
					$checked = NULL;
					$disabled = NULL;
					$day_price = NULL;
					
					if ($tpl['wt_arr'][$k.'_dayoff'] == 'T')
					{
						$pjTime_hf->attr('disabled', 'disabled');
						$pjTime_mf->attr('disabled', 'disabled');
						$pjTime_ht->attr('disabled', 'disabled');
						$pjTime_mt->attr('disabled', 'disabled');
						
						$pjTime_lhf->attr('disabled', 'disabled');
						$pjTime_lmf->attr('disabled', 'disabled');
						$pjTime_lht->attr('disabled', 'disabled');
						$pjTime_lmt->attr('disabled', 'disabled');
						
						$day_price = ' disabled';
						
						$checked = ' checked="checked"';
						$disabled = ' disabled="disabled"';
					}
				} else {
					$hour_from = NULL;
					$hour_to = NULL;
					$minute_from = NULL;
					$minute_to = NULL;
					
					$lunch_hour_from = NULL;
					$lunch_hour_to = NULL;
					$lunch_minute_from = NULL;
					$lunch_minute_to = NULL;
					
					$checked = NULL;
					//$disabled = NULL;
					
					$limit = NULL;
					$length = NULL;
					$price = NULL;
					$day_price = NULL;
				}
				?>
				<tr class="<?php echo ($i % 2 !== 0 ? 'odd' : 'even'); ?>">
					<td class="bold"><?php echo $day; ?></td>
					<td>
						<p class="w150"><span class="float_left"><?php __('time_tbl_from'); ?>:</span><span class="float_right">
						<?php
						echo $pjTime_hf
							->prop('selected', $hour_from)
							->hour();
						?>
						<?php
						echo $pjTime_mf
							->prop('selected', $minute_from)
							->minute();
						?>
						</span></p>
						<p class="w150"><span class="float_left"><?php __('time_tbl_to'); ?>:</span><span class="float_right">
						<?php
						echo $pjTime_ht
							->prop('selected', $hour_to)
							->hour();
						?>
						<?php
						echo $pjTime_mt
							->prop('selected', $minute_to)
							->minute();
						?>
						</span></p>
					</td>
					<td>
						<p class="w150"><span class="float_left"><?php __('time_tbl_from'); ?>:</span><span class="float_right">
						<?php
						echo $pjTime_lhf
							->prop('selected', $lunch_hour_from)
							->hour();
						?>
						<?php
						echo $pjTime_lmf
							->prop('selected', $lunch_minute_from)
							->minute();
						?>
						</span></p>
						<p class="w150"><span class="float_left"><?php __('time_tbl_to'); ?>:</span><span class="float_right">
						<?php
						echo $pjTime_lht
							->prop('selected', $lunch_hour_to)
							->hour();
						?>
						<?php
						echo $pjTime_lmt
							->prop('selected', $lunch_minute_to)
							->minute();
						?>
						</span></p>
					</td>
					<td class="align_top">
						<p class="w100">
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="<?php echo $k; ?>_price" id="<?php echo $k; ?>_price" class="pj-form-field w50 align_right" value="<?php echo $price; ?>"<?php echo @$disabled; ?> />
							</span>
						</p>
						<a href="<?php echo $_SERVER['PHP_SELF']; ?>" data-day="<?php echo $k; ?>" class="day-price<?php echo $day_price; ?>"><?php __('time_tbl_customize'); ?></a>
					</td>
					<td class="align_top">
						<select name="<?php echo $k; ?>_length" id="<?php echo $k; ?>_length" class="pj-form-field w60"<?php echo @$disabled; ?>>
						<?php
						foreach ($time_slot_length as $sk => $sv)
						{
							?><option value="<?php echo $sk; ?>"<?php echo $length == $sk ? ' selected="selected"' : NULL; ?>><?php echo $sv; ?></option><?php
						}
						?>
						</select>
					</td>
					<td class="align_top">
						<input type="text" name="<?php echo $k; ?>_limit" id="<?php echo $k; ?>_limit" class="pj-form-field spin w50" value="<?php echo $limit; ?>"<?php echo @$disabled; ?> />
					</td>
					<td class="align_top align_center"><input type="checkbox" class="working_day" name="<?php echo $k; ?>_dayoff" value="T"<?php echo $checked; ?> /></td>
				</tr>
				<?php
				$i++;
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="9"><input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button"  /></td>
				</tr>
			</tfoot>
		</table>
	</form>
	<div id="dialogDayPrice" title="<?php __('time_dp_title'); ?>" style="display: none"></div>
	<?php
}
?>