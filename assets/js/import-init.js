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

            Devoy = ('<div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_0" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_0" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_1" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_1" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_2" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_2" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_3" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_3" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_4" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_4" placeholder="أطوال شاذة" value="" /></div></div><div class="abnormal"><div style="margin:3px 0 3px 0;" class="abnormalFirst col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-numbers-' + range + '-upnormal_5" placeholder="العدد" value="" /></div><div style="margin:3px 0 3px 0;" class="abnormalSecond col-xs-2"><input class="form-control" style="text-align:center;" type="text" name="wood-length-' + range + '-upnormal_5" placeholder="أطوال شاذة" value="" /></div></div>');

            var devo = '<div class="form-group"><div class="col-sm-10"><div align="center" style="padding-top:10px;border:rgb(234,239,244) 1px solid;min-height:463px;"><div align="center"><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="cat-' + range + '"><option value="" selected>[اختر الصنف]</option>'+ cats +'</select></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="city-' + range + '"><option value="" selected>[اختر البلد]</option>'+ cities +'</select></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="dimension-' + range + '"><option value="" selected>[اختر المقاس]</option>'+ dimensions +'</select></div></div><div align="center"><div class="col-xs-4" style="margin:3px 0 3px 0;"><input class="form-control" style="border-radius:4px;" id="total-numbers-' + range + '" type="text" name="total-numbers-' + range + '" placeholder="العدد الكلي للرابطة" value="" /></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><input class="form-control" style="border-radius:4px;" id="unit-' + range + '" type="text" name="unit-' + range + '" placeholder="رقم الرابطة ( سيتم إنشاءه تلقائي )" value="" /></div><div class="col-xs-4" style="margin:3px 0 3px 0;"><select class="_select_ form-control" name="degree-' + range + '"><option value="" selected>[اختر الدرجة]</option>'+ degrees +'</select></div></div><div align="center">'+Devony+' <div align="center">'+Devoy+'</div></div></div></div><label class="col-sm-2 control-label"> رابطة '+ (range + 1) +' ( <b><a onClick="slots(' + (range + 1) + ')" style="cursor:pointer;"> المزيد ؟</a></b> )</label></div>';
            $('div#inputsContainer').append(devo);





            //$('div#inputsContainer').append('</div></div></div><label class="col-sm-2 control-label">رابطة '+ (range + 1) +' ( <b><a onClick="slots(' + (range + 1) + ')" style="cursor:pointer;"> المزيد ؟</a></b> )</label></div>');

            range++;
            document.ShipManagment.range.value = range;
        }
    }
}

//$("button#addNewImportButton").on("click", function(e) {
//$("form#ShipManagment").on("submit", function(e) {
$('form#ImportManagmentForm').submit( function(e) {
	q = $(this);
	e.preventDefault();
	var _error = false;

	var supplierId = $("#supplier_id").val();
	if(supplierId == ""){
		alert("يتوجب عليك إدخال إسم المورد أولاً");
		$("#supplier_name").focus();
		_error = true;
	}else{
		var boatName = $("#boat_name").val();
		if(boatName == ""){
			alert("يتوجب عليك إدخال إسم المركب أولاً");
			$("#boat_name").focus();
			_error = true;
		}else{
			var Range = $("#Range").val();
			var unitIds = new Array();
			var catIds = new Array();
			var dimensionIds = new Array();
			var degreeIds = new Array();
			var cityIds = new Array();
			var totalNumbers = new Array();

			for(i = 0;i<Range ; i++) {
				unitIds[i] = $("#unit-"+i).val();
				catIds[i] = $("#cat-"+i).val();
				cityIds[i] = $("#city-"+i).val();
				dimensionIds[i] = $("#dimension-"+i).val();
				degreeIds[i] = $("#degree-"+i).val();
				totalNumbers[i] = $("#total-numbers-"+i).val();
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
					url :"imports.html?do=checkUnit",
					data: "unitIds=" + unitIds,
					success : function(data) {
						Nu = Number(data);
						if(Nu != 0){
							$("#unit-"+Number(Nu-1)).focus();
							alert("عفوا رقم الرابطة الخاص ببيان "+(Nu)+" تمت إضافته سابقاً");
						}else if(Nu == 0)
						{
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
});
