<?php
include('../Classe/TournoiManager.php');
include('../Classe/Tournoi.php');
include('../Classe/ArbitreManager.php');
include('../ConnectBDD.php');

session_start();
if (!isset($_REQUEST['act']))
{   
    $manager_tournoi = connect('Tournoi');
    $manager_arbitre = connect('Arbitre');
 
    
    $tab_tournoi_organisateur = $manager_tournoi->getListTournoiByIdOrganisateur($_SESSION['id_supporter']);
    $tab_tournoi_arbitre = $manager_arbitre->getListTournoiWhereSupporterArbitre($_SESSION['id_supporter']);
    
    if(count($tab_tournoi_arbitre) > 0)
    {
        foreach($tab_tournoi_arbitre as $value)
        {
            $liste_tournoi_arbitre[] =$manager_tournoi->getByIdTournoi($value->getIdTournoi());   
        }
    }
    
    $_SESSION['tab_tournoi_organisateur'] = $tab_tournoi_organisateur;
    $_SESSION['tab_tournoi_arbitre'] = $liste_tournoi_arbitre;
    header('Location: mes_tournois_vue.php');
}
