<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
include_once("libs/maLibSecurisation.php");
securiser('index.php?view=login');
if(!isAdmin(valider('idUser','SESSION'),valider('pseudo','SESSION'))){
  rediriger('index.php');
}


define('TARGET', '/assets/img');    // Repertoire cible
	define('MAX_SIZE', 100000);    // Taille max en octets du fichier
	define('WIDTH_MAX', 800);    // Largeur max de l'image en pixels
	define('HEIGHT_MAX', 800);    // Hauteur max de l'image en pixels
?>

<style>
        .contenant69
        {
            display:flex;
            justify-content:space-around;
        }
</style>
    
<script type="text/javascript">

    
function afficheDiv(idDiv)
{
    HideByClassName('mesActivites');
    if(idDiv!=0)
    {
        var elm = document.getElementById(idDiv);
        elm.style.display='block';
    }
}

function HideByClassName(className)
{
    var elementList = document.getElementsByClassName(className);

    for (i = 0; i< elementList.length; i++) 
    {
        var ele = elementList[i];
          console.log(ele.id);
        ele.style.display='none';
    }





}
</script>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 slide-in-right">
<div class="scroller">
</br>
    
    
    <?php
        $idActivite = valider("activite");  //permet de revenir sur l'activite modifiée
        $activiteModifiee ='';
        $activite='';
    
        if( $activite= valider("activite") ) 
        {
                    switch($activite)
                    {
                        case '1':
                            $activiteModifiee = 'Apprentissage Natation';
                        break;

                        case '2':
                            $activiteModifiee = 'Aquabike';
                        break;

                        case '3':
                            $activiteModifiee = 'Aquagym';
                        break;

                        case '4':
                            $activiteModifiee = 'Entrainement Natation';
                        break;

                        case '5':
                            $activiteModifiee = 'Half';
                        break;

                        case '6':
                            $activiteModifiee = 'IronMan';
                        break;

                        case '7':
                            $activiteModifiee = 'Olympique';
                        break;

                        case '8':
                            $activiteModifiee = 'Perfectionnement Natation';
                        break;

                        case '9':
                            $activiteModifiee = 'Perfectionnement Natation en Eau Libre';
                        break;

                        case '10':
                            $activiteModifiee = 'Entrainement Natation';
                        break;
                    }
                
                
            if( $couleur= valider("couleur") ) 
            {
                if($message=valider("message"))
                {
                    echo '<div style="background-color :' . $couleur . '; color : white; padding : 10px 0 1px 15px; margin : 5px 50% 5px 0px; border-radius: 10px; ">';
                    echo '<p>';
                    echo '<strong> <a style="text-decoration: underline;">' . $activiteModifiee . ' :</a> ' . $message ."</strong>";
                    echo "</p>";
                    echo "</div>";
                } 
            }

            if( $changementMiniDesc=valider("changementMiniDesc") ) 
            {
                echo '<div style="background-color : LimeGreen; color : white; padding : 10px 0 1px 15px; margin : 5px 50% 5px 0px; border-radius: 10px; ">';
                echo '<p>';
                echo '<strong> <a style="text-decoration: underline;">' . $activiteModifiee . " :</a> Phrase d'accroche mise à jour !</strong>";
                echo "</p>";
                echo "</div>";
            }

            if( $changementDescription=valider("changementDescription") ) 
            {
                echo '<div style="background-color : LimeGreen; color : white; padding : 10px 0 1px 15px; margin : 5px 50% 5px 0px; border-radius: 10px; ">';
                echo '<p>';
                echo '<strong> <a style="text-decoration: underline;">' . $activiteModifiee . " :</a> Description mise à jour !</strong>";
                echo "</p>";
                echo "</div>";
            }

            if( $changementPrix=valider("changementPrix") ) 
            {
                echo '<div style="background-color : LimeGreen; color : white; padding : 10px 0 1px 15px; margin : 5px 50% 5px 0px; border-radius: 10px; ">';
                echo '<p>';
                echo '<strong> <a style="text-decoration: underline;">' . $activiteModifiee . " :</a> Prix mis à jour !</strong>";
                echo "</p>";
                echo "</div>";
            }





        }

     

               
    ?>

    </br>

    <div class="encadreMenu">
        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="maliste" onclick="afficheDiv(this.value);">
        <option >Choisissez le cours à modifier</option>
        <option value="1" <?php if($idActivite == 1) echo 'selected';?>>🏊‍♂️ Apprentissage Natation</option>
        <option value="8" <?php if($idActivite == 8) echo 'selected';?>>🏊‍♂️ Perfectionnement Natation</option>
        <option value="9" <?php if($idActivite == 9) echo 'selected';?>>🏊‍♂️ Perfectionnement Natation en Eau Libre</option>
        <option value="4" <?php if($idActivite == 4) echo 'selected';?>>🏊‍♂️ Entrainement Natation</option>
        <option value="10" <?php if($idActivite == 10) echo 'selected';?>>🏃 Sprint</option>
        <option value="7" <?php if($idActivite == 7) echo 'selected';?>>🏃 Olympique</option>
        <option value="5" <?php if($idActivite == 5) echo 'selected';?>>🏃 Half</option>
        <option value="6" <?php if($idActivite == 6) echo 'selected';?>>🏃 IronMan</option>
        <option value="2" <?php if($idActivite == 2) echo 'selected';?>>🌊 Aquabike</option>
        <option value="3" <?php if($idActivite == 3) echo 'selected';?>>🌊 Aquagym</option>
        </select>
    </div>


    <div id="1" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Apprentissage Natation</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(1); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(1); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(1); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="1" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>

        </form>
    </div>

    <div id="2" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Aquabike</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(2); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(2); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(2); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="2" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="3" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Aquagym</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(3); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(3); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(3); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="3" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="4" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Entrainement Natation</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(4); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(4); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(4); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="4" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="5" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Half</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(5); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(5); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(5); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="5" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="6" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : IronMan</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(6); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(6); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(6); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="6" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="7" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Olympique</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(7); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(7); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(7); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="7" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="8" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Perfectionnement Natation</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(8); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(8); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(8); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="8" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="9" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Perfectionnement Natation en Eau Libre</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(9); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(9); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(9); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="9" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>

    <div id="10" class="mesActivites" style="display:none">
        </br>
          <center><h2> Activité : Sprint</h2></center>
          </br>
        <form action="controleur.php" method="post" enctype='multipart/form-data'>
             <div class="contenant69">
            <div class="item69 form-group col-md-5">
                <label for="miniDesc">Phrase d'accroche</label>
                <input type="textarea" name="miniDesc" class="form-control" id="miniDesc" value='<?php echo getMiniDesc(10); ?>'>
            </div>
            <div class="item69 form-group col-md-1">
                <label for="prix">Prix</label>
                <input type="textarea" name="prix" class="form-control" id="prix" value="<?php echo getTarifSport(10); ?>">
            </div>
        </div>
            <div class="form-group">
                <label for="description">Description</label>                   
                <textarea name="description" rows="5" class="form-control" id="description" ><?php echo getDescriptionSport(10); ?></textarea>
            </div>
            <div>
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Changer l'image de l'activité</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                <input name="fichier" class="form-control" type="file" id="fichier_a_uploader" />
            </div>
            <input type="hidden" name="IDactiviteModif" value="10" />
            </br>
            <center>
                <input class='btn btn-primary' type="submit" name="action" value="Enregistrer les Modifications"/>
            </center>
        </form>   
    </div>
</div>
   

</main>
</div>
</div>

