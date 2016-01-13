<?php
include('Classe/TournoiManager.php');
include('Classe/Tournoi.php');
include('ConnectBDD.php');

session_start();
if (!isset($_REQUEST['act']))
{   
    $manager_tournoi = connect('Tournoi');
    
    $tab_tournoi_termine = $manager_tournoi->getListTournoiTermine();
    $tab_tournoi_recent = $manager_tournoi->getListTournoiRecent();
    /*foreach($tab_tournoi_recent as $value_recent)
    {
        echo $value_recent->getNomTournoi()."<br>";
    }*/
                                        
    $_SESSION['tab_tournoi_termine']=$tab_tournoi_termine;
    $_SESSION['tab_tournoi_recent']=$tab_tournoi_recent;
    
    header('Location: index_vue.php');
}