<?php

function connect($classe)
{
    $classe=$classe."Manager";
    $db = new PDO('mysql:host=localhost;dbname=project_tournament', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $manager = new $classe($db);
    
    return $manager;
}