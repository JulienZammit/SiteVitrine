<?php
session_start();




	include_once "libs/maLibUtils.php";

	// on récupère le paramètre view éventuel 
	$view = valider("view"); 
	/* valider automatise le code suivant :
	if (isset($_GET["view"]) && $_GET["view"]!="")
	{
		$view = $_GET["view"]
	}*/

	// S'il est vide, on charge la vue accueil par défaut
	if (!$view) $view = "accueil"; 

	// NB : il faut que view soit défini avant d'appeler l'entête

	// Dans tous les cas, on affiche l'entete, 
	// qui contient les balises de structure de la page, le logo, etc. 
	// Le formulaire de recherche ainsi que le lien de connexion 
	// si l'utilisateur n'est pas connecté 



	//permet de choisir quelle header afficher

	if($view!="admin" && $view!="login" && $view!="inscription" && $view!="oubli" && $view!="reinit" && $view!="modifierCours" && $view!="gestion" && $view!="reservationAdmin" && $view!="planning" && $view!="modificationActu" && $view!="adminBlog") include("templates/header.php");
	elseif($view=="admin" || $view=="modifierCours" || $view=="reservationAdmin" || $view=="gestion" || $view=="planning" || $view=="modificationActu" || $view=="adminBlog") include("templates/admin/adminheader.php");
	else include("templates/loginheader.php");

	// En fonction de la vue à afficher, on appelle tel ou tel template
	switch($view)
	{
		case "accueil" : 
			include("templates/accueil.php");
		break;

		////////////////////// TEMPLATES COURS ////////////////////////////////////

		case "aquabike" :
			include("templates/cours/aquabike.php");
			break;

		case "aquagym" :
			include("templates/cours/aquagym.php");
			break;

		case "sprint" :
			include("templates/cours/sprint.php");
			break;

		case "reservationAdmin" :
			include("templates/admin/reservationAdmin.php");
			break;

		case "half" :
			include("templates/cours/half.php");
			break;

		case "olympique" :
			include("templates/cours/olympique.php");
			break;

		case "ironman" :
			include("templates/cours/ironman.php");
			break;
			
		case "apprentissageNatation" :
			include("templates/cours/apprentissageNatation.php");
			break;

		case "perfectionnementNatation" :
			include("templates/cours/perfectionnementNatation.php");
			break;

		case "perfectionnementNatationEauLibre" :
			include("templates/cours/perfectionnementNatationEauLibre.php");
			break;

		case "entrainementNatation" :
			include("templates/cours/entrainementNatation.php");
			break;

		case "modifierCours" :
			include("templates/admin/modifierCours.php");
			break;

		case "adminBlog" :
			include("templates/admin/adminBlog.php");
		break;

		case "modificationActu" :
			include("templates/admin/modificationActu.php");
		break;

		case "reservation" :
			include("templates/reservation.php");
			break;

		case "blog" :
			include("templates/blog.php");
			break;

		case "admin" :
			include("templates/admin/dashboard.php");
			break;

		case "gestion" :
			include("templates/admin/gestion.php");
			break;

		case "login" :
			include("templates/login.php");
			break;

		case "inscription" :
			include("templates/inscription.php");
			break;

		case "oubli" :
			include("templates/oubli.php");
			break;

		case "planning" :
			include("templates/admin/planning.php");
			break;

		case "moncompte" :
			include("templates/moncompte.php");
			break;			

		default : // si le template correspondant à l'argument existe, on l'affiche
			if (file_exists("templates/$view.php"))
				include("templates/$view.php");
	}
	

if($view!="admin" && $view!="login" && $view!="modificationActu" && $view!="reservationAdmin" && $view!="modifierCours" && $view!="adminBlog" && $view!="inscription" && $view!="oubli" && $view!="reinit" && $view!="planning" && $view!="gestion"){include("templates/footer.php");}
else if($view!="inscription" && $view!="oubli" && $view!="reinit" && $view!="login"){
	echo '<script>if($(document).height()>$(window).height()){
		$("#sidebarMenu").height($(document).height());
	}else{
		$("#sidebarMenu").height($(window).height());
	}</script>';
}

	
?>








