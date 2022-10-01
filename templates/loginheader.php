<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");


// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link href="assets/fontawesome/css/all.css" rel="stylesheet">
		<style type="text/css">
			body{
				background-image: linear-gradient(to right, #4B83FC, #3498db) !important;
				height: 100%;
				width: 100%
			}
			.login-page form{
				background-color: white;padding: 45px 52px 50px 52px;border-radius: 20px;margin-top: 5%;
			}
			p{
				margin: 0;
			}
			.footer{
				margin-top: 5%;
			}
		</style>

	</head>
	<body>