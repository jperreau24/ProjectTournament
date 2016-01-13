<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" type="text/css" href="../css/tournoi.css">
        <script src="../js/jquery-1.11.2.min.js"></script>
    </head>
    <body>
        <?php
        include('../Classe/Rencontre.php'); 
        include('../Classe/Concurrent.php'); 
        include('../Classe/Tournoi.php');
        session_start(); 
        $id_tournoi = $_GET['id_tournoi'];
        $num_groupe = $_GET['gpr'];
        $tournoi= $_SESSION['tournoi'];
        $tab_rencontre_gpr=$_SESSION['tab_rencontre_gpr'];
        $tab_concurrent=$_SESSION['tab_concurrent'];
        if(isset($_SESSION['id_fantome'])){$id_fantome=$_SESSION['id_fantome'];}
        else{$id_fantome="";}
        $TBA = "--" ; // équipe non communiqué  
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
                        <li><a href="../mes_tournois/mes_tournois.php" title="Accueil">Mes tournois</a></li>
                        <li><a href="../crea_tournoi/crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="corps">
            <h1 style='text-align:center'><?php echo $tournoi['nom_tournoi']; ?></h1>
            <h2 style='text-align:center'>Groupe <?php echo $num_groupe; ?></h2>
            
            <?php foreach($tab_rencontre_gpr as $values) :?>
            <?php if($id_fantome != $values->getIdConcurrentA() && $id_fantome != $values->getIdConcurrentB()) :   ?>
            <div class='gpr' onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$values->getIdRencontre(); ?>';">
                <h3 style='text-align:center;margin-top:2%'>
                <?php foreach($tab_concurrent as $value_concurrent) :
                    if($value_concurrent->getIdConcurrent() == $values->getIdConcurrentA()) :
                        echo $value_concurrent->getNomConcurrent()."&nbsp;";
                    endif;endforeach;?>
                VS 
                <?php foreach($tab_concurrent as $value_concurrent2) : 
                    if($value_concurrent2->getIdConcurrent() == $values->getIdConcurrentB()) :
                        echo "&nbsp;".$value_concurrent2->getNomConcurrent();
                    ?> <div class="clear" style ='color:orange;font-weight:bold;font-size:large'><?php  echo $values->getScoreA()." - ".$values->getScoreB(); ?></div>
                    <?php endif;endforeach;?>
                </h3></div>
            <?php endif;endforeach;?>
        </div>
    </body>
</html>


