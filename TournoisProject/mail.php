<?php
$headers = 'From: "Le Mondes des Elfes" <devilslayer.24@hotmail.fr>'."\n";
$headers .= 'Return-Path: <login@free.fr>'."\n";
$headers .= 'MIME-Version: 1.0'."\n";


     $message = "Mon message";
     $email = "devilslayer.24@hotmail.fr";
     $sujet = "Mon Sujet";
     if(mail($email, $sujet, $message, $headers))
     {
       echo "<center>Votre message à bien été transmit à l'administrateur.</center>";
     }
     else
     {
         echo "<center>Envoi échoué</center>";
     }

?>

<form action="index.php" method="post">
        <input type="submit" value="Retour"> 
</form>


