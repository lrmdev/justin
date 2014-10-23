<div class="tsBox tsCalendarOuter">
	<div class="tsCalendarInner">
		<div class="tsHeading"><?php __('front_select_date'); ?></div>
		<div class="tsSelectorCalendarWrap">
		<?php
		list($year, $month,) = explode("-", $_GET['date']);
		echo $tpl['calendar']->getMonthHTML((int) $month, $year);
		if ((int) $tpl['option_arr']['o_show_legend'] === 1)
		{
			echo $tpl['calendar']->getLegend(__('legend', true));
		}
		?>
		</div>
		
		<div class="tsElementOutline">
			<?php if ((int) $tpl['option_arr']['o_show_legend'] === 1) : ?>
			<input type="button" class="tsButton tsButtonGray tsSelectorButton tsSelectorToggleLegend" value="<?php __('front_button_legend', false, true); ?>" />
			<?php endif; ?>
			<input type="button" class="tsButton tsButtonGray tsSelectorButton tsSelectorCart" value="<?php
			$slots = $controller->cart->getCount();
			if ($slots != 1)
			{
				printf(__('front_button_basket_plural', true, true), $slots);
			} else {
				printf(__('front_button_basket_singular', true, true), $slots);
			}
			?>" />
			<?php
			if (!$controller->cart->isEmpty())
			{
				?><input type="button" class="tsButton tsButtonGreen tsSelectorButton tsSelectorCheckout tsFloatRight" value="<?php __('front_button_checkout', false, true); ?>" /><?php
			}
			?>
		</div>
	</div>
</div>