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
          <h2>Inscription</h2>
          <div id="headerform" class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Prénom</label>
		    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom">
		  </div>
          <div id="headerform" class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Nom</label>
		    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
		  </div>
          <div id="headerform" class="mb-3">
            <label for="sexe" class="form-label">Genre</label>
            <select class="form-control" id="sexe" name="sexe">
			<option>Homme</option>
            <option>Femme</option>
            <option>Autre</option>
            </select>
          </div>
          <div id="headerform" class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Adresse Email</label>
		    <input type="email" class="form-control" name="mail" id="mail" placeholder="nom@exemple.com">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
		    <input type="password" class="form-control" name="passe" aria-describedby="passwordHelp" id="passe" placeholder="Mot de passe">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" class="form-label">Confirmer le mot de passe</label>
		    <input type="password" class="form-control" name="passe2" aria-describedby="passwordHelp" id="passe2" placeholder="Mot de passe">
		    <div id="passwordHelp" class="form-text">Le mot de passe doit faire au moins 6 caractères.</div>
		  </div>
		  <button type="submit" class="btn btn-primary">S'inscrire</button>
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
			data: {action: "Inscription",mail : val("mail"),passe : val("passe"), passe2 : val("passe2"), prenom : val("prenom"), nom : val("nom"), sexe : val("sexe")},
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
			if(traitement['value'].prenom) document.getElementById("prenom").value = traitement['value'].prenom;
			if(traitement['value'].nom) document.getElementById("nom").value = traitement['value'].nom;
			if(traitement['value'].sexe) document.getElementById("sexe").value = traitement['value'].sexe;
			if(traitement['value'].mail) document.getElementById("mail").value = traitement['value'].mail;
			if(traitement['value'].passe) document.getElementById("passe").value = traitement['value'].passe;
			if(traitement['value'].passe2) document.getElementById("passe2").value = traitement['value'].passe2;
		}

	}
</script>

