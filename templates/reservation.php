
<script src="assets/js/ajax.js"></script>
<script src="assets/js/utils.js"></script>
<script src="assets/js/jquerry.js"></script>

<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

$idCours="";



if ($resa = valider("resa")) 
{
    echo '<center><div style="background-color : LimeGreen; color : white; padding : 10px 0 1px 15px; margin : 10px 30% 0px 30%; border-radius: 10px; ">';
    echo '<p>';
     echo '<strong>Votre réservation à bien été prise en compte !</strong>';
     echo "</p>";
     echo "</div></center>";
}

if ($supprime = valider("supprime")) 
{
    echo '<center><div style="background-color : LimeGreen; color : white; padding : 10px 0 1px 15px; margin : 10px 30% 0px 30%; border-radius: 10px; ">';
    echo '<p>';
     echo '<strong>Votre réservation à bien été supprimé !</strong>';
     echo "</p>";
     echo "</div></center>";
}



if ($cours = valider("cours")) 
{
    switch($cours)
                        {
                            case 'apprentissageNatation':
                                $activiteModifiee = "l'apprentissage de la natation";
                            break;

                            case 'aquabike':
                                $activiteModifiee = "l'aquabike";
                            break;

                            case 'aquagym':
                                $activiteModifiee = "l'aquagym";
                            break;

                            case 'sprint':
                                $activiteModifiee = 'le sprint';
                            break;

                            case 'half':
                                $activiteModifiee = 'le half';
                            break;

                            case 'ironman':
                                $activiteModifiee = "l'ironman";
                            break;

                            case 'olympique':
                                $activiteModifiee = "l'olympique";
                            break;

                            case 'perfectionnementNatation':
                                $activiteModifiee = 'le perfectionnement à la natation';
                            break;

                            case 'perfectionnementNatationEauLibre':
                                $activiteModifiee = 'le perfectionnement à la natation en eau libre';
                            break;

                            case 'entrainementNatation':
                                $activiteModifiee = "l'entrainement à la natation";
                            break;
                        }



                        

?>

<!-- /////////////////CAS OU LE COURS EST DEJA CHOISI//////////////// -->

<div class='corps'>
<h2>
<h2 class='texte'><?php
echo 'Les prochains créneaux disponible pour ' . $activiteModifiee .' :';
?></h2>
<h2 class='messDejaReservé'><?php
echo 'Vous avez déjà réservé un créneau pour ' . $activiteModifiee . ', annulez votre réservation pour pouvoir en effectuer une nouvelle.';
?></h2>
<br/>
      <div class="table-responsive firstTab" style="margin-bottom:50px;">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Date</th>
              <th scope="col">Horaires</th>
              <th scope="col">Réserver</th>
            </tr>
          </thead>
          <tbody id="10lastcours">
            
          </tbody>
        </table>
      </div>
</div>
<?php

}else{
?>

<!-- /////////////////CAS OU LE COURS N'EST PAS DEFINI//////////////// -->
<div class='corps'>
<h3>Bienvenue sur la page de réservation de cours, <b>sélectionnez une catégorie dans le menu déroulant</b> et les activités correspondantes s'afficheront !</h3>

<br/>

<div id="listeCatégories">
		<select id="selListeCatégories" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
			<option disabled selected>Choisir la Catégorie</option>
            <option>Triathlon</option>
            <option>Natation</option>
            <option>Piscine</option>
		</select>
</div>

<br/>

<div id="message">
    <h3>Mes activités proposées dans cette catégorie :</h3>
</div>

<br/>

<div id="listeTriathlon">
    <div id="carteSprint" class="carte">
        <center><h2>Sprint</h2></center>
        <form action="controleur.php">
            <div class="boutonsAlign">
                <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
                <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
                <input type="hidden" name="cours" value="sprint"/>  
            </div>
        </form>
    </div>
    <div id="carteOlympique" class="carte">
        <center><h2>Olympique</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="olympique"/>
            </div>  
        </form>
    </div>
    <div id="carteHalf" class="carte">
        <center><h2>Half</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="half"/>  
            </div>
        </form>
    </div>
    <div id="carteIronMan" class="carte">
        <center><h2>IronMan</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="ironman"/>
            </div>  
        </form>
    </div>
</div>  






<div id="listeNatation">
    <div id="carteSprint" class="carte">
        <center><h2>Apprentissage Natation</h2></center>
        <form action="controleur.php">
            <div class="boutonsAlign">
                <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
                <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
                <input type="hidden" name="cours" value="apprentissageNatation"/>  
            </div>
        </form>
    </div>
    <div id="carteOlympique" class="carte">
        <center><h2>Perfectionnement Natation</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="perfectionnementNatation"/>
            </div>  
        </form>
    </div>
    <div id="carteHalf" class="carte">
        <center><h2>Perfectionnement Natation en Eau Libre</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="perfectionnementNatationEauLibre"/>  
            </div>
        </form>
    </div>
    <div id="carteIronMan" class="carte">
        <center><h2>Entrainement Natation</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="entrainementNatation"/>
            </div>  
        </form>
    </div>
</div>  




<div id="listePiscine">
    <div id="carteAquabike" class="carte">
        <center><h2>Aquabike</h2></center>
        <form action="controleur.php">
            <div class="boutonsAlign">
                <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
                <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
                <input type="hidden" name="cours" value="aquabike"/>  
            </div>
        </form>
    </div>
    <div id="carteAquagym" class="carte">
        <center><h2>Aquagym</h2></center>
        <form action="controleur.php">
        <div class="boutonsAlign">
            <input class='btn btn-primary testBtn' type="submit" name="action" value="A propos"/>  
            <input class='btn btn-primary testBtn' type="submit" name="action" value="Crénaux disponibles"/>
            <input type="hidden" name="cours" value="aquagym"/>
            </div>  
        </form>
    </div>
</div>  


<br/>
<br/>


<?php
}


        if ($cours = valider("cours"))
        {
            switch ($cours)
            {
                case 'aquabike' :
                    $idCours=2;
                break;

                case 'aquagym' :
                    $idCours=3;
                    break;

                case 'ironman' :
                    $idCours=6;
                    break;

                case 'apprentissageNatation' :
                    $idCours=1;
                    break;

                case 'entrainementNatation' :
                    $idCours=4;
                    break;

                case 'half' :
                    $idCours=5;
                    break;

                case 'olympique' :
                    $idCours=7;
                break;
                
                case 'perfectionnementNatation' :
                    $idCours=8;
                break;
            
                case 'perfectionnementNatationEauLibre' :
                    $idCours=9;
                break;

                case 'sprint' :
                    $idCours=10;
                break;

            }

        }
        


        if ($idUser = valider("idUser",'SESSION'))
        {
            $test = dejaReserve($idUser,$idCours);
            if(empty($test))
            {
                $dejaBooke=0;
            }
            else{
                $dejaBooke=1;
            }
            
        
        }
?>


<hr>


<div class="table-responsive secondTab" style="margin-bottom:50px;">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
            <th scope="col">Activité</th>
              <th scope="col">Date</th>
              <th scope="col">Horaires</th>
              <th scope="col">Annulation</th>
            </tr>
          </thead>
          <tbody id="mesResa">
            
          </tbody>
        </table>
      </div>
</div>
<style>

    #listeSports{
        display:none;
    }


    .corps{
        margin : 5%;
    }

   

    .carte
    {
        padding : 10px;
        background-color:#C2E6FD;
        border-radius:10px;
        margin : 10px;
    }


    #listeTriathlon {
        
        display: flex;
        flex-direction: row;
        justify-content:space-around;
    }

    #listePiscine {
        
        display: flex;
        flex-direction: row;
        justify-content:space-around;
        
    }

    #listeNatation {
        
        display: flex;
        flex-direction: row;
        justify-content:space-around;
        
    }

    .boutonsAlign {
        display: flex; 
        flex-direction: row;
        justify-content:space-around;
    }

    .testBtn{
        margin:3px;
    }

    #message{
        display:none;
    }

    .messDejaReservé
    {
        display:none;
    }

</style>

<script>
    var idCours = <?php echo json_encode($idCours); ?>;
    var idUser = <?php echo json_encode($idUser); ?>;
  function getActiviteDispo() {
		ajax("api/reservation.php",{
			data: {action: "getActiviteDispo", idActivite:idCours},
			callback:executerep2,
			type: "POST"
		});
	}

function mesResaaa() {
    ajax("api/reservation.php",{
			data: {action: "getMesResa", idUser:idUser},
			callback:executerep3,
			type: "POST"
		});
    }

	window.addEventListener("load",getActiviteDispo());  //lorsque la page est chargée
    window.addEventListener("load",mesResaaa());


    function executerep2(rep) {
    var lastcours = document.getElementById("10lastcours");
    lastcours.innerHTML+=rep;
  }

  

  function executerep3(rep) {
    var lastcours = document.getElementById("mesResa");
    lastcours.innerHTML+=rep;
  }


  $(document).ready(function(){

    $("#listeTriathlon").hide();
    $("#listeNatation").hide();
    $("#listePiscine").hide();

    $("#selListeCatégories").change(function(){
                
                console.log($("#selListeCatégories option:selected").val());
                $("#listeSports").show("fast");  

                $("#message").show("fast");

                $("#selListeSports").empty();

                

                    if($("#selListeCatégories option:selected").val() == 'Natation')
                    {
                        $("#listeTriathlon").hide();
                        $("#listePiscine").hide();
                        $('#listeNatation').show("slow");
                    }

                    if($("#selListeCatégories option:selected").val() == 'Triathlon')
                    {
                       $('#listeTriathlon').show("slow"); 
                       $("#listePiscine").hide();
                       $("#listeNatation").hide(); 
                    }

                    if($("#selListeCatégories option:selected").val() == 'Piscine')
                    {
                        $("#listeTriathlon").hide();
                        $("#listeNatation").hide();
                        $('#listePiscine').show("slow");
                    }




					
            });
});

var dejaBooke = <?php echo json_encode($dejaBooke); ?>;
if(dejaBooke==1)
{
$('.firstTab').hide();
$('.texte').hide();
$('.messDejaReservé').show();
}

</script>

