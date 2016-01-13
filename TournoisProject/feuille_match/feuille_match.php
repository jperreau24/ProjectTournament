<?php
include('../Classe/TournoiManager.php');
include('../Classe/ConcurrentManager.php');
include('../Classe/RencontreManager.php');
include('../Classe/ArbitreManager.php');
include('../Classe/ClassementManager.php');
include('../ConnectBDD.php');
session_start();
$manager_tournoi = connect('Tournoi');
$manager_concurrent = connect('Concurrent');
$manager_rencontre = connect('Rencontre');
$manager_arbitre = connect('Arbitre');
$manager_classement = connect('Classement');

if (!isset($_REQUEST['act']))
{
    $tournoi = $manager_tournoi->getByIdTournoi($_GET['id_tournoi']);
    $_SESSION['id_rencontre']=$_GET['id_rencontre'];
    $_SESSION['id_tournoi']=$_GET['id_tournoi'];
    
    if(isset($_GET['vue']))
    {
        $_SESSION['vue']="Bracket";
    }
    else
    {
        if(isset($_SESSION['vue']))
        {
            unset($_SESSION['vue']);
        }
    }
    
    $feuille_rencontre = $manager_rencontre->getByIdRencontre($_SESSION['id_rencontre']);
    $feuille_rencontre_concurrentA = $manager_concurrent->getByIdConcurrent($feuille_rencontre['id_concurrent_A']);
    $feuille_rencontre_concurrentB = $manager_concurrent->getByIdConcurrent($feuille_rencontre['id_concurrent_B']);
    
    $_SESSION['feuille_rencontre']=$feuille_rencontre;
    $_SESSION['feuille_rencontre_concurrentA']=$feuille_rencontre_concurrentA['nom_concurrent'];
    $_SESSION['feuille_rencontre_concurrentB']=$feuille_rencontre_concurrentB['nom_concurrent'];
    
    $liste_arbitre = $manager_arbitre->getListArbitreByIdTournoi($_GET['id_tournoi']);
    
    if(isset($_SESSION['id_supporter']))    //si il a un compte
    {     
        if($_SESSION['id_supporter'] == $tournoi['id_organisateur']) //si c'est l'organisateur
        {
            header('Location: feuille_match_vue.php?editer=true');
        }  
        else if(count($liste_arbitre)>0)  //si il y a des arbitres
        {
            $arbitre=0;
            foreach($liste_arbitre as $value)
            {      
                if($_SESSION['id_supporter'] == $value->getIdSupporter())
                {
                    $arbitre=1;    
                }
            } 
            if($arbitre==1)
            {
                header('Location: feuille_match_vue.php?editer=true');
            }
            else
            {
                header('Location: feuille_match_vue.php');
            }
        }
        else
        {
            header('Location: feuille_match_vue.php');
        }   
    }
    else        //si il n'a pas de compte
    {
        header('Location: feuille_match_vue.php');
    }    
}
else if($_REQUEST['act'] == 'enter_score')
{
    /*********************update de la rencontre**************/
    $id_rencontre=$_SESSION['id_rencontre'];
    $vainqueur = isset($_REQUEST['vainqueur']) && $_REQUEST['vainqueur']!= '' ? $_REQUEST['vainqueur'] : null;
    $score_A = isset($_REQUEST['score_A']) && $_REQUEST['score_A']!= '' ? $_REQUEST['score_A'] : null;
    $score_B = isset($_REQUEST['score_B']) && $_REQUEST['score_B']!= '' ? $_REQUEST['score_B'] : null;
    $date= isset($_REQUEST['date_rencontre']) && $_REQUEST['date_rencontre']!= '' ? $_REQUEST['date_rencontre'] : null;
    $observation = isset($_REQUEST['observation']) && $_REQUEST['observation']!= '' ? $_REQUEST['observation'] : null;

    if(!isset($date))
    {
        $date_rencontre=null;
    }
    else if(preg_match("#-#", $date))
    {
        $date_rencontre = $date;
    }
    else 
    {
        $year = substr($date, 6);
        $month = substr($date, 0, 2);
        $day = substr($date, 3, 2);
        $date_rencontre = $year.'-'.$month.'-'.$day;
    }
    if(!isset($score_A))
    {
        $score_A=0;
    }
    if(!isset($score_A))
    {
        $score_A=0;
    }
    if(!isset($score_B))
    {
        $score_B=0;
    }

    $rencontre = new Rencontre();
    $rencontre->setIdRencontre($_SESSION['id_rencontre']);
    $rencontre->setVainqueurRencontre($vainqueur);
    $rencontre->setScoreA($score_A);
    $rencontre->setScoreB($score_B);
    $rencontre->setDateRencontre($date_rencontre);
    $rencontre->setObservation($observation);
    
    $manager_rencontre->updateRencontre($rencontre);
    
    /*********************Avancé du tournoi**************/
    $tournoi = $_SESSION['tournoi'];
    
    $av_rencontre = $manager_rencontre->getByIdRencontre($_SESSION['id_rencontre']);
    $av_concurrentA = $manager_concurrent->getByIdConcurrent($av_rencontre['id_concurrent_A']);
    $av_concurrentB = $manager_concurrent->getByIdConcurrent($av_rencontre['id_concurrent_B']);
    
    if($tournoi['type_tournoi']=="elimination_directe")
    {
        //permet de définir la nouvelle position
        function new_place($av_rencontre, $manager_tournoi)
        {
            //echo "ancienne position :".$av_rencontre['place_rencontre']."<br>";
            $new_phase = substr($av_rencontre['place_rencontre'], 0, 1);
            if($new_phase == "H")
            {
                $new_phase = "Q";
            }
            else if($new_phase == "Q") 
            {
                $new_phase = "D";
            }
            else if($new_phase == "D") 
            {
                $new_phase = "F";
            }
            else if($new_phase == "F") 
            {
                include('../Classe/Tournoi.php');
                $vainqueur_tournoi= new Tournoi();
                $vainqueur_tournoi->setIdTournoi($av_rencontre['id_tournoi']);
                $vainqueur_tournoi->setVainqueurTournoi($av_rencontre['vainqueur_rencontre']);
                
                $manager_tournoi->updateVainqueurTournoi($vainqueur_tournoi);
                $new_phase = "Fin";
                
            }   
            $new = substr($av_rencontre['place_rencontre'], 1, 1);

            $new_pos = $new/2;
            if($new%2 != 0) //permet de savoir si c'est le concurrent A ou B du prochain match
            {
                $pos_box = "A";
            }
            else
            {
                $pos_box = "B";
            }
            $new_nb = ceil($new_pos);
            $new_position = $new_phase.$new_nb;
            $tab_positon = array('new_position' => $new_position, 'pos_box' => $pos_box);
            //echo "<br>nouvelle position : ".$new_position;

            return $tab_positon;
        }

        //met a jour la prochaine rencontre
        if($av_rencontre['vainqueur_rencontre'] == $av_concurrentA['nom_concurrent'])
        {
            $tab_position = new_place($av_rencontre, $manager_tournoi);
            //recherche l'id de la prochaine rencontre
            $tab_id_rencontre = $manager_rencontre->getByIdTournoiAndPlaceRencontre($_SESSION['id_tournoi'], $tab_position['new_position']);
            
            if($tab_position['new_position']!= "Fin")
            {
                $new_rencontre = new Rencontre();
                $new_rencontre->setIdRencontre($tab_id_rencontre['id_rencontre']);
                $new_rencontre->setIdTournoi($_SESSION['id_tournoi']);
                $new_rencontre->setPlaceRencontre($tab_position['new_position']);
                if($tab_position['pos_box'] == "A")
                {
                    $new_rencontre->setIdConcurrentA($av_concurrentA['id_concurrent']);
                }
                else if($tab_position['pos_box'] == "B")
                {
                    $new_rencontre->setIdConcurrentB($av_concurrentA['id_concurrent']);
                }
                $manager_rencontre->updateNewRencontre($new_rencontre);
            }
            else
            {
                header('Location: ../tournoi/tournoi.php?id_tournoi='.$_SESSION['id_tournoi']);
            }

        }
        else if ($av_rencontre['vainqueur_rencontre'] == $av_concurrentB['nom_concurrent'])
        {
            $tab_position = new_place($av_rencontre, $manager_tournoi);
            //recherche l'id de la prochaine rencontre
            $tab_id_rencontre = $manager_rencontre->getByIdTournoiAndPlaceRencontre($_SESSION['id_tournoi'], $tab_position['new_position']);

            if($tab_position['new_position']!= "Fin")
            {
                $new_rencontre = new Rencontre();
                $new_rencontre->setIdRencontre($tab_id_rencontre['id_rencontre']);
                $new_rencontre->setIdTournoi($_SESSION['id_tournoi']);
                $new_rencontre->setPlaceRencontre($tab_position['new_position']);
                if($tab_position['pos_box'] == "A")
                {
                    $new_rencontre->setIdConcurrentA($av_concurrentB['id_concurrent']);
                }
                else if($tab_position['pos_box'] == "B")
                {
                    $new_rencontre->setIdConcurrentB($av_concurrentB['id_concurrent']);
                }
                $manager_rencontre->updateNewRencontre($new_rencontre);
            }
            else
            {
                header('Location: ../tournoi/tournoi.php?id_tournoi='.$_SESSION['id_tournoi']);
            }
        }
    }
    else if($tournoi['type_tournoi']=="championnat")
    {
        
        if($av_rencontre['vainqueur_rencontre'] == $av_concurrentA['nom_concurrent'])
        { 
            $tab_classement = $manager_classement->getClassementByIdTournoiByIdConcurrent($tournoi['id_tournoi'],$av_rencontre['id_concurrent_A']);
            $point = $tab_classement['point'];
            $new_point = $point + 3;

            $classement= new Classement();
            $classement->setIdTournoi($tournoi['id_tournoi']);
            $classement->setIdConcurrent($av_rencontre['id_concurrent_A']);
            $classement->setPoint($new_point);
            
            //ajout des points au classement du joueur
            $manager_classement->updateClassement($classement);
        }
        else if ($av_rencontre['vainqueur_rencontre'] == $av_concurrentB['nom_concurrent'])
        { 
            $tab_classement = $manager_classement->getClassementByIdTournoiByIdConcurrent($tournoi['id_tournoi'],$av_rencontre['id_concurrent_B']);
            $point = $tab_classement['point'];
            $new_point = $point + 3;

            $classement= new Classement();
            $classement->setIdTournoi($tournoi['id_tournoi']);
            $classement->setIdConcurrent($av_rencontre['id_concurrent_B']);
            $classement->setPoint($new_point);
            
            //ajout des points au classement du joueur
            $manager_classement->updateClassement($classement);
        }
        
        
        //vérif si c'est la fin !
        $tab_rencontre = $manager_rencontre->getListRencontreGroup($tournoi['id_tournoi']);
        $tab_concurrent = $manager_concurrent->getListConcurrent($tournoi['id_tournoi']); 
        $fin = count($tab_rencontre);
        
        foreach($tab_rencontre as $value_rencontre)
        {
            if($value_rencontre->getVainqueurRencontre() != "")
            {
                $fin = $fin-1;
            } 
        }
        
        // fin de la phase de groupe ! en avant les amis pour la phase de bracket !!
        if($fin==0)
        {
            //calcul du nombre de groupe
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
                $tab_concurrent_groupe[] = $manager_rencontre->getListConcurrentByGroupe($tournoi['id_tournoi'], $i);
            }
            
            //récupére le nom des concurrents par groupe
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
            
            foreach($tab_concurrent as $con)
        {
            $tab_classement[$con->getIdConcurrent()] = $manager_classement->getClassementByIdTournoiByIdConcurrent($tournoi['id_tournoi'],$con->getIdConcurrent());
        }

        //on trie le tableau en fonction des points des concurrents
        $tab_concurrent_tri = $manager_classement->getClassementByIdTournoiTriByPoint($tournoi['id_tournoi']);
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
            //on garde les 2 meilleurs de chaque groupe !
            foreach ($tab_groupe_classe as $sub_array) {
                $tab_up_bracket_multi[] = array_slice($sub_array, 0,2);
            }
            var_dump($tab_up_bracket_multi);
            
            //on enléve le tableau multi
            $x=0;
            foreach($tab_up_bracket_multi as $note)
            {
                $tab_up_bracket[$x] = $note[0];
                $tab_up_bracket[$x+1] = $note[1];
                $x=$x+2;
            }
            //on transforme le tableau en un tableau simple de concurrent
            $tab_up_inverse_bracket=array_reverse($tab_up_bracket);
        
            $demi = count($tab_up_bracket)/2;
            $inverse_demi = -$demi;
            $tab_up_inverse_bracket2 = array_slice($tab_up_inverse_bracket, 0,$demi);
           
            $tab_up_bracket2 = array_slice($tab_up_bracket, 0,$demi);

            echo $tab_up_bracket2[0];
            $j=0;
            for($i=0; $i<=(count($tab_up_bracket)/2)-1;$i++)
            {
                $tab_up_bracket_final[$j] = $tab_up_bracket2[$i];
                $tab_up_bracket_final[$j+1] = $tab_up_inverse_bracket2[$i];
                $j=$j+2;
            }

            //var_dump($tab_up_bracket_final);
            //nombre d'équipe dans le bracket !
            $nb_equipe_bracket = count($tab_up_bracket_final);

            //calcul de la phase a update
            if($nb_equipe_bracket == 4)
            {
                $phase="D";
                $nb_rencontre_update=2;
            }
            else if($nb_equipe_bracket == 8)
            {
                $phase="Q";
                $nb_rencontre_update=4;
            }
            else if($nb_equipe_bracket == 16)
            {
                $phase="H";
                $nb_rencontre_update=8;
            }
            $id_tournoi = $tournoi['id_tournoi'];
            $n=0;
            for($i=0; $i<=$nb_rencontre_update-1;$i++)
            {
                $tab_concurrent_A = $manager_concurrent->getByNomConcurrentByIdTournoi($id_tournoi,$tab_up_bracket_final[$n]);
                $tab_concurrent_B = $manager_concurrent->getByNomConcurrentByIdTournoi($id_tournoi,$tab_up_bracket_final[$n+1]);
                
                $id_concurrent_A = $tab_concurrent_A['id_concurrent'];
                $id_concurrent_B = $tab_concurrent_B['id_concurrent'];

                $n=$n+2;
                $id_place=$i+1;
                $place_rencontre=$phase.$id_place;
                
                $rencontre = new Rencontre();
                $rencontre->setIdTournoi($id_tournoi);
                $rencontre->setIdConcurrentA($id_concurrent_A);
                $rencontre->setIdConcurrentB($id_concurrent_B);
                $rencontre->setPlaceRencontre($place_rencontre);
                
                //update les rencontre des brackets
                $manager_rencontre->updateRencontreGroupeBracket($rencontre);
            }
            $bracket="ON";
        }
        
        if(isset($bracket) && $bracket == "ON")
        {
            //permet de définir la nouvelle position
            function new_place($av_rencontre, $manager_tournoi)
            {
                //echo "ancienne position :".$av_rencontre['place_rencontre']."<br>";
                $new_phase = substr($av_rencontre['place_rencontre'], 0, 1);
                if($new_phase == "H")
                {
                    $new_phase = "Q";
                }
                else if($new_phase == "Q") 
                {
                    $new_phase = "D";
                }
                else if($new_phase == "D") 
                {
                    $new_phase = "F";
                }
                else if($new_phase == "F") 
                {
                    include('../Classe/Tournoi.php');
                    $vainqueur_tournoi= new Tournoi();
                    $vainqueur_tournoi->setIdTournoi($av_rencontre['id_tournoi']);
                    $vainqueur_tournoi->setVainqueurTournoi($av_rencontre['vainqueur_rencontre']);

                    $manager_tournoi->updateVainqueurTournoi($vainqueur_tournoi);

                }   
                $new = substr($av_rencontre['place_rencontre'], 1, 1);

                $new_pos = $new/2;
                if($new%2 != 0) //permet de savoir si c'est le concurrent A ou B du prochain match
                {
                    $pos_box = "A";
                }
                else
                {
                    $pos_box = "B";
                }
                $new_nb = ceil($new_pos);
                $new_position = $new_phase.$new_nb;
                $tab_positon = array('new_position' => $new_position, 'pos_box' => $pos_box);
                //echo "<br>nouvelle position : ".$new_position;

                return $tab_positon;
            }

            //met a jour la prochaine rencontre
            if($av_rencontre['vainqueur_rencontre'] == $av_concurrentA['nom_concurrent'])
            {
                $tab_position = new_place($av_rencontre, $manager_tournoi);
                //recherche l'id de la prochaine rencontre
                $tab_id_rencontre = $manager_rencontre->getByIdTournoiAndPlaceRencontre($_SESSION['id_tournoi'], $tab_position['new_position']);

                $new_rencontre = new Rencontre();
                $new_rencontre->setIdRencontre($tab_id_rencontre['id_rencontre']);
                $new_rencontre->setIdTournoi($_SESSION['id_tournoi']);
                $new_rencontre->setPlaceRencontre($tab_position['new_position']);
                if($tab_position['pos_box'] == "A")
                {
                    $new_rencontre->setIdConcurrentA($av_concurrentA['id_concurrent']);
                }
                else if($tab_position['pos_box'] == "B")
                {
                    $new_rencontre->setIdConcurrentB($av_concurrentA['id_concurrent']);
                }
                $manager_rencontre->updateNewRencontre($new_rencontre);

            }
            else if ($av_rencontre['vainqueur_rencontre'] == $av_concurrentB['nom_concurrent'])
            {
                $tab_position = new_place($av_rencontre, $manager_tournoi);
                //recherche l'id de la prochaine rencontre
                $tab_id_rencontre = $manager_rencontre->getByIdTournoiAndPlaceRencontre($_SESSION['id_tournoi'], $tab_position['new_position']);

                $new_rencontre = new Rencontre();
                $new_rencontre->setIdRencontre($tab_id_rencontre['id_rencontre']);
                $new_rencontre->setIdTournoi($_SESSION['id_tournoi']);
                $new_rencontre->setPlaceRencontre($tab_position['new_position']);
                if($tab_position['pos_box'] == "A")
                {
                    $new_rencontre->setIdConcurrentA($av_concurrentB['id_concurrent']);
                }
                else if($tab_position['pos_box'] == "B")
                {
                    $new_rencontre->setIdConcurrentB($av_concurrentB['id_concurrent']);
                }
                $manager_rencontre->updateNewRencontre($new_rencontre);
            }
        }
                             
    }

    header('Location: ../tournoi/tournoi.php?id_tournoi='.$_SESSION['id_tournoi']);
}