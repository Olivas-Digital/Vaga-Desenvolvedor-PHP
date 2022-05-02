<?php 

//Email de boas vindas
$email = "teste@gitub.com";
$title_email="Bem vindo";
$message_email="
<div style='background:#fff;padding:5px;'>
    <div style='display:inline-block;margin:0 auto;padding:20px;background:#eee;border:1px solid #333;'>
    <table cellpadding='0' cellspacing='0' border='0' style='background:#eee;width:600px;font:13px/18px Verdana,sans-serif;color:#333;'>
    <tr><td style='padding:5px;'>Ola,</td></tr>
    <tr><td style='padding:10px 5px;'>Seja muito bem vindo ao ambiente teste.</b></td></tr>
    <tr><td style='padding:5px;'>Att,<br>Github.</td></tr>
    </table>
    </div>
</div>";
sendEmail($email, $title_email, $message_email);

/*SEND MAIL*/
function sendEmail($email, $title_email, $message_email){
	
	/*### SEND GRID - Get a account on https://sendgrid.com ###*/
	/*api_user = username and api_key = password of sendgrid account*/				
	$params = array(
		'api_user'  => '$api_user',
		'api_key'   => '$api_senha',
		'to'        => $email,
		'subject'   => $title_email,
		'html'      => $message_email,
		'text'      => '',
		'from'      => 'email@github.com',
		'fromname'      => 'Teste_Vaga',
	  );
	
	$request =  'https://api.sendgrid.com/api/mail.send.json';
	
	// Generate curl request
	$session = curl_init($request);
	// Tell curl to use HTTP POST
	curl_setopt ($session, CURLOPT_POST, true);
	// Tell curl that this is the body of the POST
	curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
	// Tell curl not to return headers, but do return the response
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	
	// obtain response
	$response = curl_exec($session);
	curl_close($session);
	
	if(strpos($response,'message') !== false && strpos($response,'success') !== false) {
		//Email sent with success
		$mail_success = 1;
		return $mail_success;
	}else{
		//Error mail not sent
		$mail_success = 0;
		return $mail_success;
	}
	/*### END SEND GRID ###*/
	
}
/*END SEND MAIL*/

?>


