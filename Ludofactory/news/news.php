<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

// -----------------------------------------------------------------------------
if (!isset($http_request['act']))
{
    $tab_news= NewsManager::getList();
    foreach($tab_news as $row)                                                  // affichage dans le tableau pour lier tous les articles de toutes les langues à la même news
    {   
        if(!isset($liste_news[$row->getId()][0]))
        {
            $liste_news[$row->getId()]['id']=$row->getId();
            $liste_news[$row->getId()]['intitule']=$row->getIntitule();
            $liste_news[$row->getId()]['date']=$row->getDate();
            $liste_news[$row->getId()]['valide']=$row->getValide();
        }
        $liste_news[$row->getId()][$row->getLangue()][]=$row->getTitre();
        $liste_news[$row->getId()][$row->getLangue()][]=$row->getCorps();
        
        $liste_news[$row->getId()][$row->getLangue()] = array(
            'titre'=>$row->getTitre(),
            'corps'=>$row->getCorps()
        );
    }

    $obj_page->setData('news', $liste_news);
    $tab_langue = Config::get('tab_lang');
    arsort($tab_langue);
    $obj_page->setData('langue', $tab_langue);
    $obj_page->setUrlPage('news/news');
  
}

// Page d'ajout d'une news -----------------------------------------------------
else if($http_request['act']=='ajouter')
{
   $tab_langue = Config::get('tab_lang');
   $obj_page->setData('langue', $tab_langue);
   
   $obj_page->setUrlPage('news/news_ajouter_editer');
}

// Page d'édition d'une news ---------------------------------------------------
else if($http_request['act']=='detail')
{
   $tab_news = NewsManager::get($http_request['id']);
   $obj_page->setData('news', $tab_news);
   
   $obj_page->setData('date_a', substr($tab_news[0]->getDate(),0,10));  
   $obj_page->setData('heure_a', substr($tab_news[0]->getDate(),11,2));
   $obj_page->setData('minute_a', substr($tab_news[0]->getDate(),14,2));
   
   $editer=true;
   $obj_page->setData('editer', $editer);
   
   $tab_langue = Config::get('tab_lang');
   $obj_page->setData('langue', $tab_langue);
   
   $obj_page->setUrlPage('news/news_ajouter_editer');
}

// insertion d'une news -----------------------------------------------------
else if($http_request['act']=='insert')
{    
   $intitule = isset($http_request['intitule']) && $http_request['intitule']!= '' ? $http_request['intitule'] : null;
   $date_a = isset($http_request['date_a']) && $http_request['date_a']!= '' ? $http_request['date_a'] : null;
   $heure_a = isset($http_request['heure_a']) && $http_request['heure_a']!= '' ? $http_request['heure_a'] : null;
   $minute_a = isset($http_request['minute_a']) && $http_request['minute_a']!= '' ? $http_request['minute_a'] : null;
   $valide_news = isset($http_request['valide_news']) && $http_request['valide_news']!= '' ? $http_request['valide_news'] : null;
   
   
   $date_affichage= $date_a." ".$heure_a.":".$minute_a.":00";
   
   $obj_news = new News();
   $obj_news->setIntitule($intitule);
   $obj_news->setDate($date_affichage);
   if($valide_news=="on")
   {
       $obj_news->setValide(1);
   }
   else
   {
       $obj_news->setValide(0);
   }
   
   //insert dans T_News
   $tab_retour_news = NewsManager::insertNewsBDD($obj_news);
   
   $id = NewsManager::getIdNews();                                              //récupération de l'id du dernier insert
   $obj_news->setId($id);
   
   $tab_langue = Config::get('tab_lang');                                       
    
    foreach($tab_langue as $row)
    {
        if(isset($http_request['titre'.$row]) && isset($http_request['corps'.$row]))
        {
            $http_request['titre'.$row] = isset($http_request['titre'.$row]) && $http_request['titre'.$row]!= '' ? $http_request['titre'.$row] : null;
            $http_request['corps'.$row] = isset($http_request['corps'.$row]) && $http_request['corps'.$row]!= '' ? $http_request['corps'.$row] : null;
            
            $obj_news->setLangue($row);
            $obj_news->setTitre($http_request['titre'.$row]);
            $obj_news->setCorps($http_request['corps'.$row]);
            
            //insert dans T_NewsTextes
            $tab_retour_netx = NewsManager::insertNewsTextesBDD($obj_news);
        }
    }
    switch($tab_retour_news[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_news[1]);
        break;
    }
    
    redirectBacko(10);
}

// update d'une news -----------------------------------------------------
else if($http_request['act']=='update')
{   
   $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
   $intitule = isset($http_request['intitule']) && $http_request['intitule']!= '' ? $http_request['intitule'] : null;
   $date_a = isset($http_request['date_a']) && $http_request['date_a']!= '' ? $http_request['date_a'] : null;
   $heure_a = isset($http_request['heure_a']) && $http_request['heure_a']!= '' ? $http_request['heure_a'] : null;
   $minute_a = isset($http_request['minute_a']) && $http_request['minute_a']!= '' ? $http_request['minute_a'] : null;
   $valide_news = isset($http_request['valide_news']) && $http_request['valide_news']!= '' ? $http_request['valide_news'] : null;
   
   
   $date_affichage= $date_a." ".$heure_a.":".$minute_a.":00";
   
   $obj_news = new News($id);
   $obj_news->setIntitule($intitule);
   $obj_news->setDate($date_affichage);
   if($valide_news=="on")
   {
       $obj_news->setValide(1);
   }
   else
   {
       $obj_news->setValide(0);
   }
   
   //update de T_News
   $tab_retour_news = NewsManager::updateNewsBDD($obj_news);   
   NewsManager::deleteNetxBdd($id);                                             //delete des lignes T_NewsTextes correspondant à l'id
   $tab_langue = Config::get('tab_lang');                                       
    
    foreach($tab_langue as $row)
    {
        if(isset($http_request['titre'.$row]) && isset($http_request['corps'.$row]))
        {
            $http_request['titre'.$row] = isset($http_request['titre'.$row]) && $http_request['titre'.$row]!= '' ? $http_request['titre'.$row] : null;
            $http_request['corps'.$row] = isset($http_request['corps'.$row]) && $http_request['corps'.$row]!= '' ? $http_request['corps'.$row] : null;
            
            $obj_news->setLangue($row);
            $obj_news->setTitre($http_request['titre'.$row]);
            $obj_news->setCorps($http_request['corps'.$row]);
            
            //insertion des nouvelles lignes de T_NewsTextes
            $tab_retour_netx = NewsManager::insertNewsTextesBDD($obj_news);
        }
    }
    switch($tab_retour_news[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour_news[1]);
        break;
    }
    
    redirectBacko(10);
}

// Update du champ valide à partir de la liste----------------------------------
else if($http_request['act']=='updateValideListe')
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $obj_news = new News($id);
    if(isset($http_request['valideNews']) && $http_request['valideNews']=="on") {
        $obj_news->setValide(1);
    } else {
        $obj_news->setValide(0);
    }
    echo $id;
    NewsManager::updateNewsBDD($obj_news);
    
}