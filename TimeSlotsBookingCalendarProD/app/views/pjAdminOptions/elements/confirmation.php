<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
<div class="multilang b10"></div>
<?php endif; ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form pj-form clear_both">
	<input type="hidden" name="options_update" value="1" />
	<input type="hidden" name="next_action" value="pjActionIndex" />
	<input type="hidden" name="tab" value="<?php echo @$_GET['tab']; ?>" />
	
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1"><?php __('tabEmails'); ?></a></li>
			<li><a href="#tabs-2"><?php __('tabSms'); ?></a></li>
		</ul>
		
		<div id="tabs-1">
	
			<fieldset class="fieldset white">
				<legend><?php __('confirmation_client_confirmation'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_subject'); ?></label>
							<input type="text" name="i18n[<?php echo $v['id']; ?>][confirm_subject_client]" class="pj-form-field w500 b10" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['confirm_subject_client'])); ?>" />
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][confirm_tokens_client]" class="pj-form-field w500 h230"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['confirm_tokens_client']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<fieldset class="fieldset white">
				<legend><?php __('confirmation_client_payment'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_subject'); ?></label>
							<input type="text" name="i18n[<?php echo $v['id']; ?>][payment_subject_client]" class="pj-form-field w500 b10" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['payment_subject_client'])); ?>" />
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][payment_tokens_client]" class="pj-form-field w500 h230"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['payment_tokens_client']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<fieldset class="fieldset white">
				<legend><?php __('confirmation_admin_confirmation'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_subject'); ?></label>
							<input type="text" name="i18n[<?php echo $v['id']; ?>][confirm_subject_admin]" class="pj-form-field w500 b10" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['confirm_subject_admin'])); ?>" />
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][confirm_tokens_admin]" class="pj-form-field w500 h230"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['confirm_tokens_admin']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<fieldset class="fieldset white">
				<legend><?php __('confirmation_admin_payment'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_subject'); ?></label>
							<input type="text" name="i18n[<?php echo $v['id']; ?>][payment_subject_admin]" class="pj-form-field w500 b10" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['payment_subject_admin'])); ?>" />
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][payment_tokens_admin]" class="pj-form-field w500 h230"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['payment_tokens_admin']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<fieldset class="fieldset white">
				<legend><?php __('confirmation_client_reminder'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_subject'); ?></label>
							<input type="text" name="i18n[<?php echo $v['id']; ?>][reminder_subject_client]" class="pj-form-field w500 b10" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['reminder_subject_client'])); ?>" />
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('confirmation_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][reminder_tokens_client]" class="pj-form-field w500 h230"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['reminder_tokens_client']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<p>
				<input type="submit" class="pj-button" value="<?php __('btnSave'); ?>" />
			</p>
		</div>
		<div id="tabs-2">
			<fieldset class="fieldset white">
				<legend><?php __('confirm_sms_admin'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('sms_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][confirm_sms_admin]" class="pj-form-field w500 h100"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['confirm_sms_admin']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<fieldset class="fieldset white">
				<legend><?php __('payment_sms_admin'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('sms_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][payment_sms_admin]" class="pj-form-field w500 h100"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['payment_sms_admin']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<fieldset class="fieldset white">
				<legend><?php __('reminder_sms_client'); ?></legend>
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
						<p class="block t5">
							<label class="title" style="width: 180px"><?php __('sms_body'); ?></label>
							<textarea name="i18n[<?php echo $v['id']; ?>][reminder_sms_client]" class="pj-form-field w500 h100"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['reminder_sms_client']); ?></textarea>
							<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
							<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
							<?php endif; ?>
						</p>
					</div>
					<?php
				}
				?>
			</fieldset>
			<p>
				<input type="submit" class="pj-button" value="<?php __('btnSave'); ?>" />
			</p>
		</div>
	</div>
	
</form>
<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1): ?>
<?php $locale = isset($_GET['locale']) && (int) $_GET['locale'] > 0 ? (int) $_GET['locale'] : @$tpl['lp_arr'][0]['id']; ?>
<script type="text/javascript">
(function ($) {
	$(function() {
		$(".multilang").multilang({
			langs: <?php echo $tpl['locale_str']; ?>,
			flagPath: "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/",
			select: function (event, ui) {
				//callback
			}
		});
		$(".multilang").find("a[data-index='<?php echo $locale; ?>']").trigger("click");
	});
})(jQuery_1_8_2);
</script>
<?php endif; ?>