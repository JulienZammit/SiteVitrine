<?php
	//cron every day
	include_once "../libs/maLibUtils.php";
	include_once "../libs/maLibSQL.pdo.php";
	include_once "../libs/maLibSecurisation.php"; 
	include_once "../libs/modele.php"; 
	include_once "../libs/mail.php";

	//envoi mail rappel reservation pour demain
	$reservationsdemain=getresademain();

	foreach ($reservationsdemain as $resa) {
		$message="Bonjour $resa[prenom] !<br><br> N'oubliez pas demain c'est $resa[nomsport]<br><br>";
		$message.= "À bientôt,<br>Nicolas Barthes";
		SendEmail($resa['mail'], "Demain c'est $resa[nomsport]",$message);
	}
	
?>










