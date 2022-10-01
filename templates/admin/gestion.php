<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
include_once("libs/maLibSecurisation.php");
securiser('index.php?view=login');
if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
  rediriger('index.php');
}
?>
<style>
.scroller {
    max-width: 1600px;
    height: 800px;
    overflow-y: scroll;
    scrollbar-color: rebeccapurple green;
    scrollbar-width: thin;
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 slide-in-right">

	<div class="sumerhead row">
		<h2>Gestion d'utilisateurs</h2>
	</div>

	<div class="scroller">
	  <div class="table-responsive" style="margin-bottom:50px;">
	    <table class="table table-striped table-sm">
	      <thead>
	        <tr>
	          <th scope="col">Nom</th>
	          <th scope="col">Prénom</th>
	          <th scope="col">Email</th>
	          <th scope="col">Blacklisté</th>
	          <th scope="col">Gérer</th>
	        </tr>
	      </thead>
	      <tbody id="tableau">
	        
	      </tbody>
	    </table>
	  </div>
	</div>

</main>
</div>
</div>

<script>
var form = document.getElementById("formdisconnect");
function handleForm(event) { event.preventDefault(); disconnect(); } 
form.addEventListener('submit', handleForm);
</script>
<script>
	function disconnect() {
		ajax("api/clients.php",{
			data: {action: "Logout"},
			callback:executerep,
			type: "POST"
		});
	}
  function executerep(rep) {
		var traitement = JSON.parse(rep);
		if(("redirect" in traitement)){
			var delai=traitement['redirect'].in;
			var page="index.php?view="+traitement['redirect'].to;
			redirect(page,delai);
		}

	}
  function GetUtilisateurs() {
		ajax("api/admin.php",{
			data: {action: "GetUtilisateurs"},
			callback:executerep2,
			type: "POST"
		});
	}

  function blacklist(iduser) {
  	console.log("blacklist :"+iduser);
		ajax("api/admin.php",{
			data: {action: "Bannir", id: iduser},
			callback:GetUtilisateurs,
			type: "POST"
		});
	}

	function deblacklist(iduser) {
		console.log("yeah");
		ajax("api/admin.php",{
			data: {action: "deBannir", id: iduser},
			callback:GetUtilisateurs,
			type: "POST"
		});
	}

	window.addEventListener("load",GetUtilisateurs());
	function executerep2(rep) {
    var lastcours = document.getElementById("tableau");
    lastcours.innerHTML=rep;
  }
</script>