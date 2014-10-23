var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	"use strict";
	$(function () {
		var dialog = ($.fn.dialog !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			datepicker = ($.fn.datepicker !== undefined),
			validate = ($.fn.validate !== undefined),
			buttonset = ($.fn.buttonset !== undefined),
			spinner = ($.fn.spinner !== undefined),
			invoice_id = $("#frmUpdateInvoice > input[name='id']").val(),
			tmp = $("#frmCreateInvoice > input[name='tmp']").val(),
			$dialogDeleteLogo = $("#dialogDeleteLogo"),
			$dialogSendInvoice = $("#dialogSendInvoice"),
			$dialogAddItem = $("#dialogAddItem"),
			$dialogEditItem = $("#dialogEditItem");

		$(document).on("search", ".frm-filter", function (e) {
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val()
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjInvoice&action=pjActionGetInvoices", "created", "DESC", content.page, content.rowCount);
			
		}).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $form = $(this),
				$q = $form.find("input[name='q']");
			$q.val($q.val().replace(/^\s+|\s+$/g, ""));
			$form.trigger("search");
			return false;
		}).on("focusout", "input[name='qty'], input[name='unit_price']", function () {
			var $form = $(this).closest("form"),
				$amount = $form.find("input[name='amount']"),
				qty = parseFloat($form.find("input[name='qty']").val()),
				unit_price = parseFloat($form.find("input[name='unit_price']").val());
			
			if (!isNaN(qty) && !isNaN(unit_price)) {
				$amount.val((qty * unit_price).toFixed(2));
			} else {
				$amount.val("");
			}
		}).on("change", "select[name='foreign_id']", function (e) {
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				foreign_id: $this.find("option:selected").val()
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjInvoice&action=pjActionGetInvoices", "created", "DESC", content.page, content.rowCount);
		});
		
		if (buttonset) {
			$("#boxStatus").buttonset();
		}
		
		function formatDefault (str) {
			return myLabel[str] || str;
		}
		
		function formatOrderId (str) {
			return ['<a href="', myLabel.booking_url.replace('{ORDER_ID}', str), '">', str, '</a>'].join("");
		}
		
		function formatTotal (str, obj) {
			return obj.total_formated;
		}
		
		function formatCreated(str) {
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
				return $.datagrid.formatDate(new Date(y, m, d, hh, mm, ss), pjGrid.jsDateFormat + ", hh:mm:ss");
			}
		}
		
		if ($("#grid").length > 0 && datagrid) {
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjInvoice&action=pjActionUpdate&id={:id}", title: "Edit"},
				          {type: "delete", url: "index.php?controller=pjInvoice&action=pjActionDelete&id={:id}", title: "Delete"}],
				columns: [
				    {text: myLabel.num, type: "text", sortable: true, editable: false},
				    {text: myLabel.order_id, type: "text", sortable: true, editable: false, renderer: formatOrderId},
				    {text: myLabel.issue_date, type: "date", sortable: true, editable: false, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				    {text: myLabel.due_date, type: "date", sortable: true, editable: false, renderer: $.datagrid._formatDate, dateFormat: pjGrid.jsDateFormat},
				    {text: myLabel.created, type: "text", sortable: true, editable: false, renderer: formatCreated},
				    {text: myLabel.status, type: "text", sortable: true, editable: false, renderer: formatDefault},	
				    {text: myLabel.total, type: "text", sortable: true, editable: false, align: "right", renderer: formatTotal}
				],
				dataUrl: "index.php?controller=pjInvoice&action=pjActionGetInvoices",
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
			
			var m = window.location.href.match(/&q=(.*)/);
			if (m !== null) {
				$(".frm-filter").trigger("search");
			}
			
			m = window.location.href.match(/&(foreign_id=)(\d+)?/);
			if (m !== null) {
				var $this = $(this),
					content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache");
				$.extend(cache, {
					foreign_id: m[2] !== undefined ? m[2] : ""
				});
				$grid.datagrid("option", "cache", cache);
				$grid.datagrid("load", "index.php?controller=pjInvoice&action=pjActionGetInvoices", "created", "DESC", content.page, content.rowCount);
			}
		}
		
		function formatItem(val, obj) {
			return ['<span class="bold">', val, '</span><br>', obj.description].join("");
		}
		
		function formatQty(val) {
			if (typeof pjGrid !== "undefined" && pjGrid.qty_is_int) {
				return parseInt(val, 10);
			}
			
			return val;
		}
		
		if ($("#grid_items").length > 0 && datagrid) {
			var $grid = $("#grid_items").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjInvoice&action=pjActionUpdateItem&id={:id}", title: "Edit"},
				          {type: "delete", url: "index.php?controller=pjInvoice&action=pjActionDeleteItem&id={:id}", title: "Delete"}],
				columns: [
				    {text: myLabel.i_item, type: "text", sortable: true, editable: true, width: 330, editableWidth: 290, renderer: formatItem},
				    {text: myLabel.i_qty, type: "text", sortable: true, editable: false, width: 70, align: "right", renderer: formatQty},
				    {text: myLabel.i_unit, type: "text", sortable: true, editable: false, width: 100, align: "right"},
				    {text: myLabel.i_amount, type: "text", sortable: true, editable: false, width: 100, align: "right"}
				],
				dataUrl: "index.php?controller=pjInvoice&action=pjActionGetItems&invoice_id=" + invoice_id,
				dataType: "json",
				fields: ['name', 'qty', 'unit_price_formated', 'amount_formated'],
				paginator: false,
				saveUrl: "index.php?controller=pjInvoice&action=pjActionSaveItem&id={:id}",
				select: false
			});
			
			if (tmp !== undefined) {
				var content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache");
				$.extend(cache, {
					tmp: tmp
				});
				$grid.datagrid("option", "cache", cache);
				window.setTimeout(function () {
					$grid.datagrid("load", "index.php?controller=pjInvoice&action=pjActionGetItems", "id", "ASC", content.page, content.rowCount);
				}, 2000);
			}
		}
		
		$("#content").on("click", ".plugin_invoice_delete_logo", function () {
			if ($dialogDeleteLogo.length > 0 && dialog) {
				$dialogDeleteLogo.dialog("open");
			}
		}).on("click", ".plugin_invoice_add_item", function () {
			if ($dialogAddItem.length > 0 && dialog) {
				$dialogAddItem.dialog("open");
			}
		}).on("change", "input[name='p_accept_paypal'], input[name='p_accept_authorize'], input[name='p_accept_bank']", function () {
			var $this = $(this);
			if ($this.is(":checked")) {
				$($this.data("box")).show();
			} else {
				$($this.data("box")).hide();
			}
		}).on("focusin", ".datepick", function () {
			if (datepicker) {
				var $this = $(this);
				$this.datepicker({
					firstDay: $this.attr("rel"),
					dateFormat: $this.attr("rev")
				});
			}
		}).on("click", ".btnInvoiceView", function () {
			var $frm = $("#frmPluginInvoiceView");
			if ($frm.length > 0) {
				$frm.submit();
			}
		}).on("click", ".btnInvoicePrint", function () {
			var $frm = $("#frmPluginInvoicePrint");
			if ($frm.length > 0) {
				$frm.submit();
			}
		}).on("click", ".btnInvoiceSend", function () {
			if ($dialogSendInvoice.length > 0 && dialog) {
				$dialogSendInvoice.data('uuid', $(this).data('uuid')).dialog("open");
			}
		});
		
		$(document).ajaxSuccess(function(event, xhr, settings, data) {
			if (settings.url.match(/index\.php\?controller=pjInvoice&action=pjActionDeleteItem&id=\d+/) !== null && data.status && data.status === "OK" && data.total) {
				$("#total").val(data.total.toFixed(2));
			}
		});
		
		$("#grid_items").on("click", ".pj-table-icon-edit", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogEditItem.length > 0 && dialog) {
				$dialogEditItem.data('id', $(this).data('id').id).dialog("open");
			}
			return false;
		});
		
		if ($dialogSendInvoice.length > 0 && dialog) {
			var buttons = {};
			buttons[myLabel.btn_send] = function () {
				var $this = $(this);
				$.post("index.php?controller=pjInvoice&action=pjActionSend", $dialogSendInvoice.find("form").serialize()).always(function () {
					$this.dialog("close");
				});
			};
			buttons[myLabel.btn_cancel] = function () {
				$(this).dialog("close");
			};
			$dialogSendInvoice.dialog({
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				width: 770,
				open: function () {
					var $this = $(this);
					$dialogSendInvoice.html("");
					$.get("index.php?controller=pjInvoice&action=pjActionSend", {
						"uuid": $this.data("uuid")
					}).done(function (data) {
						$dialogSendInvoice.html(data);
					}).always(function () {
						$dialogSendInvoice.dialog("option", "position", "center");
					});
				},
				buttons: buttons
			});
		}
		
		if ($dialogDeleteLogo.length > 0 && dialog) {
			
			var buttons = {};
			buttons[myLabel.btn_delete] = function () {
				var $this = $(this);
				$.post("index.php?controller=pjInvoice&action=pjActionDeleteLogo").done(function () {
					$("#plugin_invoice_box_logo").html('<input type="file" name="y_logo" id="y_logo" />')
				}).always(function () {
					$this.dialog("close");
				});
			};
			buttons[myLabel.btn_cancel] = function () {
				$(this).dialog("close");
			};
			
			$dialogDeleteLogo.dialog({
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				buttons: buttons
			});
		}
		
		var itemOpts = {
			rules: {
				"name": "required",
				"qty": {
					required: true,
					number: true
				},
				"unit_price": {
					required: true,
					number: true
				},
				"amount": {
					required: true,
					number: true
				}
			},
			errorPlacement: function (error, element) {
				error.insertAfter(element.parent());
			}
		};
		
		var spinOpts = {
			min: 0,
			numberFormat: "n",
			step: 0.1
		};

		if (typeof pjGrid !== "undefined" && pjGrid.qty_is_int) {
			spinOpts.numberFormat = null;
			spinOpts.step = 1;
		}
		
		if ($dialogAddItem.length > 0 && dialog) {
			var buttons = {};
			buttons[myLabel.btn_save] = function () {
				var $this = $(this),
					$form = $dialogAddItem.find("form");
				
				if ($form.length > 0 && validate) {
					var validator = $form.validate(itemOpts);
					if (validator.form()) {
						$.post("index.php?controller=pjInvoice&action=pjActionAddItem", $form.serialize()).done(function (data) {
							if (data.status === "OK" && data.total) {
								$("#total").val(data.total.toFixed(2));
							}
							var content = $grid.datagrid("option", "content");
							$grid.datagrid("load", "index.php?controller=pjInvoice&action=pjActionGetItems&invoice_id=" + invoice_id, "id", "ASC", content.page, content.rowCount);
						}).always(function () {
							$this.dialog("close");
						});
					}
				}
			};
			buttons[myLabel.btn_cancel] = function () {
				$(this).dialog("close");
			};
			$dialogAddItem.dialog({
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				width: 560,
				open: function () {
					$dialogAddItem.html("");
					$.get("index.php?controller=pjInvoice&action=pjActionAddItem", {
						"invoice_id": invoice_id,
						"tmp": tmp
					}).done(function (data) {
						$dialogAddItem.html(data);
						if (spinner) {
							$dialogAddItem.find("input[name='qty']").spinner(spinOpts);
						}
					}).always(function () {
						$dialogAddItem.dialog("option", "position", "center");
					});
				},
				buttons: buttons
			});
		}
		
		if ($dialogEditItem.length > 0 && dialog) {
			var buttons = {};
			buttons[myLabel.btn_update] = function () {
				var $this = $(this),
					$form = $dialogEditItem.find("form");
				
				if ($form.length > 0 && validate) {
					var validator = $form.validate(itemOpts);
					if (validator.form()) {
						$.post("index.php?controller=pjInvoice&action=pjActionEditItem", $form.serialize()).done(function () {
							var content = $grid.datagrid("option", "content");
							$grid.datagrid("load", "index.php?controller=pjInvoice&action=pjActionGetItems&invoice_id=" + invoice_id, "id", "ASC", content.page, content.rowCount);
						}).always(function () {
							$this.dialog("close");
						});
					}
				}
			};
			buttons[myLabel.btn_cancel] = function () {
				$(this).dialog("close");
			};
			$dialogEditItem.dialog({
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				width: 560,
				open: function () {
					$dialogEditItem.html("");
					$.get("index.php?controller=pjInvoice&action=pjActionEditItem", {
						"id": $(this).data("id")
					}).done(function (data) {
						$dialogEditItem.html(data);
						if (spinner) {
							$dialogEditItem.find("input[name='qty']").spinner(spinOpts);
						}
					}).always(function () {
						$dialogEditItem.dialog("option", "position", "center");
					});
				},
				buttons: buttons
			});
		}
		
		if (window.tinyMCE !== undefined) {
			tinyMCE.init({
				// General options
				mode : "textareas",
				theme : "advanced",
				editor_selector : "mceEditor",
				editor_deselector : "mceNoEditor",
				plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,formatselect,fontselect,fontsizeselect,justifyleft,justifycenter,justifyright,justifyfull,|,ltr,rtl,|,cite,abbr,acronym,del,ins,attribs",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,visualchars,nonbreaking,template,blockquote,pagebreak",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,insertfile,insertimage,insertdate,inserttime,|,forecolor,backcolor",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				width: "710"
			});
		}
	});
})(jQuery_1_8_2);