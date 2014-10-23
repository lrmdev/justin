<?php
if (isset($tpl['status']) && $tpl['status'] == "OK")
{
	?>
	<div class="tsBox">
		<div class="tsServicesInner">
			<div class="tsHeading"><?php __('front_system_msg'); ?></div>
			<div class="tsOverflowHidden">
			<?php
			$status = __('front_booking_status', true);
			if (isset($tpl['booking_arr']))
			{
				switch ($tpl['booking_arr']['payment_method'])
				{
					case 'paypal':
						if ($tpl['invoice_arr']['status'] == 'not_paid')
						{
							?><div class="tsElement tsElementOutline"><?php echo $status[11]; ?></div>
							<div class="tsElementOutline"><?php
							if (pjObject::getPlugin('pjPaypal') !== NULL)
							{
								$controller->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionForm', 'params' => $tpl['params']));
							}
							?></div><?php
						} else {
							?>
							<div class="tsElement tsElementOutline"><?php echo $status[3]; ?></div>
							<div class="tsElementOutline">
								<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
							</div>
							<?php
						}
						break;
					case 'authorize':
						if ($tpl['invoice_arr']['status'] == 'not_paid')
						{
							?><div class="tsElement tsElementOutline"><?php echo $status[11]; ?></div>
							<div class="tsElementOutline"><?php
							if (pjObject::getPlugin('pjAuthorize') !== NULL)
							{
								$controller->requestAction(array('controller' => 'pjAuthorize', 'action' => 'pjActionForm', 'params' => $tpl['params']));
							}
							?></div><?php
						} else {
							?>
							<div class="tsElement tsElementOutline"><?php echo $status[3]; ?></div>
							<div class="tsElementOutline">
								<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
							</div>
							<?php
						}
						break;
					case 'bank':
						?>
						<div class="tsElement tsElementOutline"><?php echo $status[1]; ?></div>
						<div class="tsElementOutline"><?php echo pjSanitize::html(nl2br($tpl['option_arr']['o_bank_account'])); ?></div>
						<div class="tsElementOutline">
							<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
						</div>
						
						<?php
						$thankyou_page = $tpl['option_arr']['o_thankyou_page'];
						if (!empty($thankyou_page) && preg_match('/^http(s)?:\/\//i', $thankyou_page))
						{
							?>
							<script type="text/javascript">
							window.setTimeout(function () {
								window.location.href = '<?php echo $thankyou_page; ?>';
							}, 3000);
							</script>
							<?php
						}
						break;
					case 'creditcard':
					case 'none':
					default:
						?>
						<div class="tsElement tsElementOutline"><?php echo $status[1]; ?></div>
						<div class="tsElementOutline">
							<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
						</div>
						
						<?php
						$thankyou_page = $tpl['option_arr']['o_thankyou_page'];
						if (!empty($thankyou_page) && preg_match('/^http(s)?:\/\//i', $thankyou_page))
						{
							?>
							<script type="text/javascript">
							window.setTimeout(function () {
								window.location.href = '<?php echo $thankyou_page; ?>';
							}, 3000);
							</script>
							<?php
						}
				}
			} else {
				?><div class="tsElement tsElementOutline"><?php echo $status[4]; ?></div><?php
			}
			?>
			</div>
		</div>
	</div>
	<?php
} elseif (isset($tpl['status']) && $tpl['status'] == 'ERR') {
	?>
	<div class="tsBox">
		<div class="tsServicesInner">
			<div class="tsHeading"><?php __('front_system_msg'); ?></div>
			<div class="tsOverflowHidden">
				<div class="tsElement tsElementOutline"><?php __('front_booking_na'); ?></div>
				<div class="tsElementOutline">
					<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
					<input type="button" value="<?php __('front_return_back', false, true); ?>" class="tsSelectorButton tsSelectorPreview tsButton tsButtonGray" />
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>