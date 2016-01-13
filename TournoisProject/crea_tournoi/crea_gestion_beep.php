<?php

function new_place($av_rencontre) //permet de définir la nouvelle position de la rencontre Q4 B ou Q4 A ou D2 A
{
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

    return $tab_positon;
}

function Beep($id_tournoi)
{    
    $manager_concurrent = connect('Concurrent');
    $manager_rencontre = connect('Rencontre');
        
    $tab_r= $manager_rencontre->getListRencontre($id_tournoi);
    $tab_rencontre = array_reverse($tab_r);  //on renverse le tableau pour commencer par les 1ere rencontre et non pas par la final
    foreach($tab_rencontre as $key=>$value)
    {
        $av_rencontre = $manager_rencontre->getByIdRencontre($value->getIdRencontre());
        $av_concurrentA = $manager_concurrent->getByIdConcurrent($av_rencontre['id_concurrent_A']);
        $av_concurrentB = $manager_concurrent->getByIdConcurrent($av_rencontre['id_concurrent_B']);
       
        //mise à jour de la rencontre défini le vainqueur
        $rencontre_up = new Rencontre();
        $rencontre_up->setIdRencontre($value->getIdRencontre());
        
        if($av_concurrentA['nom_concurrent']== "~~free win~~" || $av_concurrentB['nom_concurrent']== "~~free win~~")
        {
            echo "il y a un fantome<br>";
            if($av_concurrentA['nom_concurrent']== "~~free win~~")
            {
                $rencontre_up->setVainqueurRencontre($av_concurrentB['nom_concurrent']);
                $av_rencontre['vainqueur_rencontre'] = $av_concurrentB['nom_concurrent'];
            }
            else if($av_concurrentB['nom_concurrent']== "~~free win~~")
            {
                $rencontre_up->setVainqueurRencontre($av_concurrentA['nom_concurrent']);
                $av_rencontre['vainqueur_rencontre'] = $av_concurrentA['nom_concurrent'];
            }    
        
            echo "Vainqueur :".$rencontre_up->getVainqueurRencontre()."<br><br>";

            //ajoute le vainqueur de la rencontre si il y a un fantome
            $manager_rencontre->updateVainqueurRencontre($rencontre_up);

            //met a jour la prochaine rencontre
            if($av_rencontre['vainqueur_rencontre'] == $av_concurrentA['nom_concurrent'])
            {

                $tab_position = new_place($av_rencontre);
                //recherche l'id de la prochaine rencontre
                $tab_id_rencontre = $manager_rencontre->getByIdTournoiAndPlaceRencontre($id_tournoi, $tab_position['new_position']);

                $new_rencontre = new Rencontre();
                $new_rencontre->setIdRencontre($tab_id_rencontre['id_rencontre']);
                $new_rencontre->setPlaceRencontre($tab_position['new_position']);

                if($tab_position['pos_box'] == "A")
                {
                    $new_rencontre->setIdConcurrentA($av_concurrentA['id_concurrent']);
                }
                else if($tab_position['pos_box'] == "B")
                {
                    $new_rencontre->setIdConcurrentB($av_concurrentA['id_concurrent']);
                }
                echo 'id_new_rencontre : '.$new_rencontre->getIdRencontre()."<br>";
                echo 'place_new_rencontre : '.$new_rencontre->getPlaceRencontre()."<br>";
                echo 'id_concurrent : '.$new_rencontre->getIdConcurrentA().$new_rencontre->getIdConcurrentB()."<br><br>";
                $manager_rencontre->updateNewRencontre($new_rencontre);
            }
            else if ($av_rencontre['vainqueur_rencontre'] == $av_concurrentB['nom_concurrent'])
            {
                $tab_position = new_place($av_rencontre);
                var_dump($tab_position);

                //recherche l'id de la prochaine rencontre
                $tab_id_rencontre = $manager_rencontre->getByIdTournoiAndPlaceRencontre($id_tournoi, $tab_position['new_position']);

                $new_rencontre = new Rencontre();
                $new_rencontre->setIdRencontre($tab_id_rencontre['id_rencontre']);
                $new_rencontre->setPlaceRencontre($tab_position['new_position']);
                if($tab_position['pos_box'] == "A")
                {
                    $new_rencontre->setIdConcurrentA($av_concurrentB['id_concurrent']);
                }
                else if($tab_position['pos_box'] == "B")
                {
                    $new_rencontre->setIdConcurrentB($av_concurrentB['id_concurrent']);
                }
                echo 'id_new_rencontre : '.$new_rencontre->getIdRencontre()."<br>";
                echo 'place_new_rencontre : '.$new_rencontre->getPlaceRencontre()."<br>";
                echo 'id_concurrent : '.$new_rencontre->getIdConcurrentB().$new_rencontre->getIdConcurrentB()."<br><br>";
                $manager_rencontre->updateNewRencontre($new_rencontre);
            }
        }
    }
}