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
        <title>test</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="assets/css/animate.css" rel="stylesheet">
        <link href="assets/css/styles.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="left">  
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/img/logo.png" alt="" height="64" class="d-inline-block align-text-top">
                    </a>
                </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                

                <div class="right">
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Activités & tarifs
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li>Triathlon</li>
                                <li><?php mkLien('index.php','Sprint','view=sprint'); ?></li>
                                <li><?php mkLien('index.php','Olympique','view=olympique'); ?></li>
                                <li><?php mkLien('index.php','Half','view=half'); ?></li>
                                <li><?php mkLien('index.php','Ironman','view=ironman'); ?></li>
                                    <li>Natation</li>
                                <li><?php mkLien('index.php','Apprentissage Natation','view=apprentissageNatation'); ?></li>
                                <li><?php mkLien('index.php','Perfectionnement Natation','view=perfectionnementNatation'); ?></li>
                                <li><?php mkLien('index.php','Perfectionnement Natation en Eau Libre','view=perfectionnementNatationEauLibre'); ?></li>
                                <li><?php mkLien('index.php','Entrainement Natation','view=entrainementNatation'); ?></li>    
                                    <li>Piscine</li>
                                <li><?php mkLien('index.php','Aquabike','view=aquabike'); ?></li>
                                <li><?php mkLien('index.php','Aquagym','view=aquagym'); ?></li>
                                </ul>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php?view=reservation">Réservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php?view=blog">Blog</a>
                            </li>
                            
                            <?php
                            if (valider("connecte","SESSION")) {
                                mkForm("controleur.php"); 
                                if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))) mkInput("submit","action","Mon Compte");
                                else mkInput("submit","action","Administration");
                                endForm();
                            }else{
                                mkForm("controleur.php"); 
                                mkInput("submit","action","Connexion");
                                endForm();
                            }
                            ?>

                            <?php
                            if (valider("connecte","SESSION")) {
                                mkForm("controleur.php"); 
                                mkInput("submit","action","Se déconnecter");
                                endForm();
                            }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
            
          </nav>







