<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

$obj_page->addCSS('backoffice/tournoi.css');
$obj_page->addJS('backoffice/tournoi.js');

if(!isset($http_request['act']))
{
  exit;  
}
// -----------------------------------------------------------------------------
if ($http_request['act'] == 'listing_en_cours')
{
	// tournois en cours
	$tab_tournois_solo = TournoiSoloManager::getListEnCoursWithDotation();
	$tab_tournois_equipe = TournoiEquipeManager::getListEnCoursWithDotation();
	
	//Stats Tournois
	foreach ($tab_tournois_equipe as $idTournois => $datas )
	{
		$tab_tournois_equipe[$idTournois]['stats']['nb_participants'] = TournoiEquipeManager::getNbParticipants($idTournois);
		$tab_tournois_equipe[$idTournois]['stats']['ca'] = TournoiEquipeManager::getCAParticipants($idTournois);
	}

	foreach ($tab_tournois_solo as $idTournois => $datas )
	{
		$tab_tournois_solo[$idTournois]['stats']['nb_participants'] = TournoiSoloManager::getNbParticipants($idTournois);
		$tab_tournois_solo[$idTournois]['stats']['ca'] = TournoiSoloManager::getCAParticipants($idTournois);
	}

	$obj_page->setData('tab_tournois_solo', $tab_tournois_solo);
	$obj_page->setData('tab_tournois_equipe', $tab_tournois_equipe);
        $obj_page->setUrlPage('tournois/tournois_listing');
    
}

// -----------------------------------------------------------------------------
else if ($http_request['act'] == 'classement_details')
{
    switch($http_request['type'])
    {
        case 'solo':
            $tab_classement_general = TournoiSoloManager::getClassement($http_request['tournoi']);            
        break;
        case 'equipe':
            $tab_classement_general = TournoiEquipeManager::getClassement($http_request['tournoi']);
        break;
    }

        $obj_page->setData('classement', $tab_classement_general);
        $obj_page->setData('type', $http_request['type']);
        $obj_page->setAppelAjax(true);
        $obj_page->setUrlPage('tournois/tournois_classement_details');
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == 'historique_tournois')
{

    switch($http_request['type'])
    {
        case 'solo':
            $tab_tournois = TournoiSoloManager::getListDerniersTermines(10);           
        break;
        case 'equipe':
            $tab_tournois = TournoiEquipeManager::getListDerniersTermines(10);
        break;
    }


    $tab_tournois_termines = array();
    foreach($tab_tournois as $obj_tournoi)
    {
        $tab_dotation = ItemManager::getListByDotation($obj_tournoi->getIdDotation());
        $tab_tournois_termines[] = array(
            'tournoi' => $obj_tournoi,
            'dotation' => $tab_dotation,
            'nb_participants' => ($http_request['type']=='solo') ? TournoiSoloManager::getNbParticipants($obj_tournoi->getId()) : TournoiEquipeManager::getNbParticipants($obj_tournoi->getId()) ,
            'ca' => ($http_request['type']=='solo') ? TournoiSoloManager::getCAParticipants($obj_tournoi->getId()) : TournoiEquipeManager::getCAParticipants($obj_tournoi->getId())
        );
    }

    $obj_page->setData('type', $http_request['type']);
    $obj_page->setData('historique', $tab_tournois_termines);
    $obj_page->setAppelAjax(true);
    $obj_page->setUrlPage('tournois/tournoi_historique');
      
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == 'tournois_details')
{
     $obj_page->setUrlPage('tournois/tournois_details');
     
      switch($http_request['type'])
    {
        case 'solo':
            $obj_tournois = TournoiSoloManager::get($http_request['id_tournois']);           
        break;
        case 'equipe':
            $obj_tournois = TournoiEquipeManager::get($http_request['id_tournois']);
        break;
    }
    
    $tab_dotation_modele = DotationModeleManager::getListWithCritere();
    
    $obj_page->setData('date_fin_tournoi', substr($obj_tournois->getFin(),0,10));  
    $obj_page->setData('heure_tournoi', substr($obj_tournois->getFin(),11,2));
    $obj_page->setData('minute_tournoi', substr($obj_tournois->getFin(),14,2));
    $obj_page->setData('seconde_tournoi', substr($obj_tournois->getFin(),17,2));
            
    $obj_page->setData('tournois', $obj_tournois);
    
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == 'update_tournois')
{
    //vérification des valeurs reçues
    $id_tournoi = isset($http_request['id_tournoi']) && $http_request['id_tournoi']!= '' ? $http_request['id_tournoi'] : null;
    $domo = isset($http_request['domo']) && $http_request['domo']!= '' ? $http_request['domo'] : null;
    $reputation_min = isset($http_request['reputation_min']) && $http_request['reputation_min']!= '' ? $http_request['reputation_min'] : null;
    $cout_energie = isset($http_request['cout_energie']) && $http_request['cout_energie']!= '' ? $http_request['cout_energie'] : null;
    $date_t = isset($http_request['date_fin_tournoi']) && $http_request['date_fin_tournoi']!= '' ? $http_request['date_fin_tournoi'] : null;
    $heure_t = isset($http_request['heure_tournoi']) && $http_request['heure_tournoi']!= '' ? $http_request['heure_tournoi'] : null;
    $minute_t = isset($http_request['minute_tournoi']) && $http_request['minute_tournoi']!= '' ? $http_request['minute_tournoi'] : null;
    $seconde_t = isset($http_request['seconde_tournoi']) && $http_request['seconde_tournoi']!= '' ? $http_request['seconde_tournoi'] : null;
    $type = isset($http_request['type']) && $http_request['type']!= '' ? $http_request['type'] : null;
    $duree = isset($http_request['duree']) && $http_request['duree']!= '' ? $http_request['duree'] : null;
    $valide_t = isset($http_request['valide_tournois']) && $http_request['valide_tournois']!= '' ? $http_request['valide_tournois'] : null;

    
    $datefin= $date_t." ".$heure_t.":".$minute_t.":".$seconde_t;
    
    $valide_tournois = ($valide_t=="on" || $valide_t==1) ? 1 : 0;//valide_t varie selon la page précédente : tournois_details_vue (on/off), tournoi_historique_vue(0/1) 
        
    $obj_maj_tournois = new Tournoi($id_tournoi);
    $obj_maj_tournois->setIdDotationModele($domo);
    $obj_maj_tournois->setReputationMin($reputation_min);
    $obj_maj_tournois->setCoutEnergie($cout_energie);
    $obj_maj_tournois->setFin($datefin);
    $obj_maj_tournois->setType($type);
    $obj_maj_tournois->setDuree($duree);
    $obj_maj_tournois->setValide($valide_tournois);
  
    switch($http_request['type_tournoi']) //update des champs
    {
        case 'solo':
            TournoiSoloManager::updateBdd($obj_maj_tournois);
        break;
        case 'equipe':
            TournoiEquipeManager::updateBdd($obj_maj_tournois);
        break;
    } 
    redirectBacko(25, array('act'=>'listing_en_cours'));
}