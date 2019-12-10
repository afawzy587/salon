<?php
ob_start("ob_gzhandler");
    define("inside",true);
	if (!session_id()) {
		session_start();
	}

	include("../inc/fundamentals_api.php");
?>
<!DOCTYPE html>
<html lang="en">
<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title><?php echo $lang['recovery_PASS'];?></title>
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

        aside h1 {
            margin-bottom: 30px;
            text-transform: uppercase;
            text-decoration: none;
            font-weight: 400;
            font-size: 2.5rem;
        }

        #forgetpw {
            text-align: center;
        }

        .wrapper {
            box-shadow: 1px 1px 2px 2px #ece8e8;
            margin: 310px  115px 0 115px;
            padding: 113px 61px;
            background-color: #fff;
            border: 1px;
            border-radius: 25px;
        }

        @media only screen and (max-width: 1415px) {
            .wrapper {
                margin: 250px  28px 0 28px;
            }
        }

        @media only screen and (max-width: 911px) {
            aside.right,
            aside.left {
                width: 100%;
            }
            .wrapper {
                margin: 304px 15px 0 15px;
                padding: 113px 36px;
            }
        }

        @media only screen and (max-width: 430px) {
            .wrapper {
                margin: 140px 28px 0 28px;
            }
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
                <div class="alert alert-success"><h1><?php echo $lang['password_back'];?></h1></div>
            </div>
        </aside>
    </div>
</body>

</html>
