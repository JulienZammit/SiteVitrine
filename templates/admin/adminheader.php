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
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Administrateur</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<link href="assets/fontawesome/css/all.css" rel="stylesheet">	
		<style type="text/css">
			.fc .fc-button-primary{
				background-color: #4B83FC !important;
			}
		</style>
	</head>
	<body>

		    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .scroller{
          height: 500px;
          max-width: 1600px;
      }

      .bg-admin{
      	background-color: #4B83FC;
      }
      .bg-admin a{
      	color: #fff;
      }
      .bg-admin a:hover{
      	color: #ccc;
      }

      .navbar-nav .btn {
		    margin-left: 50px;
		    margin-right: 40px;
		    padding: 15px 30px 15px 30px;
		    text-align: center;
		    text-transform: uppercase;
		    font-weight: 600;
		    font-size: 14px;
		    letter-spacing: normal;
		    text-shadow: none;
		    font-style: normal;
		    font-family: Nunito Sans, sans-serif;
		    color: #ffffff;
		    background-color: #4B83FC;
    border-color: #4B83FC;
    box-shadow: 3px 4px 7px 0px rgb(0 0 0 / 45%);
		}
		.navbar-brand{
			margin-left: 1%;
		}
		h1{
			font-size: 18px;
		}
		.sumerhead .magnet{
			background-color: #4B83FC;
			padding: 20px 20px 20px 20px;
			border-radius: 15px;
			text-align: center;
			color: white;
			height: 125px;
			align-content: center;
			display: grid;
		}
		.sumerhead{
			margin-top: 2%;
			margin-bottom: 4%;
		}
		.sumerhead h2{
			margin-bottom: 2%;
		}
		.sumerhead span{
			font-size: 12px;
		}
		body{
			background-color: #f8f9fc;color: #4F4F4F;
			overflow-x: hidden;
		}

		.navbar{
			position: relative;
		}

		.scale-in-center{-webkit-animation:scale-in-center .6s cubic-bezier(.25,.46,.45,.94) both;animation:scale-in-center .6s cubic-bezier(.25,.46,.45,.94) both}

		.slide-in-right{-webkit-animation:slide-in-right .7s cubic-bezier(.25,.46,.45,.94) both;animation:slide-in-right .7s cubic-bezier(.25,.46,.45,.94) both}

		@-webkit-keyframes scale-in-center{0%{-webkit-transform:scale(0);transform:scale(0);opacity:1}100%{-webkit-transform:scale(1);transform:scale(1);opacity:1}}@keyframes scale-in-center{0%{-webkit-transform:scale(0);transform:scale(0);opacity:1}100%{-webkit-transform:scale(1);transform:scale(1);opacity:1}}

		@-webkit-keyframes slide-in-right{0%{-webkit-transform:translateX(1000px);transform:translateX(1000px);opacity:0}100%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}}@keyframes slide-in-right{0%{-webkit-transform:translateX(1000px);transform:translateX(1000px);opacity:0}100%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}}

		.table-striped>tbody>tr:nth-of-type(odd)>*{
			background-color: #4B83FC;
    		color: white !important;
		}

		.table-striped>tbody>tr:nth-of-type(odd) a{
			color: white !important;
		}
    </style>
    
<script src="assets/js/ajax.js"></script>
<script src="assets/js/utils.js"></script>

    
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">
  <a class="navbar-brand" href="index.php">
  	<img src="assets/img/logo.png" alt="" height="64" class="d-inline-block align-text-top">
  </a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <form id="formdisconnect">
    	  <input class="btn btn-header" type="submit" name="action" value="Se déconnecter">
      </form>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-admin sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
		  	<?php mkLienAdmin('index.php','<i class="fas fa-home"></i> Dashboard','view=admin'); ?>
          </li>
          <li class="nav-item">
		  	<?php mkLienAdmin('index.php','<i class="fas fa-calendar"></i> Planning','view=planning'); ?>
          </li>
          <li class="nav-item">
		  	<?php mkLienAdmin('index.php','<i class="fas fa-book"></i> Réservations','view=reservationAdmin'); ?>
          </li>
          <li class="nav-item">
              <?php mkLienAdmin('index.php','<i class="fas fa-users"></i> Utilisateurs','view=gestion'); ?>
          </li>
            <li class="nav-item">
                <?php mkLienAdmin('index.php','<i class="fa fa-wrench"></i> Modifier Blog','view=adminBlog'); ?>
            </li>
		      <li class="nav-item">
		  	      <?php mkLienAdmin('index.php','<i class="fa fa-wrench"></i> Modifier Un Cours','view=modifierCours'); ?>
          </li>
        </ul>
      </div>
    </nav>
