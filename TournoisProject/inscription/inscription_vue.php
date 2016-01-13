<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <script src="../js/jquery-1.11.2.min.js"></script>
    </head>
    <body>
        <?php session_start(); ?>
        <div id="header-wrapper">
          <?php  if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <div class="login" style="padding:1%;">
                <form action="../logout.php" method="post">
                    <input type="Submit" value="Déconnexion" name="submit">
                </form>
            </div>   
                <?php else : ?>               
            <div class="login">
                <form action="../checkLogin.php" method="post">
                    <label for="pseudo">Login : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="pseudo" class="textbox" id="pseudo" style="width: 50%;margin-top: -1%"/><br /><br />
                    <label for="mdp">Password : </label><input type="password" name="mdp" class="textbox" id="mdp" style="width: 50%;margin-top: -1%"/><br /><br />
                    <input type="Submit" value="Connexion" name="submit"></input>
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
                    </ul>
                </div>
            </div>
        </div>
        <div id="corps">
            <h2 id="logo">Inscription</h2>
                <div id="formulaire">
                    <form id="form_inscription" action="inscription.php?act=inscription" method="post" onsubmit="return verifForm(this)" style="margin-left: 40%; margin-bottom: 2%;"> 
                        <table>
                            <tr>
                            <td><label for="login"><strong>Nom de compte :</strong></label></td>
                            <td><input type="text" name="login" class="textbox" id="login"/></td>
                            <td class='alert' id="alert_login" hidden>Votre login doit être composé d'au moins 4 caractères</td>

                            </tr>
                            <tr>

                            <td><label for="Email"><strong>Adresse mail</strong></label></td>
                            <td><input type="text" name="email" class="textbox" id="email"/></td>
                            <td class='alert' id="alert_email" hidden>Votre email n'est pas conforme</td>

                            </tr>
                            <tr>

                            <td><label for="pass"><strong>Mot de passe :</strong></label></td>
                            <td><input type="password" name="pass" class="textbox" id="pass"/></td>
                            <td class='alert' id="alert_pass" hidden>Votre mot de passe doit être composé d'au moins 8 caractères</td>

                            </tr>
                            <tr>

                            <td><label for="pass2"><strong>Confirmez le mot de passe :</strong></label></td>
                            <td><input type="password" name="pass2" class="textbox" id="pass2"/></td>
                            <td class='alert' id="alert_pass2" hidden>Mauvaise confirmation</td>

                        </table>
                    <div style="margin-left:12%;margin-top:1%">
                        <input type="submit" name="register" value="S'inscrire"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() 
            {
                $('#form_inscription').submit(function() {
                    
                    var login = $('#login').val();
                    var email = $('#email').val();
                    var pass = $('#pass').val();
                    var pass2 = $('#pass2').val();
                   
                    
                   if(login=="" || login.length < 4 || login.length > 16)
                   {$('#alert_login').show();return false;} 
                   else{$('#alert_login').hide();}
                   
                   if (email=="" || !email.match(/[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i))
                   {$('#alert_email').show();return false;}
                   else{$('#alert_email').hide();}
                   
                   if(pass=="" || pass.length < 8)
                   {$('#alert_pass').show();return false;}
                   else{$('#alert_pass').hide();}
                   
                   if(pass2=="" || pass2 != pass)
                   {$('#alert_pass2').show();return false;}
                   else{$('#alert_pass2').hide();}
                   
                   
               });
            });
        </script>
        
    </body>
</html>
            
