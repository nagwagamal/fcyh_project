<!doctype html>
<html class="signin no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="{$title}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->

    <title>{$title}</title>

    <!-- page level plugin styles -->
    <!-- /page level plugin styles -->

    <!-- core styles -->
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min_{$lang.DEFAULT}.css">
    <link rel="stylesheet" href="./assets/css/font-awesome.css">
    <link rel="stylesheet" href="./assets/css/themify-icons.css">
    <link rel="stylesheet" href="./assets/css/animate.min.css">
    <!-- /core styles -->

    <!-- template styles -->
    <link rel="stylesheet" href="./assets/css/skins/palette.css">
    <link rel="stylesheet" href="./assets/css/fonts/font.css">
    <link rel="stylesheet" href="./assets/css/main_{$lang.DEFAULT}.css">
    <!-- template styles -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    <script src="./assets/plugins/modernizr.js"></script>
    {$hockHeader}
</head>

<body class="bg-primary">

    <div class="cover" style="background-image: url(./assets/img/cover1.jpg)"></div>

    <div class="overlay bg-primary"></div>

    <div class="center-wrapper">
        <div class="center-content">
            {if $logLast eq 1}
            	<div class="row"><div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="float:none;">
                    <section class="panel bg-white no-b"><ul class="switcher-dash-action">
						<li><a href="#" class="selected">{$logdata}</a></li>
					</ul></section>
                </div></div>
            {/if}

            {if $logexception eq 1}
            	<div class="row"><div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="float:none;">
                    <section class="panel bg-white no-b"><ul class="switcher-dash-action">
						<li><a href="#" class="selected">{$logdata}</a></li>
					</ul></section>
                </div></div>
            {/if}

            {if $logFine neq 1}
            <div class="row" style="widdth:99%;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="float:none;">
                   {if $area_name eq 'login'}
                    <section class="panel bg-white no-b">
                        <ul class="switcher-dash-action">
                            <li><a href="#" class="selected">{if $logMode eq 1}{$logdata}{/if}</a></li>
                        </ul>
                        <div class="p15">
                            <form role="form" id="ForM" action="login.html?do=login" method="post">
                                <input type="text" class="form-control input-lg mb25" placeholder="{$lang.email}" name="email" id="email" autofocus>
                                <input type="password" class="form-control input-lg mb25" placeholder="{$lang.password}" name="password" id="password">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">{$lang.login}</button>
                                <input name="remember" type="hidden" value="1" >
<!--                                <a href="login.html?do=forgetten" class="input-sm mb25">  {$lang.forget_password} </a>-->
                            </form>
                        </div>
                    </section>
                  {elseif $area_name eq 'forgetten'}
                   <section class="panel bg-white no-b">
                        <ul class="switcher-dash-action">
                            <li><a href="#" class="selected">{$logdata}</a></li>
                        </ul>
                        <div class="p15">
                            <form role="form" id="ForM" action="login.html?do=send_message" method="post">
                                <input type="text" autocomplete="new-password" autocomplete="off" class="form-control input-lg mb25" placeholder="{$lang.email}" name="email" id="email" autofocus>
                                <button class="btn btn-primary btn-lg btn-block" type="submit"> {$lang.rest_mail} </button>
                            </form>
                        </div>
                    </section>
                    {elseif $area_name eq 'send_message'}
                   <section class="panel bg-white no-b">
                        <ul class="switcher-dash-action">
                            <li><a href="#" class="selected">{$logdata}</a></li>
                        </ul>
                    </section>
                    {elseif $area_name eq 'rest_password'}
                   <section class="panel bg-white no-b">
                       {if $logMode eq 2}
                        <ul class="switcher-dash-action">
                            <li><a href="login.html?do=login" class="selected">{$logdata}</a></li>
                        </ul>
                        {else}
                         <ul class="switcher-dash-action">
                            <li><a href="#" class="selected">{$logdata}</a></li>
                        </ul>
                        <div class="p15">
                            <form role="form" id="ForM" action="#" method="post">
                            		<input type="text" name="email"  value="{$email}" hidden>
                            		<input type="text" name="key"  value="{$_key}" hidden>
									<input type="password" class="form-control input-lg mb25" autocomplete="off" placeholder="{$lang.password}" autocomplete="new-password" name="password" id="password" required>
									<input type="password" class="form-control input-lg mb25"autocomplete="off" placeholder=" {$lang.confirm_password} " autocomplete="new-password" name="confirm_password" id="confirm_password" required>
                              		<button class="btn btn-primary btn-lg btn-block" type="submit"> {$lang.rest_password} </button>
                            </form>
                        </div>
                        {/if}
                    </section>
                    {/if}
                    <p class="text-center">
                        Copyright &copy;
                        <span id="year" class="mr5"></span>
                        <span style='font-size:20px;font-family:Open Sans, sans-serif;'><b><a href='https://www.eramint.com/' target='_blank'><span style='color:#0dff59'>Era</span><span style='color:3838a5'>Mint</span></a></b></span>
                    </p>
                </div>
            </div>
            {/if}

        </div>
    </div>
    <script type="text/javascript">
        var el = document.getElementById("year"),
            year = (new Date().getFullYear());
        el.innerHTML = year;
		var password = document.getElementById("password")
		  , confirm_password = document.getElementById("confirm_password");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
			confirm_password.setCustomValidity('');
		  }
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
    </script>
</body>

</html>





