<?php
	
	// include_once "../libs/maLibUtils.php";
	// include_once "../libs/maLibSQL.pdo.php";
	// include_once "../libs/maLibSecurisation.php"; 
	// include_once "../libs/modele.php"; 

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../vendor/phpmailer/phpmailer/src/Exception.php';
	require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '../vendor/phpmailer/phpmailer/src/SMTP.php';

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

	// pour tester http://localhost/projetweb/projetinfo/api/mail.php?to=klach1703@gmail.com&subject=petit%20test&message=%3Ch1%3Etest%20de%20bg%3C/h1%3E

?>