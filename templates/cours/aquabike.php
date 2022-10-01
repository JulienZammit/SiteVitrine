<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
?>





		<div class="myoffers container">
			<div class="row">
				<div class="col-5 slide-left">
					<h2>
						<?php
							echo getNomSport(2);
						?>
					</h2>
					
					<h3><i>
						<?php
							echo getMiniDesc(2);
						?>
					</i></h3>

</br>
					
					<p>
						<?php
							echo getDescriptionSport(2);
						?>
					</p>

					<h4>
						<?php
							echo 'Tarif : ' . getTarifSport(2) . '€/h';
						?>
					</h4>

					
				    <?php
                        mkForm('controleur.php');

                        mkInputBoutton("submit","action","Crénaux disponibles");
                        mkInput("hidden","cours","aquabike");
                        endForm();

                    ?>
                </div>
				
					<div class="col-5 natation slide-right">
					<div class="boxImage">
						<img class ="fgfg" src=<?php
									echo getImageSport(2);
								?> 
								 
							alt="Aquabike" 
						/>
					</div>
				</div>
			</div>


			

			</div>
		</div>