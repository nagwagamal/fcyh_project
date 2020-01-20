
var range = 1;
function slots( num )
{
    if ( range > 0 )
    {
        if ( num == range )
        {
            Devony = "";
            for(var i=0;i<lengthsName.length;i++)
            {
            	Devony +=('<div class="col-xs-4" style="margin:3px 0 3px 0;"><input type="hidden" name="wood-lengh-' + range + '-'+ lengthsName[i] +'" value="'+ lengthsName[i] +'" value="" /><input class="form-control" style="border-radius:4px;" type="text" name="wood-numbers-' + range + '-'+ lengthsName[i] +'" placeholder="العدد ( طول '+ lengthsName[i] +' سم )" value="" /></div>');
            }

            Devoy = ('<div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" type="text" name="wood-numbers-' + range + '-upnormal_0" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" type="text" name="wood-length-' + range + '-upnormal_0" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" type="text" name="wood-numbers-' + range + '-upnormal_1" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" type="text" name="wood-length-' + range + '-upnormal_1" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" type="text" name="wood-numbers-' + range + '-upnormal_2" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" type="text" name="wood-length-' + range + '-upnormal_2" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_3" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_3" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_4" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_4" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_5" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_5" placeholder="أطوال شاذة" value="" /></div></div>');

            var devo = '<div class="form-group"><div class="col-sm-10"><div align="center" style="padding-top:10px;border:rgb(234,239,244) 1px solid;min-height:500px;"><div align="center"><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="cat-' + range + '" id="cat-' + range + '"><option value="" selected>[اختر الصنف]</option>'+ cats +'</select></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="city-' + range + '" id="city-' + range + '"><option value="" selected>[اختر البلد]</option>'+ cities +'</select></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="dimension-' + range + '" id="dimension-' + range + '"><option value="" selected>[اختر المقاس]</option>'+ dimensions +'</select></div></div><div align="center"><div class="col-xs-4" style="margin:3px 0 3px 0;"><input class="form-control" style="border-radius:4px;" id="total-numbers-' + range + '" type="text" name="total-numbers-' + range + '" placeholder="العدد الكلي للرابطة" value="" /></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><input class="form-control" style="border-radius:4px;" id="unit-' + range + '" type="text" name="unit-' + range + '" placeholder="رقم الرابطة ( سيتم إنشاءه تلقائي )" value="" /></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="degree-' + range + '" id="degree-' + range + '"><option value="" selected>[اختر الدرجة]</option>'+ degrees +'</select></div></div><div align="center"><div class="col-xs-12" style="margin:3px 0 3px 0;"><input class="form-control" style="border-radius:4px;text-align:center" type="text" name="price-' + range + '" id="price-' + range + '" placeholder="سعر الرابطة" value="" /></div></div><div align="center">'+Devony+' <div align="center">'+Devoy+'</div></div></div></div><label class="col-sm-2 control-label"> رابطة '+ (range + 1) +' ( <b><a onClick="slots(' + (range + 1) + ')" style="cursor:pointer;"> المزيد ؟</a></b> )</label></div>';
            $('div#inputsContainer').append(devo);

            range++;
            document.ShipManagment.range.value = range;
        }
    }
}




//$("button#addNewSellButton").on("click", function(e) {
$('form#SellManagmentForm').submit( function(e) {
	q = $(this);
	e.preventDefault();
	var _error = false;
	/*$("#client_name").css('background-color', '#FFF');
	$("#sell_date").css('background-color', '#FFF');
	$("#sell_weeks").css('background-color', '#FFF');*/

	var client_Id = $("#client_id").val();
	if(client_Id == ""){
		/*$("#client_name").css('background-color', '#FFEDEF');
        $("#client_name").fadeOut(500);
        $("#client_name").fadeIn(500);*/
		alert("يتوجب عليك إدخال إسم العميل أولاً");
		$("#client_name").focus();
		_error = true;
	}else{
		var sellDate = $("#sell_date").val();
		if(sellDate == ""){
			/*$("#client_name").css('background-color', '#FFF');
			$("#sell_date").css('background-color', '#FFEDEF');
			$("#sell_date").fadeOut(500);
			$("#sell_date").fadeIn(500);*/
			alert("يتوجب عليك إختيار تاريخ الصرف أولاً");
			$("#sell_date").focus();
			_error = true;
		}else{
			var sellWeeks = $("#sell_weeks").val();
			if(sellWeeks == 0){
				/*$("#sell_date").css('background-color', '#FFF');
				$("#sell_weeks").css('background-color', '#FFEDEF');
				$("#sell_weeks").fadeOut(500);
				$("#sell_weeks").fadeIn(500);*/
				alert("يتوجب عليك إختيار عدد أسابيع السداد أولاً");
				$("#sell_weeks").focus();
				_error = true;
			}else{
				$("#sell_weeks").css('background-color', '#FFF');
				var Range = $("#Range").val();
				var unitIds = new Array();
				var catIds = new Array();
				var dimensionIds = new Array();
				var degreeIds = new Array();
				var cityIds = new Array();
				var totalNumbers = new Array();
				var priceValues = new Array();

				for(i = 0;i<Range ; i++) {
					unitIds[i] = $("#unit-"+i).val();
					catIds[i] = $("#cat-"+i).val();
					cityIds[i] = $("#city-"+i).val();
					dimensionIds[i] = $("#dimension-"+i).val();
					degreeIds[i] = $("#degree-"+i).val();
					totalNumbers[i] = $("#total-numbers-"+i).val();
					priceValues[i] = $("#price-"+i).val();
					if($("#cat-"+i).val() == 0)
					{
						alert("يتوجب عليك إختيار الصنف للرابطة "+Number(i+1));
						$("#cat-"+i).focus();
						_error = true;
					}else if($("#city-"+i).val() == 0)
					{
						alert("يتوجب عليك إختيار البلد للرابطة "+Number(i+1));
						$("#city-"+i).focus();
						_error = true;
					}else if($("#dimension-"+i).val() == 0)
					{
						alert("يتوجب عليك إختيار المقاس  للرابطة "+Number(i+1));
						$("#dimension-"+i).focus();
						_error = true;
					}else if($("#degree-"+i).val() == 0)
					{
						alert("يتوجب عليك إختيار الدرجة للرابطة "+Number(i+1));
						$("#degree-"+i).focus();
						_error = true;
					}else if($("#price-"+i).val() == "")
					{
						alert("يتوجب عليك كتابة سعر الرابطة للرابطة "+Number(i+1));
						$("#price-"+i).focus();
						_error = true;
					}else if($("#total-numbers-"+i).val() == "")
					{
						alert("يتوجب عليك كتابة العدد الكلي للرابطة "+Number(i+1));
						$("#total-numbers-"+i).focus();
						_error = true;
					}
				}
				if(_error == false)
				{
					Nu = "";

					$.ajax( {
						async :true,
						type :"POST",
						url :"sell.html?do=checkQuantity",
						data: {"catIds": (catIds), "cityIds": cityIds, "dimensionIds": dimensionIds, "degreeIds": degreeIds, "unitIds": unitIds, "totalNumbers": totalNumbers},
						success : function(data) {
							alert(data);
							Nu = Number(data);
							if(Nu != 0){
								$("#cat-"+Number(Nu-1)).focus();
								alert("عفوا بيانات الرابطة الخاص ببيان "+(Nu)+" غير موجود في المخزن أو أقل من المطلوب صرفه");
							}else if(Nu == 0)
							{
								//$("form#ShipManagment").submit();
								q.unbind('submit').submit();
							}
						},
						error : function() {
							alert("error");
						}
					});
				}
			}
		}
	}

});


