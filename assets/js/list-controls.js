$(document).ready(function(){
	
//		$('th').wrapInner('<span title=" ترتيب "/>').each(function (col) {
//							
//							$(this).hover(
//									function () {
//										$(this).addClass('focus');
//									},
//									function () {
//										$(this).removeClass('focus');
//									}
//							);
//							$(this).click(function () {
//								if ($(this).is('.asc')) {
//									$(this).removeClass('asc');
//									$(this).addClass('desc selected');
//									sortOrder = -1;
//								} else {
//									$(this).addClass('asc selected');
//									$(this).removeClass('desc');
//									sortOrder = 1;
//								}
//								$(this).siblings().removeClass('asc selected');
//								$(this).siblings().removeClass('desc selected');
//								var arrData = $('table').find('tbody >tr:has(td)').get();
//								arrData.sort(function (a, b) {
//									var val1 = $(a).children('td').eq(col).text().toUpperCase().replace("*","");
//									var val2 = $(b).children('td').eq(col).text().toUpperCase().replace("*","");
//									
//									
//									if ($.isNumeric(val1) && $.isNumeric(val2))
//										return sortOrder == 1 ? val1 - val2 : val2 - val1;
//									else
//										return (val1 < val2) ? -sortOrder : (val1 > val2) ? sortOrder : 0;
//								});
//								$.each(arrData, function (index, row) {
//									$('tbody').append(row);
//								});
//							});
//						});
	
	$('a.xlxs').click(function(e){$('table.tableau_eleves').tableExport({type:'xlsx',escape:false,excelstyles:{textAlign: 'center',dir:"ltr"} }); });
	
  $('a.csv').click(function(e){
	$('table.tableau_eleves').tableExport({type: 'xlsx', ignoreColumn: [4,7],ignoreRow: [4,8]});
      });
	
		$('a.pdf').click(function(e){
		  $('table.tableau_eleves').tableExport({type:'pdf',pdfmake:{enabled:true,
			 
			 docDefinition:{pageOrientation:'landscape',
			 defaultStyle:{font:'Mirza',alignment: 'center' ,fontSize: 15,
    RTL: true
 }},
			 fonts:{Mirza: {
					  normal:      'Mirza-Regular.ttf',
					  bold:        'Mirza-Bold.ttf',
					  italics:     'Mirza-Medium.ttf',
					  bolditalics: 'Mirza-SemiBold.ttf'
					}}}},{'a1': [1683.78, 2383.94]});
		  });
	
			$(document).ready(function(){
					  $("#myInput").on("keyup", function() {
						var value = $(this).val().toLowerCase();
						$("#myTable tr").filter(function() {
						  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					  });
					});
	
		    $('a.phone').click(function(e){
			e.preventDefault();
			page=$('#page').val();
			id              = $(this).parent('span').attr('id').replace("active_","");
			mobile_verified = $(this).parent('span').attr('class').replace("pho_","");
			if (confirm($('#lang_phone').val()+" "+$('#lang_name').val()+" ؟ "))
			{
				jQuery.ajax( {
					async :true,
					type :"POST",
					url :page+".php?do=phone",
					data:  "id=" + id + "&mobile_verified="+ mobile_verified,
					success : function(data) {
					if(data == 200)
					{
						
						
						setTimeout(location.reload(), 1000);
					}else if(data == 111)
					{
						alert("we can't Active default items.");
					}
					},
					error : function() {
						return true;
					}
				});
			}
		});
	



	
		$('select.gov').on('change',function(){//change function on country to display all state 
			var govID = $(this).val();
			if(govID){
				$.ajax({
					type:'POST',
					url:'cities.php?do=city',
					data:'gov_id='+govID,
					success:function(html){
						$('select.city').html(html);
										  }
					   }); 
						  }else{
							   $('select.city').html('<option value="">Select country first</option>');
							   }
			});	
	
		$('select.product').on('change',function(){//change function on country to display all state 
        var productID = $(this).val();
        if(productID){
            $.ajax({
                type:'POST',
                url:'orders.php?do=product',
                data:'product_id='+productID,
				
                success:function(html){
                    $('div.price').html(html);
					calc($('.request'))
                                      }
                   }); 
                      }
							
    	});	
	
	$("input.date").datetimepicker({
		step:5 });
//	$('input.getMyDate').on('change',function(){//change function on country to display all state 
//       //$(this).datetimepicker({ step:15 });
//		alert(1);
//		//'<input  autocomplete="off" class="date form-control" style="text-align: right" name="date" value="{if $n}{$n.date}{else}{$u.date}{/if}">';
//			$('div#ahmedKemoz').html('<input  autocomplete="off" class="date form-control" style="text-align: right" name="date" value="dddd">');
//			$("input.date").datetimepicker({ step:15 });	
//							
//    	});	
	
	$('a.email').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id              = $(this).parent('span').attr('id').replace("active_","");
		email_verified = $(this).parent('span').attr('class').replace("eml_","");
		if (confirm($('#lang_email').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=email",
				data:  "id=" + id + "&email_verified="+ email_verified,
				
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.email").attr("title","تم التفعيل");
					$("a.email#"+id+"").css("color","green");
					
				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});
	
	
    $('button.approveTestImport').click(function(e){
        e.preventDefault();
        page=$('#page').val();
		
		id = $(this).parent().attr('id').replace("item_","");
        
		if (confirm($('#lang_approve').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			window.location= 'imports.html?do=approve&id='+id;
		}
	});
  
    
    
    $('a.status_active').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("sta_","");
		if (confirm($('#lang_status').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
			     $("a.status_active").attr("title","تم التفعيل");
					$("a.status_active#"+id+"").attr("class","badge bg-success");
							   

				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
		});
    
 
   $('tr.reps').click(function(e){
            page=$('#page').val();
            id    = $(this).attr('id').replace("tr_","");
			status = $('tr.row_tr_'+id).attr('style');
const urlParams = new URLSearchParams(window.location.search);
const to = urlParams.get('to');
const from = urlParams.get('from');
       if(from!=null||to!=null)
					{
						date =   " and((`date` <= '"+to+"') and (`date` >= '"+from+"' )) ";
					}
                else{
						date = "" ;
					}
       
       if( status == 'display:none')
			{
			   $('tr.row_tr_'+id).attr("style"," ");
			}else{
			   $('tr.row_tr_'+id).attr("style","display:none");
			}
            jQuery.ajax({
                    async :true,
                    type :"POST",
                    url :page+".php?do=reps_product_reports",
                    data:  "product_id=" + id+"&where="+ date,
                    success : function(data) {
						$('td.colRep_'+id).attr("style"," ");
                       /* $('td.colRep_'+id).html('<table class="tableau_eleves table table-bordered table-striped ">'+data+'</table>') ; */
                        $('td.colRep_'+id).html('<table class="tableau_eleves table table-bordered table-striped " style="background-color:gainsboro;text-align: center;background-color: gainsboro;text-align: center;"><td style="padding: 9px;">اسم المندوب</td><td style="padding: 9px;">الكميه </td>'+data+'</table>') ;
                        
                       
                    }
            });
            
        });
    
     $('tr.product').click(function(e){
            page=$('#page').val();
            id= $(this).attr('id').replace("tr_","");
			status = $('tr.row_clt_'+id).attr('style');
			if( status == 'display:none')
			{
			   $('tr.row_clt_'+id).attr("style"," ");
			}else{
			   $('tr.row_clt_'+id).attr("style","display:none");
			}
            jQuery.ajax({
                    async :true,
                    type :"POST",
                    url :page+".php?do=getrep_cltinfo",
                    data:  "rep_id=" + id,
                    success : function(data) {
						$('td.clt_'+id).attr("style"," ");
                        $('td.clt_'+id).html('<table class="tableau_eleves table table-bordered table-striped " style="background-color:gainsboro;text-align: center;background-color: gainsboro;text-align: center;"><td style="padding: 9px;">اسم العميل</td><td style="padding: 9px;">المبيعات </td>'+data+'</table>') ;
                        
                       
                    }
            });
            
        }); 
    
    
	$('a.admin_approval').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("approval_","");
		if (confirm($('#lang_approval').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.admin_approval").attr("title","تم الموافقة");
					$("a.admin_approval#"+id+"").attr("class","badge bg-success");
							   

				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
		});
	$('a.admin_cancel').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("cancel_","");
		if (confirm($('#lang_approval').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.admin_cancel").attr("title","تم الموافقة");
					$("a.admin_cancel#"+id+"").attr("class","badge bg-success");
							   

				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
		});
	$('a.admin_refund').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("refund_","");
		if (confirm($('#admin_refund').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.admin_refund").attr("title","تم الموافقة");
					$("a.admin_refund#"+id+"").attr("class","badge bg-success");
							   

				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
		});
	$('a.status_deactive').click(function(e){
        e.preventDefault();
		page=$('#page').val(); 
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("sta_","");
		
		if (confirm($('#lang_status').val()+" "+$('#lang_name').val()+" ؟ "))
		{	
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{	
					setTimeout(location.reload(), 1000);
					$("a.status_deactive").attr("title"," غير مفعل");
					$("a.status_deactive#"+id+"").attr("class","badge bg-danger");
				}else if(data == 111)
				{	
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});
	
	
	$('a.block_deactive').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		block = $(this).parent('span').attr('class').replace("sta_","");
		if (confirm($('#lang_block').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=block",
				data:  "id=" + id + "&block="+ block,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.block_deactive").attr("title"," الغاء الحظر");
					$("a.block_deactive#"+id+"").attr("class","badge bg-danger");
				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});

	$('a.infr').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		infr = $(this).parent('span').attr('class').replace("sta_","");
		if (confirm("هل انت متأكد من تغير حاله مخالفه لذلك المندوب ؟"))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=infr",
				data:  "id=" + id + "&infr="+ infr,
				success : function(data) {
				
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.infr").attr("title","الغاء المخالفه");
					$("a.infr#"+id+"").attr("class","badge bg-danger");
				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});
	
	
	$('a.block_active').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		block = $(this).parent('span').attr('class').replace("sta_","");
		if (confirm($('#lang_dis_block').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=block",
				data:  "id=" + id + "&block="+ block,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.block_deactive").attr("title","حظر");
					$("a.block_deactive#"+id+"").attr("class","badge bg-danger");
				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});




	
	
    $('button.deleteorder').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent().attr('id').replace("item_","");
		if (confirm(" هل تريد حذف هذا الدواء من الطلب ؟"))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+'.php?do=delete_product',
				data: "id=" + id + "",
				success : function(data) {
				if(data == 116)
				{
					setTimeout(location.reload(), 1000);
				}else if(data == 111)
				{
					alert("we can't delete default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});
	
	$('a.addrequest').click(function(e){
        e.preventDefault();
		
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :'orders.php?do=request',
				success:function(html){
                    $('div.request').append(html);
				},
				error : function() {
					return true;
				}
			});
	});
	
	
	$('a.addtarget').click(function(e){
        e.preventDefault();
		
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :'representatives.php?do=product',
				success:function(html){
                    $('div.target').append(html);
				},
				error : function() {
					return true;
				}
			});
	});
	
	$('button.deletetarget').click(function(e){
        e.preventDefault();
		id = $(this).parent().attr('id').replace("item_","");
		if (confirm(" هل تريد حذف هذا الدواء من التقييم ؟"))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :'representatives.php?do=delete_product',
				data: "id=" + id + "",
				success : function(data) {
				if(data == 116)
				{
					setTimeout(location.reload(), 1000);
				}else if(data == 111)
				{
					alert("we can't delete default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});


	$('button.reset_location').click(function(e){
        e.preventDefault();
		id = $(this).parent().attr('id').replace("item_","");
		if (confirm(" هل تريد اعاده الوضع الافتراضي للاحداثيات ؟"))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :'client_problems.php?do=reset_location',
				data: "id=" + id + "",
				success : function(data) {
				if(data == 116)
				{
					setTimeout(location.reload(), 1000);
				}else if(data == 111)
				{
					alert("هل تريد اعاده الوضع الافتراضي للاحداثيات ؟");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});


	
	
	
    

    

    
	$('button.delete').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=delete",
				data: "id=" + id + "",
				success : function(data) {
				if(data == 116)
				{
					$("#tr_" + id).fadeTo(400, 0, function () { $("#tr_" + id).slideUp(400);});
				}else if(data == 111)
				{
					alert("we can't delete default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});
    
    $( "input[type=checkbox]").on( "click", function() {
        var moh = $('input#boat_sys[type=checkbox]').is(':checked');
        if(moh == true)
        {
            $("div#boat_to_hide").css("display","none");
        }else
        {
            $("div#boat_to_hide").css("display","block");
        }
    });
	
	$( "input[type=radio]").on( "click", function() {
        var moh = $('input.invoice_type[type=radio]').is(':checked');
        if(moh == true)
        {
			valieeno = $('input.invoice_type[type=radio]:checked').val();
            if(valieeno == 2)
			{
				$("div#supplier_to_hide").css("display","none");
				$("div#client_to_hide").css("display","block");
				$("b#_credit_").text("");
				$("div#credit_to_hide").css("display","none");
				$("input#credit").val("");
			}else if(valieeno == 1)
			{
				$("div#supplier_to_hide").css("display","block");
				$("div#client_to_hide").css("display","none");
				$("b#_credit_").text("");
				$("div#credit_to_hide").css("display","none");
				$("input#credit").val("");
			}
        }
    });


	$('button.edit').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		window.location = page+".html?do=edit&id=" + id;
	});
    $('button.testImportedit').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		window.location = page+".html?do=test&id=" + id;
	});

	$('button.view').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		window.location = page+".html?do=view&id=" + id;
	});

	function redirectNow()
	{
		window.location= page+'.html';
	}

	$('a.delete').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('div').attr('id').replace("item_","");
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val().toLowerCase()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".html?do=delete",
				data: "id=" + id + "",
				success : function(data) {
				if(data == 116)
				{
			        setTimeout(redirectNow, 1000);
			        return false;
				}
			},
			error : function() {
					return true;
				}
			});
		}
	});

});
