$( "body" ).on( "click", 'input#contactMe' , function (e) { /* , .complain-rev */
    e.preventDefault();
	$('input#name,input#email,input#mobile,input#subject,textarea#message').css('background-color', '#FFFFFF');
	$('span._error').css('display', 'none');

	_name = $('input#name').val();
	_email = $('input#email').val();
	_mobile = $('input#mobile').val();
	_subject = $('input#subject').val();
	_message = $('textarea#message').val();


	if(_name == "")
	{
		$('input#name').fieldError('name',"يجب إدخال الإسم");
	}else
	{
		if(_email == "")
		{
			$('input#email').fieldError('email',"يجب إدخال البريد الإلكتروني");
		}else
		{
			if(isValidEmailAddress(_email) == false)
			{
				$('input#email').fieldError('email',"يجب كتابة البريد الإلكتروني بشكل صحيح");
			}else
			{
				if(_mobile == "")
				{
					$('input#mobile').fieldError('mobile',"يجب إدخال رقم الهاتف");
				}else
				{
					if(isNaN(_mobile))
					{
						$('input#mobile').fieldError('mobile',"عفوا خانة الهاتف يجب أن تكون أرقام إنجليزية فقط");
					}else
					{
						if( _subject == "")
						{
							$('input#subject').fieldError('subject',"يجب إدخال الموضوع");
						}else
						{
							if(_message == "")
							{
								$('textarea#message').fieldError('message',"يجب كتابة الرسالة");
							}else
							{
								$.ajax( {
									async :true,
									type :"POST",
									cache: false,
									dataType: "json",
									url :"contact.html?do=contactUs",
									data: "mobile="+_mobile+"&name="+_name+"&email="+_email+"&subject="+_subject+"&message="+_message+"",
									success : function(data)
									{
										responseType = data['type'];
										if(responseType == "error")
										{
											errorNumber = data['error_no'];
											if(errorNumber == 1001 )
											{
												$('input#name').fieldError('name',"عفوا يجب كتابة الإسم ");
											}else
											{
												if(errorNumber == 1002 )
												{
													$('input#email').fieldError('mobile',"عفوا يجب كتابة البريد الإلكتروني");
												}else
												{
													if(errorNumber == 1003 )
													{
														$('input#email').fieldError('email',"عفوا يجب كتابة البريد الإلكتروني بطريقة صحيحة");
													}else
													{
														if(errorNumber == 1004 )
														{
															$('input#mobile').fieldError('mobile',"عفوا يجب كتابة رقم الهاتف بطريقة صحيحة");
														}else
														{
															if(errorNumber == 1005 )
															{
																$('textarea#subject').fieldError('subject',"يجب كتابة عنوان الموضوع");
															}else
															{
																if(errorNumber == 1006 )
																{
																	$('textarea#message').fieldError('message',"يجب كتابة نص الرسالة");
																}else
																{
																	$('#message-result').html('<div style="color:green;">تم قبول الرسالة وسيتم الإتصال بك قريباً</div>');
																	$('input#name,input#email,input#mobile,input#subject,textarea#message').val('');
																}
															}
														}
													}
												}
											}
										}else
										{
											$('#message-result').html('<div style="color:green;">تم قبول الرسالة وسيتم الإتصال بك قريباً</div>');
											$('input#name,input#email,input#mobile,input#subject,textarea#message').val('');
										}
									},
									error : function(error) {
										//alert("error response");
										console.log(error);
										responseType = data['type'];
										return true;
									}
								});
							}
						}
					}
				}
			}
		}
	}

});


function isValidEmailAddress(emailAddress)
{
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

$.fn.fieldError = function(attName,errorValue)
{

	if(attName)
	{
		$('span#error_'+attName).css('display', 'block');
		$('span#error_'+attName).fadeOut(500);
		$('span#error_'+attName).fadeIn(500);
		if(errorValue != "")
		{
			$('span#error_'+attName).html(errorValue);
		}
	}
	$(this).attr('disabled', false);
	$(this).css('background-color', '#FFEDEF');
	$(this).fadeOut(500);
	$(this).fadeIn(500);

	$(this).focus();
}
