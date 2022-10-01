<?php
	//cron every minute
	include_once "../libs/maLibUtils.php";
	include_once "../libs/maLibSQL.pdo.php";
	include_once "../libs/maLibSecurisation.php"; 
	include_once "../libs/modele.php"; 
	include_once "../libs/mail.php";

	//suppression des demandes de mot de passe
	$now=date("Y-m-d H:i:s");
	suppdemandemdp($now);
	echo "deleting demande new password : ok";

	
?>










