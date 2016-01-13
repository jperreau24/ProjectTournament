<?php
include('../Classe/TournoiManager.php');
include('../Classe/ConcurrentManager.php');
include('../Classe/RencontreManager.php');
include('../Classe/SportManager.php');
include('../Classe/SupporterManager.php');
include('../Classe/ArbitreManager.php');
include('../Classe/ClassementManager.php');
include('../Classe/Tournoi.php');
include('../ConnectBDD.php');
include('crea_arbitre.php');
include('crea_gestion_beep.php');
include('crea_championnat.php');


session_start();
if (!isset($_REQUEST['act']))
{
    $manager_sport = connect('Sport');
    
    $tab_sport = $manager_sport->getListSport();

    $_SESSION['sport'] = $tab_sport;
    header('Location: crea_tournoi_vue.php');
}

/*********************************************************/
else if ($_REQUEST['act'] == 'valide_tournoi_caracteristique')
{
      
    $nom_tournoi = isset($_REQUEST['nom_tournoi']) && $_REQUEST['nom_tournoi']!= '' ? $_REQUEST['nom_tournoi'] : null;
    $type_sport = isset($_REQUEST['type_sport']) && $_REQUEST['type_sport']!= '' ? $_REQUEST['type_sport'] : null;
    $type_tournoi = isset($_REQUEST['type_tournoi']) && $_REQUEST['type_tournoi']!= '' ? $_REQUEST['type_tournoi'] : null;
    $nb_concurrent = isset($_REQUEST['nb_concurrent']) && $_REQUEST['nb_concurrent']!= '' ? $_REQUEST['nb_concurrent'] : null;
    $presence_arbitre = isset($_REQUEST['presence_arbitre']) && $_REQUEST['presence_arbitre']!= '' ? $_REQUEST['presence_arbitre'] : null;
    $random = isset($_REQUEST['random']) && $_REQUEST['random']!= '' ? $_REQUEST['random'] : null;
    $nb_arbitre = isset($_REQUEST['nb_arbitre']) && $_REQUEST['nb_arbitre']!= '' ? $_REQUEST['nb_arbitre'] : null;
    
    $_SESSION["nom_tournoi"]=$nom_tournoi;
    $_SESSION["type_sport"]=$type_sport;
    $_SESSION["type_tournoi"]=$type_tournoi;
    $_SESSION["nb_concurrent"]=$nb_concurrent;
    
    if($random=="oui")
    {
        $_SESSION["random"]=$random;  
    }
    if($presence_arbitre == "oui")
    {
        $_SESSION['presence_arbitre']=$presence_arbitre;
        $_SESSION["nb_arbitre"]=$nb_arbitre;
    }
    
    header('Location: crea_tournoi_concurrent_vue.php?nb='.$nb_concurrent);
 }
 
 /**********************************************************/
 else if ($_REQUEST['act'] == 'valide_tournoi_concurrent')
 {
     $_SESSION['crea_tournoi_tab_concurrent'] = $_REQUEST; 
     if(isset($_SESSION['presence_arbitre']))
     {
         header('Location: crea_tournoi_arbitre_vue.php?nb_arbitre='.$_SESSION['nb_arbitre']);
     }
     else
     {
         header('Location: crea_tournoi.php?act=valide_tournoi');
     }
     
 }
 
 /**********************************************************/
 else if ($_REQUEST['act'] == 'valide_arbitre')
 {
     //vérifie si les arbitre existe dans la table supporter
      $manager_supporter = connect('Supporter');
      $tab_verif_arbitre = $_GET;
      array_splice($tab_verif_arbitre, 0,1);
      for($i=1 ; $i<=count($tab_verif_arbitre)/2 ; $i++)
      {
          $verif_login = $tab_verif_arbitre['nom_arbitre_'.$i];
          $verif_mail = $tab_verif_arbitre['mail_arbitre_'.$i];

          $verif = $manager_supporter->getUserByLoginByMail($verif_login,$verif_mail);
          if($verif == "")
          {
              echo "Vérifiez le login et l'adresse email de l'arbitre ".$i."#<br>";
          }
      }
      
 }
 
 /**********************************************************/
 else if ($_REQUEST['act'] == 'valide_tournoi')
 {
    $manager_tournoi = connect('Tournoi');
    $manager_concurrent = connect('Concurrent');
    $manager_rencontre = connect('Rencontre');
    
    $tab_arbitre = $_REQUEST;
    $crea_tournoi_tab_concurrent = $_SESSION['crea_tournoi_tab_concurrent'];
    unset($_SESSION['crea_tournoi_tab_concurrent']);
    
    //mélanger le tableau
    array_splice($crea_tournoi_tab_concurrent, 0,1);        //on enléve le "act"
    foreach($crea_tournoi_tab_concurrent as $key=>$value)
    {
        $tab_c[]=$value;
    }
    
    if(isset($_SESSION['random']))
    {
        shuffle($tab_c);
        unset($_SESSION['random']);
    }

    /*************Tournoi******************
     ***********************************/
    
    $tournoi = new Tournoi();
    $tournoi->setIdOrganisateur($_SESSION["id_supporter"]);
    $tournoi->setNomTournoi($_SESSION["nom_tournoi"]);
    $tournoi->setSport($_SESSION["type_sport"]);
    $tournoi->setNbEquipe($_SESSION["nb_concurrent"]);
    $tournoi->setTypeTournoi($_SESSION["type_tournoi"]); 
    
    //ajout du tournoi
    $manager_tournoi->addTournoi($tournoi);
    
    /*************Concurrent******************
     ***********************************/
    
    $id_tournoi = $manager_tournoi->getLastId();
    $concurrent = new Concurrent();
    for($i=1; $i<=$tournoi->getNbEquipe();$i++)
    {
        $nom_concurrent = isset($crea_tournoi_tab_concurrent['nom_concurrent_'.$i]) && $crea_tournoi_tab_concurrent['nom_concurrent_'.$i]!= '' ? $crea_tournoi_tab_concurrent['nom_concurrent_'.$i] : null; 
        $concurrent->setIdTournoi($id_tournoi);
        $concurrent->setNomConcurrent($nom_concurrent);
        $concurrent->setNbConcurrent(1);

        //ajout des concurrents
        $manager_concurrent->addConcurrent($concurrent);
    }
    
    /******************************************
     *****************************************/
    if($_SESSION['type_tournoi'] == "elimination_directe")
    {
        //Si besoin d'un ou plusieurs fantomes :
        if($tournoi->getNbEquipe()!=2 || $tournoi->getNbEquipe()!=4 || $tournoi->getNbEquipe()!=8|| $tournoi->getNbEquipe()!=16)
        {
            if($tournoi->getNbEquipe()<=2){$nb_fantome= 2-$tournoi->getNbEquipe();}
            else if($tournoi->getNbEquipe()<=4){$nb_fantome= 4-$tournoi->getNbEquipe();}
            else if($tournoi->getNbEquipe()<=8){$nb_fantome= 8-$tournoi->getNbEquipe();}
            else if($tournoi->getNbEquipe()<=16){$nb_fantome= 16-$tournoi->getNbEquipe();}

            for($i=1; $i<=$nb_fantome; $i++)
            {
                $concurrent->setIdTournoi($id_tournoi);
                $concurrent->setNomConcurrent("~~free win~~");
                $concurrent->setNbConcurrent(1);
                $tab_fantome[] = $concurrent->getNomConcurrent();
                $manager_concurrent->addConcurrent($concurrent);
            }
            //fusion des 2 tableaux fantome et real concurrent
            $tab_co = array_reverse($tab_c);
            $x=0;
            foreach($tab_co as $value_concurrent)
            {
                if($x<$nb_fantome)
                {   
                    $tab_con[] = $tab_fantome[$x];
                    $x++;
                }
                $tab_con[] = $value_concurrent;
            }
            $tab_concurrent = array_reverse($tab_con);
        }
        //$tab_concurrent contient que les nom des concurrents
    }
    else if($_SESSION['type_tournoi'] == "championnat") // gestion fantome pour un championnat
    {
        $tab_fantome_championnat = creaChampionnatFantome($id_tournoi, $tab_c, $tournoi, $concurrent);
        $nb_fantome = $tab_fantome_championnat['nb_fantome'];
        $tab_concurrent = $tab_fantome_championnat['tab_concurrent'];
    }
    /*************Rencontre******************
     ***********************************/
    
    $rencontre = new Rencontre();
    
    if(isset($nb_fantome))
    {$nb_equipe = $nb_fantome + $tournoi->getNbEquipe();}
    else 
    {$nb_equipe = $tournoi->getNbEquipe();}
    
    //calcul du nombre de rencontre total
    if($_SESSION['type_tournoi'] == "elimination_directe")
    {
        if($nb_equipe==2)
        {$nb_rencontre=($nb_equipe/2);}
        else if($nb_equipe==4)
        {$nb_rencontre=(($nb_equipe/2)+($nb_equipe/4));}
        else if($nb_equipe==8)
        {$nb_rencontre=(($nb_equipe/2)+($nb_equipe/4)+($nb_equipe/8));}
        else if($nb_equipe==16)
        {$nb_rencontre=(($nb_equipe/2)+($nb_equipe/4)+($nb_equipe/8)+($nb_equipe/16));}
    }
    else if($_SESSION['type_tournoi'] == "championnat")
    {
        $nb_rencontre = creaChampionnatNbRencontre($nb_equipe);
    }
    //le nb d'équipe est bonne et le nb de concurrent aussi (fantome compris)
    
    if($_SESSION['type_tournoi'] == "elimination_directe")
    {
        $phase="F"; // finale
        $id_place=1; // numéro de la rencontre D2 H8 F1
        $id=0;  //numéro de tournoi de la table concurrent array(0=>team_1,1=>team_2, etc...)7
        //création des rencontres
        for($i=1;$i<=$nb_rencontre;$i++)
        {   
            $place_rencontre=$phase.$id_place;
            $rencontre->setIdTournoi($id_tournoi);
            $rencontre->setPlaceRencontre($place_rencontre);  


                if($phase=="F" && $nb_equipe==2)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1];  
                    $id=$id+2;
                }
                else if($phase=="D" && $nb_equipe>2 && $nb_equipe<=4)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1];    
                    $id=$id+2;
                }
                else if($phase=="Q" && $nb_equipe>4 && $nb_equipe<=8)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1];  
                    $id=$id+2;
                }
                else if($phase=="H" && $nb_equipe>8)
                {
                    $nom_concurrent_A = $tab_concurrent[$id];
                    $nom_concurrent_B = $tab_concurrent[$id+1]; 
                    $id=$id+2;
                }

            //si la rencontre n'es pas compléte
            if(!isset($nom_concurrent_A)){$nom_concurrent_A="-";} 
            if(!isset($nom_concurrent_B)){$nom_concurrent_B="-";}

            $tab_concurrent_A = $manager_concurrent->getByNomConcurrentByIdTournoi($id_tournoi,$nom_concurrent_A);
            $tab_concurrent_B = $manager_concurrent->getByNomConcurrentByIdTournoi($id_tournoi,$nom_concurrent_B);

            $id_concurrent_A = $tab_concurrent_A['id_concurrent'];
            $id_concurrent_B = $tab_concurrent_B['id_concurrent'];

            $rencontre->setIdConcurrentA($id_concurrent_A);
            $rencontre->setIdConcurrentB($id_concurrent_B);

            //change la phase de la rencontre
            if($i==1){$phase="D"; $id_place=0;}
            else if($i==3){$phase="Q"; $id_place=0;}
            else if($i==7){$phase="H"; $id_place=0;}

            $id_place++; 
            //ajout d'une rencontre
            $manager_rencontre->addRencontre($rencontre); 
        }
    }
    else if($_SESSION['type_tournoi'] == "championnat")
    {
        creaChampionnatRencontre($id_tournoi, $nb_equipe, $nb_rencontre, $tab_concurrent, $rencontre);
        creaChampionnatClassement($id_tournoi);
        creaChampionnatBracket($id_tournoi, $nb_equipe, $rencontre);
    }
    if(isset($_SESSION['nb_arbitre']) && isset($_SESSION['presence_arbitre']))
    {
        CreaArbitre($id_tournoi,$tab_arbitre, $_SESSION['nb_arbitre']);
    }
    Beep($id_tournoi);
    
    unset($_SESSION["nom_tournoi"]);
    unset($_SESSION["type_sport"]);
    unset($_SESSION["type_tournoi"]);
    unset($_SESSION["nb_concurrent"]);
    unset($_SESSION['nb_arbitre']);
    unset($_SESSION['presence_arbitre']);
    
    header('Location: ../tournoi/tournoi.php?id_tournoi='.$id_tournoi);
 }