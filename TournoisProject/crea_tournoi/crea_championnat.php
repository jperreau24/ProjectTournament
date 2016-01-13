<?php

//ajoute les fantomes si besoin au concurrent
function creaChampionnatFantome($id_tournoi, $tab_c, Tournoi $tournoi, Concurrent $concurrent)
{    
    $manager_concurrent = connect('Concurrent');
    //gestion des fantomes
    if($tournoi->getNbEquipe()!=4 ||
        $tournoi->getNbEquipe()!=6 ||
        $tournoi->getNbEquipe()!=8 ||
        $tournoi->getNbEquipe()!=12 ||
        $tournoi->getNbEquipe()!=16 ||
        $tournoi->getNbEquipe()!=24 ||
        $tournoi->getNbEquipe()!=32)
    {
        if($tournoi->getNbEquipe()<=4){$nb_fantome= 4-$tournoi->getNbEquipe();}
        else if($tournoi->getNbEquipe()<=6){$nb_fantome= 6-$tournoi->getNbEquipe();}
        else if($tournoi->getNbEquipe()<=8){$nb_fantome= 8-$tournoi->getNbEquipe();}
        else if($tournoi->getNbEquipe()<=12){$nb_fantome= 12-$tournoi->getNbEquipe();}
        else if($tournoi->getNbEquipe()<=16){$nb_fantome= 16-$tournoi->getNbEquipe();}
        else if($tournoi->getNbEquipe()<=24){$nb_fantome= 24-$tournoi->getNbEquipe();}
        else if($tournoi->getNbEquipe()<=32){$nb_fantome= 32-$tournoi->getNbEquipe();}

        for($i=1; $i<=$nb_fantome; $i++)
        {
            $concurrent->setIdTournoi($id_tournoi);
            $concurrent->setNomConcurrent("~~free win~~");
            $concurrent->setNbConcurrent(1);
            $tab_fantome[] = $concurrent->getNomConcurrent();
            $manager_concurrent->addConcurrent($concurrent);          
        }
        
        $nb_equipe_total = $tournoi->getNbEquipe()+$nb_fantome;
        //fusion des 2 tableaux fantome et real concurrent
        $tab_co = array_reverse($tab_c);
        $x=0;
        $espace_fantome=0;
        foreach($tab_co as $value_concurrent)
        {
            
            if($x<$nb_fantome)
            {   
                if((($espace_fantome%3)==0) && (($nb_equipe_total==6) || ($nb_equipe_total==12) || ($nb_equipe_total==24)))
                {
                    $tab_con[] = $tab_fantome[$x];
                    $x++;
                }
                else if((($espace_fantome%3)==0) && (($nb_equipe_total==4) || ($nb_equipe_total==8) || ($nb_equipe_total==16) || ($nb_equipe_total==32)))
                {
                    $tab_con[] = $tab_fantome[$x]; 
                    $x++;
                }        
            }
            $tab_con[] = $value_concurrent;
            $espace_fantome++;
        }
        $tab_concurrent = array_reverse($tab_con);
    }
    $tab_fantome_championnat = array('nb_fantome' => $nb_fantome, 'tab_concurrent' => $tab_concurrent);
    
    return $tab_fantome_championnat;
}

//calcul le nombre de rencontres
function creaChampionnatNbRencontre($nb_equipe)
{
    if($nb_equipe==4){$nb_rencontre=5;}
    else if($nb_equipe==6){$nb_rencontre=8;}
    else if($nb_equipe==8){$nb_rencontre=15;}
    else if($nb_equipe==12){$nb_rencontre=19;}
    else if($nb_equipe==16){$nb_rencontre=31;}
    else if($nb_equipe==24){$nb_rencontre=39;}
    else if($nb_equipe==32){$nb_rencontre=63;}
    
    return $nb_rencontre;
}

//créer toutes les rencontres d'un championnat
function creaChampionnatRencontre($id_tournoi, $nb_equipe, $nb_rencontre, $tab_concurrent, Rencontre $rencontre)
{
        $manager_concurrent = connect('Concurrent');
        $manager_rencontre = connect('Rencontre');
        $phase="G"; // G1M1 G1M2
        $id_groupe=1;
        $id_place=1; // numéro de la rencontre M1 M2 M3
        $id=0;  //numéro de tournoi de la table concurrent array(0=>team_1,1=>team_2, etc...)7
        
        //création des rencontres
        if($nb_equipe==4){$nb_rencontre_groupe=2;}
        else if($nb_equipe==6){$nb_rencontre_groupe=6;}
        else if($nb_equipe==8){$nb_rencontre_groupe=12;}
        else if($nb_equipe==12){$nb_rencontre_groupe=12;}
        else if($nb_equipe==16){$nb_rencontre_groupe=24;}
        else if($nb_equipe==24){$nb_rencontre_groupe=24;}
        else if($nb_equipe==32){$nb_rencontre_groupe=48;}

        
        for($i=1;$i<=$nb_rencontre_groupe;$i++)
        {   
            $place_rencontre=$phase.$id_groupe."M".$id_place;

            $rencontre->setIdTournoi($id_tournoi);
            $rencontre->setPlaceRencontre($place_rencontre);  
            
            if($nb_equipe==4)
            {
                if($id_place==1)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1];
                }
            }
            else if($nb_equipe==6 || $nb_equipe==12 || $nb_equipe==24)
            {
                if($id_place==1)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1];
                }
                else if($id_place==2)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+2];
                }
                else if($id_place==3)
                {
                    $nom_concurrent_A = $tab_concurrent[$id+1];
                    $nom_concurrent_B = $tab_concurrent[$id+2];
                }
            }
            else if($nb_equipe==8 || $nb_equipe==16 || $nb_equipe==32)
            {
                if($id_place==1)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1];
                }
                else if($id_place==2)
                {
                    $nom_concurrent_A = $tab_concurrent[$id+2];
                    $nom_concurrent_B = $tab_concurrent[$id+3];
                }
                else if($id_place==3)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+2];
                }
                else if($id_place==4)
                {
                    $nom_concurrent_A = $tab_concurrent[$id+1];
                    $nom_concurrent_B = $tab_concurrent[$id+3];
                }
                else if($id_place==5)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+3];
                }
                else if($id_place==6)
                {
                    $nom_concurrent_A = $tab_concurrent[$id+1];
                    $nom_concurrent_B = $tab_concurrent[$id+2];
                }
            }

            $tab_concurrent_A = $manager_concurrent->getByNomConcurrentByIdTournoi($id_tournoi,$nom_concurrent_A);
            $tab_concurrent_B = $manager_concurrent->getByNomConcurrentByIdTournoi($id_tournoi,$nom_concurrent_B);

            $id_concurrent_A = $tab_concurrent_A['id_concurrent'];
            $id_concurrent_B = $tab_concurrent_B['id_concurrent'];

            $rencontre->setIdConcurrentA($id_concurrent_A);
            $rencontre->setIdConcurrentB($id_concurrent_B);

            //change la phase de la rencontre
            if(($nb_equipe == 6 ||$nb_equipe == 12 ||$nb_equipe == 24) && $id_place==3)
            {
                $id=$id+3;
                $id_place=0;
                $id_groupe++;
            }
            else if(($nb_equipe == 8 ||$nb_equipe == 16 ||$nb_equipe == 32) && $id_place==6)
            {
                $id=$id+4;
                $id_place=0;
                $id_groupe++;  
            }
            else if(($nb_equipe == 4) && $id_place==1)
            {
                $id=$id+2;
                $id_place=0;
                $id_groupe++;  
            }

            $id_place++;  
            //ajout d'une rencontre
            $manager_rencontre->addRencontre($rencontre); 
        }        
}


function creaChampionnatBracket($id_tournoi, $nb_equipe, Rencontre $rencontre)
{
    $manager_rencontre = connect('Rencontre');
    
    //calcul le nombre de rencontre dans le bracket
    if($nb_equipe==4 || $nb_equipe==6 || $nb_equipe==8){$nb_rencontre_bracket = 3;}
    else if($nb_equipe==12 || $nb_equipe==16){$nb_rencontre_bracket = 7;}
    else if($nb_equipe==24 || $nb_equipe==32){$nb_rencontre_bracket = 15;}   
    
    $phase="F"; // finale
    $id_place=1; // numéro de la rencontre D2 H8 F1

    //création des rencontres
    for($i=1;$i<=$nb_rencontre_bracket;$i++)
    {   
        $place_rencontre=$phase.$id_place;
        $rencontre->setIdTournoi($id_tournoi);
        $rencontre->setPlaceRencontre($place_rencontre); 
        $rencontre->setIdConcurrentA(null);
        $rencontre->setIdConcurrentB(null);
        //change la phase de la rencontre
        if($i==1){$phase="D"; $id_place=0;}
        else if($i==3){$phase="Q"; $id_place=0;}
        else if($i==7){$phase="H"; $id_place=0;}

        $id_place++; 
        
        //ajout d'une rencontre
        $manager_rencontre->addRencontre($rencontre);
    }
}

function creaChampionnatClassement($id_tournoi)
{
    $manager_concurrent = connect('Concurrent');
    $manager_classement = connect('Classement');
    
    $list_concurrent = $manager_concurrent->getListConcurrent($id_tournoi);
    
    foreach($list_concurrent as $value_classement)
    {
        $point=0;
        if($value_classement->getNomConcurrent()=="~~free win~~")
        {
            $point=-4;
        }  
        $classement = new Classement();
        $classement->setIdTournoi($id_tournoi);
        $classement->setIdConcurrent($value_classement->getIdConcurrent());
        $classement->setNumPhase(1);
        $classement->setPoint($point);
        
        //ajoute dans les concurrent dans le classement
        $manager_classement->addClassement($classement);
    } 
}