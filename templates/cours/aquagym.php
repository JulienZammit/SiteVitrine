<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
?>





<div class="myoffers container">
			<div class="row">
				<div class="col-5 slide-left">
					<h3>
						<?php
							echo getNomSport(3);
						?>
					</h3>
					
					<h3><i>
						<?php
							echo getMiniDesc(3);
						?>
					</i></h3>

</br>
					
					<p>
						<?php
							echo getDescriptionSport(3);
						?>
					</p>

					<h4>
						<?php
							echo 'Tarif : ' . getTarifSport(3) . '€/h';
						?>
					</h4>

					
				    <?php
                        mkForm('controleur.php');
                        mkInputBoutton("submit","action","Crénaux disponibles");
                        mkInput("hidden","cours","aquagym");
                        endForm();

                    ?>
                </div>
				
					<div class="col-5 natation slide-right">
					<div class="boxImage">
						<img class ="fgfg" src=<?php
									echo getImageSport(3);
								?> 
								 
							alt="aquagym" 
						/>
					</div>
				</div>
			</div>


			

			</div>
		</div>