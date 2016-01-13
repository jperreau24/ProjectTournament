<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
        <!--<script src="../js/jquery-1.11.2.min.js"></script>-->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />
    </head>
    <body>
    <?php
        session_start();
        $feuille_rencontre=$_SESSION['feuille_rencontre'];

        $feuille_rencontre_concurrentA=$_SESSION['feuille_rencontre_concurrentA'];
        $feuille_rencontre_concurrentB=$_SESSION['feuille_rencontre_concurrentB'];
        ?>
        <div id="header-wrapper">
          <?php  if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <div class="login">
                <form action="../logout.php" method="post">
                    <input type="Submit" value="Déconnexion" name="submit">
                </form>
            </div>   
                <?php else : ?>               
            <div class="login">
                <form action="../checkLogin.php" method="post">
                    <label for="pseudo">Login : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="pseudo" class="textbox" id="pseudo" style="width: 50%;margin-top: -1%"/><br /><br />
                    <label for="mdp">Password : </label><input type="password" name="mdp" class="textbox" id="mdp" style="width: 50%;margin-top: -1%"/><br />
                    <input type="Submit" value="Connexion" name="submit">
                </form>
                <?php if(isset($_SESSION['logged'])):?>
                    <div id="wrongLogin">Login ou mot de passe incorrect</div>
                <?php unset($_SESSION['logged']);endif;?>  
            </div>
            <?php endif;?>
            <div id="header" class="container">
                <div id="logo" style="">                   
                    <h1><a href="#">Challenge Tournament</a></h1>
                </div>
                <div id="menu">
                    <ul>
                        <li><a href="../index.php" title="Accueil">Accueil</a></li>
                        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
                        <li><a href="../mes_tournois/mes_tournois.php" title="Mes Tournois">Mes tournois</a></li>
                        <li><a href="../crea_tournoi/crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        
        <div id="corps">
            <h1 style='text-align:center'>Feuille de match</h1>
            <h2 class='feuille_match' style='font-size:xx-large'><?php echo $feuille_rencontre_concurrentA; ?> &nbsp;&nbsp;&nbsp;&nbsp;<img  src="../Images/VS.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $feuille_rencontre_concurrentB ?></h2>
            <?php if(isset($_GET['editer']) && isset($feuille_rencontre['id_concurrent_A']) && isset($feuille_rencontre['id_concurrent_B'])) : ?>
            <div id="formulaire">
                <form action="feuille_match.php?act=enter_score" method="POST">
                    <div class='feuille_match'><h3>Joué le : <input type="text" id="datepicker" name="date_rencontre" value="<?php echo $feuille_rencontre['date_rencontre']; ?>"></h3></div>
                    <div class='feuille_match'><h3>Vainqueur : 
                            <input type="radio" name="vainqueur" value="<?php echo $feuille_rencontre_concurrentA; ?>" <?php if($feuille_rencontre_concurrentA == $feuille_rencontre['vainqueur_rencontre']) : echo "checked='checked'"; endif; ?>><label style='color:orange;font-weight:bold;font-size:large'><?php echo $feuille_rencontre_concurrentA; ?></label>
                        <input type="radio" name="vainqueur" value="<?php echo $feuille_rencontre_concurrentB; ?>" <?php if($feuille_rencontre_concurrentB == $feuille_rencontre['vainqueur_rencontre']) : echo "checked='checked'"; endif; ?>><label style='color:orange;font-weight:bold;font-size:large'><?php echo $feuille_rencontre_concurrentB; ?></label>
                        </h3>
                    </div>
                    <div class='feuille_match'><h3>Score : </h3>
                        <div style='color:orange;font-weight:bold;font-size:large'><?php echo $feuille_rencontre_concurrentA; ?> <input type="number" name="score_A" style="width:75px" value="<?php echo $feuille_rencontre['score_A']; ?>"> 
                        <?php echo $feuille_rencontre_concurrentB; ?> <input type="number" name="score_B" style="width:75px" value="<?php echo $feuille_rencontre['score_B']; ?>"></div>
                    </h3></div>
                    <div class='feuille_match'><h3>Observation :</h3><textarea name='observation' style="border:3px solid black; border-radius:10px 10px 10px 10px; width:50%;height:20%;"><?php echo $feuille_rencontre['observation']; ?></textarea></div>
                    <div style="margin-left:45%;float:left;margin-top:1%">
                        <input type="submit" name="valider_score" value="Valider">
                    </div>
                </form>      
            </div>

            <?php else :
                  if($feuille_rencontre['vainqueur_rencontre'] != "") :?>
            <div class='feuille_match'><h3>Joué le : <label style='color:orange;font-weight:bold;font-size:large'><?php echo $feuille_rencontre['date_rencontre']; ?></label></h3></div>
            <div class='feuille_match'><h3>Vainqueur : <label style='color:orange;font-weight:bold;font-size:large'><?php echo $feuille_rencontre['vainqueur_rencontre']; ?></label></h3></div>
            <div class='feuille_match'><h3>Score :</h3> 
                <div style='color:orange;font-weight:bold;font-size:large'><?php echo $feuille_rencontre['score_A'].' - '.$feuille_rencontre['score_B'];?></div>
            </div>
            <div class='feuille_match'><h3>Observation :</h3>
                <textarea readonly="" name='observation' style="border:3px solid black; border-radius:10px 10px 10px 10px; width:50%;height:20%;">&nbsp; <?php echo $feuille_rencontre['observation']; ?></textarea>
            </div>

            <?php else : echo "<h1 class='feuille_match'>La feuille de match n'a pas été encore rempli ou la rencontre n'a pas encore été joué!</h1>"; 
            endif;endif; ?>
            <form <?php echo "action='../tournoi/tournoi.php?id_tournoi=".$_SESSION['id_tournoi']."'"; ?> method="POST">
                <div style="margin-left:45%;float:left;margin-top:1%">
                    <input type="submit" name="return" value="Retour">
                </div>
            </form>
         </div>
        	
        <script>
        jQuery(document).ready(function($){
            $("#datepicker").datepicker();
        });
        </script>
    </body>
</html>

