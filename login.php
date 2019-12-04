<?php
	// output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

        switch($_GET['do'])
        {
            case"":

            case"login":
				if($login->doCheck() == true)
				{
					header("Location:./index.php");
				}else
				{

                    // recieving the parameters
                     $logResult = $login->doLogin(sanitize($_POST["email"]),sanitize($_POST["password"]),sanitize($_POST["remember"]));

                    if($logResult ==0)
                    {
                        $message = $lang['LGN_EMPTY_DATA'];
                    }elseif($logResult ==1)
                    {
                        $logs->addLog(69,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"login",
                                    "mode" 		        => 	"login",
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                        $message = $lang['LGN_IS_SUCESSFULLY'];
                        header("Location:./index.php");

                    }elseif($logResult ==3)
                    {
                        $message = $lang['LGN_IS_DUPLICATED'];
                        header("Location:./index.php");
                    }else
                    {
                        $message = $lang['LGN_WORNG_DATA'];
                    }
				}

            break;
            case"logout":
                if($login->doLogout() == true)
                {
                    $message = $lang['LGN_SUCCESSFUL_LOGOUT'];
                    $logs->addLog(70,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"login",
                                    "mode" 		        => 	"logout",
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                }else
                {
                    $message = $lang['login_first'];
                }
            break;
        }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Salon | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./assets/login/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/login/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./assets/login/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/login/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./assets/login/blue.css">



  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Salon</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <?php if($message){echo '<p class="login-box-msg" style="color:red"><b>'.$message.'</b></p>';} ?>
    <form action="login.php?do=login" method="post">
      <div class="form-group has-feedback">
        <input type="email" name='email' autocomplete="new-password" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" autocomplete="new-password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4" style="float:right">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="./assets/login/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./assets/login/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./assets/login/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
