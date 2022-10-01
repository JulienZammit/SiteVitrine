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
			case 'GetLast10books' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else{
					echo "<div style=\"slide-in-right\">";
					$lastcours=lastcours();
					foreach($lastcours as $cours){
					$date=strtotime($cours['debut']);
					$datestr=date("d/m/Y",$date);
					$hours=date("H:i",$date);
					echo "<tr>
					<td><a href=\"\">#$cours[id_reservation]</a></td>
					<td><a href=\"\">$cours[prenom] $cours[nom]</a></td>
					<td>Cours de $cours[nomsport]</td>
					<td>le <b>$datestr</b> à <b>$hours</b></td>
					</tr>";
					}
					echo "</div>";
					
				}

				// On redirigera vers la page index automatiquement
			break;
        
      case 'GetUtilisateurs' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else{
					echo "<div style=\"slide-in-right\">";
					$getUsers=getUsers();
					foreach($getUsers as $users){
						echo "<tr>
						<td>$users[nom]</td>
						<td>$users[prenom]</td>
						<td>$users[mail]</td>";
						if($users['blacklist']==1){
							echo "
							<td>Oui</td>
							<td><input onclick='deblacklist($users[id_utilisateur]);' type='button' value='Autoriser' class='form-control' id='$users[id_utilisateur]'></td>
							</tr>";
						}else{
							echo "
							<td>Non</td>
							<td><input onclick='blacklist($users[id_utilisateur]);' type='button' value='Bannir' class='form-control bannissement' id='$users[id_utilisateur]'></td>
							</tr>";
						}
					}
					echo "</div>";
					
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Bannir' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else{
					$id=valider("id");
					bannir($id);
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'deBannir' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else{
					$id=valider("id");
					debannir($id);
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Reservation' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else{
					echo "<div style=\"slide-in-right\">";
					$lastcours=touslesCours();
					foreach($lastcours as $cours){
						$date=strtotime($cours['debut']);
						$statut=$cours['statut'];
						$datestr=date("d/m/Y",$date);
						$hours=date("H:i",$date);
						echo "<tr>
					<td><a href=\"\">#$cours[id_reservation]</a></td>
					<td><a href=\"\">$cours[prenom] $cours[nom]</a></td>
					<td>Cours de $cours[nomsport]</td>
					<td>le <b>$datestr</b> à <b>$hours</b></td>
					<td>";
						if($statut==0){
							echo "<input onclick='acceptRequest($cours[id_reservation]);' type=\"submit\" name=\"action\" value=\"Accepter\" class=\"btn btn-primary\">
								<input onclick='refuseRequest($cours[id_reservation]);'type=\"submit\" name=\"action\" value=\"Refuser\" class=\"btn btn-primary\">";
						}else{
							echo "<b>Requête Acceptée</b>";
						}
					}
					echo "</td></tr>";
					}
					echo "</div>";
				// On redirigera vers la page index automatiquement
				break;

			case "AcepterRequest":
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					if ($idRequest = valider("idRequest")) {
						$inforeservation=getinforesa($idRequest);
						$date=strtotime($inforeservation['debut']);
						$message="Bonjour $inforeservation[prenom],<br><br> Votre réservation $inforeservation[nomsport] pour le ".(date("d/m/Y",$date))." a été <b>accepté</b> !<br><br>";
						$message.= "À bientôt,<br>Nicolas Barthes";
						SendEmail($inforeservation['mail'], "Réservation $inforeservation[nomsport] accepté",$message);
						accepterReservation($idRequest);
					}
				}
				break;

			case "RefuserRequest":
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					if ($idRequest = valider("idRequest")) {
						$inforeservation=getinforesa($idRequest);
						$date=strtotime($inforeservation['debut']);
						$message="Bonjour $inforeservation[prenom],<br><br> Votre réservation $inforeservation[nomsport] pour le ".(date("d/m/Y",$date))." a été <b>réfusé</b>.<br><br>";
						$message.= "À bientôt,<br>Nicolas Barthes";
						SendEmail($inforeservation['mail'], "Réservation $inforeservation[nomsport] refusé",$message);
						refuserReservation($idRequest);
					}
				}
				break;

			case "supprimerRequestAccept":
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					supprimerRequestAccept();
				}
				break;
				break;

			case "Archiver" :
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					if ($idActu = valider("idActu")) {
						archiveActu($idActu);
						echo ("
							{
								\"redirect\":{
									\"to\":\"adminBlog\",
									\"in\":\"500\"
								},
								\"alert\":{
									\"message\":\"Article archivé !\",
									\"type\":\"success\"
								}
							}
							");
					}
				}
				break;

			case "Supprimer" :
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					if ($idActu = valider("idActu")) {
						deleteActu($idActu);
						echo("
							{
								\"redirect\":{
									\"to\":\"adminBlog\",
									\"in\":\"500\"
								},
								\"alert\":{
									\"message\":\"Article suppprimé !\",
									\"type\":\"success\"
								}
							}
							");
					} else {
						echo("
							{
								\"alert\":{
									\"message\":\"Il manque l'id de l'actualité\",
									\"type\":\"danger\"
								}
							}

							");
					}
				}
				break;

			case "Mettreenligne" :
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					if ($idActu = valider("idActu")) {
						mettreenligneActu($idActu);
						echo("
							{
								\"redirect\":{
									\"to\":\"adminBlog\",
									\"in\":\"500\"
								},
								\"alert\":{
									\"message\":\"Article mis en ligne !\",
									\"type\":\"success\"
								}
							}
							");
					} else {
						echo("
							{
								\"alert\":{
									\"message\":\"Il manque l'id de l'actualité\",
									\"type\":\"danger\"
								}
							}

							");
					}
				}
				break;

			case "Modifier2" :
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}else {
					if ($idActu = valider("idActu")) {
						echo("
							{
								\"redirect\":{
									\"to\":\"modificationActu&idActu=$idActu\",
									\"in\":\"500\"
								},
								\"alert\":{
									\"message\":\"Article numéro $idActu !\",
									\"type\":\"success\"
								}
							}
							");
					} else {
						echo("
							{
								\"alert\":{	
									\"message\":\"Manque élément actualité\",
									\"type\":\"danger\"
								}
							}
							");
					}
				}
				break;

			case 'updatecoursHour' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}
				else{
					if ($idactidispo = valider("idactidispo")){
						if ($debut_date = valider("debut_date")){
							if($debut_hour = valider("debut_hour")){
								if ($fin_date = valider("fin_date")){
									if($fin_hour = valider("fin_hour")){
										$debut="$debut_date $debut_hour";
										$fin="$fin_date $fin_hour";
										$idcreneaux=getidcreneaux_fromactidispo($idactidispo);
										modifheurecours($debut,$fin,$idcreneaux);
									}
								}
							}
						}
					}
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'addCours' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}
				else{
					if ($idactivite = valider("idactivite")){
						if ($debut_date = valider("debut_date")){
							if($debut_hour = valider("debut_hour")){
								if ($fin_date = valider("fin_date")){
									if($fin_hour = valider("fin_hour")){
										$debut="$debut_date $debut_hour";
										$fin="$fin_date $fin_hour";
										createcreneau($debut,$fin);
										$lastidcreneau=getlastidcreneau();
										createactidispo($lastidcreneau,$idactivite);
										$datasend["idcours"]=getlastcreatedcours();
										echo json_encode($datasend);
									}
								}
							}
						}
					}
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'disableCours' :
				// On verifie la presence des champs login et passe
				securiser('index.php?view=login');
				if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
					rediriger('index.php');
				}
				else{
					if ($idEvent = valider("idEvent")){
						updatedisableCours($idEvent);
					}else{
						echo "erreur avec idEvent";
					}
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










