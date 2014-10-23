var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var tabs = ($.fn.tabs !== undefined),
			$tabs = $("#tabs");
		
		if ($tabs.length > 0 && tabs) {
			$tabs.tabs();
		}
		
		$(".field-int").spinner({
			min: 0
		});
		
		function reDrawCode() {
			var code = $("#hidden_code").text(),
				layout = $("select[name='layout']").find("option:selected").val(),
				locale = $("select[name='install_locale']").find("option:selected").val(),
				hide = $("input[name='install_hide']").is(":checked") ? "&hide=1" : "";
			locale = typeof locale !== "undefined" && locale !== null && parseInt(locale.length, 10) > 0 ? "&locale=" + locale : "";
			layout = parseInt(layout.length, 10) > 0 ? "&layout=" + layout : "";		
			$("#install_code").text(code.replace(/(&cid=\d+)/g, function(match, p1) {
	            return [p1, layout, locale, hide].join("");
	        }));
		}
		
		$("#content").on("focus", ".textarea_install", function (e) {
			var $this = $(this);
			$this.select();
			$this.mouseup(function() {
				$this.unbind("mouseup");
				return false;
			});
		}).on("keyup", "#uri_page", function (e) {
			console.log(this.value);
			var tmpl = $("#hidden_htaccess").text(),
				index = this.value.indexOf("?");
			$("#install_htaccess").text(tmpl.replace('::URI_PAGE::', index >= 0 ? this.value.substring(0, index) : this.value));
		}).on("change", "select[name='layout']", function (e) {
			
			var $this = $(this),
				$selected = $this.find("option:selected"),
				val = $selected.val();

			if (val == 2 && $selected.data("ok") == 0) {
				$("#weekly_warn").show();
				$(".install_stuff, #btnPreview").hide();
			} else {
				$("#weekly_warn").hide();
				$(".install_stuff, #btnPreview").show();
			}
			
			reDrawCode.call(null);
			
		}).on("change", "select[name='install_locale']", function(e) {
            
            reDrawCode.call(null);
            
		}).on("change", "input[name='install_hide']", function (e) {
			
			reDrawCode.call(null);
			
		}).on("change", "select[name='value-enum-o_send_email']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'mail|smtp::mail':
				$(".boxSmtp").hide();
				break;
			case 'mail|smtp::smtp':
				$(".boxSmtp").show();
				break;
			}
		}).on("change", "input[name='value-bool-o_allow_paypal']", function (e) {
			if ($(this).is(":checked")) {
				$(".boxPaypal").show();
			} else {
				$(".boxPaypal").hide();
			}
		}).on("change", "input[name='value-bool-o_allow_authorize']", function (e) {
			if ($(this).is(":checked")) {
				$(".boxAuthorize").show();
			} else {
				$(".boxAuthorize").hide();
			}
		}).on("change", "input[name='value-bool-o_allow_bank']", function (e) {
			if ($(this).is(":checked")) {
				$(".boxBank").show();
			} else {
				$(".boxBank").hide();
			}
		});
	});
})(jQuery_1_8_2);