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
            <form id="form_generer_arbitre" action="crea_tournoi.php?act=valide_tournoi" method="post">

                <h3 style='text-align:center'>Sélectionnez vos arbitres</h3>
                <h4 style='text-align:center'>Vos arbitres doivent obligatoirement posséder un compte</h4>
                <div id="commentaires" class="alert" style='text-align:center'></div>
                <div  style="float:left;width:100%; margin-left:35%;margin-top:2%">
                    <table>
                        <thead class="affichage_liste_concurrent" style="text-align:center">
                            <tr>
                                <td>Nom de l'arbitre</td>
                                <td>Adresse e-mail</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=1; $i<=$_GET['nb_arbitre'] ; $i++) :?>
                            <tr>
                                <td class="affichage_liste_concurrent"><?php echo $i; ?># <input type="text" name="nom_arbitre_<?php echo $i; ?>" id="nom_arbitre_<?php echo $i; ?>">&nbsp;</td>
                                <td><input type="text" name="mail_arbitre_<?php echo $i; ?>" id="mail_arbitre_<?php echo $i; ?>">&nbsp;</td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div style="margin-left:45%;float:left;margin-top:2%">
                    <input type="submit" value="Valider" id='valider'>
                </div>
            </form>
            <?php else : echo "<p class='alert' style='text-align:center'>Il faut être connecté pour accèder à cette page !</p>";
         endif ?>
         </div>
        <script>
            $(document).ready(function() 
                {
                    $('#valider').click(function( event ) { 
                        event.preventDefault();
                        var envoie1="";
                        var envoie2="";
                        var envoie3="";
                        
                        if($('#nom_arbitre_1').length)
                        {
                            var nom_arbitre_1 = $('#nom_arbitre_1').val();
                            var mail_arbitre_1 = $('#mail_arbitre_1').val();
                            envoie1 = '&nom_arbitre_1=' + nom_arbitre_1 + '&mail_arbitre_1=' + mail_arbitre_1;
                        }
                        if($('#nom_arbitre_2').length)
                        {
                            var nom_arbitre_2 = $('#nom_arbitre_2').val();
                            var mail_arbitre_2 = $('#mail_arbitre_2').val();
                            envoie2= '&nom_arbitre_2=' + nom_arbitre_2 + '&mail_arbitre_2=' + mail_arbitre_2;
                        }
                        if($('#nom_arbitre_3').length)
                        {
                            var nom_arbitre_3 = $('#nom_arbitre_3').val();
                            var mail_arbitre_3 = $('#mail_arbitre_3').val();
                            envoie3= '&nom_arbitre_3=' + nom_arbitre_3 + '&mail_arbitre_3=' + mail_arbitre_3;
                        }
                        var envoie = 'act=valide_arbitre'+envoie1+envoie2+envoie3;

                        $.ajax({
                            url : 'crea_tournoi.php', // La ressource ciblée
                            type : 'GET', // Le type de la requête HTTP.
                            data : envoie,
                            dataType : 'html', // On désire recevoir du HTML
                            success : function(result){ 
                                jQuery("#commentaires").html(result);
                                if(result=="")
                                {
                                    $('#form_generer_arbitre').submit();
                                }
                            },
                            error : function(resultat, statut, erreur){}
                        }); 
 
                      }); 
                });
        </script>
    </body>
</html>