<?php
session_start();
// génère et envoie un ID  de session  sous forme de cookie au client 
// qui nous le renverra 

	include_once "../libs/maLibUtils.php";
	include_once "../libs/maLibSQL.pdo.php";
	include_once "../libs/maLibSecurisation.php"; 
	include_once "../libs/modele.php"; 
	include_once "../libs/mail.php"; 

	$qs = "";

	if ($action = valider("action"))
	{
		ob_start ();
		//echo "Action = '$action' <br />";
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

			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				{
					if ($passe = valider("passe"))
					{
						// On verifie l'utilisateur, 
						// et on crée des variables de session si tout est OK
						// Cf. maLibSecurisation
						if ($passe2=getMdp($login))
						{
							if (password_verify($passe, $passe2))
							{
								if (verifUser($login,$passe2)) 
								{
									// tout s'est bien passé, doit-on se souvenir de la personne ? 
									if (valider("remember")) 
									{
										setcookie("login",$login , time()+60*60*24*30);
										setcookie("passe",$password, time()+60*60*24*30);
										setcookie("remember",true, time()+60*60*24*30);
									} 
									else 
									{
										setcookie("login","", time()-3600);
										setcookie("passe","", time()-3600);
										setcookie("remember",false, time()-3600);
									}
									if(isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION')))
									{
									echo ("
									{
										\"redirect\":{
											\"to\":\"admin\",
											\"in\":\"2800\"
										},
										\"alert\":{
											\"message\":\"Connexion réussie ! Vous allez être redirigé... \",
											\"type\":\"success\"
										}
									}
									");
									}
									else
									{
									echo ("
									{
										\"redirect\":{
											\"to\":\"accueil\",
											\"in\":\"2800\"
										},
										\"alert\":{
											\"message\":\"Connexion réussie ! Vous allez être redirigé... \",
											\"type\":\"success\"
										}
									}
									");
									}
								}
								else
								{
								echo ("
									{
										\"alert\":{
											\"message\":\"La Connexion a échouée, veuillez essayer à nouveau.\",
											\"type\":\"danger\"
										},
										\"value\":{
											\"login\":\"$login\",
											\"passe\":\"$passe\"
										}
									}
			
								");
								}
							}
							else
							{
							echo ("
								{
									\"alert\":{
										\"message\":\"Le mot de passe est erroné, veuillez essayer à nouveau.\",
										\"type\":\"danger\"
									},
									\"value\":{
										\"login\":\"$login\",
										\"passe\":\"$passe\"
									}
								}
		
							");
							}
						}
						else
						{
						echo ("
							{
								\"alert\":{
									\"message\":\"Cette adresse mail n'a pas de compte, veuillez essayer à nouveau.\",
									\"type\":\"danger\"
								},
								\"value\":{
									\"login\":\"$login\",
									\"passe\":\"$passe\"
								}
							}
						");			
						}
					}
					else
					{
					echo ("
						{
							\"alert\":{
								\"message\":\"Veuillez saisir un mot de passe.\",
								\"type\":\"danger\"
							},
							\"value\":{
								\"login\":\"$login\"
							}
						}
					");		
					}
				}
				else
				{
				echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez saisir une adresse mail.\",
							\"type\":\"danger\"
						}
					}
				");	
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Inscription' :
				// On verifie la presence des champs login et passe
				if ($prenom = valider("prenom"))
				{
					if ($nom = valider("nom"))
					{
						if ($sexe = valider("sexe"))
						{
							if ($mail = valider("mail"))
							{
								if ($passe = valider("passe"))
								{
									if ($passe2 = valider("passe2"))
									{
										if($passe == $passe2)
										{
											if(getUserByMail($mail)!=$mail){
												$passe=password_hash($passe, PASSWORD_DEFAULT);
												getinscription($prenom, $nom, $sexe, $mail, $passe);
												if (verifUser($mail,$passe)) {
													setcookie("login","", time()-3600);
													setcookie("passe","", time()-3600);
													setcookie("remember",false, time()-3600);
													$message="Bonjour $prenom !<br><br> Merci pour votre inscription.<br>Votre mot de passe est : $passe2<br><br>";
													$message.= "À bientôt,<br>Nicolas Barthes";
													SendEmail($mail, "Bienvenue $prenom !",$message);
													echo ("
													{
														\"redirect\":{
															\"to\":\"accueil\",
															\"in\":\"2800\"
														},
														\"alert\":{
															\"message\":\"Inscription réussie ! Vous allez être redirigé... \",
															\"type\":\"success\"
														}
													}
													");
												}
											}
											else
											{
											echo ("
												{
													\"alert\":{
														\"message\":\"Cet email est déjà utilisé.\",
														\"type\":\"danger\"
													},
													\"value\":{
														\"prenom\":\"$prenom\",
														\"nom\":\"$nom\",
														\"sexe\":\"$sexe\",
														\"mail\":\"$mail\",
														\"passe\":\"$passe\",
														\"passe2\":\"$passe2\"
													}
												}
											");	
											}
										}
										else
										{
										echo ("
											{
												\"alert\":{
													\"message\":\"Les mots de passes ne sont pas identiques.\",
													\"type\":\"danger\"
												},
												\"value\":{
													\"prenom\":\"$prenom\",
													\"nom\":\"$nom\",
													\"sexe\":\"$sexe\",
													\"mail\":\"$mail\",
													\"passe\":\"$passe\",
													\"passe2\":\"$passe2\"
												}
											}
										");											
										}
									}
									else
									{
									echo ("
										{
											\"alert\":{
												\"message\":\"Veuillez entrer un mot de passe.\",
												\"type\":\"danger\"
											},
											\"value\":{
												\"prenom\":\"$prenom\",
												\"nom\":\"$nom\",
												\"sexe\":\"$sexe\",
												\"mail\":\"$mail\",
												\"passe\":\"$passe\"
											}
										}
									");
									}
								}
								else
								{
								echo ("
									{
										\"alert\":{
											\"message\":\"Veuillez entrer un mot de passe.\",
											\"type\":\"danger\"
										},
										\"value\":{
											\"prenom\":\"$prenom\",
											\"nom\":\"$nom\",
											\"sexe\":\"$sexe\",
											\"mail\":\"$mail\"
										}
									}
								");
								}
							}
							else
							{
							echo ("
								{
									\"alert\":{
										\"message\":\"Veuillez entrer un email.\",
										\"type\":\"danger\"
									},
									\"value\":{
										\"prenom\":\"$prenom\",
										\"nom\":\"$nom\",
										\"sexe\":\"$sexe\"
									}
								}
							");
							}
						}
						else
						{
							echo ("
							{
								\"alert\":{
									\"message\":\"Votre genre est mal défini.\",
									\"type\":\"danger\"
								},
								\"value\":{
									\"prenom\":\"$prenom\",
									\"nom\":\"$nom\"
								}
							}
						");
						}
					}
					else
					{
					echo ("
						{
							\"alert\":{
								\"message\":\"Veuillez entrer un nom.\",
								\"type\":\"danger\"
							},
							\"value\":{
								\"prenom\":\"$prenom\"
							}
						}
					");
					}
				}
				else
				{
				echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez entrer un prénom.\",
							\"type\":\"danger\"
						}
					}
				");
				}
			break;

			case 'Oubli' :
				if ($mail = valider("login"))
				{
					if(getUserByMail($mail)){
						$id=getIdByMail($mail);
						if(!getIdOubli($id))
						{
							updateOubli($id);
							$UID=getUIDOubli($id);
							$message="Vous avez demandé une réinitialisation de mot de passe<br><br> Veuillez suivre le lien suivant:<br><br>";
							$message .= "<a href=\"http://localhost/projetweb/projetinfo/index.php?view=reinit&id=".$UID."\"><p>Réinitialiser le mot de passe</p></a>";
							echo ("	
							{
								\"alert\":{
									\"message\":\"Une demande de réinitialisation de mot de <br>passe a été envoyée à votre adresse électronique.\",
									\"type\":\"success\"
								}
							}
							");
							SendEmail($mail, 'Réinitialisation de mot de passe',$message);
						}
						else
						{
							echo ("
							{
								\"alert\":{
									\"message\":\"Une demande de réinitialisation de mot de <br>passe a déja été envoyé à cette adresse mail.<br> Veuillez attendre 15 minutes avant de pouvoir<br> faire une nouvelle demande.\",
									\"type\":\"danger\"
								},
								\"value\":{
									\"login\":\"$mail\"
								}
							}
							");		
						}
					}
					else
					{
						echo ("
						{
							\"alert\":{
								\"message\":\"Cette adresse mail n'a pas de compte.\",
								\"type\":\"danger\"
							},
							\"value\":{
								\"login\":\"$mail\"
							}
						}
					");
					}
				}
				else
				{
					echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez entrer une adresse mail.\",
							\"type\":\"danger\"
						}
					}
				");
				}
			break;

			case 'Logout' :
				session_destroy();
				echo ("
							
							{
								\"redirect\":{
									\"to\":\"login\",
									\"in\":\"0\"
								}
							}
				");
			break;

			case 'Reinitialiser' :
				if($passe = valider("passe"))
				{
					if($passe2 = valider("passe2"))
					{
						if($passe == $passe2)
						{
							$id=valider("id");
							$passe=password_hash($passe, PASSWORD_DEFAULT);
							updateMdp($id,$passe);
							deleteOubli($id);
							$mail=getMail($id);
							if (verifUser($mail,$passe)) {
								setcookie("login","", time()-3600);
								setcookie("passe","", time()-3600);
								setcookie("remember",false, time()-3600);
								echo ("
								{
									\"redirect\":{
										\"to\":\"accueil\",
										\"in\":\"2800\"
									},
									\"alert\":{
										\"message\":\"Réinitialisation de mot de passe réussie ! Vous allez être redirigé... \",
										\"type\":\"success\"
									}
								}
								");
							}
						}
						else
						{
						echo ("
						{
							\"alert\":{
								\"message\":\"Les mots de passes ne sont pas identiques.\",
								\"type\":\"danger\"
							},
							\"value\":{
								\"passe\":\"$passe\",
								\"passe2\":\"$passe2\"
							}
						}
						");
						}
					}
					else
					{
					echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez confirmer votre nouveau mot de passe.\",
							\"type\":\"danger\"
						},
						\"value\":{
							\"passe\":\"$passe\"
						}
					}
					");
					}
				}
				else
				{
				echo ("
				{
					\"alert\":{
						\"message\":\"Veuillez entrer un nouveau mot de passe.\",
						\"type\":\"danger\"
					}
				}
				");
				}

			break;

			case "Modifier Nom" :
				if($nom=valider("donnee")){
					$id=valider("id");
					modifNom($id,$nom);
					echo ("
					{
						\"alert\":{
							\"message\":\"Le nom a été modifié avec succés.\",
							\"type\":\"success\"
						}
					}
					");	
				}
				else
				{
					echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez saisir un nom.\",
							\"type\":\"danger\"
						}
					}
					");	
				}
			break;

			case "Modifier Prenom" :
				if($prenom=valider("donnee")){
					$id=valider("id");
					modifPrenom($id,$prenom);
					echo ("
					{
						\"alert\":{
							\"message\":\"Le prénom a été modifié avec succés.\",
							\"type\":\"success\"
						}
					}
					");	
				}
				else
				{
					echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez saisir un prénom.\",
							\"type\":\"danger\"
						}
					}
					");	
				}
			break;


			case "Modifier Genre" :
				if($genre=valider("donnee")){
					$id=valider("id");

					if($genre=='Homme'){
						$sexe=0;
					}
					if($genre=='Femme'){
						$sexe=1;
					}
					if($genre=='Autre'){
						$sexe=2;
					}

					modifGenre($id,$sexe);
					echo ("
					{
						\"alert\":{
							\"message\":\"Le genre a été modifié avec succés.\",
							\"type\":\"success\"
						}
					}
					");	
				}
				else
				{
					echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez saisir un genre.\",
							\"type\":\"danger\"
						}
					}
					");	
				}
			break;


			case "Modifier Mail" :
				if($mail=valider("donnee")){
					$id=valider("id");
					modifMail($id,$mail);
					echo ("
					{
						\"alert\":{
							\"message\":\"Le mail a été modifié avec succés.\",
							\"type\":\"success\"
						}
					}
					");	
				}
				else
				{
					echo ("
					{
						\"alert\":{
							\"message\":\"Veuillez saisir un mail.\",
							\"type\":\"danger\"
						}
					}
					");	
				}

			break;

		}

	}else{



	$urlBase = dirname($_SERVER["PHP_SELF"]) . "";
    $urlBase = str_replace("api", "index.php", $urlBase);
	// On redirige vers la page index avec les bons arguments
	header("Location:" . $urlBase . $qs);
    }

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>