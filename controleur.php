<?php
session_start();
// génère et envoie un ID  de session  sous forme de cookie au client 
// qui nous le renverra 

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 
	include_once "libs/controleur_mails.php";

	define('TARGET', './assets/img/sports/');    // Repertoire cible
	define('TARGET2', './assets/img/imageBlog/');    // Repertoire cible
	define('MAX_SIZE', 100000);    // Taille max en octets du fichier
	define('WIDTH_MAX', 2000);    // Largeur max de l'image en pixels
	define('HEIGHT_MAX', 2000);    // Hauteur max de l'image en pixels
	
	// Tableaux de donnees
	$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
	$infosImg = array();
	
	// Variables
	$extension = '';
	$message = '';
	$nomImage = '';


	$qs = "";

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{

			case 'Crénaux disponibles' :
                if ($cours = valider("cours"))
                {
                    switch ($cours)
                    {
                        case 'aquabike' :
                            $qs='?view=reservation&cours=aquabike';
                        break;

						case 'aquagym' :
							$qs='?view=reservation&cours=aquagym';
							break;

						case 'ironman' :
							$qs='?view=reservation&cours=ironman';
							break;

						case 'apprentissageNatation' :
							$qs='?view=reservation&cours=apprentissageNatation';
							break;

						case 'entrainementNatation' :
							$qs='?view=reservation&cours=entrainementNatation';
							break;

						case 'half' :
							$qs='?view=reservation&cours=half';
							break;
	
						case 'olympique' :
							$qs='?view=reservation&cours=olympique';
						break;
						
						case 'perfectionnementNatation' :
							$qs='?view=reservation&cours=perfectionnementNatation';
						break;
					
						case 'perfectionnementNatationEauLibre' :
							$qs='?view=reservation&cours=perfectionnementNatationEauLibre';
						break;

						case 'sprint' :
							$qs='?view=reservation&cours=sprint';
						break;

                    }

                }
            break;

			case 'Réserver pour ce créneaux' :
				if ($idCours = valider("idCours"))
                {
					if ($idUser = valider("idUser",'SESSION'))
                	{
						creerNewResa($idUser,$idCours);
						$prenom=getFirstName($idUser);
						$email=getMail($idUser);
						send_type_mail('confirmreserve',$email,$prenom);
						$qs='?view=reservation&resa=oui';
					}
				}

			break;

			case 'Annuler cette réservation' :
				if ($idResa = valider("idResa"))
                {
					if ($idUser = valider("idUser",'SESSION'))
                	{
						deleteResa($idResa);
						$qs='?view=reservation&supprime=oui';
					}
				}

			break;


			case 'A propos' :
				if ($cours = valider("cours"))
                	{
						switch($cours)
						{
							case 'sprint' :
								$qs='?view=sprint';
							break;

							case 'olympique' :
								$qs='?view=olympique';
							break;

							case 'half' :
								$qs='?view=half';
							break;

							case 'ironman' :
								$qs='?view=ironman';
							break;

							case 'apprentissageNatation' :
								$qs='?view=apprentissageNatation';
							break;

							case 'aquabike' :
								$qs='?view=aquabike';
							break;

							case 'aquagym' :
								$qs='?view=aquagym';
							break;

							case 'entrainementNatation' :
								$qs='?view=entrainementNatation';
							break;

							case 'perfectionnementNatation' :
								$qs='?view=perfectionnementNatation';
							break;

							case 'perfectionnementNatationEauLibre' :
								$qs='?view=perfectionnementNatationEauLibre';
							break;
						}
					}
			break;

      case 'Connexion' :
                $qs='?view=login';
			break;

			case 'Mon Compte' :
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))) $qs='?view=moncompte';
				else $qs='?view=admin';
			break;
			
			case 'Administration' :
				$qs='?view=admin';
			break;


			case 'Se déconnecter' :
				session_destroy();
			break;

			case 'Enregistrer les Modifications' :

				if($idActivite = valider("IDactiviteModif"))  //recuperation de l'id de l'activite modifiée
				{
					$qs='?view=modifierCours&activite=' . $idActivite;		
				}

				
				if($description = valider("description"))     //on modifie la description si elle est differente de celle dans la db
				{
					$descriptionActuelle = getDescriptionSport($idActivite);
					if($description != $descriptionActuelle)
					{
						$qs= $qs . '&changementDescription=oui';
						updateDescriptionActivite($idActivite, $description);	
					}
				}
				
				if($miniDesc = valider("miniDesc"))           //on modifie la mini description si elle est differente de celle dans la db
				{
					$miniDescActuelle = getMiniDesc($idActivite);
					if($miniDesc != $miniDescActuelle)
					{
						$qs= $qs . '&changementMiniDesc=oui';
						updateMiniDescActivite($idActivite, $miniDesc);	
					}
				}
				
				if($prix = valider("prix"))                //on modifie le prix si elle est differente de celle dans la db
				{
					$prixActuel = getTarifSport($idActivite);
					if($prix != $prixActuel)
					{
						$qs= $qs . '&changementPrix=oui';
						updatePrixActivite($idActivite, $prix);	
					}
				}


				///////////////////////////////TELEVERSEMENT D'IMAGES///////////////////////////////
				if(!empty($_POST))
				{
					if( !empty($_FILES["fichier"]["name"]) )
					{
						$extension  = pathinfo($_FILES["fichier"]["name"], PATHINFO_EXTENSION);  //on recup l'extension du fichier afin de la comparer avec les extensions valides
					
						if(in_array(strtolower($extension),$tabExt))
						{
						
						$infosImg = getimagesize($_FILES['fichier']['tmp_name']);
					
							if($infosImg[2] >= 1 && $infosImg[2] <= 14)
							{
								if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
								{
									if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
									{
										$nomImage = md5(uniqid()) .'.'. $extension;
							
										if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
										{										
											$message = "Image changée avec succès !&couleur=LimeGreen";
											$lien = './assets/img/sports/' . $nomImage;
											updateLienImageActivite($idActivite, $lien);
										}
										else
										{
										$message = "Problème lors de l'upload !&couleur=red";
										}
									}
									else
									{
										$message = "Une erreur interne a empêché l'upload de l'image&couleur=red";
									}
								}
								else
								{
								$message = "Erreur dans les dimensions de l'image !&couleur=red";
								}
							}
							else
							{
								$message = "Le fichier à uploader n'est pas une image !&couleur=red";
							}
						}
						else
						{
							$message = "L'extension du fichier est incorrecte !&couleur=red";
						}
					}
				}

				$qs= $qs . '&message=' . $message;
			break;

			case 'Poster Article' :
				$qs='?view=adminBlog';
				$titre = valider("titre");
				$texte = valider("texte");
				$date = valider("date");
				if(!empty($_POST)){
					if(!empty($_FILES["fichier2"])){
						$extension  = pathinfo($_FILES["fichier2"]["name"], PATHINFO_EXTENSION);
						if(in_array(strtolower($extension),$tabExt)){
							$infosImg = getimagesize($_FILES['fichier2']['tmp_name']);
							if($infosImg[2] >= 1 && $infosImg[2] <= 14) {
								if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier2']['tmp_name']) <= MAX_SIZE)) {
									if(isset($_FILES['fichier2']['error']) && UPLOAD_ERR_OK === $_FILES['fichier2']['error']){
										$nomImage = md5(uniqid()) .'.'. $extension;

										if(move_uploaded_file($_FILES['fichier2']['tmp_name'], TARGET2.$nomImage)){
											$lien = './assets/img/imageBlog/' . $nomImage;
											ajoutArticle($titre, $texte, $date,$lien);
											$message = "Article posté avec succès !&couleur=LimeGreen";
										}
										else{
											$message = "Problème lors de l'upload !&couleur=red";
										}
									}
									else{
										$message = "Une erreur interne a empêché l'upload de l'image&couleur=red";
									}
								}
								else{
									$message = "Erreur dans les dimensions de l'image !&couleur=red";
								}
							}
							else{
								$message = "Le fichier à uploader n'est pas une image !&couleur=red";
							}
						}
						else{
							$message = "L'extension du fichier est incorrecte !&couleur=red";
						}
					}
				}
				$qs= $qs . '&message=' . $message;
				break;

			case 'Modifier Article' :
				$qs='?view=adminBlog';
				$idActu = valider("idActu");
				$titre = valider("titre");
				$texte = valider("texte");
				$date = valider("date");
				if(!empty($_POST)){
					if(!empty($_FILES["fichier2"])){
						$extension  = pathinfo($_FILES["fichier2"]["name"], PATHINFO_EXTENSION);
						if(in_array(strtolower($extension),$tabExt)){
							$infosImg = getimagesize($_FILES['fichier2']['tmp_name']);
							if($infosImg[2] >= 1 && $infosImg[2] <= 14) {
								if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier2']['tmp_name']) <= MAX_SIZE)) {
									if(isset($_FILES['fichier2']['error']) && UPLOAD_ERR_OK === $_FILES['fichier2']['error']){
										$nomImage = md5(uniqid()) .'.'. $extension;

										if(move_uploaded_file($_FILES['fichier2']['tmp_name'], TARGET2.$nomImage)){
											$message = "Article modifié avec succès !&couleur=LimeGreen";
											$lien = './assets/img/imageBlog/' . $nomImage;
											modifarticle($idActu,$titre,$texte,$date,$lien);
										}
										else{
											$message = "Problème lors de l'upload !&couleur=red";
										}
									}
									else{
										$message = "Une erreur interne a empêché l'upload de l'image&couleur=red";
									}
								}
								else{
									$message = "Erreur dans les dimensions de l'image !&couleur=red";
								}
							}
							else{
								$message = "Le fichier à uploader n'est pas une image !&couleur=red";
							}
						}
						else{
							$message = "Article modifié avec succès ! (sans changement image)&couleur=LimeGreen";
							modifarticle($idActu,$titre,$texte,$date,NULL);
						}
					}
				}
				$qs= $qs . '&message=' . $message;
		break;
				
		}
	
	}

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $qs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










