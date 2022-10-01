<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
?>
<style>
    .blogClassDroite{
        float: right;
        width: 900px;
    }
    .blogClassGauche{
        float: left;
        width: 400px;
    }
</style>
<div class="main-content img-main">
    <div class="black-filter position-relative">
        <div class="row position-absolute bottom-0 end-25">
            <div class="col-9">
                <h1>Nicolas Barthes</h1>
                <p>Bienvenue sur mon blog !</p>
            </div>
        </div>
    </div>
</div>
<div class="blogcontent container slide-left">
    <div class="row">
    <?php
        $tableauArticle = getActuNonArchive();
        if(!empty($tableauArticle)) {
            foreach ($tableauArticle as $i) {
                $date = strtotime($i["date"]);
                echo '<div class="blogClassDroite" id="'.$i['idActu'].'">
					<div class="row">
                        <div class="col-10">
                        <h1>' . $i["titre"] . '</h1></a>
                        </div>
                        <div class="col-10">
                            <p>' . nl2br($i["texte"]) . '</p>
                            <p>Posté le <span>' . date("d/m/Y", $date) . '</span></p>
                        </div>';
                echo '</div></div>';
                if ($i["image"] !== null) {
                    echo '<div class="blogClassGauche">
                        <img class="fit-picture img-fluid img-thumbnail rounded float-right" src="' . $i["image"] . '">
                        </div>';
                }
            }
        }else{
            echo "<br><br><br><h1>Pas d'article pour le moment ! </h1><br><br><br><br><br><br><br><br><br><br><br>";
        }
    ?>
    </div>
</div>
</div>
</div>