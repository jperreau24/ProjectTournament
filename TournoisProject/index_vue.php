<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title>
        
        <link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
    </head>
    <body>
        <?php include('Classe/Tournoi.php');
        session_start(); 
        $tab_tournoi_termine = $_SESSION['tab_tournoi_termine'];
        $tab_tournoi_recent = $_SESSION['tab_tournoi_recent'];
        ?>
        
        
        <div id="header-wrapper">
            <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <div class="login_index">
                <form action="logout.php" method="post">
                    <input type="Submit" value="Déconnexion" name="submit">
                </form>
            </div>

                    <?php else : ?>               
            <div class="login_index">
                <form action="checkLogin.php" method="post">
                    <label for="pseudo">Login : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="pseudo" class="textbox" id="pseudo" style="width: 50%;margin-top: -1%"/><br /><br />
                    <label for="mdp">Password : </label><input type="password" name="mdp" class="textbox" id="mdp" style="width: 50%;margin-top: -1%"/><br />
                    <input type="Submit" value="Connexion" name="submit">
                </form>
                <?php if(isset($_SESSION['logged'])):?>
                    <div id="wrongLogin">Login ou mot de passe incorrect</div>
                <?php unset($_SESSION['logged']);endif;?>
                <form action="inscription/inscription.php" method="post" >
                    <input type='submit' name='inscription' value="S'inscrire">
                </form>
            </div>
            <?php endif; ?>

            <div id="header" class="container">
                <div id="logo" style="">                   
                    <h1><a href="#">Challenge Tournament</a></h1>
                </div>
                <div id="menu">
                <ul>
                    <li class="current_page_item"><a href="index.php" title="Accueil">Accueil</a></li>
                    <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
                    <li><a href="mes_tournois/mes_tournois.php" title="Accueil">Mes tournois</a></li>
                    <li><a href="crea_tournoi/crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                </ul>
                </div>
            </div>
        </div>
        <div id="corps">
            <!--<form action="tournoi/tournoi.php?id_tournoi=7" method="post">
                <input type="submit" value="Afficher tournoi"> 
            </form>-->
            <!--<form action="mail.php" method="post">
                <input type="submit" value="Envoyer mail"> 
            </form>-->
            <div style="width:100%;text-align:center;padding:1%;float:left;">
                <h3>Venez créer vos propres tournois maintenant !</h3>
                <a href="crea_tournoi/crea_tournoi.php" style="background-color: #ff6816" class="button_generator">Générer un tournoi</a>
            </div>
            <div id="liste_index">
                <div style="float:left;margin-left:15%;">
                    <h2>Tournois terminés</h2><br>
                    <ul class="ul_index">
                    <?php foreach($tab_tournoi_termine as $value_termine) : ?>
                        <li><a href="tournoi/tournoi.php?id_tournoi=<?php echo $value_termine->getIdTournoi();?>" class="affichage_liste_tournois">
                            <?php echo $value_termine->getNomTournoi()."</a> : ".$value_termine->getVainqueurTournoi(); ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
                <div style="float:left;margin-left:25%;">
                    <h2>Tournois récents</h2><br>
                    <ul class="ul_index">
                    <?php foreach($tab_tournoi_recent as $value_recent) : ?>
                        <li><a href="tournoi/tournoi.php?id_tournoi=<?php echo $value_recent->getIdTournoi();?>" class="affichage_liste_tournois">
                            <?php echo $value_recent->getNomTournoi(); ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
   
    </body>
</html>
