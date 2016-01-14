<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

// -----------------------------------------------------------------------------
if (!isset($http_request['act']))
{
    $tab_lots = LotGagneManager::getListPasEnvoyes();
    $tab_lots_envoyes = LotGagneManager::getListEnvoyes();   
    $tab_titre= Config::get('titres');
    $obj_page->addJS(array('backoffice/commun.js', 'backoffice/lot.js'));   
}

// -----------------------------------------------------------------------------
else if ($http_request['act'] == 'lot_tab_json')
{
    $tab_itec = LotManager::getList();
    $tab_itec_select=[];
    foreach($tab_itec as $value)
    {
        $tab_itec_select[$value->getId()] = $value->getNom();
        
    }
    print json_encode($tab_itec_select);
    exit;
}

// -----------------------------------------------------------------------------
else if($http_request['act']=='lot_update_field'){
    
    if(isset($http_request['id_lotgagne']) 
            && !empty($http_request['id_lotgagne']) 
            && isset($http_request['id_item'])
            && !empty($http_request['id_item']))
    {
        $obj_lotgagne = new LotGagne($http_request['id_lotgagne']);
        $obj_lotgagne->setIdItem($http_request['id_item']);
        LotGagneManager::updateBdd($obj_lotgagne);
        
        $obj_item = ItemManager::get($http_request['id_item']);
        //exit($obj_item->getNom());
    }
    exit();
}



// -----------------------------------------------------------------------------
else if ($http_request['act'] == 'generer_etiquettes')
{
    loadLibs('tiers/fpdf/FPDF', false);
    setlocale(LC_ALL, 'fr_FR'); // permet de mettre les caractères accentués en majuscule
    $tab_lots = LotGagneManager::getListPasEnvoyes();

    if (isset($http_request['checkbox'])) {
        $tab = explode(",", $http_request['checkbox']);
        foreach ($tab as $key => $value) {
            if ($value != "")
                $tab_checkbox[$key] = $value;
        }
    }


    class PDF extends FPDF {

        function AjouteEtiquette($p, $i, $y, $txt) {
            if ($p == 1) {
                $this->SetY(20 + $y); //ordonnée de l'étiquette gauche
            } else if ($p == 2) {
                $this->SetXY(110, 20 + $y); //abscisse/ordonnée de l'étiquette droite
            }

            $this->SetFont('Times', 'B', 10);
            $this->drawTextBox($txt, 90, 35, 'L', 'M', 0); // crée l'étiquette

            if ($i % 14 == 0) { //ajoute une page après la 10ème étiquette de la page courante
                $this->AddPage();
            }
        }

    }

    $pdf = new PDF();
    $pdf->AddPage();
    $p = 1; // détermine si l'étiquette est à gauche ou à droite de la page : 1 pour la gauche, 2 pour la droite
    $y = -13; // ordonnée des étiquettes
    $i = 1; // numéro de l'étiquette
    $tab_titre= config::get('titres');
    
    
    foreach ($tab_lots as $value) {
    $txt_etiquettes ="" . strtoupper($tab_titre[$value['membre']->getTitre()] .". "  
                        .utf8_decode($value['membre']->GetNom()) . ""
                        . " " . utf8_decode($value['membre']->GetPrenom()) . "\n\n"
                        . "" . utf8_decode($value['membre']->GetAdresse()) . "\n\n"
                        . "" . $value['membre']->GetCodePostal() . ""
                        . " " . utf8_decode($value['membre']->GetVille()) . ""
                        . " (" . utf8_decode($value['membre']->GetPays())) . ")";      //texte à afficher dans l'étiquette
    
        if (!empty($tab_checkbox)) {
            //FPDF utilise utf8_decode() pour gérer les caractères accentués     
            if (in_array($value['lot']->getId(), $tab_checkbox)) {
                $pdf->AjouteEtiquette($p, $i, $y, $txt_etiquettes);

                if ($p == 2) {
                    $y = $y + 40; //mise à jour de l'ordonnée
                    $p = 0;
                }
                if ($i % 14 == 0) {
                    $y = -15; //nouvelle page, ordonnée remis à l'initiale
                }
                $p++;
                $i++;
            }
        } else {
            $pdf->AjouteEtiquette($p, $i, $y, $txt_etiquettes);
            if ($p == 2) {
                $y = $y + 40; //mise à jour de l'ordonnée
                $p = 0;
            }
            if ($i % 14 == 0) {
                $y = -15; //nouvelle page, ordonnée remis à l'initiale
            }
            $p++;
            $i++;
        }
    }
   
    $pdf->Output(); //document terminé : envoyé au navigateur
    exit;
}

// -----------------------------------------------------------------------------
else if ($http_request['act'] == 'valider_lot')
{

    $tab_lots = LotGagneManager::getListPasEnvoyes();
    $tab_lots_envoyes = LotGagneManager::getListEnvoyes();

    if (isset($http_request['valider_lot'])) {
        $tab_checkbox = $http_request['checkbox'];
    }



    if (!empty($tab_checkbox)) {
        foreach ($tab_lots as $value) {
            if (in_array($value['lot']->getId(), $tab_checkbox)) {
                $value['lot']->setEtatEnvoi(2);
                $value['lot']->setDateEnvoi(now());
                LotGagneManager::updateBdd($value['lot']);

                if ($value['lot']->getProvenanceType() == "tournoi_solo") {
                    TournoiSoloManager::updateEnvoie($value['lot']->getIdFk(), 2);
                } else if ($value['lot']->getProvenanceType() == "tournoi_equipe") {
                    TournoiEquipeManager::updateEnvoie($value['lot']->getIdFk(), 2);
                }
            }
        }
    }
    redirectBacko(9);
}

// -----------------------------------------------------------------------------
else
{
    exit;
}