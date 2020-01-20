document.querySelectorAll('.component--switcher').forEach(element => {
	new Switcher({selector: element}).init();
});

document.querySelectorAll('.component--main-slider').forEach(element => {
	new MainSlider({selector: element}).init();
});

$("body").on( "click", 'input#importerSignIn' , function (e) {
	e.preventDefault();
	$('form#importerLogin input[type="email"],form#importerLogin input[type="password"]').css('background-color', '#fff');

	_email 		= $('form#importerLogin input[type="email"]').val();
	_password 	= $('form#importerLogin input[type="password"]').val();
	_remember 	= $('form#importerLogin input[type="checkbox"]').is(":checked");

	if(_email == "")
	{
		$('form#importerLogin input[type="email"]').fieldError('email',"empty email");
	}else
	{
		if(isValidEmailAddress(_email) == false)
		{
			$('form#importerLogin input[type="email"]').fieldError('email',"wrong email format");
		}else
		{
			if(_password == "")
			{
				$('form#importerLogin input[type="password"]').fieldError('email',"empty password");
			}else
			{
				$.ajax( {
					async :true,
					type :"POST",
					cache: false,
					dataType: "json",
					url :"membership.html?do=importerLogin",
					data: "remember="+_remember+"&password="+_password+"&email="+_email+"",
					success : function(data)
					{
						responseType = data['type'];
						if(responseType == "error")
						{
							errorNumber = data['error_no'];
							if(errorNumber == 1001 )
							{
								$('form#importerLogin input[type="email"]').fieldError('email',"empty email");
							}else
							{
								if(errorNumber == 1002 )
								{
									$('form#importerLogin input[type="email"]').fieldError('email',"wrong email format");
								}else
								{
									if(errorNumber == 1003 )
									{
										$('form#importerLogin input[type="password"]').fieldError('email',"empty password");
									}else
									{
										$('#message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
										$('input#importerSignIn').css('background-color', 'green');
										$('input#importerSignIn').css('border-color', 'green');
										$('input#importerSignIn').attr('disabled', true);
										$('input#importerSignIn').fadeOut(500);
										$('input#importerSignIn').fadeIn(500);
										setTimeout("window.location.href='index.html';",2000);
									}
								}
							}
						}else
						{
							responseType = data['type'];

							if(responseType == 1)
							{
								$('#message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
								$('input#importerSignIn').css('background-color', 'green');
								$('input#importerSignIn').css('border-color', 'green');
								$('input#importerSignIn').attr('disabled', true);
								$('input#importerSignIn').fadeOut(500);
								$('input#importerSignIn').fadeIn(500);
								setTimeout("window.location.href='index.html';",2000);
							}else if(responseType == 3)
							{
								$('#message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message danger">'+ data['message'] +'</div></div>');
								setTimeout("window.location.href='index.html';",2000);
							}else
							{
								$('#message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message info">'+ data['message'] +'</div></div>');
							}
						}
					},
					error : function(error) {
						return true;
					}
				});
			}
		}
	}
});

$("body").on( "change", 'select[name="country"]' , function (e) {
	e.preventDefault();
	_country 	= $('select[name="country"]').val();

	if(_country == 0)
	{
		$('select[name="city"]').html('<option value="0" selected="selected">[ Choose City ]</option>');
	}else
	{
		$.ajax( {
			async :true,
			type :"POST",
			cache: false,
			url :"membership.html?do=cities",
			data: "country="+_country,
			success : function(data)
			{
				if(data == 0)
				{
					$('select[name="city"]').html('<option value="0" selected="selected">[ Choose City ]</option>');
				}else
				{
					$('select[name="city"]').html('<option value="0" selected="selected">[ Choose City ]</option>'+data);
				}
			},
			error : function(error) {
				return true;
			}
		});
	}
});


$("body").on( "click", 'input#importerRegisterButton' , function (e) {
	e.preventDefault();
	$('form#importerRegister input[type="email"], form#importerRegister input[type="text"],form#importerRegister input[type="password"]').css('background-color', '#fff');

	_name 		= $('form#importerRegister input.name').val();
	_email 		= $('form#importerRegister input[type="email"]').val();
	_password 	= $('form#importerRegister input[type="password"]').val();
	_rpassword 	= $('form#importerRegister input[type="password"].rpassword').val();
	//_remember 	= $('form#importerLogin input[type="checkbox"]').is(":checked");

	if(_name == "")
	{
		$('form#importerRegister input.name').fieldError('email',"empty name");
	}else
	{
		if(_email == "")
		{
			$('form#importerRegister input[type="email"]').fieldError('email',"empty email");
		}else
		{
			if(isValidEmailAddress(_email) == false)
			{
				$('form#importerRegister input[type="email"]').fieldError('email',"wrong email format");
			}else
			{
				if(_password == "" || _rpassword == "" || ( _password != _rpassword ))
				{
					$('form#importerRegister input[type="password"]').fieldError('email',"empty password");
				}else
				{
					$.ajax( {
						async :true,
						type :"POST",
						cache: false,
						dataType: "json",
						url :"membership.html?do=importerRegister",
						data: "name="+_name+"&password="+_password+"&email="+_email+"",
						success : function(data)
						{
							responseType = data['type'];
							if(responseType == "error")
							{
								errorNumber = data['error_no'];
								if(errorNumber == 1001 )
								{
									$('form#importerLogin input[type="email"]').fieldError('email',"empty email");
								}else
								{
									if(errorNumber == 1002 )
									{
										$('form#importerLogin input[type="email"]').fieldError('email',"wrong email format");
									}else
									{
										if(errorNumber == 1003 )
										{
											$('form#importerLogin input[type="password"]').fieldError('email',"empty password");
										}else
										{
											$('#register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
											$('input#importerRegisterButton').css('background-color', 'green');
											$('input#importerRegisterButton').css('border-color', 'green');
											$('input#importerRegisterButton').attr('disabled', true);
											$('input#importerRegisterButton').fadeOut(500);
											$('input#importerRegisterButton').fadeIn(500);
											setTimeout("window.location.href='membership.html#importerProfileArea';location.reload();",2000);

										}
									}
								}
							}else
							{
								if(responseType == 1)
								{
									$('#register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
									$('input#importerRegisterButton').css('background-color', 'green');
									$('input#importerRegisterButton').css('border-color', 'green');
									$('input#importerRegisterButton').attr('disabled', true);
									$('input#importerRegisterButton').fadeOut(500);
									$('input#importerRegisterButton').fadeIn(500);
									setTimeout("window.location.href='membership.html#importerProfileArea';location.reload();",2000);
								}else if(responseType == 3)
								{
									$('#register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message danger">'+ data['message'] +'</div></div>');
									setTimeout("window.location.href='index.html';",2000);
								}else
								{
									$('#register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message info">'+ data['message'] +'</div></div>');
								}
							}
						},
						error : function(error) {
							return true;
						}
					});
				}
			}
		}
	}
});


$("body").on( "click", 'a.resendActivationMail' , function (e) {
	e.preventDefault();
	$.ajax( {
		async 		: true,
		type 		: "POST",
		cache		: false,
		dataType	: "json",
		url 		: "membership.html?do=resendActivationMail",
		success : function(data)
		{
			responseType = data['type'];
			if(responseType == 1)
			{
				$('div#resendActivationMailDiv').html('<span style="color:green;">'+ data['message'] +'</span>');
				//setTimeout("window.location.href='membership.html';",2000);
			}else if(responseType == 2)
			{
				$('div#resendActivationMailDiv').html('<span style="color:red;">'+ data['message'] +'</span>');
			}else
			{
				$('div#resendActivationMailDiv').html('<span style="color:blue;">'+ data['message'] +'</span>');
			}
		},
		error : function(error) {
			return true;
		}
	});
});

/* Exporter */

$("body").on( "click", 'input#exporterSignIn' , function (e) {

	e.preventDefault();
	$('form#exporterLogin input[type="email"],form#exporterLogin input[type="password"]').css('background-color', '#fff');

	_email 		= $('form#exporterLogin input[type="email"]').val();
	_password 	= $('form#exporterLogin input[type="password"]').val();
	_remember 	= $('form#exporterLogin input[type="checkbox"]').is(":checked");
	if(_email == "")
	{
		$('form#exporterLogin input[type="email"]').fieldError('email',"empty email");
	}else
	{
		if(isValidEmailAddress(_email) == false)
		{
			$('form#exporterLogin input[type="email"]').fieldError('email',"wrong email format");
		}else
		{
			if(_password == "")
			{
				$('form#exporterLogin input[type="password"]').fieldError('email',"empty password");
			}else
			{
				$.ajax( {
					async :true,
					type :"POST",
					cache: false,
					dataType: "json",
					url :"membership.html?do=exporterLogin",
					data: "remember="+_remember+"&password="+_password+"&email="+_email+"",
					success : function(data)
					{
						responseType = data['type'];
						if(responseType == "error")
						{
							errorNumber = data['error_no'];
							if(errorNumber == 1001 )
							{
								$('form#exporterLogin input[type="email"]').fieldError('email',"empty email");
							}else
							{
								if(errorNumber == 1002 )
								{
									$('form#exporterLogin input[type="email"]').fieldError('email',"wrong email format");
								}else
								{
									if(errorNumber == 1003 )
									{
										$('form#exporterLogin input[type="password"]').fieldError('email',"empty password");
									}else
									{
										$('#exporter-message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
										$('input#exporterSignIn').css('background-color', 'green');
										$('input#exporterSignIn').css('border-color', 'green');
										$('input#exporterSignIn').attr('disabled', true);
										$('input#exporterSignIn').fadeOut(500);
										$('input#exporterSignIn').fadeIn(500);
										setTimeout("window.location.href='index.html';",2000);
									}
								}
							}
						}else
						{
							responseType = data['type'];
							if(responseType == 1)
							{
								$('#exporter-message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
								$('input#exporterSignIn').css('background-color', 'green');
								$('input#exporterSignIn').css('border-color', 'green');
								$('input#exporterSignIn').attr('disabled', true);
								$('input#exporterSignIn').fadeOut(500);
								$('input#exporterSignIn').fadeIn(500);
								setTimeout("window.location.href='index.html';",2000);
							}else if(responseType == 3)
							{
								$('#exporter-message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message danger">'+ data['message'] +'</div></div>');
								setTimeout("window.location.href='index.html';",2000);
							}else
							{
								$('#exporter-message-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message info">'+ data['message'] +'</div></div>');
							}
						}
					},
					error : function(error) {
						return true;
					}
				});
			}
		}
	}
});

$("body").on( "click", 'input#exporterRegisterButton' , function (e) {
	e.preventDefault();
	$('form#exporterRegister input[type="email"], form#exporterRegister input[type="text"],form#exporterRegister input[type="password"]').css('background-color', '#fff');

	_name 		= $('form#exporterRegister input.name').val();
	_email 		= $('form#exporterRegister input[type="email"]').val();
	_password 	= $('form#exporterRegister input[type="password"]').val();
	_rpassword 	= $('form#exporterRegister input[type="password"].rpassword').val();

	if(_name == "")
	{
		$('form#exporterRegister input.name').fieldError('email',"empty name");
	}else
	{
		if(_email == "")
		{
			$('form#exporterRegister input[type="email"]').fieldError('email',"empty email");
		}else
		{
			if(isValidEmailAddress(_email) == false)
			{
				$('form#exporterRegister input[type="email"]').fieldError('email',"wrong email format");
			}else
			{
				if(_password == "" || _rpassword == "" || ( _password != _rpassword ))
				{
					$('form#exporterRegister input[type="password"]').fieldError('email',"empty password");
				}else
				{

					$.ajax( {
						async :true,
						type :"POST",
						cache: false,
						dataType: "json",
						url :"membership.html?do=exporterRegister",
						data: "name="+_name+"&password="+_password+"&email="+_email+"",
						success : function(data)
						{
							responseType = data['type'];
							if(responseType == "error")
							{
								errorNumber = data['error_no'];
								if(errorNumber == 1001 )
								{
									$('form#exporterLogin input[type="email"]').fieldError('email',"empty email");
								}else
								{
									if(errorNumber == 1002 )
									{
										$('form#exporterLogin input[type="email"]').fieldError('email',"wrong email format");
									}else
									{
										if(errorNumber == 1003 )
										{
											$('form#exporterLogin input[type="password"]').fieldError('email',"empty password");
										}else
										{
											$('#exporter-register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
											$('input#exporterRegisterButton').css('background-color', 'green');
											$('input#exporterRegisterButton').css('border-color', 'green');
											$('input#exporterRegisterButton').attr('disabled', true);
											$('input#exporterRegisterButton').fadeOut(500);
											$('input#exporterRegisterButton').fadeIn(500);
											setTimeout("window.location.href='membership.html#exporterProfileArea';location.reload();",2000);
										}
									}
								}
							}else
							{
								if(responseType == 1)
								{
									$('#exporter-register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message success">'+ data['message'] +'</div></div>');
									$('input#exporterRegisterButton').css('background-color', 'green');
									$('input#exporterRegisterButton').css('border-color', 'green');
									$('input#exporterRegisterButton').attr('disabled', true);
									$('input#exporterRegisterButton').fadeOut(500);
									$('input#exporterRegisterButton').fadeIn(500);
									setTimeout("window.location.href='membership.html#exporterProfileArea';location.reload();",2000);
								}else if(responseType == 3)
								{
									$('#exporter-register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message danger">'+ data['message'] +'</div></div>');
									setTimeout("window.location.href='index.html';",2000);
								}else
								{
									$('#exporter-register-result').html('<div class="component--alert-messages" style="font-size:20px;"><div class="alert-message info">'+ data['message'] +'</div></div>');
								}
							}
						},
						error : function(error) {
							return true;
						}
					});
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
	$(this).fadeOut(500);
	$(this).fadeIn(500);

	$(this).focus();
}
