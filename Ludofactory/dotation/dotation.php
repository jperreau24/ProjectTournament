<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

$obj_page->addJS('backoffice/dotation.js');
if(!isset($http_request['act']))
{
    if(isset($http_request['dota_id']) && !empty($http_request['dota_id']))
    {
        $tab_dota = DotationManager::get($http_request['dota_id']); 
        if($tab_dota==null)
        {
            setFlashData('message', "La dotation '".$http_request['dota_id']."' n'existe pas"); 
        }
    }
    else if (isset($http_request['dota_id_tournois']) && !empty($http_request['dota_id_tournois']))
    {
        $tab_dota = DotationManager::getListByTournoi($http_request['dota_id_tournois']); 
        if($tab_dota==null)
        {
            setFlashData('message', "Aucun résultat trouvé"); 
        }
    }
    else if (isset($http_request['dota_id_item']) && !empty($http_request['dota_id_item']))
    {
        $tab_dota = DotationManager::getListByItem($http_request['dota_id_item']); 
        if($tab_dota==null)
        {
            setFlashData('message', "Aucune dotation avec l'item '".$http_request['dota_id_item']."'"); 
        }
    }
    else if (isset($http_request['dota_all']))
    {
        $tab_dota = DotationManager::getListWithItemTournoi(); 
    }
    else if (isset($http_request['dota_tosc']))
    {
        $tab_dota = DotationManager::getListTournoiSoloOnly(); 
    }
    else if (isset($http_request['dota_toec']))
    {
        $tab_dota = DotationManager::getListTournoiEquipeOnly(); 
    }
    else 
    {
        $tab_dota = DotationManager::getListTournoiSoloEquipe();
    }
    
    $obj_page->setData('tab_dota', $tab_dota);
    
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "classement_dotation")
{
    $tab_classement = DotationManager::getDotaClassement($http_request['id']);
    $obj_page->setData('tab_classement', $tab_classement);
    $obj_page->setData('id', $http_request['id']);
    
    $obj_page->setUrlPage('dotation/dotation_classement');
    $obj_page->setAppelAjax(true);
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "classement_modele")
{
    $tab_classement = DotationModeleManager::getDomoClassement($http_request['id']);
    $verif_modele=true;
    
    $obj_page->setData('tab_classement', $tab_classement);
    $obj_page->setData('modele', $verif_modele);
    $obj_page->setData('id', $http_request['id']);
    
    $obj_page->setUrlPage('dotation/dotation_classement');
    $obj_page->setAppelAjax(true);
}

// -----------------------------------------------------------------------------
else if ($http_request['act'] == 'domo_tabGain_json')
{
    $tab_domc = DotationModeleCritereManager::getList();
    $tab_domc_select=[];
    foreach($tab_domc as $row)
    {
        $tab_domc_select[$row->getId()] = $row->getDescription();
        
    }
    print json_encode($tab_domc_select);
    exit;
}

// -----------------------------------------------------------------------------
else if ($http_request['act'] == 'domo_tabGainSec_json')
{
    $tab_item_type = ItemManager::getByType(6);
    $tab_item_type_select=[];
    $tab_item_type_select[0]= "Aucun" ;
    foreach($tab_item_type as $row)
    {
        $tab_item_type_select[$row->getId()] = $row->getNom();
        
    }
    print json_encode($tab_item_type_select);
    exit;
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "liste_critere")
{
    $tab_domc = DotationModeleCritereManager::getList(); 
    $obj_page->setData('tab_domc', $tab_domc);
    $obj_page->setUrlPage('dotation/dotation_liste_critere');
    
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "liste_modele")
{
    $tab_domo = DotationModeleManager::getList(); 
    $obj_page->setData('tab_domo', $tab_domo);
    $obj_page->setUrlPage('dotation/dotation_liste_modele');  
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "ajouter_critere")
{
    $obj_page->setUrlPage('dotation/dotation_ajouter_editer_critere');
    $max_id = DotationModeleCritereManager::getMaxId()+1;
    $obj_page->setData('max_id', $max_id);
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "editer_critere")
{
    $obj_page->setUrlPage('dotation/dotation_ajouter_editer_critere');
    $domc = DotationModeleCritereManager::get($http_request['id']);
    $editer=true;
    
    $obj_page->setData('domc', $domc);
    $obj_page->setData('id', $http_request['id']);
    $obj_page->setdata('editer', $editer);
    
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "ajouter_modele")
{
    $obj_page->setUrlPage('dotation/dotation_ajouter_editer_modele');
    $max_id = DotationModeleManager::getNextId();
    $tab_domc = DotationModeleCritereManager::getList();
    $tab_item = ItemManager::getByType(6);
    
    $obj_page->setData('max_id', $max_id);
    $obj_page->setData('tab_domc', $tab_domc);
    $obj_page->setData('tab_item', $tab_item);
        
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == "editer_modele")
{
    $obj_page->setUrlPage('dotation/dotation_ajouter_editer_modele');
    $tab_domo = DotationModeleManager::get($http_request['id']);
    $tab_domc = DotationModeleCritereManager::getList();
    $tab_item = ItemManager::getByType(6);
    $editer=true;
    
    $obj_page->setData('tab_domo', $tab_domo);
    $obj_page->setData('tab_domc', $tab_domc);
    $obj_page->setData('tab_item', $tab_item);
    $obj_page->setData('id', $http_request['id']);
    $obj_page->setdata('editer', $editer);
    
}

//------------------------------------------------------------------------------
else if($http_request['act'] == 'update_critere')                                  //Page d'édition
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $description = isset($http_request['description']) && $http_request['description']!= '' ? $http_request['description'] : null;
    $type = isset($http_request['type']) && $http_request['type']!= '' ? $http_request['type'] : null;  
    $data = isset($http_request['data']) && $http_request['data']!= '' ? $http_request['data'] : null;

    $obj_domc = new DotationModeleCritere($id);
    $obj_domc->setDescription($description);
    $obj_domc->setType($type);
    $obj_domc->setData($data);
    
    
    $tab_retout_domc = DotationModeleCritereManager::updateBdd($obj_domc);

    switch($tab_retour_domc[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_domc[1]);
        break;
    }
    redirectBacko(12, array('act' => 'liste_critere'));    
               
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == 'insert_critere')
{
    $description = isset($http_request['description']) && $http_request['description']!= '' ? $http_request['description'] : null;
    $type = isset($http_request['type']) && $http_request['type']!= '' ? $http_request['type'] : null;
   
    if(preg_match('{"type":.+,"min":.+,"max":.+}',$http_request['data']))
    {
        $data_replace = $http_request['data'];
        $data_t = array('{', '}', '"');
        $data_replace = str_replace($data_t, "", $data_replace);

        list($type_t, $min_t, $max_t) = explode(",", $data_replace);

        list($type_data,$type_value) = explode(":", $type_t);
        list($min,$min_value) = explode(":", $min_t);
        list($max,$max_value) = explode(":", $max_t);
        $type_value=intval($type_value);
        $min_value=intval($min_value);
        $max_value=intval($max_value);
        $data= array('type' => $type_value, 'min' => $min_value , 'max' => $max_value);
        
    }
    else {
        $data = isset($http_request['data']) && $http_request['data']!= '' && is_numeric($http_request['data']) ? $http_request['data'] : null;  
        if($data==null)
        {
            setFlashData('message', "Echec de l'ajout");
            redirectBacko(12, array('act' => 'ajouter'));
        }
    }
    
    $obj_domc = new DotationModeleCritere();
    $obj_domc->setDescription($description);
    $obj_domc->setType($type);
    $obj_domc->setData($data);
    
    $tab_retour_domc = DotationModeleCritereManager::insertBdd($obj_domc);
    
    $id=$obj_domc->getId();
    switch($tab_retour_domc[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_domc[1]);
        break;
    }
    redirectBacko(12, array('act' => 'liste_critere'));
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == 'insert_modele')
{
    foreach($_POST as $key=>$value)
    {
        $$key=$value;
    }
    
    for($i=0; $i<=sizeof($_POST)/3-1;$i++)
    {

        $obj_domo = new DotationModele($id);
        $obj_domo->setClassement($http_request['classement-'.$i]);
        $obj_domo->setIdGain($http_request['idgain-'.$i]);
        $obj_domo->setIdGain2($http_request['idgainsec-'.$i]);

        $tab_retour_domo = DotationModeleManager::insertBdd($obj_domo);
    }   
    switch($tab_retour_domo[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_domo[1]);
        break;
    }
    redirectBacko(12, array('act' => 'liste_modele'));    
        
}

// -----------------------------------------------------------------------------
else if($http_request['act'] == 'insert_modele_classement')                     //ajout d'une ligne de classement
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $classement = isset($http_request['classement']) && $http_request['classement']!= '' ? $http_request['classement'] : null;
    
    $obj_domo = new DotationModele($id);
    $obj_domo->setClassement($classement);
    
    DotationModeleManager::insertBdd($obj_domo);
}

//------------------------------------------------------------------------------
else if($http_request['act'] == 'update_modele')                                //liste des modèles
{
        $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
        $classement = isset($http_request['classement']) && $http_request['classement']!= '' ? $http_request['classement'] : null;
        $idgain = isset($http_request['idgain']) && $http_request['idgain']!= '' ? $http_request['idgain'] : null;
        $idgain2 = isset($http_request['idgain2']) && ($http_request['idgain2']!= '' || $http_request['idgain2']==0) ? $http_request['idgain2'] : null;


        $obj_domo = new DotationModele($id);
        $obj_domo->setClassement($classement);
        $obj_domo->setIdGain($idgain);
        if($idgain2=="0")
        {
            DotationModeleManager::updateGainSecBdd($obj_domo,$idgain2);        //pour mettre idGain2 à null
        }
        else
        {
            $obj_domo->setIdGain2($idgain2);
            DotationModeleManager::updateBdd($obj_domo);
        }  
}

//------------------------------------------------------------------------------
else if($http_request['act'] == 'edit_modele')                                  //Page d'édition
{
    foreach($_POST as $key=>$value)
    {
        $$key=$value;
    }    
    
    DotationModeleManager::DeleteBdd($id);                                      //suppression des anciennes lignes
    for($i=0; $i<=sizeof($_POST)/3-1;$i++)
    {
        $obj_domo = new DotationModele($id);
        $obj_domo->setClassement($http_request['classement-'.$i]);
        $obj_domo->setIdGain($http_request['idgain-'.$i]);
        $obj_domo->setIdGain2($http_request['idgainsec-'.$i]);
            
        $tab_retour_domo = DotationModeleManager::insertBdd($obj_domo);         //ajout des nouvelles lignes
    }   

    switch($tab_retour_domo[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_domo[1]);
        break;
    }
    redirectBacko(12, array('act' => 'liste_modele'));    
               
}

//------------------------------------------------------------------------------
else if($http_request['act'] == 'delete_modele')                                //liste des modèles
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $classement = isset($http_request['classement']) && $http_request['classement']!= '' ? $http_request['classement'] : null;
    
    $tab_retour_domo = DotationModeleManager::deleteClassementBdd($id,$classement);
    
     switch($tab_retour_domo[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Suppression effectuée");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_domo[1]);
        break;
    }
}