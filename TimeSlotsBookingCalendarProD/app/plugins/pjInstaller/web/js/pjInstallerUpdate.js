var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $dialogExecute = $("#dialogExecute"),
			datagrid = ($.fn.datagrid !== undefined),
			dialog = ($.fn.dialog !== undefined);
		
		function formatButton(str, obj) {
			return ['<input type="button" value="', myLabel.execute, '" class="pj-button btn-execute" data-name="', obj.name, 
			        '" data-module="', typeof obj.plugin !== "undefined" ? 'plugin' : 'script',
			        '" data-path="', obj.path, '" />'].join("");
		}
		
		if ($("#grid").length > 0 && datagrid) {
			var $grid = $("#grid").datagrid({
				buttons: [],
				columns: [{text: myLabel.name, type: "text", sortable: false, editable: false, width: 830},
				          {text: "", type: "text", sortable: false, editable: false, width: 100, align: "center", renderer: formatButton}],
				dataUrl: "index.php?controller=pjInstaller&action=pjActionSecureGetUpdate&module=script",
				dataType: "json",
				fields: ['name', 'path'],
				paginator: {
					actions: [
					   {text: myLabel.execute_selected, url: "index.php?controller=pjInstaller&action=pjActionSecureSetUpdate&module=script", render: false, confirmation: myLabel.confirm_selected}
					],
					gotoPage: false,
					paginate: false,
					total: true,
					rowCount: false
				},
				saveUrl: null,
				select: {
					field: "path",
					name: "record[]"
				}
			});
		}
		
		if ($("#grid_plugins").length > 0 && datagrid) {
			var $grid_plugins = $("#grid_plugins").datagrid({
				buttons: [],
				columns: [{text: myLabel.name, type: "text", sortable: false, editable: false, width: 500},
				          {text: myLabel.plugin, type: "text", sortable: false, editable: false, width: 320},
				          {text: "", type: "text", sortable: false, editable: false, width: 100, align: "center", renderer: formatButton}],
				dataUrl: "index.php?controller=pjInstaller&action=pjActionSecureGetUpdate&module=plugin",
				dataType: "json",
				fields: ['name', 'plugin', 'path'],
				paginator: {
					actions: [
					   {text: myLabel.execute_selected, url: "index.php?controller=pjInstaller&action=pjActionSecureSetUpdate&module=plugin", render: false, confirmation: myLabel.confirm_selected}
					],
					gotoPage: false,
					paginate: false,
					total: true,
					rowCount: false
				},
				saveUrl: null,
				select: {
					field: "path",
					name: "record[]"
				}
			});
		}
		
		$(document).on("click", ".btn-execute", function (e) {
			if ($dialogExecute.length > 0 && dialog) {
				var $this = $(this);
				$dialogExecute
					.data("name", $this.data("name"))
					.data("path", $this.data("path"))
					.data("module", $this.data("module"))
					.dialog("open");
			}
		});
		
		if ($dialogExecute.length > 0 && dialog) {
			$dialogExecute.dialog({
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				close: function () {
					$dialogExecute.find(".i-error-clean").hide().html("");
				},
				buttons: {
					"Execute": function () {
						$.post("index.php?controller=pjInstaller&action=pjActionSecureSetUpdate", {
							"name": $dialogExecute.data("name"),
							"path": $dialogExecute.data("path"),
							"module": $dialogExecute.data("module")
						}).done(function (data) {
							if (data.status == "OK") {
								$dialogExecute.dialog("close");
							} else {
								$dialogExecute.find(".i-error-clean").html(data.text).show();
							}
						});
					},
					"Cancel": function () {
						$dialogExecute.dialog("close");
					}
				}
			});
		}
		
	});
})(jQuery_1_8_2);