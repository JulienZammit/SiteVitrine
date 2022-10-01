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
define('MAX_SIZE', 100000);
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 slide-in-right">
        <?php
        $idActu = valider("idActu");
        $actu = getActu2($idActu);
        echo '<h1>Modifier une Actualité</h1></br>';
        ?>

        <div class="col d-flex justify-content-center align-items-center">
            <form action="controleur.php" enctype="multipart/form-data" method="post">
            <div id="headerform" class="mb-3">
                <h2>Poster Article</h2>
                <h5>Titre</h5>
                <?php
                echo "<input type=\"texte\" class=\"form-control me-2\" name=\"titre\" id=\"titre\" style=\"width: 1000px\" value=" . $actu[0]['titre'] . ">";
                ?>
            </div>
            <div class="mb-3">
                <h5>Texte</h5>
                <?php
                echo "<textarea for=\"exampleInputPassword1\" class=\"form-control me-2\" name=\"texte\" id=\"texte\" style=\"width: 1000px; height: 300px\">" . $actu[0]['texte'] . "</textarea>";
                ?>
            </div>
                <div class="mb-3">
                    <h5>Ajouter un fichier image (type .png, .jpeg, .jpg, .gif) : </h5>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                    <input type="hidden" name="idActu" value="<?php echo $actu[0]['idActu']; ?>" />
                    <?php
                    echo "<input type=\"file\" id=\"fichier2\" name=\"fichier2\" class=\"form-control\">";
                    ?>
                </div>
            <?php
            echo "<input type=\"date\" name=\"date\" id=\"date\" value=". $actu[0]['date']. ">";
            echo "<br><br><input type=\"submit\" type=\"submit\" name=\"action\" value=\"Modifier Article\" class=\"btn btn-primary\">";
            ?>
        </form>
    </div>
</main>
        