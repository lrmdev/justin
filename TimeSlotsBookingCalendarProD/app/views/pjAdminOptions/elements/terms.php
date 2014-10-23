<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
<div class="multilang b10"></div>
<?php endif; ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form pj-form clear_both">
	<input type="hidden" name="options_update" value="1" />
	<input type="hidden" name="next_action" value="pjActionIndex" />
	<input type="hidden" name="tab" value="<?php echo @$_GET['tab']; ?>" />
	<?php
	foreach ($tpl['lp_arr'] as $v)
	{
		?>
		<div class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
			<div class="t10">
				<span class="inline_block pt5"><?php __('lblOptionsTermsURL'); ?></span>
			</div>
			<span class="block t5">
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-url"></abbr></span>
					<input name="i18n[<?php echo $v['id']; ?>][terms_url]" type="text" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['terms_url'])); ?>" class="pj-form-field w500" />
				</span>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
				<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
				<?php endif; ?>
			</span>
			<div class="t10">
				<span class="inline_block pt5"><?php __('lblOptionsTermsContent'); ?></span>
			</div>
			<span class="block t5">
				<textarea name="i18n[<?php echo $v['id']; ?>][terms_body]" class="pj-form-field w700 h300"><?php echo stripslashes(@$tpl['arr']['i18n'][$v['id']]['terms_body']); ?></textarea>
				<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
				<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
				<?php endif; ?>
			</span>
		</div>
		<?php
	}
	?>
	<p>
		<input type="submit" class="pj-button" value="<?php __('btnSave'); ?>" />
	</p>
</form>

<?php $locale = isset($_GET['locale']) && (int) $_GET['locale'] > 0 ? (int) $_GET['locale'] : @$tpl['lp_arr'][0]['id']; ?>
<script type="text/javascript">
<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
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
<?php endif; ?>
</script>