<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="myStyle.css" />
		<title>Accueil</title>
	</head>
	<body>
		
		<div id="bloc_page">
			<?php /*include("header2.php");*/?>
			<section id="Id_Slide">
				<div Id="Id_SlideWindow">
					<div Id="Id_Container">
						<figure class="c_FigSlide">
				    		<img class="c_ImageSlide" src="images/mario.png" alt="mario" />
				   			<figcaption>Mario : "See you next time!"</figcaption>
						</figure><!--
					--><figure class="c_FigSlide">
		    				<img class="c_ImageSlide" src="images/halo.jpg" alt="halo" />
		    				<figcaption>Halo : "Vous êtes l'unique espoir de l'humanité!"</figcaption>
						</figure><!--
				 	--><figure class="c_FigSlide">
		    				<img class="c_ImageSlide" src="images/starwars.jpg" alt="starwars" />
		    				<figcaption>StarWars : "Il y a très longtemps..."</figcaption>
						</figure><!--
					--><figure class="c_FigSlide">
		    				<img class="c_ImageSlide" src="images/paysage.jpg" alt="starwars" />
		    				<figcaption>Représentation : "Un doux rêve..."</figcaption>
						</figure>							
					</div>	
					<div id="Id_ProgressBar">
					</div>
					<div Id="Id_Pause"></div>	
					<div Id="Id_Play"></div>	
					<div Id="Id_Right" class="C_NavSlide"></div>	
					<div Id="Id_Left" class="C_NavSlide"></div>	
				</div>

				<ul class="dots_commands"><!--
				--><li><div Id="Id_Slide0" class="C_ChoiceSlide" title="Afficher la slide 1"><div></div></div></li><!--
				--><li><div Id="Id_Slide1" class="C_ChoiceSlide" title="Afficher la slide 2"><div></div></div></li><!--
				--><li><div Id="Id_Slide2" class="C_ChoiceSlide" title="Afficher la slide 3"><div></div></div></li><!--
				--><li><div Id="Id_Slide3" class="C_ChoiceSlide" title="Afficher la slide 4"><div></div></div></li>
				</ul>
			</section>
			<section id="Id_Description">
				<p Id="texteJQ"></p>
				<p Id="texteJQ2"></p>
			</section>
			<?php include("footer.php");?>
		</div>



		<script src="jquery-2.1.3.js"></script>
    	<script src="myScript.js"></script>
	</body>
</html>