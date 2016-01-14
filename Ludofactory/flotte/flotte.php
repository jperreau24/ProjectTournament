<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

$obj_page->addJS('backoffice/commun.js');
$obj_page->addJS('backoffice/flotte.js');

//------------------------------------------------------------------------------
if (!isset($http_request['act']))
{
    
}

// -----------------------------------------------------------------------------
else if ($http_request['act']=="liste")
{    
     if(isset($http_request['flotte_id']) && !empty($http_request['flotte_id']))
    {
       
        $obj_flotte = FlotteManager::get($http_request['flotte_id']);
        if($obj_flotte!=null)
        {
            $tab_flottes[0]=$obj_flotte;
        }
        else
        {
            setFlashData('message', "La flotte '".$http_request['flotte_id']."' n'existe pas");    // renvoie un message d'erreur
            $tab_flottes=array();
        }
    }
    else if(isset($http_request['flotte_name'])&& !empty($http_request['flotte_name']))
    {
        $tab_flottes = FlotteManager::getListByName($http_request['flotte_name']);
        if($tab_flottes==null)
        {
            setFlashData('message', "Aucun résultat trouvé pour '".$http_request['flotte_name']."'");    // renvoie un message d'erreur
        }
    }
    else if (isset($http_request['flotte_idmemb']) && $http_request['flotte_idmemb']!= null && $http_request['flotte_idmemb']!= "0")
    {
        $obj_flotte = FlotteManager::getByIdMembre($http_request['flotte_idmemb']);
        if($obj_flotte!=null)
        {
            $tab_flottes[0]=$obj_flotte;
        }
        else
        {
            setFlashData('message', "Le membre '".$http_request['flotte_idmemb']."' n'existe pas ou ne fait pas partie d'une flotte");    // renvoie un message d'erreur
            $tab_flottes=array();
        }
        
    }
    else
    {
        $tab_flottes = FlotteManager::getList();
    }    
    if(sizeof($tab_flottes)==1)
    {
        redirectBacko(29, array("act"=> "detail", "id" => $tab_flottes[0]->getId()));
    }
    else
    {
        $obj_page->setData("flottes", $tab_flottes);
        $obj_page->setUrlPage('flotte/flotte_liste');
    }
}

//------------------------------------------------------------------------------
else if($http_request['act']=="detail")
{

    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $obj_flotte = FlotteManager::get($id);
    $obj_page->setData('flotte', $obj_flotte);
    $obj_page->setUrlPage('flotte/flotte_detail');
    
    $tab_devise = FlotteDeviseManager::getList();
    $obj_page->setData('devise', $tab_devise);
    
    $obj_fanion = ItemFlotteManager::get($obj_flotte->getFanion());
    $obj_page->setData('fanion', $obj_fanion);
    
    $tab_membres = FlotteManager::getListMembresByFlotte($id);
    $obj_page->setData('membres', $tab_membres);
    
    $tab_langue = Config::get('tab_lang');
    $obj_page->setData('langue', $tab_langue);    
    
    $tab_reputation = BateauManager::getList();
    $obj_page->setData('reputation', $tab_reputation);
}

//------------------------------------------------------------------------------
else if($http_request['act']=="updateValideListe")
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $tresor = isset($http_request['tresor']) && $http_request['tresor']!= '' ? $http_request['tresor'] : null;
    
    $obj_flotte = new Flotte($id);
    $obj_flotte->setTresor($tresor);
    if(isset($http_request['valide']) && $http_request['valide']=="on") {
        $obj_flotte->setValide(1);
    } else {
        $obj_flotte->setValide(0);
    }
    FlotteManager::updateBdd($obj_flotte);
}

//------------------------------------------------------------------------------
else if($http_request['act']=="update")
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $nom = isset($http_request['nom']) && $http_request['nom']!= '' ? $http_request['nom'] : null;
    $id_amiral = isset($http_request['amiral']) && $http_request['amiral']!= '' ? $http_request['amiral'] : null;
    $devise = isset($http_request['devise']) && $http_request['devise']!= '' ? $http_request['devise'] : null;
    $tresor = isset($http_request['tresor']) && $http_request['tresor']!= '' ? $http_request['tresor'] : null;
    $langue = isset($http_request['langue']) && $http_request['langue']!= '' ? $http_request['langue'] : null;
    $invitation = isset($http_request['invitation']) && $http_request['invitation']!= '' ? $http_request['invitation'] : null;
    $valide = isset($http_request['valide']) && $http_request['valide']!= '' ? $http_request['valide'] : null;
    
    $obj_flotte = new Flotte($id);
    $obj_flotte->setNom($nom);
    $obj_flotte->setAmiral($id_amiral);
    $obj_flotte->setDevise($devise);
    $obj_flotte->setTresor($tresor);
    $obj_flotte->setLangues($langue);
    if($invitation=="on")
    {
        $obj_flotte->setAutorisationInvitationAmi(1);
    }
    else
    {
        $obj_flotte->setAutorisationInvitationAmi(0);
    }
    if($valide=="on")
    {
        $obj_flotte->setValide(1);
    }
    else
    {
        $obj_flotte->setValide(0);
    }
    
    $tab_retour = FlotteManager::updateBdd($obj_flotte);
    
    switch($tab_retour[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour[1]);
        break;
    }
    redirectBacko(29, array("act"=>"liste"));
}

//------------------------------------------------------------------------------
else if($http_request['act']=="liste_items_flotte")
{  
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    
    $obj_flotte = FlotteManager::get($id);
    $obj_page->setData('flotte', $obj_flotte);
 
    $tab_ids= ItemManager::getListIdsByFlotte($id, 'array');
        
        foreach($tab_ids as $row)
        {
            $tab_items[][] = ItemManager::get($row);
        }
        if(!empty($tab_items))
        {
            $obj_page->setData('items', $tab_items);
        }
    
    $obj_page->setAppelAjax(true);
    $obj_page->setUrlPage('flotte/flotte_items');

}

//------------------------------------------------------------------------------
else if($http_request['act']=="ajout_item_flotte")
{
    $id = intval($http_request['id']);
    $id_item = intval($http_request['id_item']);
        
    $tab_item_flotte = ItemManager::getListIdsByFlotte($id, 'array');   
    
    
    if(!is_null($obj_flotte = FlotteManager::get($id)))                         // la flotte doit exister
    {
        $obj_membre = MembreManager::get($obj_flotte->getAmiral());
        if(!is_null($obj_article = ArticleBoutiqueManager::get($id_item)))      //l'item doit exister
        {
            if($obj_article->getType()==7)                                      //l'item doit être de type flotte
            {
                if(in_array($obj_article->getId(), $tab_item_flotte))           //vérifie que la flotte ne possède pas déjà l'item
                {
                    setFlashData('message', "La flotte possède déja l'élément <a style='color:blue' href=#$id_item>$id_item</a>"); 
                }
                else
                { 
                    $obj_flotte->setTotalReputation($obj_flotte->getTotalReputation()+$obj_article->getReputation());
                    FlotteManager::updateBdd($obj_flotte);
                    $tab_article=ArticleBoutiqueManager::getListLiaison($obj_article);
                    foreach($tab_article as $obj_article_temp)
                    {
                        // on note l'achat dans boutique_t
                        if(ItemManager::insertItemFlotte($obj_article_temp->getId(), $obj_flotte->getId(),$obj_membre->getId()))
                        {   
                            if($obj_article_temp->getReputation()>0)
                            {
                                configurerTraduction($obj_membre->getLangue());
                                // Actualité de la flotte
                                $obj_message = new FlotteActualite();
                                $obj_message->setTexte(sprintf(tradTxt("Le Service Client vient d'offrir l'objet &quot;%s&quot; à votre équipe. La réputation de votre équipe augmente de %s."),$obj_article_temp->getNom(),$obj_article_temp->getReputation()));
                                $obj_message->setIdFlotte($obj_flotte->getId());
                                $obj_message->setIdCapitaine($obj_membre->getId());
                                FlotteActualiteManager::insertBdd($obj_message);
                                setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id_item>$id_item</a>");
                            }
                        }
                        else
                        {
                            // problème d'insertion
                            setFlashData('message', "Une erreur est survenue ! merci de réessayer");
                        }
                    }
                } 
            }
            else
            {
                setFlashData('message', "L'élément <a style='color:blue' href=#$id_item>$id_item</a> n'est pas de type flotte");
            }
        }
        else
        {
            setFlashData('message', "L'élément <a style='color:blue' href=#$id_item>$id_item</a> n'existe pas");
        }
    }
    else
    {
        setFlashData('message', "La flotte <a style='color:blue'>$id</a> n'existe pas"); 
    }

        
}

//------------------------------------------------------------------------------
else if($http_request['act']=="actualites")
{
    if(isset($http_request['id']))
    {
        $id = intval($http_request['id']);
        $actualites = FlotteActualiteManager::get($id);
        
        $obj_page->setData('actualites', $actualites);
        $obj_page->setData('id_flotte', $id);
    }
    $obj_page->setAppelAjax(true);
    $obj_page->setUrlPage('flotte/flotte_actualites');
}

//------------------------------------------------------------------------------
else if($http_request['act']=="mur")
{
    if(isset($http_request['id']))
    {
        $id = intval($http_request['id']);
        $tab_mur = FlotteMurManager::getAllListByFlotte($id);
        $obj_page->setData('mur', $tab_mur);
        $obj_page->setData('id_flotte', $id);
    }
    $obj_page->setAppelAjax(true);
    $obj_page->setUrlPage('flotte/flotte_mur');
}

//------------------------------------------------------------------------------
else if($http_request['act']=="updateValideMessageMur")
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $date = isset($http_request['date']) && $http_request['date']!= '' ? $http_request['date'] : null;
    
    $obj_message = new FlotteMur($id);
    $obj_message->setDate($date);
    if(isset($http_request['valide']) && $http_request['valide']=="on") {
        $obj_message->setValide(1);
    } else {
        $obj_message->setValide(0);
    }
    FlotteMurManager::updateBdd($obj_message);  
}



        
        