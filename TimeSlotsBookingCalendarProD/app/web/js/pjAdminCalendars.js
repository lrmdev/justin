var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmCreateCalendar = $("#frmCreateCalendar"),
			$frmUpdateCalendar = $("#frmUpdateCalendar"),
			$dialogBookingDelete = $("#dialogBookingDelete"),
			$dialogTimeslotDelete = $("#dialogTimeslotDelete"),
			datagrid = ($.fn.datagrid !== undefined),
			dialog = ($.fn.dialog !== undefined),
			validate = ($.fn.validate !== undefined);
		
		if ($frmCreateCalendar.length > 0 && validate) {
			$frmCreateCalendar.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		if ($frmUpdateCalendar.length > 0 && validate) {
			$frmUpdateCalendar.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		
		function onBeforeShow (obj) {
			if (parseInt(obj.id, 10) === pjGrid.currentCalendarId) {
				return false;
			}
			return true;
		}
		
		function formatTitle(val, obj) {
			return ['<a href="index.php?controller=pjAdmin&action=pjActionRedirect&nextController=pjAdminCalendars&nextAction=pjActionView&calendar_id=', obj.id, '&nextParams=', encodeURIComponent("id=" + obj.id), '">', val, '</a>'].join("");
		}
		
		if ($("#grid").length > 0 && datagrid) {
			
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjAdminCalendars&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminCalendars&action=pjActionDeleteCalendar&id={:id}", beforeShow: onBeforeShow}
				          ],
				columns: [{text: myLabel.title, type: "text", sortable: true, editable: false, width: 280, renderer: formatTitle},
				          {text: myLabel.email, type: "text", sortable: true, editable: false, width: 165},
				          {text: myLabel.name, type: "date", sortable: true, editable: false, width: 160}
				          ],
				dataUrl: "index.php?controller=pjAdminCalendars&action=pjActionGetCalendar",
				dataType: "json",
				fields: ['title', 'email', 'name'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminCalendars&action=pjActionDeleteCalendarBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminCalendars&action=pjActionSaveCalendar&id={:id}",
				select: {
					field: "id",
					name: "record[]"
				}
			});
		}
		
		$(document).on("submit", ".frm-filter", function (e) {
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
			$grid.datagrid("load", "index.php?controller=pjAdminCalendars&action=pjActionGetCalendar", "id", "ASC", content.page, content.rowCount);
			return false;
		});
			
		function getSlots(dt) {
			var $gridReservations = $("#gridReservations");
			$gridReservations.html("");
			$.get("index.php?controller=pjAdminCalendars&action=pjActionGetSlots", {
				"date": dt
			}).done(function (data) {
				$gridReservations.html(data);
			});
		}
		
		function getCalendar(m, y) {
			$.get("index.php?controller=pjAdminCalendars&action=pjActionGetCal", {
				"month": m, 
				"year": y
			}).done(function (data) {
				$(".tsContainerCalendar:first").html(data);
			});
		}

		if ($(".tsContainerCalendar").length > 0) {
			var dt = new Date(),
				iso = [dt.getFullYear(), dt.getMonth() + 1, dt.getDate()].join("-");
			getCalendar.call(null, dt.getMonth() + 1, dt.getFullYear());
			getSlots.call(null, iso);
		}
		
		$(".tsContainerCalendar").on("click", ".tsCalendarDate, .tsCalendarFull, .tsCalendarPast", function (e) {
			getSlots.call(null, $(this).data("iso"));
		}).on("click", ".tsCalendarLinkMonth", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			
			var $this = $(this);
			getCalendar.call(null, $this.data("month"), $this.data("year"));
			$("#gridReservations").html("");
			
			return false;
		});
			
		$("#gridReservations").on("click", ".timeslot-delete", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogTimeslotDelete.length > 0 && dialog) {
				var $this = $(this);
				$dialogTimeslotDelete
					.data("id", $this.data('id'))
					.data("iso", $this.data('iso'))
					.dialog('open');
			}
			return false;
		}).on("click", "a.booking-delete", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			if ($dialogBookingDelete.length > 0 && dialog) {
				var $this = $(this);
				$dialogBookingDelete
					.data("booking_id", $this.data('booking_id'))
					.data("iso", $this.data('iso'))
					.dialog('open');
			}
			return false;
		});
		
		if ($dialogTimeslotDelete.length > 0 && dialog) {
			$dialogTimeslotDelete.dialog({
				autoOpen: false,
				resizable: false,
				draggable: false,
				modal: true,
				close: function(){
					tsApp.enableButtons.call(null, $dialogTimeslotDelete);
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.erase] = function() {
						tsApp.disableButtons.call(null, $dialogTimeslotDelete);
						var dt = $dialogTimeslotDelete.data('iso').split("-");
						$.post("index.php?controller=pjAdminCalendars&action=pjActionDeleteTimeslot", {
							"id": $dialogTimeslotDelete.data('id')
						}).done(function (data) {
							if (data.status == 'OK') {
								getCalendar.call(null, dt[1], dt[0]);
								getSlots.call(null, $dialogTimeslotDelete.data('iso'));
								$dialogTimeslotDelete.dialog('close');
								noty({text: data.text, type: "success"});
							} else {
								noty({text: data.text, type: "error"});
								tsApp.enableButtons.call(null, $dialogTimeslotDelete);
							}
						});
					};
					buttons[tsApp.locale.button.cancel] = function() {
						$dialogTimeslotDelete.dialog('close');
					};
					
					return buttons;
				})()
			});
		}
		
		if ($dialogBookingDelete.length > 0 && dialog) {
			$dialogBookingDelete.dialog({
				autoOpen: false,
				resizable: false,
				draggable: false,
				modal: true,
				close: function() {
					tsApp.enableButtons.call(null, $dialogBookingDelete);
				},
				buttons: (function () {
					var buttons = {};
					buttons[tsApp.locale.button.erase] = function() {
						tsApp.disableButtons.call(null, $dialogBookingDelete);
						var dt = $dialogBookingDelete.data('iso').split("-");
						$.post("index.php?controller=pjAdminCalendars&action=pjActionDeleteBooking", {
							"booking_id": $dialogBookingDelete.data("booking_id")
						}).done(function (data) {
							if (data.status == 'OK') {
								getCalendar.call(null, dt[1], dt[0]);
								getSlots.call(null, $dialogBookingDelete.data("iso"));
								$dialogBookingDelete.dialog('close');
								noty({text: data.text, type: "success"});
							} else {
								noty({text: data.text, type: "error"});
								tsApp.enableButtons.call(null, $dialogBookingDelete);
							}
						});
									
					};
					buttons[tsApp.locale.button.cancel] = function() {
						$dialogBookingDelete.dialog('close');
					};
					
					return buttons;
				})()
			});
		}
	});
})(jQuery_1_8_2);