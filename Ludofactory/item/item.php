<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

$obj_page->addJS('backoffice/item.js');

// -----------------------------------------------------------------------------
if (!isset($http_request['act']))
{
    $type_item_c= Config::get('types_items');
    $obj_page->setData('type_item', $type_item_c);
}

//------------------------------------------------------------------------------
// VUES
//------------------------------------------------------------------------------

// Affiche la liste des items --------------------------------------------------
else if($http_request['act']=='liste')
{
    
    if(isset($http_request['item_id']) && !empty($http_request['item_id']))
    {
        $obj_items = ItemManager::get($http_request['item_id']);
        if($obj_items!=null)
        {
            redirectBacko(3, array('act'=>'detail', 'id'=>$obj_items->getId()));  //affiche directement la page d'édition de l'item
        }
        else
        {
            setFlashData('message', "L'item '".$http_request['item_id']."' n'existe pas");    // renvoie un message d'erreur
        }
    }
    else if(isset($http_request['item_nom']) && !empty($http_request['item_nom']))
    {
        $obj_items = ItemManager::getByName($http_request['item_nom']);
        if(sizeof($obj_items)==1)
        {
            redirectBacko(3, array('act'=>'detail', 'id'=>$obj_items[0]->getId()));         //affiche directement la page d'édition de l'item si un seul résultat est retourné
        }
        else if(sizeof($obj_items) == 0)
        {
            setFlashData('message', 'Aucun résultat trouvé pour "'.$http_request['item_nom'].'"');    // renvoie un message d'erreur
        }
    }
    else if(isset($http_request['item_type']) && (!empty($http_request['item_type']) || $http_request['item_type']=="0") && $http_request['item_type']!="aucun")
    {
        $obj_items = ItemManager::getByType($http_request['item_type']);
    }
    else if(isset($http_request['item_ajout_recent']))                          //affiche les X derniers items ajoutés
    {
        if(empty($http_request['item_nb']))
        {
            //valeur pas défaut
            $http_request['item_nb']=30;                                        // nombre d'items à afficher                                                
        }
        $obj_items = ItemManager::getRecentAddition($http_request['item_nb']);
    }
    else
    {
        $obj_items = ItemManager::getList(false);                               //affiche tous les items
    }
    $type_item_c= Config::get('types_items');
    $obj_page->setData('type_item', $type_item_c);
    $obj_page->setData('items', $obj_items);
    $obj_page->setUrlPage('item/item_liste');
}
// Détails d'un objet + édition OU ajout ------------------------------------------------
else if($http_request['act']=='detail')
{
    $obj_page->setUrlPage('item/item_detail');
    //Détails et édition d'un objet
    $type_item_c= Config::get('types_items');
    
    if(isset($http_request['id']) && !empty($http_request['id']))               
    {
        $verif_id=true;     //vérifie si l'id existe (défini si c'est le formulaire d'insert ou d'update)
        $id = intval($http_request['id']);
        
        $tab_item = ItemManager::getWithLotFlotteBateau($id);
        
        foreach($tab_item as $value)
        {
            $obj_page->setData('item', $value['item']);
            $obj_page->setData('item_lot', $value['item_lot']);
            $obj_page->setData('item_flotte', $value['item_flotte']);
            $obj_page->setData('item_bateau', $value['item_bateau']);         
        } 
        $obj_page->setData('verif_id', $verif_id);
        
    }
    else
    {
        $max_id = ItemManager::getMaxItem()+1;                    //permet d'afficher l'id du futur item
        $obj_page->setData('max_id', $max_id);
    }
        $tab_flotte_categorie = ItemFlotteCategorieManager::getList();
        $tab_bateau_categorie = ItemBateauCategorieManager::getList();
        asort($tab_flotte_categorie);
        asort($tab_bateau_categorie);
        
        $obj_page->setData('type_item', $type_item_c);
        $obj_page->setData('tab_flotte_cat', $tab_flotte_categorie);
        $obj_page->setData('tab_bateau_cat', $tab_bateau_categorie);

}

//Détails d'un type ------------------------------------------------------------
else if($http_request['act']=='type_detail')
{
    $type=$http_request['type'];
    if($type==8)                                                                //affichera le formulaire des items lots
    {
        $item_lot = LotManager::get($http_request['id']);
        $obj_page->setData('item', $item_lot);
    }
    else if($type==7 || $type==9)                                               //affichera le formulaire des items flottes
    {
        $item_flotte = ItemFlotteManager::get($http_request['id']);
        $tab_flotte_categorie = ItemFlotteCategorieManager::getList();
        asort($tab_flotte_categorie);
        $obj_page->setData('item', $item_flotte);
        $obj_page->setData('tab_flotte_cat', $tab_flotte_categorie);
        
    }
    else if($type>=10 && $type<=23)                                             //affichera le formulaire des items bateaux
    {
        $item_bateau = ItemBateauManager::get($http_request['id']);
        $tab_bateau_categorie = ItemBateauCategorieManager::getList();
        asort($tab_bateau_categorie);
        $obj_page->setData('item', $item_bateau);
        $obj_page->setData('tab_bateau_cat', $tab_bateau_categorie);
    }
    
    $obj_page->setUrlPage('item/item_type_detail');
    $obj_page->setAppelAjax(true);
        
}

//------------------------------------------------------------------------------
// ACTIONS
//------------------------------------------------------------------------------

// Processus de mise à jour ----------------------------------------------------
else if($http_request['act']=='update')
{    
    foreach($_POST as $key=>$value)
    {
       $$key = $value;
    } 
    
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $nom= isset($http_request['nom']) && $http_request['nom']!= '' ? $http_request['nom'] : null;
    $description = isset($http_request['description']) && $http_request['description']!= '' ? $http_request['description'] : null;
    $valeur = isset($http_request['valeur']) && $http_request['valeur']!= '' ? $http_request['valeur'] : null;
    $valeurBis = isset($http_request['valeurBis']) && $http_request['valeurBis']!= '' ? $http_request['valeurBis'] : null;
    $reputation = isset($http_request['reputation']) && $http_request['reputation']!= '' ? $http_request['reputation'] : null;
    $type = isset($http_request['type']) && $http_request['type']!= '' ? $http_request['type'] : null;
    $image = isset($http_request['image']) && $http_request['image']!= '' ? $http_request['image'] : null;
    $defaut = isset($http_request['defaut']) && $http_request['defaut']!= '' ? $http_request['defaut'] : null;
    $valide = isset($http_request['valide']) && $http_request['valide']!= '' ? $http_request['valide'] : null;
  

    $obj_item = new Item($id);
    if(isset($http_request['edit'])) //si oui, on reçoit les infos de la page d'édition sinon on reçoit les infos de la liste
    {
        $obj_item->setNom($nom);
        $obj_item->setDescription($description);
        $obj_item->setValeur($valeur);
        $obj_item->setValeurBis($valeurBis);
        $obj_item->setReputation($reputation);
        $obj_item->setType($type);
        $obj_item->setImgDot($image);
    }
    if($http_request['defaut']=="on") {
        $obj_item->setParDefaut(1);
    } else if ($http_request['defaut']=="off" || (isset($http_request['edit']) && !isset($http_request['defaut']))) {
        $obj_item->setParDefaut(0);
    }
    if($http_request['valide']=="on") {
        $obj_item->setValide(1);
    } else if ($http_request['valide']=="off" || (isset($http_request['edit']) && !isset($http_request['valide']))){
        $obj_item->setValide(0);
    }
    
    
    if(LotManager::get($id)!=null)                                               //update lot
    {
        $obj_lot = new Lot($id);
        $obj_lot->setPrix($prix);
        if($http_request['valide_lot']=="on") {
            $obj_lot->setValideLot(1);
        } else if ($http_request['valide_lot']=="off" ||
                  (isset($http_request['edit']) && !isset($http_request['valide_lot'])) ||
                  (isset($http_request['edit_type']) && $http_request['edit_type']==8))
        {
            $obj_lot->setValideLot(0);
        }
        $tab_retour_lot = LotManager::updateBdd($obj_lot);
        
        if(isset($http_request['edit_type']))
        {
            switch($tab_retour_lot[0])
            {
                case 0: //Succès de la mise à jour
                    setFlashData('message', "Mise à jour effectuée avec succès !");
                break;
                default: //Problème de mise à jour
                    setFlashData('message', $tab_retour_lot[1]);
                break;
            }
        }
        
    }
    else if($prix!= "" || $http_request['valide_lot']=="on")                                                         //insert lot si n'existe pas
    {
        $obj_lot = new Lot($obj_item->getId());
        $obj_lot->setPrix($prix);
        if($http_request['valide_lot']=="on") {
            $obj_lot->setValideLot(1);
        } else {
            $obj_lot->setValideLot(0);
        }
        $tab_retour_lot = LotManager::insertBdd($obj_lot);
    }
     
    if(ItemFlotteManager::get($id)!=null)                                       //update flotte   
    {
        $obj_flotte = new ItemFlotte($id);   
        $obj_flotte->setImage($imageFlotte);
        $obj_flotte->setImageBis($imageBisFlotte);
        $obj_flotte->setImageVignette($imageVignetteFlotte);
        $obj_flotte->setIdCategorie($flotteCat);
        if($http_request['valide_flotte']=="on") {
            $obj_flotte->setValideFlotte(1);
        } else if ($http_request['valide_flotte']=="off" ||
                  (isset($http_request['edit']) && !isset($http_request['valide_flotte'])) ||
                  (isset($http_request['edit_type']) && ($http_request['edit_type']==7 || $http_request['edit_type']==9)))
        {
            $obj_flotte->setValideFlotte(0);
        }
        $tab_retour_flotte = ItemFlotteManager::updateBdd($obj_flotte);
        
        if(isset($http_request['edit_type']))
        {
            switch($tab_retour_flotte[0])
            {
                case 0: //Succès de la mise à jour
                    setFlashData('message', "Mise à jour effectuée avec succès !");
                break;
                default: //Problème de mise à jour
                    setFlashData('message', $tab_retour_flotte[1]);
                break;
            }
        }
    }
    else if(($imageFlotte!= "" || $imageBisFlotte!="" || $imageVignetteFlotte!="" || $http_request['valide_flotte']=="on"))   //insert flotte  si n'existe pas
    {
        $obj_flotte = new ItemFlotte($obj_item->getId());   
        $obj_flotte->setImage($imageFlotte);
        $obj_flotte->setImageBis($imageBisFlotte);
        $obj_flotte->setImageVignette($imageVignetteFlotte);
        $obj_flotte->setIdCategorie($flotteCat);
        if($http_request['valide_flotte']=="on") {
            $obj_flotte->setValideFlotte(1);
        } else {
            $obj_flotte->setValideFlotte(0);
        }
        $tab_retour_flotte = ItemFlotteManager::insertBdd($obj_flotte);
    }
     
    if(ItemBateauManager::get($id)!=null)                                       //update bateau
    {
        $obj_bateau = new ItemBateau($id);   
        $obj_bateau->setImage($imageBateau);
        $obj_bateau->setImageBis($imageBisBateau);
        $obj_bateau->setImageVignette($imageVignetteBateau);
        $obj_bateau->setIdCategorie($bateauCat);
        if($http_request['valide_bateau']=="on") {
            $obj_bateau->setValideBateau(1);
        } else if ($http_request['valide_bateau']=="off" ||
                  (isset($http_request['edit']) && !isset($http_request['valide_bateau'])) ||
                  (isset($http_request['edit_type']) && ($http_request['edit_type']>=10 && $http_request['edit_type']<=23)))
        {
            $obj_bateau->setValideBateau(0);
        }
        $tab_retour_bateau = ItemBateauManager::updateBdd($obj_bateau);
        if(isset($http_request['edit_type']))
        {
            switch($tab_retour_bateau[0])
            {
                case 0: //Succès de la mise à jour
                    setFlashData('message', "Mise à jour effectuée avec succès !");
                break;
                default: //Problème de mise à jour
                    setFlashData('message', $tab_retour_bateau[1]);
                break;
            }
        }
    }
    else if(($imageBateau!= "" || $imageBisBateau!="" || $imageVignetteBateau!="" || $http_request['valide_bateau']=="on"))   //insert bateau si n'existe pas
    {    
        $obj_bateau = new ItemBateau($obj_item->getId());   
        $obj_bateau->setImage($imageBateau);
        $obj_bateau->setImageBis($imageBisBateau);
        $obj_bateau->setImageVignette($imageVignetteBateau);
        $obj_bateau->setIdCategorie($bateauCat);
        if($http_request['valide_bateau']=="on") {
            $obj_bateau->setValideBateau(1);
        } else {
            $obj_bateau->setValideBateau(0);
        }
        $tab_retour_bateau = ItemBateauManager::insertBdd($obj_bateau);
    }
    
  
    $tab_retour = ItemManager::updateBdd($obj_item);
    
    if (!isset($http_request['edit_type']))
    {
        switch($tab_retour[0])
        {
            case 0: //Succès de la mise à jour
                setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
            break;
            default: //Problème de mise à jour
                setFlashData('message', $tab_retour[1]);
            break;
        }
    }
    redirectBacko(3, array('act'=>'liste', 'item_ajout_recent' => 'on', 'item_nb' => 30));
}


// Insertion d'un nouvel objet -------------------------------------------------
else if($http_request['act']=='insert')
{
    foreach($_POST as $key=>$value)
    {
        $$key = $value;
    }
    
    $obj_item = new Item();
    $obj_item->setNom($nom);
    $obj_item->setDescription($description);
    $obj_item->setValeur($valeur);
    $obj_item->setValeurBis($valeurBis);
    $obj_item->setReputation($reputation);
    $obj_item->setImgDot($image);
    $obj_item->setType($type);
     if($http_request['defaut']=="on") {
        $obj_item->setParDefaut(1);
    } else {
        $obj_item->setParDefaut(0);
    }
    if($http_request['valide']=="on") {
        $obj_item->setValide(1);
    } else {
        $obj_item->setValide(0);
    }
    
    $tab_retour = ItemManager::insertBdd($obj_item);                             //insert item
    
  
    if($prix!= "" || $http_request['valide_lot']=="on")                                                               //insert lot
    {
        $obj_lot = new Lot($obj_item->getId());
        $obj_lot->setPrix($prix);
        if($http_request['valide_lot']=="on") {
            $obj_lot->setValideLot(1);
        } else {
            $obj_lot->setValideLot(0);
        }
        $tab_retour_lot = LotManager::insertBdd($obj_lot);
    }
    
    if(($imageFlotte!= "" || $imageBisFlotte!="" || $imageVignetteFlotte!="" || $http_request['valide_flotte']=="on"))   //insert flotte  
    {
        $obj_flotte = new ItemFlotte($obj_item->getId());   
        $obj_flotte->setImage($imageFlotte);
        $obj_flotte->setImageBis($imageBisFlotte);
        $obj_flotte->setImageVignette($imageVignetteFlotte);
        $obj_flotte->setIdCategorie($flotteCat);
        if($http_request['valide_flotte']=="on") {
            $obj_flotte->setValideFlotte(1);
        } else {
            $obj_flotte->setValideFlotte(0);
        }
        $tab_retour_flotte = ItemFlotteManager::insertBdd($obj_flotte);
    }
    

    if(($imageBateau!= "" || $imageBisBateau!="" || $imageVignetteBateau!="" || $http_request['valide_bateau']=="on"))   //insert bateau
    {    
        $obj_bateau = new ItemBateau($obj_item->getId());   
        $obj_bateau->setImage($imageBateau);
        $obj_bateau->setImageBis($imageBisBateau);
        $obj_bateau->setImageVignette($imageVignetteBateau);
        $obj_bateau->setIdCategorie($bateauCat);
        if($http_request['valide_bateau']=="on") {
            $obj_bateau->setValideBateau(1);
        } else {
            $obj_bateau->setValideBateau(0);
        }
        $tab_retour_bateau = ItemBateauManager::insertBdd($obj_bateau);
    }
   
    $id = $obj_item->getId();
    switch($tab_retour[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour[1]);
        break;
    }
    redirectBacko(3, array('act'=>'liste', 'item_ajout_recent' => 'on', 'item_nb' => 30));
}
     
?>

