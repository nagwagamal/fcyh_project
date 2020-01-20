$("input[type='text']#invoice_payed").change(function (e) {
	e.preventDefault();
	var _discount 			= Number($("#discount").val());
	var _client_id 			= Number($("#i_client_id").val());
	var _invoice_payed 		= Number($("#invoice_payed").val());
	var _type 				= Number($("#i_type_id").val());
	var _times 				= Number($("#times").val());
	//alert(_invoice_payed);

	if(_client_id != 0 && _invoice_payed != "" && _discount != 0)
	{
		if(_type == 1)
		{
			if(_times < 10 )
			{
				var _finalPayed = Math.ceil( _invoice_payed - ( _invoice_payed * 7 / 100  ) );
				var _hint = "(تم تطبيق خصم 7% لمرات شراء أقل من 10 مرات)";
				var _disco = 7;
			}else
			{
				var _finalPayed = Math.ceil( _invoice_payed - ( _invoice_payed * 10 / 100  ) );
				var _hint = "(تم تطبيق خصم 10% لمرات شراء تزيد عن 10 مرات)";
				var _disco = 10;
			}
		}else if(_type == 2)
		{
			if(_invoice_payed >= 200 )
			{
				var _finalPayed = Math.ceil( _invoice_payed - ( _invoice_payed * 10 / 100  ) );
				var _hint = "(تم تطبيق خصم 10% لحالة شراء تزيد عن 200 جنيه)";
				var _disco = 10;
			}else
			{
				var _finalPayed = _invoice_payed;
				var _hint = "(لم يتم تطبيق أي خصومات - حالة الشراء أقل من 200 جنيه)";
				var _disco = 0;
			}
		}else if(_type == 3)
		{
			if(_invoice_payed >= 300 )
			{
				var _finalPayed = Math.ceil( _invoice_payed - ( _invoice_payed * 15 / 100  ) );
				var _hint = "(عميل VIP - تم تطبيق خصم 15% لحالة شراء تزيد عن 300 جنيه)";
				var _disco = 15;
			}else
			{
				var _finalPayed = Math.ceil( _invoice_payed - ( _invoice_payed * 10 / 100  ) );
				var _hint = "(عميل VIP - تم تطبيق خصم 10% لحالة شراء تقل عن 300 جنيه)";
				var _disco = 10;
			}

		}else
		{
			var _finalPayed = Math.ceil( _invoice_payed - ( _invoice_payed * _discount / 100  ) );
			var _hint = "( خصم خاص )";
			var _disco = _discount;
		}
		$("#_invoice_final_").html(_finalPayed);
		$("#hint").html(_hint);
		$("#_invoice_final_").fadeOut(500);
		$("#_invoice_final_").fadeIn(500);
		$("#_invoice_final_").css('background-color', '#FFEDEF');
		$("#_invoice_final_").fadeOut(500);
		$("#_invoice_final_").fadeIn(500);
		$("#discount").val(_disco);
	}
});


$("input[type='text']#i_client_number").change(function (e) {
	e.preventDefault();
	var _client_number = ($("#i_client_number").val());
	if(_client_number == "" || _client_number.length != 14)
	{
		alert("يتوجب عليك إدخال رقم الكارت المكون من 14 رقم");
		$("#i_client_number").val("");
	}else
	{
		jQuery.ajax( {
			async :true,
			type :"POST",
			format: "json",
			url :"cards.html?do=get_info",
			data: "number=" + _client_number + "",
			success : function(data) {
				try
				{
					jData = $.parseJSON(data);
				}
				catch(err)
				{
					alert("هذا الرقم خاطئ وغير موجود علي النظام");
					$("#i_client_number").val("");
				}

				if(jData._name != "")
				{
					($("#i_client_id").val(jData._id));
					($("#_i_client_name_").text(jData._name));
					($("#discount").val(jData._discount));
					($("#_points_").html(jData._points));
					($("#points").val(jData._points));
					($("#_times_").html(jData._times));
					($("#times").val(jData._times));
					($("#_discount_").html(jData._discount));
					if(jData._type == 1)
					{
						($("#_i_type_name_").html(_membership_1));
						($("#i_type_id").val(1));
					}else if(jData._type == 2)
					{
						($("#_i_type_name_").html(_membership_2));
						($("#i_type_id").val(2));
					}else if(jData._type == 3)
					{
						($("#_i_type_name_").html(_membership_3));
						($("#i_type_id").val(3));
					}

					// update membership type ( name , id ) , times...
				}else if(jData._status == 0)
				{
					x = confirm("هذا الرقم موجود بالفعل علي النظام ولكن يجب إنشاء عضوية جديدة له , هل تود ؟");
					if(x == true)
					{
						window.location = 'cards.html?do=edit&id='+jData._id;
					}
				}
			},
			error : function() {
				return true;
			}
		});
	}
});
