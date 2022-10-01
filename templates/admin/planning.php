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

    <link href="assets/css/planning.css" rel="stylesheet">

    <style>
.main-content{
	height: 750px;
}
	body {
		font-family: 'Roboto', sans-serif;
		}
		
	#wrap {
		width: 1100px;
		margin: 0 auto;
		margin-bottom: 40px;
		}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		text-align: left;
		}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
		}
		
	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
		}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
		}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
		}

	#calendar {
/* 		float: right; */
        margin: 0 auto;
		width: 900px;
		background-color: #FFFFFF;
		  border-radius: 6px;
        box-shadow: 0 1px 2px #C3C3C3;
		-webkit-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
-moz-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);

		}

		.fc-event-main{
			color: black !important;
		}

</style>
    
<link href='assets/js/fullcalendar/main.css' rel='stylesheet' />
<script src='assets/js/fullcalendar/main.js'></script>
<script>

		document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'timeGridWeek',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay,listMonth'
          },
          buttonText: {
			      prev: 'Précédent',
			      next: 'Suivant',
			      today: "Aujourd'hui",
			      year: 'Année',
			      month: 'Mois',
			      week: 'Semaine',
			      day: 'Jour',
			      list: 'Planning',
			    },
          navLinks: true, // can click day/week names to navigate views
          editable: true,
          height: 620,
          firstDay: 1,
          selectable: true,
          allDaySlot: false,
          nowIndicator: true,
          slotDuration: '00:15:00',
          eventTimeFormat: { hour12: false, hour: '2-digit', minute: '2-digit' },
          slotMinTime: '08:00:00',
          slotMaxTime: '22:00:00',
          locale: 'fr',
          timeZone: 'France/Paris',
          //timeZone: 'local',//timeZone de l'ordi

          select: function (time, jsEvent, view) { //selection de case pour ajouter un cours

          $('#myModal').modal('show');//affichage popup pour créer cours
						$('#addcours').off('click').click(function(){
							//2022-04-15T08:45:00

							var title = $('#selectcours option:selected').text();
							var idactivite=$('#selectcours').val();
							$('#myModal').modal('hide');

							//ajout dans la db
							var datestartupdate=time.startStr.split('T');
							var datefinupdate=time.endStr.split('T');

							// ajax("api/admin.php",{
							// 	data: {action: "addCours",idactivite: idactivite,debut_date: datestartupdate[0],debut_hour: datestartupdate[1],fin_date: datefinupdate[0],fin_hour: datefinupdate[1]},
							// 	callback: executerep,
							// 	type: "POST"
							// });
							$.ajax({
								type: "POST",
								url: "api/admin.php?action=addCours&idactivite="+idactivite+"&debut_date="+datestartupdate[0]+"&debut_hour="+datestartupdate[1]+"&fin_date="+datefinupdate[0]+"&fin_hour="+datefinupdate[1],
								success: function(oRep){
									var rep= JSON.parse(oRep);
									console.log(rep.idcours);
									calendar.addEvent(
										{
											//il manque id ici il faudrait utiliser un callback sur la requête ajax
											id: rep.idcours,
											title: title,
											start: time.startStr,
											end: time.endStr,
										},
									);
								},
							});

	          	//console.log(time.startStr);
	          	// console.log(time.endStr);
						});
						calendar.unselect();
          },

		      eventClick: function(eventObj) { //detection d'un click sur un event (ajout d'un cours)

		      	var datestartupdate=eventObj.event.start.toISOString().split('T');
						var datehourdebut=datestartupdate[1].split('.')

						var datestartorder=datestartupdate[0].split('-');
						var hourstartorder=datehourdebut[0].split(':');

		      	$("#confirmdisabled").modal('show'); //affichage popup pour confirmer la suppression du cours
			 			var content = "<h5>Vous souhaitez suspendre le cours de <b>\""+eventObj.event._def.title+"\"</b> prévu le <b>"+datestartorder[2]+"/"+datestartorder[1]+"/"+datestartorder[0]+"</b> à <b>"+hourstartorder[0]+":"+hourstartorder[1]+"</b> </h5>";
			 			content+="<input id=\"idEvent\" name=\"idEvent\" type=\"hidden\" value=\""+eventObj.event._def.publicId+"\">";
			 				$("#formdisabledcours").html(content);

			 				$("#submitdisabled").off('click').click(function(){
								$("#confirmdisabled").modal('hide');
								var idEvent=$("#idEvent").val();
								ajax("api/admin.php",{
										data: {action: "disableCours",idEvent: idEvent},
										type: "POST"
								});
								eventObj.event.remove();
							});
		      },

		      eventDrop: function(info) { //detection du drop d'un event après l'avoir déplacé (deplacement horaire)
		      	// console.log(info.event._def);
		      	// console.log(info.event.start.toISOString());
		      	// console.log(info.event.end.toISOString());

		      	var datestartupdate=info.event.start.toISOString().split('T');
						var datefinupdate=info.event.end.toISOString().split('T');
						var datehourdebut=datestartupdate[1].split('.')
						var datehourfin=datefinupdate[1].split('.')

		      	ajax("api/admin.php",{
							data: {action: "updatecoursHour",idactidispo: info.event._def.publicId,debut_date: datestartupdate[0],debut_hour: datehourdebut[0],fin_date: datefinupdate[0],fin_hour: datehourfin[0]},
							type: "POST"
						});
				  },

				  eventResize: function(info) { //detection du drop d'un event après l'avoir déplacé (deplacement horaire)
		      	// console.log(info.event._def);
		      	// console.log(info.event.start.toISOString());
		      	// console.log(info.event.end.toISOString());

		      	var datestartupdate=info.event.start.toISOString().split('T');
						var datefinupdate=info.event.end.toISOString().split('T');
						var datehourdebut=datestartupdate[1].split('.')
						var datehourfin=datefinupdate[1].split('.')

		      	ajax("api/admin.php",{
							data: {action: "updatecoursHour",idactidispo: info.event._def.publicId,debut_date: datestartupdate[0],debut_hour: datehourdebut[0],fin_date: datefinupdate[0],fin_hour: datehourfin[0]},
							type: "POST"
						});
				  },

          events: [
          <?php


			    	// [id] => 1
			     //        [debut] => 2022-04-14 18:11:22
			     //        [fin] => 2022-04-14 20:10:11
			     //        [nomsport] => flo
			     //        [mini_description] => test
			     //        [description] => test
			     //        [tarif] => 10.5

     			// {
					// 	id: 12,
					// 	title: 'flo',
					// 	start: '2022-04-12T15:30:00',
					// 	end: '2022-04-12T17:30:00',
					// },

			    	$cours=listerCours();
			    	foreach($cours as $c){
			    		// tprint($c);
			    		$datetime=explode(' ',$c['debut']);
			    		$dateonly=explode('-',$datetime[0]);
			    		$time=explode(':',$datetime[1]);
			    		$year=$dateonly[0];
			    		$month=$dateonly[1];
			    		$day=$dateonly[2];
			    		$hour=$time[0];
			    		$minute=$time[1];
			    		echo("\n{\n");
			    		echo("\tid: $c[id],\n");
			    		echo("\ttitle: '$c[nomsport]',\n");
			    		if($month < 10){
			    			$datexport=$year."-".$month."-".$day."T".$hour.":".$minute.":00";
			    		}
			    		echo("\tstart: '$datexport',\n");
			    		$datetime=explode(' ',$c['fin']);
			    		$dateonly=explode('-',$datetime[0]);
			    		$time=explode(':',$datetime[1]);
			    		$year=$dateonly[0];
			    		$month=$dateonly[1];
			    		$day=$dateonly[2];
			    		$hour=$time[0];
			    		$minute=$time[1];
			    		$datexport=$year."-".$month."-".$day."T".$hour.":".$minute.":00";
			    		echo("\tend: '$datexport',\n");
			    		echo("},\n");
			    	}
	    		?>
          ]

        });
        calendar.render();
      });

</script>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un cours au planning</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <select class="form-select" aria-label="" id="selectcours">
						  <option selected disabled>Veuillez choisir le cours</option>
						  <?php

							$sports=listerSport();

							foreach($sports as $sport){
								echo"<option value=\"$sport[id_activité]\">$sport[nomsport]</option>";
							}

							?>
						</select>
          </div>
      </div>
      <div class="modal-footer">
        <button id="addcours" type="button" class="btn btn-primary">Ajouter</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmdisabled" tabindex="-2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Suspendre un cours</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
          	<form id="formdisabledcours">
          	</form>
          </div>
      </div>
      <div class="modal-footer">
        <button id="submitdisabled" type="button" class="btn btn-primary">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 slide-in-right main-content">

	<div class="sumerhead row">
		<h2>Planning</h2>
	</div>

	<div id="wrap">

	<div id="calendar"></div>

	<div style="clear:both"></div>
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>