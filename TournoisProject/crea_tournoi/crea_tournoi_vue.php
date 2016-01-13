<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <script src="../js/jquery-1.11.2.min.js"></script>
    </head>
    <body><?php include ('../Classe/Sport.php');
                session_start(); 
                $tab_sport = $_SESSION['sport'];?>
        
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
                        <li class="current_page_item"><a href="crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        
        <div id="corps">
            <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <h2 id="logo">Générer un tournoi</h2>
            <div id="formulaire">
                <form id='form_generer_tournoi' action="crea_tournoi.php?act=valide_tournoi_caracteristique" method="post" style="margin-left: 30%; margin-bottom: 2%;">
                    <table>
                         <tr>
                         <td><label for="login"><strong>Nom du tournoi : </strong></label></td>
                         <td><input type="text" name="nom_tournoi" class="textbox_generer_tournoi" id="nom_tournoi"/></td>
                         <td class='alert' id="alert_nom_tournoi" hidden>Au moins 3 caractères</td>

                         </tr><tr>

                         <td><label for="login"><strong>Choisir un sport/jeu : </strong></label></td>
                         <td><select name="type_sport" size="1" class="textbox_generer_tournoi">
                                 <option selected>Autre</option>
                                 <?php foreach($tab_sport as $value_sport) : ?>
                                 <option><?php echo $value_sport->getNomSport(); ?></option>
                                 <?php endforeach; ?>
                             </select></td>

                         </tr><tr>

                         <td><label for="login"><strong>Type de tournoi : </strong></label></td>
                         <td><input type="radio" name="type_tournoi" value="elimination_directe" checked='checked'>Elimination directe   
                            <input type="radio" name="type_tournoi" value="championnat">Championnat</td>

                         </tr><tr>

                         <td><label for="login"><strong>Nombre de concurrents : </strong></label></td>
                         <td><input type="number" name="nb_concurrent" value="2" style="width:75px" id="nb_concurrent"></td>
                         <td class='alert' id="alert_nb_concurrent_elimination" hidden>Entre 2 et 16 concurrents</td>
                         <td class='alert' id="alert_nb_concurrent_championnat" hidden>Entre 4 et 32 concurrents</td>

                         </tr><tr>

                         <td><label for="login"><strong>Présence d'arbitre : </strong></label></td>
                         <td><input type="radio" name="presence_arbitre" value="oui" checked='checked'> Oui
                             <input type="radio" name="presence_arbitre" value="non"> Non</td>

                         </tr><tr>
                             
                         <td><label for="login"><strong>Nombre d'arbitre : </strong></label></td>
                         <td><input type="number" name="nb_arbitre" value="1" style="width:75px" id="nb_arbitre"></td>
                         <td class='alert' id="alert_nb_arbitre" hidden>Le nombre d'arbitre doit être entre 1 et 3</td>

                         </tr><tr>

                         <td><label for="login"><strong>Placement aléatoire : </strong></label></td>
                         <td><input type="radio" name="random" value="oui" checked='checked'> Oui
                             <input type="radio" name="random" value="non"> Non</td>
                         </tr>
                    </table>
                    <div style="margin-left:18%;margin-top:1%;">
                        <input type="submit" value="Valider">
                    </div>
                </form>
            </div>
            <?php else : echo "<p class='alert' style='text-align:center'>Il faut être connecté pour accèder à cette page !</p>";
            endif ?>
        </div>
        <script>
         $(document).ready(function() 
            {
                $('#form_generer_tournoi').submit(function() {
                    
                    var nom_tournoi = $('#nom_tournoi').val();
                    var nb_concurrent = $('#nb_concurrent').val();
                    var type_tournoi = $('input[type=radio][name=type_tournoi]:checked').val();
                    var nb_arbitre = $('#nb_arbitre').val();
                    var presence_arbitre = $('input[type=radio][name=presence_arbitre]:checked').val();   
                    
                    if(nom_tournoi=="" || nom_tournoi.length < 3)
                    {$('#alert_nom_tournoi').show();return false;} 
                    else{$('#alert_nom_tournoi').hide();}

                    if(type_tournoi=="elimination_directe")
                    { 
                        if(nb_concurrent=="" || nb_concurrent < 2 || nb_concurrent > 16)
                        {$('#alert_nb_concurrent_championnat').hide();
                         $('#alert_nb_concurrent_elimination').show();return false;}
                        else{$('#alert_nb_concurrent_championnat').hide();$('#alert_nb_concurrent_elimination').hide();}
                    }
                    else if(type_tournoi=="championnat")
                    {
                        if(nb_concurrent=="" || nb_concurrent < 4 || nb_concurrent > 32)
                        {$('#alert_nb_concurrent_elimination').hide();
                         $('#alert_nb_concurrent_championnat').show();return false;}
                        else{$('#alert_nb_concurrent_elimination').hide();$('#alert_nb_concurrent_championnat').hide();}
                    } 
                    
                    if(presence_arbitre=="oui")
                    {   
                        if(nb_arbitre=="" || nb_arbitre < 1 || nb_arbitre > 3)
                        {$('#alert_nb_arbitre').show();return false;}
                        else{$('#alert_nb_arbitre').hide();}
                    }
               });
            });
        </script>
    </body>
</html>


<!-- 
                <p>
                   Nom du tournoi :
                   <input type="textbox" name="nom_tournoi">
               </p>
<p>            
                   Choisir un sport/jeu :
                   <input type="textbox" name="type_sport">
               </p>
<p>
                   Type de tournoi :
                   <input type="radio" name="type_tournoi" value="championnat">Championnat
                   <input type="radio" name="type_tournoi" value="elimination_directe">Elimination directe
               </p>
 <p>
                   Nombre de concurrents :
                   <input type="number" name="nb_concurrent" value="3" style="width:75px">
               </p>
<p>
                   Présence d'arbitre : 
                   <input type="radio" name="presence_arbitre" value="oui"> Oui
                   <input type="radio" name="presence_arbitre" value="non"> Non
               </p>
<p>
                   Placement aléatoire :
                   <input type="radio" name="random" value="oui"> Oui
                   <input type="radio" name="random" value="non"> Non
               </p>