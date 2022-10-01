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
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 slide-in-right">

    	<div class="sumerhead row">
    		<h2>Dashboard</h2>
        <p>Bonjour <?php echo getFirstName(valider('idUser','SESSION')); ?> !</p>
	    	<div class="col-3">
	    		<div class="magnet">
	    			<h1><i class="fas fa-user"></i> Utilisateurs</h1>
	    			<p><b><?php echo getNbUsers(); ?></b></p>
	    		</div>
	    	</div>
	    	<div class="col-3">
	    		<div class="magnet">
	    			<h1><i class="fas fa-address-book"></i> Réservation (cette semaine)</h1>
	    			<p><b><?php echo getNbReservationThisWeek();  ?></b> restantes</p>
	    		</div>
	    	</div>
	    	<div class="col-3">
	    		<div class="magnet">
	    			<h1><i class="fas fa-school"></i> Cours (cette semaine)</h1>
	    			<p><b><?php echo getNbCoursThisWeek(); ?></b></p>
	    		</div>
	    	</div>
	    	<div class="col-3">
	    		<div class="magnet">
	    			<h1><i class="fas fa-arrow-circle-right"></i> Prochain Cours</h1>
					<?php
          $nextcours=nextCours();
            
					if($nextcours==NULL){
						echo "<p>Aucun</p>";
					}else{
						$date=strtotime($nextcours['debut']); 
						if( (date("d/m/Y",$date)) == '01/01/1970'){
							echo "<p>Aucun</p>";
						}
						else{
							$nomsport=$nextcours['nomsport'];
							$day=date("d/m/Y",$date);
							$hour=date("H:i",$date);
              echo "<p>Cours de $nomsport <span><br><b> $day </b> à <b> $hour </b></span></p>";
						}
					}
				?>
				</div>
	    	</div>
    	</div>


      <h2>10 dernières réservations</h2>
      <div class="table-responsive" style="margin-bottom:50px;">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Numéro</th>
              <th scope="col">Utilisateur</th>
              <th scope="col">Cours</th>
              <th scope="col">Date du cours</th>
            </tr>
          </thead>
          <tbody id="10lastcours">
            
          </tbody>
        </table>
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
  function GetLast10books() {
		ajax("api/admin.php",{
			data: {action: "GetLast10books"},
			callback:executerep2,
			type: "POST"
		});
	}
	window.addEventListener("load",GetLast10books());
	function executerep2(rep) {
    var lastcours = document.getElementById("10lastcours");
    lastcours.innerHTML+=rep;
  }
</script>