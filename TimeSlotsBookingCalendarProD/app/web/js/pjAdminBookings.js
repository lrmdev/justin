var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var validator,
			$bookingForm,
			$frmCreateBooking = $("#frmCreateBooking"),
			$frmUpdateBooking = $("#frmUpdateBooking"),
			$dialogItemDelete = $("#dialogItemDelete"),
			$dialogItemAdd = $("#dialogItemAdd"),
			$dialogReminderEmail = $("#dialogReminderEmail"),
			$dialogReminderSms = $("#dialogReminderSms"),
			$dialogExport = $("#dialogExport"),
			$boxSchedule = $("#boxSchedule"),
			tabs = ($.fn.tabs !== undefined),
			dialog = ($.fn.dialog !== undefined),
			spinner = ($.fn.spinner !== undefined),
			validate = ($.fn.validate !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			datepicker = ($.fn.datepicker !== undefined);
		
		function getSchedule(date) {
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetSchedule", {
				"date": date
			}).done(function (data) {
				$("#boxSchedule").find(".datepick").datepicker("destroy");
				$("#boxSchedule").html(data);
			});
		}
		
		if ($boxSchedule.length > 0) {
			var dt = new Date();
			getSchedule.call(null, [dt.getFullYear(), dt.getMonth() + 1, dt.getDate()].join("-"));
		}
		
		function getBookingItems($form) {
			$.get("index.php?controller=pjAdminBookings&action=pjActionItemGet", $form.find("input[name='id'], input[name='hash']").serialize()).done(function (data) {
				$("#boxBookingItems").html(data);
			});
		}
		
		if ($frmCreateBooking.length > 0 && validate) {
			$frmCreateBooking.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
			
			$bookingForm = $frmCreateBooking;
		}
		
		if (tabs) {
			$("#tabs").tabs();
		}
		
		if ($frmUpdateBooking.length > 0) {
			
			$frmUpdateBooking.on("click", ".btnCreateInvoice", function () {
				$("#frmCreateInvoice").trigger("submit");
			});
			
			if (validate) {
				$frmUpdateBooking.validate({
					errorPlacement: function (error, element) {
						error.insertAfter(element.parent());
					},
					onkeyup: false,
					errorClass: "err",
					wrapper: "em"
				});
			}
			
			getBookingItems.call(null, $frmUpdateBooking);
			
			$bookingForm = $frmUpdateBooking;
		}
		
		function formatDateTime(str) {
			if (str === null || str.length === 0) {
				return myLabel.empty_datetime;
			}
			
			if (str === '0000-00-00 00:00:00') {
				return myLabel.invalid_datetime;
			}
			
			if (str.match(/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/) !== null) {
				var x = str.split(" "),
					date = x[0],
					time = x[1],
					dx = date.split("-"),
					tx = time.split(":"),
					y = dx[0],
					m = parseInt(dx[1], 10) - 1,
					d = dx[2],
					hh = tx[0],
					mm = tx[1],
					ss = tx[2];
				return $.datagrid.formatDate(new Date(y, m, d, hh, mm, ss), pjGrid.jsDateFormat + ", hh:mm");
			}
		}
		
		function formatSlots(str, obj) {
			var tmp,
				arr = [];
			for (var i = 0, iCnt = obj.items.length; i < iCnt; i++) {
				tmp = obj.items[i].split("~.~");
				arr.push([tmp[0], ', ', tmp[1], '-', tmp[2]].join(""));
			}
			
			return arr.join("<br />");
		}
		
		function formatClient (str, obj) {
			return [obj.customer_name, 
			        (obj.customer_email && obj.customer_email.length > 0 ? ['<br><a href="mailto:', obj.customer_email, '">', obj.customer_email, '</a>'].join('') : ''), 
			        (obj.customer_phone && obj.customer_phone.length > 0 ? ['<br>', obj.customer_phone].join('') : '')
			        ].join("");
		}
		
		function formatDefault (str) {
			return myLabel[str] || str;
		}
		
		function formatId (str) {
			return ['<a href="index.php?controller=pjInvoice&action=pjActionUpdate&id=', str, '">#', str, '</a>'].join("");
		}
		
		function formatTotal(val, obj) {
			return obj.total_formated;
		}
		
		if ($("#grid").length > 0 && datagrid) {
			
			var options = {
				buttons: [{type: "edit", url: "index.php?controller=pjAdminBookings&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminBookings&action=pjActionDeleteBooking&id={:id}"}
				          ],
				columns: [{text: myLabel.uuid, type: "text", sortable: true, editable: false, width: 90},
				          {text: myLabel.slots, type: "text", sortable: true, editable: false, renderer: formatSlots, width: 175},
				          {text: myLabel.customer, type: "text", sortable: true, editable: false, renderer: formatClient},
				          {text: myLabel.total, type: "text", sortable: true, editable: false, align: "right", renderer: formatTotal},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, width: 90, options: [
				                                                                                     {label: myLabel.confirmed, value: 'confirmed'},
				                                                                                     {label: myLabel.pending, value: 'pending'},
				                                                                                     {label: myLabel.cancelled, value: 'cancelled'}
				                                                                                     ], applyClass: "pj-status"}],
				dataUrl: "index.php?controller=pjAdminBookings&action=pjActionGetBooking",
				dataType: "json",
				fields: ['uuid', 'id', 'customer_name', 'booking_total', 'booking_status'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminBookings&action=pjActionDeleteBookingBulk", render: true, confirmation: myLabel.delete_confirmation},
					   {text: myLabel.export_selected, url: "javascript:void(0);", render: false, ajax: false}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminBookings&action=pjActionSaveBooking&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			};
			
			var cache = {},
				m1 = window.location.href.match(/&booking_status=(\w+)/),
				m2 = window.location.href.match(/&employee_id=(\d+)/);
			if (m1 !== null) {
				options.cache = $.extend(cache, {"booking_status" : m1[1]});
			}
			if (m2 !== null) {
				options.cache = $.extend(cache, {"employee_id" : m2[1]});
			}
			
			var $grid = $("#grid").datagrid(options);
		}
		
		if ($("#grid_invoices").length > 0 && datagrid) {
			var $grid_invoices = $("#grid_invoices").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjInvoice&action=pjActionUpdate&id={:id}", title: "Edit"},
				          {type: "delete", url: "index.php?controller=pjInvoice&action=pjActionDelete&id={:id}", title: "Delete"}],
				columns: [
				    {text: myLabel.num, type: "text", sortable: true, editable: false, renderer: formatId},
				    {text: myLabel.order_id, type: "text", sortable: true, editable: false},
				    {text: myLabel.issue_date, type: "date", sortable: true, editable: false, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				    {text: myLabel.due_date, type: "date", sortable: true, editable: false, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				    {text: myLabel.created, type: "text", sortable: true, editable: false, renderer: formatDateTime},
				    {text: myLabel.status, type: "text", sortable: true, editable: false, renderer: formatDefault},	
				    {text: myLabel.total, type: "text", sortable: true, editable: false, align: "right", renderer: formatTotal}
				],
				dataUrl: "index.php?controller=pjInvoice&action=pjActionGetInvoices&q=" + $frmUpdateBooking.find("input[name='uuid']").val(),
				dataType: "json",
				fields: ['id', 'order_id', 'issue_date', 'due_date', 'created', 'status', 'total'],
				paginator: {
					actions: [
					   {text: myLabel.delete_title, url: "index.php?controller=pjInvoice&action=pjActionDeleteBulk", render: true, confirmation: myLabel.delete_body}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				select: {
					field: "id",
					name: "record[]"
				}
			});
		}
		
		$("#content").on("click", ".item-add", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogItemAdd.length > 0 && dialog) {
				$dialogItemAdd.dialog("open");
			}
			return false;
		}).on("click", ".item-delete", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogItemDelete.length > 0 && dialog) {
				var $this = $(this);
				$dialogItemDelete
					.data("id", $this.data("id"))
					.data("hash", $this.data("hash"))
					.data("key", $this.data("key"))
					.dialog("open");
			}
			return false;
		}).on("click", ".reminder-email", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogReminderEmail.length > 0 && dialog) {
				$dialogReminderEmail.data("id", $(this).data("id")).dialog("open");
			}
			return false;
		}).on("click", ".reminder-sms", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogReminderSms.length > 0 && dialog) {
				$dialogReminderSms.data("id", $(this).data("id")).dialog("open");
			}
			return false;
		}).on("click", ".order-calc", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				$form = $this.closest("form");
			$.post("index.php?controller=pjAdminBookings&action=pjActionGetPrice", $form.serialize()).done(function (data) {
				if (data.status == 'OK') {
					$form.find("#booking_price").val(data.data.price.toFixed(2));
					$form.find("#booking_deposit").val(data.data.deposit.toFixed(2));
					$form.find("#booking_tax").val(data.data.tax.toFixed(2));
					$form.find("#booking_total").val(data.data.total.toFixed(2));
					noty({text: data.text, type: "success"});
				}
			});
			return false;
		}).on("change", "#payment_method", function () {
			if ($("option:selected", this).val() == 'creditcard') {
				$(".erCC").show();
			} else {
				$(".erCC").hide();
			}
		}).on("click", ".schedule_get", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			getSchedule.call(null, $(this).data("iso"));
			return false;
		});
		
		$(document).on("focusin", ".datepick", function (e) {
			var $this = $(this);
			$this.datepicker({
				firstDay: $this.attr("rel"),
				dateFormat: $this.attr("rev"),
				onSelect: function (dateText, inst) {
					switch (inst.input.attr("name")) {
					case "schedule_date":
						getSchedule.call(null, [inst.selectedYear, inst.selectedMonth + 1, inst.selectedDay].join("-"));
						break;
					case "date":
						onChange.call(inst.input.get(0));
						break;
					}
				}
			});
		}).on("click", ".btn-all", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			var content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				booking_status: "",
				q: ""
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
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
			obj.booking_status = "";
			obj[$this.data("column")] = $this.data("value");
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
			return false;
		}).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val()
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
			return false;
		}).on("click", ".pj-form-field-icon-date", function (e) {
			var $dp = $(this).parent().siblings("input[type='text']");
			if ($dp.hasClass("hasDatepicker")) {
				$dp.datepicker("show");
			} else {
				$dp.trigger("focusin").datepicker("show");
			}
		}).on("click", ".pj-button-detailed, .pj-button-detailed-arrow", function (e) {
			e.stopPropagation();
			$(".pj-form-filter-advanced").slideToggle();
		}).on("submit", ".frm-filter-advanced", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var obj = {},
				$this = $(this),
				arr = $this.serializeArray(),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			for (var i = 0, iCnt = arr.length; i < iCnt; i++) {
				obj[arr[i].name] = arr[i].value;
			}
			cache.q = "";
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
			return false;
		}).on("reset", ".frm-filter-advanced", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(".pj-button-detailed").trigger("click");
			return false;
		}).on("click.as", ".asSlotAvailable", function (e) {	
			
			var $this = $(this),
				$form = $this.closest("form");
			
			if ($this.hasClass("asSlotSelected")) {
				$this.removeClass("asSlotSelected");
				
				$form.find("input[name='employee_id']").val("");
				$form.find("input[name='start_ts']").val("");
				$form.find("input[name='end_ts']").val("");
			} else {
				$form.find(".asSlotBlock").removeClass("asSlotSelected");
				$this.addClass("asSlotSelected");
				
				$form.find("input[name='employee_id']").val($this.data("employee_id"));
				$form.find("input[name='start_ts']").val($this.data("start_ts"));
				$form.find("input[name='end_ts']").val($this.data("end_ts"));
			}
		});
		
		$("#grid").on("click", "a.pj-paginator-action:last", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($(".pj-table-select-row:checked").length > 0 && $dialogExport.length > 0 && dialog) {
				$dialogExport.dialog("open");
				$(this).closest(".pj-menu-list-wrap").hide();
			}
			return false;
		});
		
		function onChange() {
			var $el = $(this),
				$form = $el.closest("form"),
				$dialog = $form.parent(),
				$details = $form.find(".item_details");
			
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetSlots", $form.find("input[name='booking_id'], input[name='hash'], input[name='date']").serialize()).done(function (data) {
				$details.html(data).show();
				$dialog.dialog("option", "position", "center");
			});
		}

		var aiOpts = {
			rules: {
				"date": "required"
			},
			ignore: ".ignore"
		};
		
		if ($dialogItemAdd.length > 0 && dialog) {
			$dialogItemAdd.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				width: 800,
				open: function () {
					$dialogItemAdd.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionItemAdd", $bookingForm.find("input[name='id'], input[name='hash']").serialize()).done(function (data) {
						$dialogItemAdd.html(data);
						validator = $dialogItemAdd.find("form").validate(aiOpts);
						$dialogItemAdd.dialog("option", "position", "center");
						onChange.call($dialogItemAdd.find("input[name='date']").get(0));
					});
				},
				close: function () {
					tsApp.enableButtons.call(null, $dialogItemAdd);
					$dialogItemAdd.find(".datepick").datepicker("destroy");
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.add] = function () {
						if (validator.form()) {
							tsApp.disableButtons.call(null, $dialogItemAdd);
							$.post("index.php?controller=pjAdminBookings&action=pjActionItemAdd", $dialogItemAdd.find("form").serialize()).done(function (data) {
								if (data.status == "OK") {
									getBookingItems.call(null, $bookingForm);
									$dialogItemAdd.dialog("close");
									noty({text: data.text, type: "success"});
								} else {
									noty({text: data.text, type: "error"});
									tsApp.enableButtons.call(null, $dialogItemAdd);
								}
							});
						}
					};
					buttons[tsApp.locale.button.cancel] = function () {
						$dialogItemAdd.dialog("close");
					};
					return buttons;
				})()
			});
		}
		
		if ($dialogItemDelete.length > 0 && dialog) {
			$dialogItemDelete.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				close: function () {
					tsApp.enableButtons.call(null, $dialogItemDelete);
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.erase] = function () {
						tsApp.disableButtons.call(null, $dialogItemDelete);
						$.post("index.php?controller=pjAdminBookings&action=pjActionItemDelete", {
							"id": $dialogItemDelete.data("id"),
							"hash": $dialogItemDelete.data("hash"),
							"key": $dialogItemDelete.data("key")
						}).done(function (data) {
							if (data.status == "OK") {
								getBookingItems.call(null, $bookingForm);
								$dialogItemDelete.dialog("close");
								noty({text: data.text, type: "success"});
							} else {
								noty({text: data.text, type: "error"});
								tsApp.enableButtons.call(null, $dialogItemDelete);
							}
						});
					};
					buttons[tsApp.locale.button.cancel] = function () {
						$dialogItemDelete.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
		
		if ($dialogReminderEmail.length > 0 && dialog) {
			$dialogReminderEmail.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				width: 640,
				open: function () {
					$dialogReminderEmail.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionReminderEmail", {
						"id": $dialogReminderEmail.data("id")
					}).done(function (data) {
						$dialogReminderEmail.html(data);
						validator = $dialogReminderEmail.find("form").validate({
							errorPlacement: function (error, element) {
								error.insertAfter(element.parent());
							},
							errorClass: "error_clean"
						});
						$dialogReminderEmail.dialog("option", "position", "center");
					});
				},
				close: function () {
					tsApp.enableButtons.call(null, $dialogReminderEmail);
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.send] = function () {
						if (validator.form()) {
							tsApp.disableButtons.call(null, $dialogReminderEmail);
							$.post("index.php?controller=pjAdminBookings&action=pjActionReminderEmail", $dialogReminderEmail.find("form").serialize()).done(function (data) {
								if (data.status == "OK") {
									$dialogReminderEmail.dialog("close");
									noty({text: data.text, type: "success"});
								} else {
									noty({text: data.text, type: "error"});
									tsApp.enableButtons.call(null, $dialogReminderEmail);
								}
							});
						}
					};
					buttons[tsApp.locale.button.cancel] = function () {
						$dialogReminderEmail.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
		
		if ($dialogReminderSms.length > 0 && dialog) {
			$dialogReminderSms.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				width: 640,
				open: function () {
					$dialogReminderSms.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionReminderSms", {
						"id": $dialogReminderSms.data("id")
					}).done(function (data) {
						$dialogReminderSms.html(data);
						validator = $dialogReminderSms.find("form").validate({
							errorPlacement: function (error, element) {
								error.insertAfter(element.parent());
							},
							errorClass: "error_clean"
						});
						$dialogReminderSms.dialog("option", "position", "center");
					});
				},
				close: function () {
					tsApp.enableButtons.call(null, $dialogReminderSms);
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.send] = function () {
						if (validator.form()) {
							tsApp.disableButtons.call(null, $dialogReminderSms);
							$.post("index.php?controller=pjAdminBookings&action=pjActionReminderSms", $dialogReminderSms.find("form").serialize()).done(function (data) {
								if (data.status == "OK") {
									$dialogReminderSms.dialog("close");
									noty({text: data.text, type: "success"});
								} else {
									noty({text: data.text, type: "error"});
									tsApp.enableButtons.call(null, $dialogReminderSms);
								}
							});
						}
					};
					buttons[tsApp.locale.button.cancel] = function () {
						$dialogReminderSms.dialog("close");
					};
					
					return buttons;
				})()
			});
		}
		
		if ($dialogExport.length > 0 && dialog) {
			$dialogExport.dialog({
				modal: true,
				resizable: false,
				draggable: false,
				autoOpen: false,
				open: function () {
					$dialogExport.html("");
					$.get("index.php?controller=pjAdminBookings&action=pjActionExport").done(function (data) {
						$dialogExport.html(data);
						$dialogExport.dialog("option", "position", "center");
					});
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.ship] = function () {
						var i, iCnt,
							$form = $dialogExport.find("form"),
							records = $grid.find(".pj-table-select-row").serializeArray();
						
						for (i = 0, iCnt = records.length; i < iCnt; i++) {
							$("<input>", {
								"type": "hidden",
								"name": records[i].name,
								"value": records[i].value
							}).appendTo($form);
						}
						
						$form.get(0).submit();
						$dialogExport.dialog("close");
					};
					buttons[tsApp.locale.button.cancel] = function () {
						$dialogExport.dialog("close");
					};
					
					return buttons;
				})()
			}).on("change", "select[name='format']", function () {
				if ($(this).find("option:selected").val() == "csv") {
					$dialogExport.find(".csvRelated").show();
				} else {
					$dialogExport.find(".csvRelated").hide();
				}
			});
		}
		
		$("#content").on("mouseenter", ".editable-area", function (e) {
			var $this = $(this),
				$preview = $this.find(".editable-preview");
			if ($preview.is(":visible")) {
				$this.find(".editable-control").show();
				$preview.addClass("editable-preview-hover");
			}
		}).on("mouseleave", ".editable-area", function (e) {
			var $this = $(this),
				$preview = $this.find(".editable-preview");
			if ($preview.is(":visible")) {
				$this.find(".editable-control").hide();
				$preview.removeClass("editable-preview-hover");
			}
		}).on("click", ".editable-control", function (e) {
			var $this = $(this),
				$area = $this.closest(".editable-area");
			
			$this.hide();
			$area.find(".editable-preview").hide();
			$area.find(".editable-content").show();
		}).on("click", ".editable-cancel", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				$area = $this.closest(".editable-area"),
				$content = $area.find(".editable-content");
			
			$content.hide();
			$content.find(":input:not(select)").val(function () {
				return this.defaultValue;
			});
			$content.find("select option").prop("selected", function () {
				return this.defaultSelected;
			});
			
			$area.find(".editable-preview").show();
			return false;
		});
		
		var editable = ($.fn.editable !== undefined);
		
		if (editable) {
			$.fn.editableform.buttons = '';
			$.fn.editable.defaults.mode = "inline";
		    $.fn.editable.defaults.url = "index.php?controller=pjAdminBookings&action=pjActionSave";
		    $.fn.editable.defaults.success = function(response, newValue) {
		        if (response.status == 'ERR') {
		        	return response.text;
		        }
		    };
			$("#uuid").editable({
				validate: function (value) {
					if($.trim(value) == '') {
				        return 'This field is required';
				    }
				}
			}).on("shown", function (e, editable) {
				editable.input.$input.addClass("pj-form-field");
			});
			
			$("#booking_status").editable().on("shown", function (e, editable) {
				editable.input.$input.addClass("pj-form-field");
			});
			
			$("#customer_notes").editable().on("shown", function (e, editable) {
				editable.input.$input.addClass("pj-form-field w400");
			});
		}
		
	});
})(jQuery_1_8_2);