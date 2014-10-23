<form action="" method="post" class="pj-form form">
	<input type="hidden" name="invoice_edit" value="1" />
	<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
	<p>
		<label class="title"><?php __('plugin_invoice_i_name'); ?></label>
		<span><input type="text" name="name" class="pj-form-field w300" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['name'])); ?>" /></span>
	</p>
	<p>
		<label class="title"><?php __('plugin_invoice_i_description'); ?></label>
		<span><textarea name="description" class="pj-form-field w350 h120"><?php echo htmlspecialchars(stripslashes($tpl['arr']['description'])); ?></textarea></span>
	</p>
	<p>
		<label class="title"><?php __('plugin_invoice_i_qty'); ?></label>
		<input type="text" name="qty" class="pj-form-field w100" value="<?php echo (float) $tpl['arr']['qty']; ?>" />
	</p>
	<p>
		<label class="title"><?php __('plugin_invoice_i_unit'); ?></label>
		<span class="pj-form-field-custom pj-form-field-custom-before">
			<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, !empty($tpl['arr']['currency']) ? $tpl['arr']['currency'] : $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
			<input type="text" name="unit_price" class="pj-form-field w80 align_right" value="<?php echo (float) $tpl['arr']['unit_price']; ?>" />
		</span>
	</p>
	<p>
		<label class="title"><?php __('plugin_invoice_i_amount'); ?></label>
		<span class="pj-form-field-custom pj-form-field-custom-before">
			<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, !empty($tpl['arr']['currency']) ? $tpl['arr']['currency'] : $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
			<input type="text" name="amount" class="pj-form-field w80 align_right" value="<?php echo (float) $tpl['arr']['amount']; ?>" />
		</span>
	</p>
</form>