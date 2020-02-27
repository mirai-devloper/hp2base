(function($) {
	"use strict";
	$(document).ready(function() {
		var elem = $('#freepage');
		var elemFind = elem.find('.values');
		var layout = elemFind.find('.layout');
		layout.each(function() {
			var _this = this;
			var titleMain = $(this).find('.acf-fc-layout-handle');
			var html = titleMain.html();
			var link_text = $(this).find('.link_text .acf-input-wrap :input');

			$('<span />', {
				class: 'link_text_after'
			}).appendTo(titleMain);
			
			$('.link_text_after', this).text(' ('+link_text.val()+')');
			console.log($(this).find('.acf-fc-layout-handle').text());

			link_text.on('keyup', function() {
				var val = $(this).val();
				$('.link_text_after', _this).text(' (' + val + ')');
			});
		});
	});
})(jQuery);
