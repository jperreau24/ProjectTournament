<?php
include('../Classe/TournoiManager.php');
include('../Classe/ConcurrentManager.php');
include('../Classe/RencontreManager.php');
include('../Classe/ClassementManager.php');
include('../ConnectBDD.php');

session_start();
if (!isset($_REQUEST['act']))
{
    
    $manager_tournoi = connect('Tournoi');
    $manager_concurrent = connect('Concurrent');
    $manager_rencontre = connect('Rencontre');
    $manager_classement = connect('Classement');
    
    $tournoi = $manager_tournoi->getByIdTournoi($_GET['id_tournoi']);
    $tab_concurrent = $manager_concurrent->getListConcurrent($_GET['id_tournoi']); 
    
    $tab_rencontre= $manager_rencontre->getListRencontre($_GET['id_tournoi']);
    
    if($tournoi['type_tournoi']=="championnat")
    {
        $nb_groupe=0;
        foreach($tab_rencontre as $value_rencontre) 
        {
            
            for($i=1 ;$i<=count($tab_rencontre);$i++) 
            {
                if(preg_match("#G".$i."M1#", "".$value_rencontre->getPlaceRencontre()."")) 
                {
                    $nb_groupe++;
                }
            }
        }  
        for($i=1 ;$i<=$nb_groupe;$i++) 
        {
           $tab_concurrent_groupe[] = $manager_rencontre->getListConcurrentByGroupe($_GET['id_tournoi'], $i);
        }
        
        $nb_equipe = count($tab_concurrent);
        for($i=1; $i<=$nb_groupe;$i++)
        {
            foreach($tab_concurrent as $value_concurrent)
            {
                if($nb_equipe == 4)
                {
                    if($tab_concurrent_groupe[$i-1][0]['id_concurrent_A'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                    else if($tab_concurrent_groupe[$i-1][0]['id_concurrent_B'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                }
                else if($nb_equipe == 6 || $nb_equipe == 12 || $nb_equipe == 24)
                {
                    if($tab_concurrent_groupe[$i-1][0]['id_concurrent_A'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                    else if($tab_concurrent_groupe[$i-1][0]['id_concurrent_B'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                    else if($tab_concurrent_groupe[$i-1][1]['id_concurrent_B'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                }
                else if($nb_equipe == 8 || $nb_equipe == 16 || $nb_equipe == 32)
                {
                    if($tab_concurrent_groupe[$i-1][0]['id_concurrent_A'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                    else if($tab_concurrent_groupe[$i-1][0]['id_concurrent_B'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                    else if($tab_concurrent_groupe[$i-1][1]['id_concurrent_A'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                    else if($tab_concurrent_groupe[$i-1][1]['id_concurrent_B'] == $value_concurrent->getIdConcurrent())
                    {$tab_groupe[$i][]= $value_concurrent->getNomConcurrent();    }
                }
            }
        }
        
        
        //récupère les classements des concurrents
        foreach($tab_concurrent as $con)
        {
            $tab_classement[$con->getIdConcurrent()] = $manager_classement->getClassementByIdTournoiByIdConcurrent($tournoi['id_tournoi'],$con->getIdConcurrent());
        }

        //on trie le tableau en fonction des points des concurrents
        $tab_concurrent_tri = $manager_classement->getClassementByIdTournoiTriByPoint($tournoi['id_tournoi']);
        echo $nb_equipe;
        $y=0;
         for($i=1;$i<$nb_groupe+1;$i++)
        {
            foreach($tab_concurrent_tri as $val)
            {
                if($val['nom_concurrent'] == $tab_groupe[$i][$y])
                {
                  $tab_groupe_classe[$i][] = $tab_groupe[$i][$y];
                }
                else if($val['nom_concurrent'] == $tab_groupe[$i][$y+1])
                {
                    $tab_groupe_classe[$i][] = $tab_groupe[$i][$y+1];
                }
                else if($nb_equipe != 4 && ($val['nom_concurrent'] == $tab_groupe[$i][$y+2]))
                {
                        $tab_groupe_classe[$i][] = $tab_groupe[$i][$y+2];
                }
                else if($nb_equipe!= 4 && $nb_equipe!= 6 && $nb_equipe!= 12 && $nb_equipe!= 24)
                {
                    if($val['nom_concurrent'] == $tab_groupe[$i][$y+3])
                    {
                        $tab_groupe_classe[$i][] = $tab_groupe[$i][$y+3];
                    }
                }
            }
            
        }
        /*var_dump($tab_groupe_classe);
        exit;*/
        $_SESSION['tab_classement'] = $tab_classement;
        $_SESSION['nb_equipe'] = $nb_equipe;
        $_SESSION['tab_groupe'] = $tab_groupe_classe;
    }
    
    
    //prend l'id du fantome pour bloqué les feuilles de match
    foreach($tab_concurrent as $value)
    {
        if($value->getNomConcurrent()== "~~free win~~")
        {
            $_SESSION['id_fantome'] = $value->getIdConcurrent();
            break;
        }
    }
    $_SESSION['tournoi'] = $tournoi;
    $_SESSION['tab_rencontre']=$tab_rencontre;
    $_SESSION['tab_concurrent']=$tab_concurrent;
    
   
    header('Location: tournoi_vue.php?id_tournoi='.$_GET['id_tournoi']);
}

/************************************************************/
else if ($_REQUEST['act']="plan_groupe")
{
    
    $manager_tournoi = connect('Tournoi');
    $manager_concurrent = connect('Concurrent');
    $manager_rencontre = connect('Rencontre');
    
    $num_groupe = $_GET['gpr'];
    
    $tab_concurrent = $manager_concurrent->getListConcurrent($_GET['id_tournoi']); 
    $tab_concurrent_groupe = $manager_rencontre->getListConcurrentByGroupe($_GET['id_tournoi'],$num_groupe);

    $tab_rencontre_gpr = $manager_rencontre->getListRencontreByGroup($_GET['id_tournoi'], $num_groupe);
    $_SESSION['tab_rencontre_gpr'] = $tab_rencontre_gpr;
    header('Location: tournoi_plan_gpr_vue.php?id_tournoi='.$_GET['id_tournoi'].'&gpr='.$num_groupe);
}

