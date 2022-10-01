<?php
session_start();
// génère et envoie un ID  de session  sous forme de cookie au client 
// qui nous le renverra 

	include_once "../libs/maLibUtils.php";
	include_once "../libs/maLibSQL.pdo.php";
	include_once "../libs/maLibSecurisation.php"; 
	include_once "../libs/modele.php"; 
	include_once("../libs/maLibForms.php");

	$qs = "";

	if ($action = valider("action"))
	{
		if ($idActivite = valider("idActivite"))
		{
		}	
		if ($idUser = valider("idUser"))
		{
		}	
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
			case 'getActiviteDispo' :
				// On verifie la presence des champs login et passe
				
					echo "<div style=\"slide-in-right\">";
					$lastcours=prochainesActivitesDispo($idActivite);
					if(empty($lastcours))
					{
						echo "Oups, on dirait qu'aucun crénaux n'est disponible pour ce cours 😕";
					}
					else
					{
					foreach($lastcours as $cours)
					{
						$dateDebut=strtotime($cours['debut']);
						$dateFin=strtotime($cours['fin']);
						$datestr=date("d/m/Y",$dateDebut);
						$heureDebut=date("H:i",$dateDebut);
						$heureFin=date("H:i",$dateFin);
						echo "<tr>
						<td>$datestr</td>
						<td>$heureDebut - $heureFin</td>
						<td>";
							mkForm('controleur.php');
							mkInputBoutton('submit','action','Réserver pour ce créneaux');
							mkInput('hidden','idCours',$cours['id_acti_dispo']);
							endForm();
                    	echo "</td>
						</tr>";
					}
				}
					echo "</div>";
				
				
				// On redirigera vers la page index automatiquement
			break;



			case 'getMesResa' :
				// On verifie la presence des champs login et passe
				
					echo "<div style=\"slide-in-right\">";
					$lastcours=mesReservations($idUser);
					if(empty($lastcours))
					{
						echo "Vous n'avez reservé aucun cours pour l'instant !";
					}
					else
					{
					foreach($lastcours as $cours)
					{
						$dateDebut=strtotime($cours['debut']);
						$dateFin=strtotime($cours['fin']);
						$datestr=date("d/m/Y",$dateDebut);
						$heureDebut=date("H:i",$dateDebut);
						$heureFin=date("H:i",$dateFin);
						echo "<tr>
						<td>".$cours['nomsport']."</td>
						<td>$datestr</td>
						<td>$heureDebut - $heureFin</td>
						<td>";
							mkForm('controleur.php');
							mkInputBoutton('submit','action','Annuler cette réservation');
							mkInput('hidden','idResa',$cours['id_reservation']);
							endForm();
                    	echo "</td>
						</tr>";
					}
				}
					echo "</div>";
				
				
				// On redirigera vers la page index automatiquement
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










