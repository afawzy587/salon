<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:44:45
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\user-login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6531108145dab2f6de238a0-46838293%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd37bb07f89f92d9a50526a540468dcbab2188c70' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\user-login.tpl',
      1 => 1571249980,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6531108145dab2f6de238a0-46838293',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!doctype html>
<html class="signin no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $_smarty_tpl->getVariable('title')->value;?>
">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->
    <title><?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>

    <!-- page level plugin styles -->
    <!-- /page level plugin styles -->

    <!-- core styles -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min_<?php echo $_smarty_tpl->getVariable('lang')->value['DEFAULT'];?>
.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <!-- /core styles -->
    <!-- template styles -->
    <link rel="stylesheet" href="../assets/css/skins/palette.css">
    <link rel="stylesheet" href="../assets/css/fonts/font.css">
    <link rel="stylesheet" href="../assets/css/main_<?php echo $_smarty_tpl->getVariable('lang')->value['DEFAULT'];?>
.css">
    <!-- template styles -->


    <!-- load modernizer -->
    <script src="../assets/plugins/modernizr.js"></script>
    <?php echo $_smarty_tpl->getVariable('hockHeader')->value;?>

</head>

<body class="bg-primary">

    <div class="cover" style="background-image: url(../assets/img/cover1.jpg)"></div>

    <div class="overlay bg-primary"></div>

    <div class="center-wrapper">
        <div class="center-content">
            <?php if ($_smarty_tpl->getVariable('logLast')->value==1){?>
            	<div class="row"><div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="float:none;">
                    <section class="panel bg-white no-b"><ul class="switcher-dash-action">
						<li><a href="#" class="selected"><?php echo $_smarty_tpl->getVariable('logdata')->value;?>
</a></li>
					</ul></section>
                </div></div>
            <?php }?>

            <?php if ($_smarty_tpl->getVariable('logexception')->value==1){?>
            	<div class="row"><div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="float:none;">
                    <section class="panel bg-white no-b"><ul class="switcher-dash-action">
						<li><a href="#" class="selected"><?php echo $_smarty_tpl->getVariable('logdata')->value;?>
</a></li>
					</ul></section>
                </div></div>
            <?php }?>

            <?php if ($_smarty_tpl->getVariable('logFine')->value!=1){?>
            <div class="row" style="widdth:99%;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="float:none;">
                   <?php if ($_smarty_tpl->getVariable('area_name')->value=='login'){?>
                    <section class="panel bg-white no-b">
                        <ul class="switcher-dash-action">
                            <li><a href="#" class="selected"><?php if ($_smarty_tpl->getVariable('logMode')->value==1){?><?php echo $_smarty_tpl->getVariable('logdata')->value;?>
<?php }?></a></li>
                        </ul>
                        <div class="p15">
                            <form role="form" id="ForM" action="login.html?do=login" method="post">
                                <input type="email" class="form-control input-lg mb25" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
" name="email" id="email" autofocus>
                                <input type="password" class="form-control input-lg mb25" autocomplete="new-password" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['password'];?>
" name="password" id="password">
                                <button class="btn btn-primary btn-lg btn-block" type="submit"><?php echo $_smarty_tpl->getVariable('lang')->value['login'];?>
</button>
                                <input name="remember" type="hidden" value="1" >
                            </form>
                        </div>
                    </section>
                    <?php }?>
                    <p class="text-center">
                        Copyright &copy;
                        <span id="year" class="mr5"></span>
                        <span><b><?php echo $_smarty_tpl->getVariable('lang')->value['site_name'];?>
</b></span>
                    </p>
                </div>
            </div>
            <?php }?>

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





