var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var datepicker = ($.fn.datepicker !== undefined),
			validate = ($.fn.validate !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			dialog = ($.fn.dialog !== undefined),
			spinner = ($.fn.spinner !== undefined),
			qs = "",
			$dialogDayPrice = $("#dialogDayPrice"),
			$frmTimeCustom = $("#frmTimeCustom");
		
		if ($frmTimeCustom.length > 0 && validate) {
			$frmTimeCustom.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		
		if (spinner) {
			$("input.spin").spinner({
				min: 1,
				step: 1,
				max: 65535
			});
		}
		
		$("#content").on("click", ".working_day", function () {
			var $this = $(this),
				$tr = $this.closest("tr"),
				$anchors = $tr.find("a.day-price"),
				$formElements = $tr.find(":input").not(this);
			if ($this.is(":checked")) {
				$formElements.attr("disabled", "disabled");
				$anchors.addClass("disabled");
			} else {
				$formElements.removeAttr("disabled");
				$anchors.removeClass("disabled");
			}
		}).on("change", ".pps", function () {
			
			if ($("#single_price").is(":checked")) {
				$("#boxPPS").html("");
			} else {
				$.ajax({
					type: "POST",
					data: $("#frmTimeCustom").serialize(),
					url: "index.php?controller=pjAdminTime&action=pjActionGetSlots"
				}).success(function (data) {
					$("#boxPPS").html(data);
				});					
			}
		}).on("click", "a.day-price", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			if (!$this.hasClass("disabled") && $dialogDayPrice.length > 0 && dialog) {
				$dialogDayPrice.data('day', $this.data('day')).dialog('open');
			}
			return false;
		}).on("change", "input[name='is_dayoff']", function () {
			var $this = $(this),
				$form = $this.closest("form");
			if ($this.is(":checked")) {
				$form.find(".business").hide();
			} else {
				$form.find(".business").show();
			}
		});
		
		if ($dialogDayPrice.length > 0) {
			$dialogDayPrice.dialog({
				autoOpen: false,
				resizable: false,
				draggable: false,
				height:420,
				width: 460,
				modal: true,
				close: function(){
					$(this).html("");
				},
				open: function () {
					$.get("index.php?controller=pjAdminTime&action=pjActionGetPrices", {
						"day": $dialogDayPrice.data("day")
					}).done(function (data) {
						$dialogDayPrice.html(data);
					});
				},
				buttons: (function() {
					var buttons = {};
					buttons[tsApp.locale.button.save] = function() {
						$.post("index.php?controller=pjAdminTime&action=pjActionSetPrices", $dialogDayPrice.find("form").serialize()).done(function (data) {
							
						});
						$dialogDayPrice.dialog('close');			
					};
					buttons[tsApp.locale.button.erase_all] = function () {
						$.post("index.php?controller=pjAdminTime&action=pjActionSetPrices", {
							"delete": 1,
							"day" : $dialogDayPrice.find("form :input[name='day']").val()
						}).done(function (data) {
							$dialogDayPrice.dialog('close');
						});
					};
					buttons[tsApp.locale.button.cancel] = function() {
						$dialogDayPrice.dialog('close');
					};
					
					return buttons;
				})()
			});
		}

		function formatPrice(str, obj) {
			return obj.price_format;
		}
		
		if ($("#grid").length > 0 && datagrid) {
			
			var m = window.location.href.match(/&type=(employee|calendar)&foreign_id=(\d+)/);
			if (m !== null) {
				qs = m[0];
			}
			
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjAdminTime&action=pjActionUpdateCustom"+qs+"&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminTime&action=pjActionDeleteDate&id={:id}"}
				          ],
				columns: [{text: myLabel.time_date, type: "date", sortable: true, editable: false, width: 75, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				          {text: myLabel.time_start, type: "text", sortable: true, editable: false, width: 85},
				          {text: myLabel.time_end, type: "text", sortable: true, editable: false, width: 85},
				          {text: myLabel.time_lunch_start, type: "text", sortable: true, editable: false, width: 85},
				          {text: myLabel.time_lunch_end, type: "text", sortable: true, editable: false, width: 85},
				          {text: myLabel.time_price, type: "text", sortable: true, editable: false, renderer: formatPrice},
				          {text: myLabel.time_dayoff, type: "select", sortable: true, editable: true, options: [
			     				       {label: myLabel.time_yesno.T, value: 'T'}, 
			     				       {label: myLabel.time_yesno.F, value: 'F'}
			     				       ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminTime&action=pjActionGetDate" + qs,
				dataType: "json",
				fields: ['date', 'start_time', 'end_time', 'start_lunch', 'end_lunch', 'price', 'is_dayoff'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminTime&action=pjActionDeleteDateBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminTime&action=pjActionSaveDate&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			});
		}
		
		$(document).on("click", ".btn-all", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			var content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				"is_dayoff": ""
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminTime&action=pjActionGetDate" + qs, "date", "ASC", content.page, content.rowCount);
			return false;
		}).on("click", ".btn-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache"),
				obj = {};
			$this.addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			obj.is_dayoff = "";
			obj[$this.data("column")] = $this.data("value");
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminTime&action=pjActionGetDate" + qs, "date", "ASC", content.page, content.rowCount);
			return false;
		}).on("focusin", ".datepick", function () {
			if (datepicker) {
				var $this = $(this);
				$this.datepicker({
					firstDay: $this.attr("rel"),
					dateFormat: $this.attr("rev")
				});
			}
		}).on("click", ".pj-form-field-icon-date", function (e) {
			var $dp = $(this).parent().siblings("input[type='text']");
			if ($dp.hasClass("hasDatepicker")) {
				$dp.datepicker("show");
			} else {
				$dp.trigger("focusin").datepicker("show");
			}
		});
	});
})(jQuery_1_8_2);