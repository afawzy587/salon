<?php
ob_start("ob_gzhandler");
    define("inside",true);
	if (!session_id()) {
		session_start();
	}

	include("../inc/fundamentals_api.php");

     if($_GET)
        {
            $data      = sanitize($_GET['data']);
            if($data == "")
            {
                $error  = $lang['INVALID_LINK'];
            }else{
                $salt  = "wZy";
                $_data = str_replace($salt,"",$data);

                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `recovery_code` = '".$_data."' AND (`recovery_expired` > NOW()) LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                if($usersCount == 1)
                {
                    $userCredintials    = $GLOBALS['db']->fetchitem($userQuery);
                    if($_POST){
                        $pass           = sanitize($_POST["pass"]);
                        $pass2          = sanitize($_POST["pass2"]);
                        if($pass == "")
                        {
                            $error = $lang['INSERT_PASSWORD'];
                        }else{
                            if($pass == "")
                            {
                                $error = $lang['INSERT_CONFIRM_PASSWORD'];
                            }else{
                                if($pass == $pass2)
                                {
                                    $password = crypt($pass,$salt);
                                    $GLOBALS['db']->query(
                                        "UPDATE `users` SET
                                        `recovery_code`='',
                                        `recovery_expired`='',
                                        `password`='".$password."'
                                        WHERE `user_serial`='".$userCredintials['user_serial']."'
                                    ");
                                     $success = $lang['password_back'];
                                }else{
                                    $error = $lang['NOT_CONFIRM_PASSWORD'];
                                }
                            }
                        }
                    }

                    $logs->addLog(7,
                        array(
                            "type" 		=> 	"client",
                            "module" 	=> 	"rest_pass",
                            "mode" 		=> 	"get",
                            "id" 		=>	$userCredintials['user_serial'],
                        ),"client",$userCredintials['user_serial'],1
                    );
                }else
                {
                     $error  = $lang['INVALID_LINK'];
                }
            }

        }else
        {
           header("Location:../error/index.php");
        }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Reset your password</title>
    <style>
        aside.right {
            background: url(mainbg2.png) center no-repeat;
            width: 50%;
            position: absolute;
            right: 0;
            top: 0;
            background-color: #fff;
            min-height: 100vh;
            overflow: hidden;
        }

        aside.left {
            background-color: #000;
            min-height: 100vh;
            width: 50%;
        }

        aside.left div {
            padding-top: 165px;
        }

        aside h1,
        a {
            margin-bottom: 30px;
            text-transform: uppercase;
            text-decoration: none;
            font-weight: 400;
        }

        .rounded {
            border-radius: 25px !important;

        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input {
            padding: 1.4rem .75rem !important;
        }

        label {
            position: absolute;
            background-color: #fff;
            right: 225px;
            top: 423px;
            padding: 5px 10px;
        }

        label.label2 {
            top: 492px;
        }

        .btn_1.rounded {
            padding: 12px 30px;
            display: block;
            width: 100%;
            text-align: center;
            margin-bottom: 5px;
            cursor: pointer;
            background: #22D768;
            color: #fff;
            font-weight: 600;
        }

        #forgetpw {
            text-align: center;
        }

        .wrapper {
            box-shadow: 1px 1px 2px 2px #ece8e8;
            margin: 251px 115px 0 115px;
            padding: 113px 61px;
            background-color: #fff;
            border: 1px;
            border-radius: 25px;
        }

        ::-webkit-input-placeholder {
            text-align: right;
        }

        /* mozilla solution */
        input:-moz-placeholder {
            text-align: right;
        }

        @media only screen and (max-width: 1415px) {

            .wrapper {
                margin: 157px 28px 0 28px;
            }

            label {
                right: 137px;
                top: 335px;
            }

            label.label2 {
                top: 405px;
            }

            .wrapper h1 {
                font-size: 2.8rem;
            }
        }
        @media only screen and (max-width: 1145px) {
            .wrapper h1 {
                font-size: 1.9rem;
            }
            label {
                right: 100px;
                top: 321px;
            }

            label.label2 {
                top: 391px;
            }
        }
        @media only screen and (max-width: 911px) {

            aside.right,
            aside.left {
                width: 100%;
            }

            .wrapper {
                margin: 163px 15px 0 15px;
                padding: 113px 36px;
            }

            .wrapper h1 {
                font-size: 1.8rem;
            }
        }

        @media only screen and (max-width: 430px) {
            .wrapper {
                margin: 91px 28px 0 28px;
            }

            .wrapper h1 {
                font-size: 1.2rem;
                font-weight: 600;
            }

            label {
                right: 100px;
                top: 236px;
            }

            label.label2 {
                top: 306px;
            }
        }

        @media only screen and (max-width: 364px) {

            .wrapper h1 {
                font-size: 1rem;
            }
        }

        input::-webkit-input-placeholder {
            color: #ced4da!important;
        }

        input:-moz-placeholder {
            /* Firefox 18- */
            color: #ced4da;
        }

        input::-moz-placeholder {
            /* Firefox 19+ */
            color: #ced4da;
        }

        input:-ms-input-placeholder {
            color: #ced4da;
        }

        input::placeholder {
            color: #ced4da;
        }
    </style>
</head>

<body>
    <div id="forgetpw">
        <aside class="left col-sm-12 col-md-6">
            <div class="salon-logo">
                <img width="100%" src="salonLogo.png" alt="">

            </div>
        </aside>
        <aside class="right  col-sm-12 col-md-6">
            <div class="wrapper">
					<?php if ($success){
							echo '<div class="alert alert-success">'.$success.'</div>';
						}else{
							if($error)
							{
								echo'<div class="alert alert-danger">'.$error.'</div>';
							}
						}
					?>
                <h1><?php echo $lang['recovery_PASS'];?></h1>
                <form action="./index.php?data=<?php echo $data;?>"  method="post" enctype="multipart/form-data">
                    <row>
                    <div class="form-group">
                        <label><?php echo $lang['NEW_PASS'];?></label>
                        <input class="form-control rounded" name="pass" type="password" placeholder="<?php echo $lang['NEW_PASS'];?>">
                        <i class="ti-user"></i>
                    </div>
                        </row>
                    <row>
                    <div class="form-group">
                        <label class="label2"><?php echo $lang['NEW_PASS2'];?></label>
                        <input class="form-control rounded" name="pass2" type="password" placeholder="<?php echo $lang['NEW_PASS2'];?>">
                        <i class="ti-user"></i>
                    </div>
                </row>
                    <button type="submit" class="btn_1 rounded full-width add_top_30"><?php echo $lang['SEND'];?></button>
                </form>

            </div>

        </aside>
    </div>
</body>

</html>
