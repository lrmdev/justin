<?php
if (isset($tpl['arr']))
{
	if (is_array($tpl['arr']))
	{
		$count = count($tpl['arr']);
		if ($count > 0)
		{
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form pj-form">
				<input type="hidden" name="options_update" value="1" />
				<input type="hidden" name="tab" value="<?php echo @$_GET['tab']; ?>" />
				<input type="hidden" name="next_action" value="pjActionIndex" />
				<table class="pj-table b10" cellpadding="0" cellspacing="0" style="width: 100%">
					<thead>
						<tr>
							<th><?php __('lblOption'); ?></th>
							<th><?php __('lblValue'); ?></th>
						</tr>
					</thead>
					<tbody>

			<?php
			for ($i = 0; $i < $count; $i++)
			{
				if ((int) $tpl['arr'][$i]['is_visible'] === 0) continue;
				
				$rowClass = NULL;
				$rowStyle = NULL;
				if (in_array($tpl['arr'][$i]['key'], array('o_smtp_host', 'o_smtp_port', 'o_smtp_user', 'o_smtp_pass')))
				{
					$rowClass = " boxSmtp";
					$rowStyle = "display: none";
					switch ($tpl['option_arr']['o_send_email'])
					{
						case 'smtp':
							$rowStyle = NULL;
							break;
					}
				} elseif (in_array($tpl['arr'][$i]['key'], array('o_authorize_mid', 'o_authorize_tz', 'o_authorize_key', 'o_authorize_hash'))) {
					$rowClass = " boxAuthorize";
					$rowStyle = "display: none";
					switch ($tpl['option_arr']['o_allow_authorize'])
					{
						case '1':
							$rowStyle = NULL;
							break;
					}
				} elseif (in_array($tpl['arr'][$i]['key'], array('o_paypal_address'))) {
					$rowClass = " boxPaypal";
					$rowStyle = "display: none";
					switch ($tpl['option_arr']['o_allow_paypal'])
					{
						case '1':
							$rowStyle = NULL;
							break;
					}
				} elseif (in_array($tpl['arr'][$i]['key'], array('o_bank_account'))) {
					$rowClass = " boxBank";
					$rowStyle = "display: none";
					switch ($tpl['option_arr']['o_allow_bank'])
					{
						case '1':
							$rowStyle = NULL;
							break;
					}
				}
				?>
				<tr class="pj-table-row-odd<?php echo $rowClass; ?>" style="<?php echo $rowStyle; ?>">
					<td><?php __('opt_' . $tpl['arr'][$i]['key']); ?></td>
					<td class="align_top">
						<?php
						switch ($tpl['arr'][$i]['type'])
						{
							case 'string':
								?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field w200" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>" /><?php
								break;
							case 'text':
								?><textarea name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field" style="width: 400px; height: 80px;<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>"><?php echo stripslashes(str_replace(array('\r\n', '\n'), '&#10;', $tpl['arr'][$i]['value'])); ?></textarea><?php
								break;
							case 'int':
								?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field field-int w60 digits" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>" readonly="readonly" /><?php
								break;
							case 'float':
								switch ($tpl['arr'][$i]['key'])
								{
									case 'o_deposit':
										?><input type="text" name="value-int-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field field-float w60" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" value="<?php echo (int) $tpl['arr'][$i]['value']; ?>" /><?php
										?>
										<select name="value-enum-o_deposit_type" class="pj-form-field" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>">
										<?php
										$default = explode("::", $tpl['o_arr']['o_deposit_type']['value']);
										$enum = explode("|", $default[0]);
										
										$enumLabels = array();
										if (!empty($tpl['o_arr']['o_deposit_type']['label']) && strpos($tpl['o_arr']['o_deposit_type']['label'], "|") !== false)
										{
											$enumLabels = explode("|", $tpl['o_arr']['o_deposit_type']['label']);
										}
										
										foreach ($enum as $k => $el)
										{
											?><option value="<?php echo $default[0].'::'.$el; ?>"<?php echo $default[1] == $el ? ' selected="selected"' : NULL; ?>><?php echo array_key_exists($k, $enumLabels) ? stripslashes($enumLabels[$k]) : stripslashes($el); ?></option><?php
										}
										?>
										</select>
										<?php
										break;
									case 'o_security':
										?>
										<span class="pj-form-field-custom pj-form-field-custom-before">
											<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
											<input type="text" name="value-int-<?php echo $tpl['arr'][$i]['key']; ?>" value="<?php echo (int) $tpl['arr'][$i]['value']; ?>" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" class="pj-form-field number w60" />
										</span>
										<?php
										break;
									case 'o_tax':
										?>
										<span class="pj-form-field-custom pj-form-field-custom-before">
											<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text">%</abbr></span>
											<input type="text" name="value-int-<?php echo $tpl['arr'][$i]['key']; ?>" value="<?php echo (int) $tpl['arr'][$i]['value']; ?>" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" class="pj-form-field field-float w60" />
										</span>
										<?php
										break;
									default:
										?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field field-float w60" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>" /><?php
								}
								break;
							case 'enum':
								?><select name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>">
								<?php
								$default = explode("::", $tpl['arr'][$i]['value']);
								$enum = explode("|", $default[0]);
								
								$enumLabels = array();
								if (!empty($tpl['arr'][$i]['label']) && strpos($tpl['arr'][$i]['label'], "|") !== false)
								{
									$enumLabels = explode("|", $tpl['arr'][$i]['label']);
								}
								
								foreach ($enum as $k => $el)
								{
									?><option value="<?php echo $default[0].'::'.$el; ?>"<?php echo $default[1] == $el ? ' selected="selected"' : NULL; ?>><?php echo array_key_exists($k, $enumLabels) ? stripslashes($enumLabels[$k]) : stripslashes($el); ?></option><?php
								}
								?>
								</select>
								<?php
								if (in_array($tpl['arr'][$i]['key'], array('o_bf_adults', 'o_bf_children')))
								{
									__('lblMaxValue'); ?>: <input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>_max" class="pj-form-field field-int w60" value="<?php echo pjSanitize::html($tpl['o_arr'][$tpl['arr'][$i]['key'].'_max']['value']); ?>" /><?php
								}
								break;
							case 'bool':
								?><input type="checkbox" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>"<?php echo $tpl['arr'][$i]['value'] == '1|0::1' ? ' checked="checked"' : NULL; ?> value="1|0::1" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" /><?php
								break;
							case 'color':
								?>
								<span class="pj-form-field-custom pj-form-field-custom-after">
									<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="pj-form-field field-color w60" style="<?php echo pjSanitize::html($tpl['arr'][$i]['style']); ?>" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>" />
									<span class="pj-form-field-after"></span>
								</span>
								<?php
								break;
						}
						?>
					</td>
				</tr>
				<?php
			}
			if (@$_GET['tab'] == 8)
			{
				?>
				<tr>
					<td><?php __('option_cron_title'); ?></td>
					<td><?php printf(__('option_cron_info', true, false), PJ_INSTALL_PATH, PJ_INSTALL_URL); ?></td>
				</tr>
				<?php
			}
			?>
					</tbody>
				</table>
				
				<p><input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" /></p>
			</form>
			<?php
		}
	}
}
?>