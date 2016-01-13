<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <script src="../js/jquery-1.11.2.min.js"></script>
    </head>
    <body><?php session_start(); ?>
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
                        <li class="current_page_item"><a href="crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
         <div id="corps">
             <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <h1 style='text-align:center'>Générer un tournoi</h1>
            <form id='form_generer_concurrent' action="crea_tournoi.php?act=valide_tournoi_concurrent" method="post">
                <h3 style='text-align:center'>Entrez les noms des concurrents</h3>
                <div style='width:100%;float:left;'>
                    <div style="float:left; margin-left:5%; width:26%;">
                        <?php for($i=0; $i <= $_REQUEST['nb']-1; $i++) : $x=$i+1;?>
                        <?php if ($i%8 == 0) : ?>
                    </div>
                    <div style="float:left;margin-left:3%;width:22%;">
                        <?php endif; ?>
                        <p class="affichage_liste_concurrent"><?php echo $x."#"; ?>&nbsp;<input type="text" id="nom_concurrent_<?php echo $x; ?>" name="nom_concurrent_<?php echo $x; ?>" class='concurrent'></p>
                        <?php endfor; ?>
                    </div>
                </div>
                <div style="margin-left:40%;float:left;">
                    <p class='alert' id="alert_nb_concurrent" hidden>Certains concurrent n'ont pas de nom !<br>limité à 12 caractère</p>
                </div>
                <div style="margin-left:42%;float:left;">
                    <input type="submit" value="Valider" style='margin-left:45%'>
                </div>
            </form>
            <?php else : echo "<p class='alert' style='text-align:center'>Il faut être connecté pour accèder à cette page !</p>";
         endif ?>
         </div>
        <script>
        $(document).ready(function() 
        {
            $('#form_generer_concurrent').submit(function() {
                
                var nb_concurrent = $(".concurrent").length;
                
                for(var i=1; i<=nb_concurrent; i++)
                { 
                    var nom_concurrent = $('#nom_concurrent_'+i).val();
                    if(nom_concurrent == "" || nom_concurrent.length > 12)
                    {
                        $('#alert_nb_concurrent').show();
                        return false;
                    }
                }                
            });
        });
        </script>
    </body>
</html>

