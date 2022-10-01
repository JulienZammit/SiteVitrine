<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

$uid=valider("id");

if(!$id=getIDbyUID($uid) ) rediriger('index.php');

?>

<style>
	.alert{
		max-width: fit-content;
	}
</style>

<script src="assets/js/ajax.js"></script>
<script src="assets/js/utils.js"></script>

<div class="login-page">
	<div class="col d-flex justify-content-center align-items-center">
		<form id="formlogin">
		  <div id="headerform" class="mb-3">
		  	<h2 class="text-center">Réinitialisation du mot de passe</h2><br>
		    <div>Veuillez entrer votre nouveau mot de passe pour votre compte.</div>
		  </div>
		  <div id="headerform" class="mb-3">
		    <label for="passe" class="form-label">Mot de passe</label>
		    <input type="password" class="form-control" name="passe" id="passe" placeholder="Mot de passe">
		  </div>
          <div id="headerform" class="mb-3">
		    <label for="passe2" class="form-label">Confirmer le mot de passe</label>
		    <input type="password" class="form-control" name="passe2" id="passe2" placeholder="Mot de passe">
		  </div>
		  <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
		</form>

	</div>
</div>
<script>
var form = document.getElementById("formlogin");
function handleForm(event) { event.preventDefault(); login(); } 
form.addEventListener('submit', handleForm);
</script>
<script>
	function login() {
		ajax("api/clients.php",{
			data: {action: "Reinitialiser",passe : val("passe"),passe2 :  val("passe2"), id : <?php echo json_encode($id); ?>},
			callback:executerep,
			type: "POST"
		});
	}
	var headerform = document.getElementById("headerform");
	var save = headerform.innerHTML;
	function executerep(rep) {
		var traitement = JSON.parse(rep);
		if (("alert" in traitement))
		{
			headerform.innerHTML= "<div class=\"alert alert-"+ traitement['alert'].type + "\" role=\"alert\">" + traitement['alert'].message + "</div>" + save;
		}
		if(("redirect" in traitement)){
			var delai=traitement['redirect'].in;
			var page="index.php?view="+traitement['redirect'].to;
			redirect(page,delai);
		}
		if("value" in traitement){
			if(traitement['value'].passe) document.getElementById("passe").value = traitement['value'].passe;
			if(traitement['value'].passe2) document.getElementById("passe2").value = traitement['value'].passe2;
		}

	}
</script>