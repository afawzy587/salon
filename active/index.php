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
                $message = $lang['INVALID_LINK'];
                $type    = "error";
            }else{
                $salt  = "wZy";
                $_data = str_replace($salt,"",$data);
                if($_data != "")
                {
                    $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `verified_code` = '".$_data."'  LIMIT 1");
                    $usersCount = $GLOBALS['db']->resultcount();
                    if($usersCount == 1)
                    {
                        $userCredintials    = $GLOBALS['db']->fetchitem($userQuery);

                        $GLOBALS['db']->query(
                            "UPDATE `users` SET
                            `verified_code`='0',
                            `verified`='1'
                            WHERE `user_serial`='".$userCredintials['user_serial']."'
                        ");
                         $message = $lang['email_activated'];
                         $type    = "success";
                        $logs->addLog(7,
                            array(
                                "type" 		=> 	"client",
                                "module" 	=> 	"active",
                                "mode" 		=> 	"get",
                                "id" 		=>	$userCredintials['user_serial'],
                            ),"client",$userCredintials['user_serial'],1
                        );
                    }else
                    {
                         $message = $lang['INVALID_LINK'];
                         $type    = "error";
                    }
                }else
                    {
                         $message = $lang['INVALID_LINK'];
                         $type    = "error";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
   <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title><?php echo $lang['ACTIVE_EMAIL'];?></title>
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

                <?php if($type == "success")
                {
                    echo '<div class="alert alert-success"><h1>'.$message.'</h1></div>';

                }elseif($type == "error")
                {
                        echo '<div class="alert alert-danger"><h1>'.$message.'</h1></div>';

                }?>
            </div>

        </aside>
    </div>
</body>

</html>
