<?php

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "";
    $urlBase = str_replace("api", "index.php", $urlBase);
	// On redirige vers la page index avec les bons arguments
	header("Location:" . $urlBase . $qs);
    

	// On écrit seulement après cette entête
	ob_end_flush();

?>