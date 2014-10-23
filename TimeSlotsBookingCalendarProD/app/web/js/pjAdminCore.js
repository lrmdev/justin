var tsApp = tsApp || {};
var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var button = ($.fn.button !== undefined);
		
		$(window.document).on("mouseenter", ".pj-table tbody tr", function () {
			$(this).addClass("pj-table-row-hover");
		}).on("mouseleave", ".pj-table tbody tr", function () {
			$(this).removeClass("pj-table-row-hover");
		}).on("mouseenter", ".pj-button", function () {
			$(this).addClass("pj-button-hover");
		}).on("mouseleave", ".pj-button", function () {
			$(this).removeClass("pj-button-hover");
		}).on("mouseenter", ".pj-checkbox", function () {
			$(this).addClass("pj-checkbox-hover");
		}).on("mouseleave", ".pj-checkbox", function () {
			$(this).removeClass("pj-checkbox-hover");
		});

		$("#content").on("click", ".notice-close", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).closest(".notice-box").fadeOut();
			return false;
		});
		
		$("#leftmenu").on("change", ".setForeignId", function () {
			var cid = $("option:selected", this).val();
			if (cid !== "" && cid.length > 0) {
				var $this = $(this);
				window.location.href = ["index.php?controller=pjAdmin&action=pjActionRedirect&nextController=", $this.data("controller"), "&nextAction=", $this.data("action"), "&calendar_id=", cid, "&nextParams=", encodeURIComponent("id=" + cid)].join("");
			}
		});
		
		if ($.noty !== undefined) {
			$.noty.defaults = $.extend($.noty.defaults, {
				layout: "bottomRight",
				timeout: 3000
			});
		}
		
		tsApp.enableButtons = function ($dialog) {
			if ($dialog.length > 0 && button) {
				$dialog.siblings(".ui-dialog-buttonpane").find("button").button("enable");
			}
		};
		
		tsApp.disableButtons = function ($dialog) {
			if ($dialog.length > 0 && button) {
				$dialog.siblings(".ui-dialog-buttonpane").find("button").button("disable");
			}
		};
	});
})(jQuery_1_8_2);