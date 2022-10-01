<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

	if(valider('idUser','SESSION')){
		if(isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
			rediriger('index.php?view=admin');
		}else{
			rediriger('index.php');
		}
	}
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
		  	<h2 class="text-center">Mot de Passe Oublié</h2><br>
		    <div>Si tu as oublié ton mot de passe, tu peux entrer ton <br>adresse e-mail et nous t'enverrons des instructions <br>sur la manière de le réinitialiser.</div>
		  </div>
		  <div id="headerform" class="mb-3">
		    <label for="login" class="form-label">Courriel</label>
		    <input type="email" class="form-control" name="login" id="login" placeholder="nom@exemple.com">
		  </div>
		  <button type="submit" class="btn btn-primary">Demander une réinitialisation du mot de passe</button>
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
			data: {action: "Oubli",login : val("login")},
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
			if(traitement['value'].login) document.getElementById("login").value = traitement['value'].login;
		}

	}
</script>