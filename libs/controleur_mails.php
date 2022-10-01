<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

function SendEmail($to, $subject, $message) {

	$mail = new PHPMailer();

	$mail->isSMTP();
	$mail->Host = 'ssl0.ovh.net';
	$mail->SMTPAuth = true;
	$mail->Username = 'noreply@leçons-natation81.fr';
	$mail->Password = 'EbP{5*97r5@28PW';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->CharSet = "UTF-8";
	$mail->Encoding = 'base64';

	$mail->setFrom('noreply@leçons-natation81.fr', 'Nicolas Barthes');
	$mail->addReplyTo('noreply@leçons-natation81.fr', 'Nicolas Barthes');

	// destinataire
	$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->isHTML(true);
	$mail->Body = $message;


    if(!$mail->send()){
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
}

function send_type_mail($case,$email,$prenom){
	switch ($case) {
		case 'confirmreserve':
				$message="Bonjour $prenom,<br><br> Votre demande de réservation a bien été pris en compte, vous recevrez un email une fois que celle-ci sera acceptée.<br><br>";
				$message.= "À bientôt,<br>Nicolas Barthes";
				SendEmail($email, "Confirmation demande de réservation",$message);
			break;
		
		default:
			break;
	}
}

?>