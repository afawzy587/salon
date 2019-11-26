<?php

 include("./send_email.php");
 $send = new sendmail();

$_link ='<a href="https://www.w3schools.com">Visit W3Schools.com!</a>';

  $message = '<!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Salon</title>
    </head>
    <body>
      <table>
        <thead>
          <tr>
            <th>
              Salon
            </th>
            <th>
              verified
            </th>
          </tr>
        </thead>
        <tbody>';
       $message.= $_link;
       $message .= '</tbody>
      </table>
    </body>
  </html>';

	$subject = "SAlon verified email";
	$emails ='ah.fawzy587@gmail.com';

//	foreach($emails as $k=>$e)
//	{
		$send->email($emails,$_link);
//	}


?>