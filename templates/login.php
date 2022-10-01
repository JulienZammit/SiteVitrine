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
		  	<h2>Connexion</h2>
		    <label for="exampleInputEmail1" class="form-label">Adresse Email</label>
		    <input type="email" class="form-control" name="login" id="login" placeholder="nom@exemple.com">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
		    <input type="password" class="form-control" name="passe" aria-describedby="passwordHelp" id="passe" placeholder="Mot de passe">
		    <div id="passwordHelp" class="form-text">Le mot de passe doit faire au moins 6 caractères.</div>
		  </div>
		  <div class="mb-3 form-check">
		    <input type="checkbox" class="form-check-input" id="exampleCheck1">
		    <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
		  </div>
		  <button type="submit" class="btn btn-primary">Se connecter</button>


		  <div class="footer">
		  	<a href="index.php?view=oubli"><p>Mot de passe oublié ?</p></a>
		  	<a href="index.php?view=inscription"><p>S'inscrire</p></a>
		  </div>
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
			data: {action: "Connexion",login : val("login"),passe : val("passe")},
			callback:executerep,
			type: "POST"
		});
	}
	var headerform = document.getElementById("headerform");
	var save = headerform.innerHTML;
	function executerep(rep) {
		var traitement = JSON.parse(rep);
		if ("alert" in traitement)
		{
			headerform.innerHTML= "<div class=\"alert alert-"+ traitement['alert'].type + "\" role=\"alert\">" + traitement['alert'].message + "</div>" + save;
		}
		if("redirect" in traitement){
			var delai=traitement['redirect'].in;
			var page="index.php?view="+traitement['redirect'].to;
			redirect(page,delai);
		}
		if("value" in traitement){
			if(traitement['value'].login) document.getElementById("login").value = traitement['value'].login;
			if(traitement['value'].passe) document.getElementById("passe").value = traitement['value'].passe;
		}

	}
</script>