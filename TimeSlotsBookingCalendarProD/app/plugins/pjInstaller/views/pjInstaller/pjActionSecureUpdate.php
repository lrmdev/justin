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
	?>
	<style type="text/css">
	.ui-widget {
	    font-family: inherit;
	    font-size: inherit;
	}
	.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {
	    font-family: inherit;
	    font-size: inherit;
	}
	</style>
	<div class="i-wrap">
		
		<?php
		pjUtil::printNotice('Database Update', 'You can update either to specified database version or more than just one.', true, false);
		?>
		
		<div id="grid"></div>
		
		<div id="grid_plugins" class="t20"></div>

		<div id="dialogExecute" style="display: none" title="Execute confirmation">Are you sure you want to execute selected file?
			<label class="i-error-clean" style="display: none"></label>
		</div>

		<script type="text/javascript">
		var myLabel = myLabel || {};
		myLabel.name = 'File name';
		myLabel.plugin = 'Plugin';
		myLabel.execute = 'Execute';
		myLabel.execute_selected = 'Execute Selected';
		myLabel.confirm_selected = 'Are you sure you want to execute selected file(s)?';
		</script>
	
	</div>
	<?php
}
?>