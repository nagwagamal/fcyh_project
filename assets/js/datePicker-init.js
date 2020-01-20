	$( ".datePicker" ).datepicker({
		dateFormat: "yyyy-MM-ddThh:mm",
		beforeShow: function(input, inst) {
			var widget = $(inst).datepicker('widget');
			widget.css('margin-right', $(input).outerWidth() - widget.outerWidth());
		}
	});
