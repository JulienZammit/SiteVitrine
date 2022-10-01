<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
    header("Location:../index.php");
    die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
define('MAX_SIZE', 100000);    // Taille max en octets du fichier
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
    <?php
    if( $couleur= valider("couleur") ) 
    {
        if($message=valider("message"))
        {
            echo '<div style="background-color :' . $couleur . '; color : white; padding : 10px 0 1px 15px; margin : 5px 50% 5px 0px; border-radius: 10px; ">';
            echo '<p>';
            echo "<strong>" . $message ."</strong>";
            echo "</p>";
            echo "</div>";
        } 
    }
    ?>
  
    <h2>Gestions Réservations Cours</h2>
    <div class="scroller">
    <div class="table-responsive" style="margin-bottom:50px;">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">Numéro</th>
                <th scope="col">Utilisateur</th>
                <th scope="col">Cours</th>
                <th scope="col">Date du cours</th>
                <th scope="col">Choix</th>
            </tr>
            </thead>
            <tbody id="lastcours">

            </tbody>
        </table>
    </div>
    </div>

</main>

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
            function Reservation(idRequest) {
                ajax("api/admin.php",{
                    data: {action: "Reservation", idRequest : idRequest},
                    callback:executerep2,
                    type: "POST"
                });
            }

            function acceptRequest(idRequest) {
                ajax("api/admin.php",{
                    data: {action: "AcepterRequest", idRequest : idRequest},
                    callback:executerep3,
                    type: "POST"
                });
            }

            function refuseRequest(idRequest) {
                ajax("api/admin.php",{
                    data: {action: "RefuserRequest", idRequest : idRequest},
                    callback:executerep3,
                    type: "POST"
                });
            }
            window.addEventListener("load",Reservation());
            function executerep2(rep) {
                var lastcours = document.getElementById("lastcours");
                lastcours.innerHTML+=rep;
            }

            function executerep3(rep) {
                location.reload();
            }
        </script>