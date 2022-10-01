<footer class="cs-footer pt-3">
    <div class="container py-lg-5 py-4">
        <div class="row">
            <div class="col-lg-2 col-md-5 col-12 order-md-1 order-2 mb-md-0 mb-4">
                <h3 class="h6 mb-3 text-uppercase text-light">Besoin de me contacter ?</h3>
                <ul class="nav nav-light flex-column">
                    <li class="nav-item mb-2">
                        <a href="tel:(405)555-0128" class="nav-link p-0 font-weight-normal">
                            <span class="text-light">Téléphone: </span>
                            +33 6 76 65 56 78
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="mailto:hello@example.com" class="nav-link p-0 font-weight-normal">
                            <span class="text-light">Email: </span>
                            niko998@outlook.fr
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-12 order-md-2 order-1 offset-lg-1 mb-md-0 mb-4">
                <h3 class="h6 mb-3 text-uppercase text-light">Mes activités & cours</h3>
                <ul class="nav nav-light flex-md-column flex-sm-row flex-column">
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">AquaGym</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="templates/reservation.php" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">AquaBike</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">IronMan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Sprint</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Olympique</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Half</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Apprentissage Natation</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Perfectionnement Natation</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Perfectionnement Natation en eau libre</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="index.php?view=reservation" class="nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal">Entrainement Natation</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-12 order-md-2 order-1 offset-lg-1 mb-md-0 mb-4">
                <h3 class="h6 mb-3 text-uppercase text-light">Mes 5 derniers Articles</h3>
                <ul class="nav nav-light flex-md-column flex-sm-row flex-column">
                    <?php
                        $actus=get5derActuNonArchive();
                        foreach ($actus as $actu) {
                            $id=$actu['idActu'];
                            echo "<li class=\"nav-item mb-2\">
                        <a href=\"index.php?view=blog#$id\" class=\"nav-link mr-md-0 mr-sm-4 p-0 font-weight-normal\">$actu[titre]</a>
                    </li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-2 pt-1">
            <div class="text-light">
            <span class="d-block font-size-xs mb-1">
              <span class="font-size-sm">&copy; </span>
              Tous droits réservés.
            </span>
            </div>
        </div>
    </div>
</footer>


<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>
