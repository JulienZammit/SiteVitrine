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

<div>
    <div class="col d-flex justify-content-center align-items-center">
            <form action="controleur.php" enctype="multipart/form-data" method="post">
                <div id="headerform" class="mb-3">
                        <h2>Poster Article</h2>
                    <h5>Titre</h5>
                    <input type="texte" class="form-control me-2" name="titre" id="titre" style="width: 1000px">
                </div>
                <div class="mb-3">
                    <h5>Texte</h5>
                    <textarea for="exampleInputPassword1" class="form-control me-2" name="texte" id="texte" style="width: 1000px; height: 300px"></textarea>
                </div>
                <div class="mb-3">
                    <h5>Ajouter un fichier image (type .png, .jpeg, .jpg, .gif) : </h5>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                    <input type="file" id="fichier2" name="fichier2" class="form-control">
                </div>
                <input type="hidden" name="date" id="date" value="<?php echo date("Y/m/d H:i:s") ?>">
                <input type="submit" name="action" value="Poster Article" class="btn btn-primary">
            </form>
    </div>

    <?php
    echo '<div id=nonarchive> <br><br><h1>Gerer les Actualités</h1><br>';
    echo '<table class="table">   
              <h2 id="titre2">Acualité non archivée</h2>
              <thead class="bg-dark text-light">
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Poste</th>
                        <th scope="col">Date Publication</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action</th> 
                    </tr>
              </thead>
              <tbody id="nonarchive">';
                $actu = getActuNonArchive();
                if (!empty($actu)) {
                    foreach ($actu as $i) {
                        echo "<tr><td>" . $i['titre'] . "</td>";
                        echo "<td>" . $i['texte'] . "</td>";
                        echo "<td>" . $i['date'] . "</td>";
                        echo "<td>";
                        echo "<button onclick=\"archiver(".$i['idActu'].");\" type=\"submit\" class=\"btn btn-primary\" name=\"archiver\" id=\"archiver\" style=\"color:white; width:100px\">Archiver</button>";
                        echo "</td>";
                        echo "<td>";
                        echo "<button type=\"submit\" onclick=\"modifier2(". $i['idActu'] .");\" class=\"btn btn-primary\">Modifier</button>";
                        echo "</td></tr>";
                    }
                } else echo 'Aucune actualité';
                          echo '</tbody>';
                echo '</div>';

    echo '<div id=archive>';
    echo '<table class="table">
                <h2 id="titre2">Actualité archivée</h2>
              <thead class="bg-dark text-light">
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Poste</th>
                        <th scope="col">Date Publication</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action</th>
                    </tr>
              </thead>
              <tbody id="archive">';
    $actu = getActuArchive();
    if (!empty($actu)) {
        foreach ($actu as $i) {
            echo "<tr><td>" . $i['titre'] . "</td>";
            echo "<td>" . $i['texte'] . "</td>";
            echo "<td>" . $i['date'] . "</td>";
            echo "<td>";
            echo "<button onclick=\"mettreenligne(". $i['idActu'] .");\" type=\"submit\" class=\"btn btn-primary\" name=\"archiver\" id=\"archiver\" style=\"color:white; width:250px\">Mettre en ligne</button>";
            echo "</td>";
            echo "<td>";
            echo "<button type=\"submit\" onclick=\"modifier2(". $i['idActu'] .");\" class=\"btn btn-primary\">Modifier</button>";
            echo "</td>";
            echo "<td>";
            echo "<button onclick=\"supprimer(". $i['idActu'] .");\" type=\"submit\" class=\"btn btn-primary\" name=\"supprimer\" id=\"supprimer\" style=\"color:white; width:100px\">Supprimer</button>";
            echo "</td></tr>";
        }
    }else echo'Aucune actualité archivée';
    echo '</tbody>';
    echo '</div></table>';
    ?>

</div>

</main>

<script>
    function disconnect() {
        ajax("api/clients.php",{
            data: {action: "Logout"},
            callback:executerep2,
            type: "POST"
        });
    }
    function executerep2(rep) {
        var traitement = JSON.parse(rep);
        if(("redirect" in traitement)){
            var delai=traitement['redirect'].in;
            var page="index.php?view="+traitement['redirect'].to;
            redirect(page,delai);
        }

    }

            function poster() {
                /*var my_files = $("#FileToUpload").val();
                var current_path = my_files.split("\\").pop();
                console.log("chemin : " + my_files); console.log("nom : " + current_path);*/

                ajax("api/admin.php",{
                    data: {action: "Poster",idActu : idActu},
                    callback:executerep,
                    type: "POST"
                });
            }

            function archiver(idActu) {
                ajax("api/admin.php",{
                    data: {action: "Archiver",idActu : idActu},
                    callback:executerep,
                    type: "POST"
                });
            }

            function modifier2(idActu) {
                ajax("api/admin.php",{
                    data: {action: "Modifier2",idActu : idActu},
                    callback:executerep,
                    type: "POST"
                });
            }

            function mettreenligne(idActu) {
                ajax("api/admin.php",{
                    data: {action: "Mettreenligne",idActu : idActu},
                    callback:executerep,
                    type: "POST"
                });
            }
            function supprimer(idActu) {
                ajax("api/admin.php",{
                    data: {action: "Supprimer",idActu : idActu},
                    callback:executerep,
                    type: "POST"
                });
            }
            function modifier(idActu) {
                ajax("api/admin.php",{
                    data: {action: "Modifier",idActu : idActu},
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
            }
</script>