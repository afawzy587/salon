<?php
//		require '/mail/autoload.php';
        require_once __DIR__ . '/mail/autoload.php';

		// Import PHPMailer classes into the global namespace
		// These must be at the top of your script, not inside a function
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;

	
class sendmail
{
	public function email($to,$_link,$subject)
	{
        
         $message = '<!DOCTYPE html>
          <html lang="en" dir="ltr">
            <head>
              <meta charset="UTF-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <title>Salon</title>
            </head>
            <body>
            <h1>'.$subject.'</h1><br><p>';
               $message.= $_link;
               $message .= '</p></body>
          </html>';
		//Load Composer's autoloader
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try
		{
			//Server settings
			$mail->SMTPDebug 	= 0;                              // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host 		= 'ssl://mail.icouna.com';               // $SMTPInfo['smtp_server'];  				 // Specify main and backup SMTP servers
			$mail->SMTPAuth 	=  true;                          // Enable SMTP authentication
			$mail->Username 	= 'fawzy@icouna.com';          //$SMTPInfo['smtp_user'];        // SMTP username
			$mail->Password 	= 'fAwZy587';                     //$SMTPInfo['smtp_pass'];               // SMTP password
//			$mail->SMTPSecure 	= 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port 		= 465; //$SMTPInfo['smtp_port'];                                     // TCP port to connect to 26
			//Recipients

				$mail->setFrom('S@salon.com' , 'Salon');
				$mail->addAddress($to);     // Add a recipient 

				//Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = "Salon mail";
				$mail->Body    = $message;

				$mail->send();

			return 1;

		}catch (Exception $e)
		{
			
			return 0;
		}
			
	}
}
?>
