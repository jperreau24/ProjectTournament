<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <script src="../js/jquery-1.11.2.min.js"></script>
    </head>
    <body>
        <?php include('../Classe/Tournoi.php');
        session_start(); 
        $tab_tournoi_organisateur = $_SESSION['tab_tournoi_organisateur'];
        $tab_tournoi_arbitre = $_SESSION['tab_tournoi_arbitre'];
        
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
                        <li class="current_page_item"><a href="mes_tournois.php" title="Accueil">Mes tournois</a></li>
                        <li><a href="../crea_tournoi/crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="corps">
        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <div id="liste_index" style='margin-left:15%;width:40%;float:left'>
                <div style="float:left;margin-left:15%;">
                    <h2>Tournois Organisés</h2><br>
                    <ul class="ul_index">
                    <?php if(isset($tab_tournoi_organisateur)) :
                    foreach($tab_tournoi_organisateur as $value_organisateur) : ?>
                        <li><a href="../tournoi/tournoi.php?id_tournoi=<?php echo $value_organisateur->getIdTournoi();?>" class="affichage_liste_tournois">
                            <?php echo $value_organisateur->getNomTournoi()."</a> : ".$value_organisateur->getVainqueurTournoi(); ?></li>
                    <?php endforeach;
                    else : echo "<p class='alert'  style='text-align:center'>Vous n'avez organisé aucun tournoi !</p>";
                    endif; ?>
                   
                    </ul>
                </div>
            </div>
            
            <div id="liste_index" style='width:40%;float:left'>
                <div style="float:left;margin-left:15%;">
                    <h2>Tournois Arbitrés</h2><br>
                    <ul class="ul_index">
                    <?php if(isset($tab_tournoi_arbitre)) :
                    foreach($tab_tournoi_arbitre as $value_arbitre) : ?>
                        <li><a href="../tournoi/tournoi.php?id_tournoi=<?php echo $value_arbitre['id_tournoi'];?>" class="affichage_liste_tournois">
                            <?php echo $value_arbitre['nom_tournoi']."</a> : ".$value_arbitre['vainqueur_tournoi']; ?></li>
                    <?php endforeach;
                    else : echo "<p class='alert'  style='text-align:center'>Vous n'avez arbitré aucun tournoi !</p>";
                    endif; ?>
                   
                    </ul>
                </div>
            </div>
            
            
        <?php else : echo "<p class='alert'>Il faut être connecté pour accèder à cette page !</p>";
         endif ?>
        </div>
    </body>
</html>
