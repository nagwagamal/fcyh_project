
	$(function() {
		$("input#supplier_name").autocomplete({
			url: 'search.html?do=suppliers',
			showResult: function(value, data) {
				return '<span style="color:green">' + value + '</span>';
			},
			onItemSelect: function(item) {
				$("input#supplier_id").val(item.data);
			},
			mustMatch: true,
			maxItemsToShow: 5,
			selectFirst: false,
			autoFill: false,
			selectOnly: true
		});
	});


	$(function() {
		$("input#client_name").autocomplete({
			url: 'search.html?do=clients',
			showResult: function(value, data) {
				return '<span style="color:green">' + value + '</span>';
			},
			onItemSelect: function(item) {
				$("input#client_id").val(item.data);
			},
			mustMatch: true,
			maxItemsToShow: 5,
			selectFirst: false,
			autoFill: false,
			selectOnly: true
		});
	});

	$(function() {
		$("input#i_client_name").autocomplete({
			url: 'search.html?do=invoices&mode=client',
			showResult: function(value, data) {
				return '<span style="color:green">' + value + '</span>';
			},
			onItemSelect: function(item) {
				$("input#i_client_id").val(item.data[0]);
				$("input#credit").val(item.data[1]);
				$("b#_credit_").text(item.data[1]);
				$("div#credit_to_hide").css("display","block");
			},
			mustMatch: true,
			maxItemsToShow: 5,
			selectFirst: false,
			autoFill: false,
			selectOnly: true
		});
	});

	$(function() {
		$("input#i_supplier_name").autocomplete({
			url: 'search.html?do=invoices&mode=supplier',
			showResult: function(value, data) {
				return '<span style="color:green">' + value + '</span>';
			},
			onItemSelect: function(item) {
				$("input#i_supplier_id").val(item.data[0]);
				$("input#credit").val(item.data[1]);
				$("b#_credit_").text(item.data[1]);
				$("div#credit_to_hide").css("display","block");
			},
			mustMatch: true,
			maxItemsToShow: 5,
			selectFirst: false,
			autoFill: false,
			selectOnly: true
		});
	});
