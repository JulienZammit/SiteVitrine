<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");
// effet de bord : chargement du fichier config 


function listerUtilisateurs($classe = "both")
{
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,connecte,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "SELECT id_utilisateur,mail,blacklist,connecte,couleur FROM utilisateurs";
	if ($classe == "bl")  $SQL .= " WHERE blacklist=1"; 
	if ($classe == "nbl")  $SQL .= " WHERE blacklist=0"; 

	//echo $SQL; 

	$resourceMysql = SQLSelect($SQL);
	// resourceMysql est un objet qui ne se parcourt pas facilement 

	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp; 
}

function listerCours()
{

	$SQL = "SELECT AD.id_acti_dispo as id, C.debut, C.fin, S.nomsport, S.mini_description, S.description, S.tarif FROM activites_disponibles AD, creneaux_horaires C, sports S WHERE AD.est_dispo=1 
AND AD.activite=S.id_activité AND AD.creneaux=C.id_crénaux";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp; 
}

function listerSport()
{

	$SQL = "SELECT * FROM sports";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp; 
}

function getidcreneaux_fromactidispo($idactidispo)
{
	$idactidispo=htmlspecialchars($idactidispo);
	$SQL = "SELECT C.id_crénaux AS id_c FROM creneaux_horaires C, activites_disponibles AD WHERE AD.creneaux=C.id_crénaux AND AD.id_acti_dispo='$idactidispo'";
	return SQLGetChamp($SQL);
}

function modifarticle($id_article,$titre,$texte,$date,$image)
{
	$titre = htmlspecialchars($titre);
	$texte = htmlspecialchars($texte);
	$date = htmlspecialchars($date);
	$image = htmlspecialchars($image);
	if($image==NULL){
		$SQL = "UPDATE blog SET titre='$titre' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
		$SQL = "UPDATE blog SET texte='$texte' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
		$SQL = "UPDATE blog SET date='$date' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
	}else{
		$SQL = "UPDATE blog SET titre='$titre' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
		$SQL = "UPDATE blog SET texte='$texte' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
		$SQL = "UPDATE blog SET date='$date' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
		$SQL = "UPDATE blog SET image='$image' WHERE idActu='$id_article'";
		SQLUpdate($SQL);
	}
}

function modifheurecours($heurestart,$heurefin,$id_crénaux)
{
	$heurestart=htmlspecialchars($heurestart);
	$heurefin=htmlspecialchars($heurefin);
	$id_crénaux=htmlspecialchars($id_crénaux);
	$SQL = "UPDATE creneaux_horaires SET debut='$heurestart' WHERE id_crénaux='$id_crénaux'";
	SQLUpdate($SQL);
	$SQL = "UPDATE creneaux_horaires SET fin='$heurefin' WHERE id_crénaux='$id_crénaux'";
	SQLUpdate($SQL);
}

function getNbUsers()
{
	// cette fonction affecte le booléen "blacklist" à faux pour l'utilisateur concerné 
	$SQL="SELECT COUNT('id_utilisateur') FROM utilisateurs";
	return SQLGetChamp($SQL);
}

function getNbReservationThisWeek(){
	$i=1;
	$startweek = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	while(date('l',$startweek) != "Monday"){
		$startweek = mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y"));
	$i=$i+1;
	}
	$nextweek=date("Y-m-d H:i:s",strtotime('+1 week',$startweek));
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT COUNT(id_reservation) FROM reservations r, creneaux_horaires c, activites_disponibles a WHERE r.activite_reservee=a.activite AND a.creneaux=c.id_crénaux AND c.debut<'$nextweek' AND c.debut>'$today'";
	return SQLGetChamp($SQL);
}

function getNbCoursThisWeek(){
	$i=1;
	$startweek = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	while(date('l',$startweek) != "Monday"){
		$startweek = mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y"));
	$i=$i+1;
	}
	$nextweek=date("Y-m-d H:i:s",strtotime('+1 week',$startweek));
	$SQL="SELECT COUNT(id_acti_dispo) FROM creneaux_horaires c, activites_disponibles a WHERE a.creneaux=c.id_crénaux AND c.debut<'$nextweek' AND c.debut>'$startweek'";
	return SQLGetChamp($SQL);
}

function suppdemandemdp($now){
	$now=htmlspecialchars($now);
	//SELECT * FROM `oubli` WHERE TIMEDIFF('$now', date)>='00:15:00'
	$SQL = "DELETE FROM oubli WHERE TIMEDIFF('$now', date)>='00:15:00'";
	SQLDelete($SQL);
}

function nextCours(){
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT * FROM creneaux_horaires c, activites_disponibles a, sports s WHERE a.creneaux=c.id_crénaux AND s.id_activité=a.activite AND c.debut>'$today' GROUP BY c.debut ORDER BY c.debut ASC";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	if(isset($tabPhp[0])) return $tabPhp[0];
	else return null;
}

function getresademain(){
	$i=1;
	$startweek = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	while(date('l',$startweek) != "Monday"){
		$startweek = mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y"));
	$i=$i+1;
	}
	$nextday=date("Y-m-d H:i:s",strtotime('+3 day',$startweek));
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT * FROM reservations r, creneaux_horaires c, activites_disponibles a, sports s, utilisateurs u WHERE  r.activite_reservee=a.id_acti_dispo AND a.activite=s.id_activité AND a.creneaux=c.id_crénaux AND U.id_utilisateur=r.utilisateur AND c.debut<'$nextday' AND c.debut>'$today' AND a.est_dispo=1 AND r.statut=1";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp;
}

function getinforesa($idresa){
	$idresa=htmlspecialchars($idresa);
	$SQL="SELECT * FROM reservations r, creneaux_horaires c, activites_disponibles a, sports s, utilisateurs u WHERE  r.activite_reservee=a.id_acti_dispo AND a.activite=s.id_activité AND a.creneaux=c.id_crénaux AND U.id_utilisateur=r.utilisateur AND r.id_reservation='$idresa'";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp[0];
}

function lastcours(){
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT * FROM reservations r, creneaux_horaires c, activites_disponibles a, sports s, utilisateurs u WHERE  r.activite_reservee=a.id_acti_dispo AND a.activite=s.id_activité AND a.creneaux=c.id_crénaux AND U.id_utilisateur=r.utilisateur ORDER BY r.id_reservation DESC LIMIT 10";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp;
}

function touslesCours(){
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT * FROM reservations r, creneaux_horaires c, activites_disponibles a, sports s, utilisateurs u WHERE  r.activite_reservee=a.id_acti_dispo AND a.activite=s.id_activité AND a.creneaux=c.id_crénaux AND U.id_utilisateur=r.utilisateur ORDER BY r.id_reservation DESC";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql);
	return $tabPhp;
}

function accepterReservation($idRequest){
	$idRequest=htmlspecialchars($idRequest);
	$SQL = "UPDATE reservations SET statut=1 WHERE id_reservation='$idRequest'";
	SQLUpdate($SQL);
}

function refuserReservation($idRequest){
	$idRequest=htmlspecialchars($idRequest);
	$SQL = "DELETE FROM reservations WHERE id_reservation='$idRequest'";
	SQLDelete($SQL);
}

function supprimerRequestAccept(){
	$SQL = "DELETE FROM reservations WHERE statut='1'";
	SQLDelete($SQL);
}

function prochainesActivitesDispo($idActivite)
{
	$idActivite=htmlspecialchars($idActivite);
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT * FROM activites_disponibles ad, creneaux_horaires cr WHERE ad.creneaux=cr.id_crénaux AND ad.est_dispo=1 AND ad.activite = '$idActivite' LIMIT 15";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp;
}

function dejaReserve($idUser,$idActivite)
{
	$idUser=htmlspecialchars($idUser);
	$idActivite=htmlspecialchars($idActivite);
	$SQL="SELECT * FROM reservations WHERE utilisateur='$idUser' AND activite_reservee='$idActivite'";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp;
}

function mesReservations($idUser)
{
	$idUser=htmlspecialchars($idUser);
	$today=date("Y-m-d H:i:s");
	$SQL="SELECT * FROM activites_disponibles ad, creneaux_horaires cr, reservations r, sports s WHERE ad.creneaux=cr.id_crénaux AND s.id_activité=ad.activite AND r.activite_reservee=ad.id_acti_dispo AND r.utilisateur='$idUser'";
	$resourceMysql = SQLSelect($SQL);
	$tabPhp = parcoursRs($resourceMysql); 
	return $tabPhp;
}

function deleteResa($idResa)
{
	$idResa=htmlspecialchars($idResa);
	$SQL = "DELETE FROM reservations WHERE id_reservation='$idResa'";
	SQLDelete($SQL);
}



function creerNewResa($idUser,$idCours)
{
	$idUser=htmlspecialchars($idUser);
	$idCours=htmlspecialchars($idCours);
	$SQL = "INSERT INTO reservations VALUES(NULL ,'$idUser','$idCours','0')";
    SQLInsert($SQL);
}

function interdireUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à vrai pour l'utilisateur concerné 
	// DANGER ! Penser à encadrer les données qui viennent de l'utilisateur 
	// par des apostrophes
	$idUser=htmlspecialchars($idUser);
	$SQL = "UPDATE utilisateurs SET blacklist=1 WHERE id_utilisateur='$idUser'";
	SQLUpdate($SQL);
}

function autoriserUtilisateur($idUser)
{
	$idUser=htmlspecialchars($idUser);
	// cette fonction affecte le booléen "blacklist" à faux pour l'utilisateur concerné 
	$SQL = "UPDATE utilisateurs SET blacklist=0 WHERE id_utilisateur='$idUser'";
	SQLUpdate($SQL);
}

function getFirstName($idUser)
{
	$idUser=htmlspecialchars($idUser);
	// cette fonction affecte le booléen "blacklist" à faux pour l'utilisateur concerné 
	$SQL="SELECT prenom FROM utilisateurs WHERE id_utilisateur='$idUser'";
	return SQLGetChamp($SQL);
}

function verifUserBdd($login,$passe)
{
	$login=htmlspecialchars($login);
	$passe=htmlspecialchars($passe);
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id_utilisateur FROM utilisateurs WHERE mail='$login' AND password='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser,$login)
{
	$idUser=htmlspecialchars($idUser);
	$login=htmlspecialchars($login);
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT isAdmin FROM utilisateurs WHERE id_utilisateur='$idUser' AND mail='$login'";
	return SQLGetChamp($SQL);
}

function isBlacklisted($idUser)
{
	$idUser=htmlspecialchars($idUser);
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT blacklist FROM utilisateurs WHERE id_utilisateur='$idUser'";
	return SQLGetChamp($SQL);
}


function getUserByMail($mail)
{
	$mail=htmlspecialchars($mail);
	//selectionne l'utilisateur par son mail
	$SQL ="SELECT mail FROM utilisateurs WHERE mail='$mail'";
	return SQLGetChamp($SQL);
}

function getIdByMail($mail)
{
	$mail=htmlspecialchars($mail);
	//selectionne l'utilisateur par son mail
	$SQL ="SELECT id_utilisateur FROM utilisateurs WHERE mail='$mail'";
	return SQLGetChamp($SQL);
}

function getinscription($prenom, $nom, $sexe, $mail,$passe)
{
	$prenom=htmlspecialchars($prenom);
	$nom=htmlspecialchars($nom);
	$sexe=htmlspecialchars($sexe);
	$mail=htmlspecialchars($mail);
	$passe=htmlspecialchars($passe);
    //inscrit une personne
	if($sexe=='Homme') $sexe2=0;
	if($sexe=='Femme') $sexe2=1;
	if($sexe=='Autre') $sexe2=2; 
    $SQL = "INSERT INTO Utilisateurs VALUES(NULL ,'$nom','$prenom',$sexe2,'$mail','$passe','0','0')";
    SQLInsert($SQL);
}

function getMdp($mail)
{
	$mail=htmlspecialchars($mail);
	//selectionne l'utilisateur par son mail
	$SQL ="SELECT password FROM utilisateurs WHERE mail='$mail'";
	return SQLGetChamp($SQL);
}

function getMail($id)
{
	$id=htmlspecialchars($id);
	$SQL ="SELECT mail FROM utilisateurs WHERE id_utilisateur='$id'";
	return SQLGetChamp($SQL);
}


function getNomSport($idSport)
{
	$idSport=htmlspecialchars($idSport);
	$SQL ="SELECT nomSport FROM sports WHERE id_activité='$idSport'";
	return SQLGetChamp($SQL);
}

function getMiniDesc($idSport)
{
	$idSport=htmlspecialchars($idSport);
	$SQL ="SELECT mini_description FROM sports WHERE id_activité='$idSport'";
	return SQLGetChamp($SQL);
}

function getDescriptionSport($idSport)
{
	$idSport=htmlspecialchars($idSport);
	$SQL ="SELECT description FROM sports WHERE id_activité='$idSport'";
	return SQLGetChamp($SQL);
}

function getTarifSport($idSport)
{
	$idSport=htmlspecialchars($idSport);
	$SQL ="SELECT tarif FROM sports WHERE id_activité='$idSport'";
	return SQLGetChamp($SQL);
}

function getImageSport($idSport)
{
	$idSport=htmlspecialchars($idSport);
	$SQL ="SELECT lien_image_associee FROM sports WHERE id_activité='$idSport'";
	return SQLGetChamp($SQL);
}

function updateDescriptionActivite($idSport, $newDescription)
{ 
	$idSport=htmlspecialchars($idSport);
	$newDescription=htmlspecialchars($newDescription);
	$SQL = "UPDATE sports SET description='$newDescription' WHERE id_activité='$idSport'";
	SQLUpdate($SQL);
}

function updateMiniDescActivite($idSport, $newMiniDesc)
{ 
	$idSport=htmlspecialchars($idSport);
	$newMiniDesc=htmlspecialchars($newMiniDesc);
	$SQL = "UPDATE sports SET mini_description='$newMiniDesc' WHERE id_activité='$idSport'";
	SQLUpdate($SQL);
}

function updatedisableCours($idEvent)
{ 
	$idEvent=htmlspecialchars($idEvent);
	$SQL = "UPDATE activites_disponibles SET est_dispo=0 WHERE id_acti_dispo='$idEvent'";
	SQLUpdate($SQL);
}

function updatePrixActivite($idSport, $newPrice)
{ 
	$idSport=htmlspecialchars($idSport);
	$newPrice=htmlspecialchars($newPrice);
	$SQL = "UPDATE sports SET tarif='$newPrice' WHERE id_activité='$idSport'";
	SQLUpdate($SQL);
}

function updateLienImageActivite($idSport, $newLien)
{ 
	$idSport=htmlspecialchars($idSport);
	$newLien=htmlspecialchars($newLien);
	$SQL = "UPDATE sports SET lien_image_associee='$newLien' WHERE id_activité='$idSport'";
	SQLUpdate($SQL);
}

function updateOubli($id)
{ 
$id=htmlspecialchars($id);
  $today=date("Y-m-d H:i:s");
  $SQL = "INSERT INTO oubli VALUES(NULL, ROUND(RAND()*999999999999999)+100000 ,'$today',$id)";
  SQLInsert($SQL);
}

function createcreneau($debut,$fin)
{ 
	$debut=htmlspecialchars($debut);
	$fin=htmlspecialchars($fin);
    $SQL = "INSERT INTO creneaux_horaires VALUES(NULL,'$debut','$fin')";
    SQLInsert($SQL);
}

function getlastidcreneau(){
	$SQL ="SELECT MAX(id_crénaux) as id FROM creneaux_horaires";
	return SQLGetChamp($SQL);
}

function getlastcreatedcours(){
	$SQL ="SELECT MAX(id_acti_dispo) as id FROM activites_disponibles";
	return SQLGetChamp($SQL);
}

function createactidispo($idcreneau,$idactivite)
{ 
	$idcreneau=htmlspecialchars($idcreneau);
	$idactivite=htmlspecialchars($idactivite);
    $SQL = "INSERT INTO activites_disponibles VALUES(NULL,'$idactivite','$idcreneau',1)";
    SQLInsert($SQL);
}

function getIdOubli($id){
	$id=htmlspecialchars($id);
	$SQL ="SELECT id_utilisateur FROM oubli WHERE id_utilisateur='$id'";
	return SQLGetChamp($SQL);
}

function getUIDOubli($id){
	$id=htmlspecialchars($id);
	$SQL ="SELECT id FROM oubli WHERE id_utilisateur='$id'";
	return SQLGetChamp($SQL);
}

function getIDbyUID($uid){
	$uid=htmlspecialchars($uid);
	$SQL ="SELECT id_utilisateur FROM oubli WHERE id='$uid'";
	return SQLGetChamp($SQL);
}

function updateMdp($id,$passe){
	$id=htmlspecialchars($id);
	$passe=htmlspecialchars($passe);
	$SQL = "UPDATE utilisateurs SET password='$passe' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}

function deleteOubli($id){
	$id=htmlspecialchars($id);
	$SQL = "DELETE FROM oubli WHERE id_utilisateur='$id'";
	SQLDelete($SQL);
}
/////////////////////////////////////////////////////////////////////////////////////////////

function getUserByID($id)
{
	$id=htmlspecialchars($id);
	//selectionne l'utilisateur par son id
	$SQL ="SELECT * FROM utilisateurs WHERE id_utilisateur='$id'";
	return parcoursRs(SQLSelect($SQL));
}

function modifNom($id,$nom)
{
	$id=htmlspecialchars($id);
	$nom=htmlspecialchars($nom);
	$SQL = "UPDATE utilisateurs SET nom='$nom' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}

function modifPrenom($id,$prenom)
{
	$id=htmlspecialchars($id);
	$prenom=htmlspecialchars($prenom);
	$SQL = "UPDATE utilisateurs SET prenom='$prenom' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}

function modifGenre($id,$genre)
{
	$id=htmlspecialchars($id);
	$genre=htmlspecialchars($genre);
	$SQL = "UPDATE utilisateurs SET sexe='$genre' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}

function modifMail($id,$mail)
{
	$id=htmlspecialchars($id);
	$mail=htmlspecialchars($mail);
	$SQL = "UPDATE utilisateurs SET mail='$mail' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}


function getUsers()
{
	$SQL = "SELECT * FROM utilisateurs";
	return parcoursRs(SQLSelect($SQL));
}

function bannir($id)
{
	$id=htmlspecialchars($id);
	$SQL = "UPDATE utilisateurs SET blacklist='1' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}

function debannir($id)
{
	$id=htmlspecialchars($id);
	$SQL = "UPDATE utilisateurs SET blacklist='0' WHERE id_utilisateur='$id'";
	SQLUpdate($SQL);
}

/******************************************Action article********************************************/

function ajoutArticle($titre,$texte,$date,$image){
	$titre = htmlspecialchars($titre);
	$texte = htmlspecialchars($texte);
	$date = htmlspecialchars($date);
	$image = htmlspecialchars($image);
	$SQL = "INSERT INTO blog VALUES ('$titre', '$texte', '$date', '0', NULL, '$image')";
	SQLInsert($SQL);
}

function getActu2($idActu){
	$idActu = htmlspecialchars($idActu);
	$SQL = "SELECT * FROM blog WHERE idActu='$idActu'";
	return parcoursRs(SQLSelect($SQL));
}

function deleteActu($idActu){
	$idActu = htmlspecialchars($idActu);
	$SQL = "DELETE FROM blog WHERE idActu='$idActu'";
	SQLDelete($SQL);
}

function archiveActu($idActu){
	$idActu = htmlspecialchars($idActu);
	$SQL = "UPDATE blog SET archive = '1' WHERE idActu = '$idActu'";
	SQLUpdate($SQL);
}

function mettreenligneActu($idActu){
	$idActu = htmlspecialchars($idActu);
	$SQL = "UPDATE blog SET archive = '0' WHERE idActu = '$idActu'";
	SQLUpdate($SQL);
}

function getActuArchive(){
	$SQL = "SELECT * FROM blog WHERE archive='1' ORDER BY date DESC";
	return parcoursRs(SQLSelect($SQL));
}
function getActuNonArchive(){
	$SQL = "SELECT * FROM blog WHERE archive='0' ORDER BY date DESC";
	return parcoursRs(SQLSelect($SQL));
}

function get5derActuNonArchive(){
	$SQL = "SELECT * FROM blog WHERE archive='0' ORDER BY date DESC LIMIT 5";
	return parcoursRs(SQLSelect($SQL));
}


?>
