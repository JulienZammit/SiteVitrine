<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

	if(!valider('idUser','SESSION')){
		rediriger('index.php');
	}

	$id=valider('idUser','SESSION');
	$user=getUserByID($id);

	if($user[0]['sexe']==0){
		$sexe='Homme';
	}
	if($user[0]['sexe']==1){
		$sexe='Femme';
	}
	if($user[0]['sexe']==2){
		$sexe='Autre';
	}
?>
<style>
	.alert{
		max-width: fit-content;
	}
</style>

<script src="assets/js/ajax.js"></script>
<script src="assets/js/utils.js"></script>

<script>
	$(document).ready(function(){



		$("#modifnom").click(function(){
			Nom();
		});

		$("#modifprenom").click(function(){
			Prenom();
		});

		$("#modifsexe").click(function(){
			Genre();
		});

		$("#modifemail").click(function(){
			Mail();
		});

	}); //fin du ready

	function Nom() {
		ajax("api/clients.php",{
			data: {action: "Modifier Nom", donnee : $("#nom").val(), id : <?php echo json_encode($id); ?>},
			callback:executerepNom,
			type: "POST"
		});
	}
	function Prenom() {
		ajax("api/clients.php",{
			data: {action: "Modifier Prenom", donnee : $("#prenom").val(), id : <?php echo json_encode($id); ?>},
			callback:executerepPrenom,
			type: "POST"
		});
	}
	function Genre() {
		ajax("api/clients.php",{
			data: {action: "Modifier Genre", donnee : $("#sexe").val(), id : <?php echo json_encode($id); ?>},
			callback:executerepSexe,
			type: "POST"
		});
	}
	function Mail() {
		ajax("api/clients.php",{
			data: {action: "Modifier Mail", donnee : $("#email").val(), id : <?php echo json_encode($id); ?>},
			callback:executerepMail,
			type: "POST"
		});
	}

	function executerepNom(rep) {
		var traitement = JSON.parse(rep);
		if (("alert" in traitement))
		{
			$(".headerForm").html("<div class=\"alert alert-"+ traitement['alert'].type + "\" role=\"alert\">" + traitement['alert'].message + "</div>")
			if(traitement['alert'].type=="success"){
				$("#entetenom").html("Nom : " + $("#nom").val());
			}
		}
	}

	function executerepPrenom(rep) {
		var traitement = JSON.parse(rep);
		if (("alert" in traitement))
		{
			$(".headerForm").html("<div class=\"alert alert-"+ traitement['alert'].type + "\" role=\"alert\">" + traitement['alert'].message + "</div>")
			if(traitement['alert'].type=="success"){
				$("#enteteprenom").html("Prénom : " + $("#prenom").val());
			}
		}
	}

	function executerepSexe(rep) {
		var traitement = JSON.parse(rep);
		if (("alert" in traitement))
		{
			$(".headerForm").html("<div class=\"alert alert-"+ traitement['alert'].type + "\" role=\"alert\">" + traitement['alert'].message + "</div>")
			if(traitement['alert'].type=="success"){
				$("#entetesexe").html("Genre : " + $("#sexe").val());
			}
		}
	}

	function executerepMail(rep) {
		var traitement = JSON.parse(rep);
		if (("alert" in traitement))
		{
			$(".headerForm").html("<div class=\"alert alert-"+ traitement['alert'].type + "\" role=\"alert\">" + traitement['alert'].message + "</div>")
			if(traitement['alert'].type=="success"){
				$("#entetemail").html("Adresse Email : " + $("#email").val());
			}
		}
	}
</script>

<div class="container-sm">
	<br><h1>Mon Compte</h1><br>
	<div class="headerForm"></div>
	<div class="mb-3">
		<div id="entetenom">Nom : <?php echo $user[0]['nom']; ?> </div>
		<input type="text" class="form-control" name="login" id="nom" placeholder="Nom">
		<input type="submit" class="form-control" value="Modifier" name="action" id="modifnom">
	</div>
	<div class="mb-3">
		<div id="enteteprenom">Prénom : <?php echo $user[0]['prenom']; ?> </div>
		<input type="text" class="form-control" name="login" id="prenom" placeholder="Prénom">
		<input type="submit" class="form-control" value="Modifier" id="modifprenom">
	</div>
	<div class="mb-3">
		<div id="entetesexe">Genre : <?php echo $sexe; ?></div>
		<select class="form-control" id="sexe" name="sexe">
		<option>Homme</option>
		<option>Femme</option>
		<option>Autre</option>
		</select>
		<input type="submit" class="form-control" value="Modifier" id="modifsexe">
	</div>
	<div class="mb-3">
		<div id="entetemail">Adresse Email : <?php echo $user[0]['mail']; ?> </div>
		<input type="email" class="form-control" name="login" id="email" placeholder="nom@exemple.com">
		<input type="submit" class="form-control" value="Modifier" id="modifemail">
	</div><br><br>
</div>

