<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

//------------------------------------------------------------------------------
if (!isset($http_request['act']))
{
    $tab_categories = ArticleBoutiqueCategorieManager::getList();

    $obj_page->setData('categories', $tab_categories);
    $obj_page->setUrlPage('item_boutique/item_boutique');
}

// -----------------------------------------------------------------------------
else if ($http_request['act']=="liste")
{
    if(isset($http_request['itemb_id']) && !empty($http_request['itemb_id']))
    {
       
        $obj_itemb = ArticleBoutiqueManager::get($http_request['itemb_id']);
        if($obj_itemb!=null)
        {
            $tab_items[0]=$obj_itemb;
        }
        else
        {
            setFlashData('message', "L'item '".$http_request['itemb_id']."' n'existe pas");    // renvoie un message d'erreur
            $tab_items=array();
        }
    }
    else if(isset($http_request['itemb_name'])&& !empty($http_request['itemb_name']))
    {
        $tab_items = ArticleBoutiqueManager::getListByNom($http_request['itemb_name']);
        if($tab_items==null)
        {
            setFlashData('message', "Aucun résultat trouvé pour '".$http_request['itemb_name']."'");    // renvoie un message d'erreur
        }
    }
    else if (isset($http_request['itemb_categorie']) && $http_request['itemb_categorie']!= "0")
    {
        $tab_items = ArticleBoutiqueManager::getListByCategorie($http_request['itemb_categorie']);
    }
    else
    {
        $tab_items = ArticleBoutiqueManager::getList();
    }
    $tab_categories = ArticleBoutiqueCategorieManager::getList();

    $obj_page->setData('categories', $tab_categories);
    
    
    $obj_page->setData('items', array_reverse($tab_items));
    $obj_page->setUrlPage('item_boutique/item_boutique_liste');
}

//------------------------------------------------------------------------------
// VUES
//------------------------------------------------------------------------------

// Page d'ajout item de la boutique ----------------------------------------------
else if($http_request['act']=='ajouter')
{
    $tab_unlinked_items = ArticleBoutiqueManager::getUnlinkedItems();
    $obj_page->setData('unlinked_items', $tab_unlinked_items);
    
    $tab_categories = ArticleBoutiqueCategorieManager::getList();
    $obj_page->setData('categories', $tab_categories);
    
    $tab_items= ItemManager::getList();
    $obj_page->setData('items', $tab_items);
    
    $tab_liaison = ArticleBoutiqueLiaisonManager::getList();
    $obj_page->setData('tab_liaison', $tab_liaison);
    
    $obj_page->setUrlPage('item_boutique/item_boutique_ajouter_editer');
}
// Détails d'un objet ----------------------------------------------------------
else if($http_request['act']=='detail')
{
    //Edition d'un objet
    if(isset($http_request['id']) && !empty($http_request['id']))
    {
        $id = intval($http_request['id']);
        $obj_item = ArticleBoutiqueManager::get($id);
        $obj_page->setData('item', $obj_item);
    }
    
    $tab_cat = ArticleBoutiqueCategorieManager::getList();
    $obj_page->setData('categories', $tab_cat);
    
    $tab_liaison = ArticleBoutiqueLiaisonManager::getList();
    $obj_page->setData('tab_liaison', $tab_liaison);
    
    $tab_items = ArticleBoutiqueManager::getList();
    $obj_page->setData('items', array_reverse($tab_items));
    
    $editer=true;
    $obj_page->setData('editer', $editer);
    
    $obj_page->setData('message', getFlashData('message'));
    $obj_page->setUrlPage('item_boutique/item_boutique_ajouter_editer');
}
// Gestion des catégories ------------------------------------------------------
else if($http_request['act']=='listeCategories')
{
    $tab_categories = ArticleBoutiqueCategorieManager::getList('desc', false);
    $obj_page->setData('categories', $tab_categories);
    $obj_page->setUrlPage('item_boutique/item_boutique_liste_categories');
}

//------------------------------------------------------------------------------
else if($http_request['act']=='detailCategorie')
{
    //Edition d'une catégorie
    if(isset($http_request['id']) && !empty($http_request['id']))
    {
        $id = intval($http_request['id']);
        $obj_categorie = ArticleBoutiqueCategorieManager::get($id);
        $obj_page->setData('categorie', $obj_categorie);
    }
    $tab_groupe = ArticleBoutiqueCategorieManager::GetGroupe();
    $obj_page->setData('tab_groupe', $tab_groupe);
    $obj_page->setData('message', getFlashData('message'));
    
    $editercat=true;
    $obj_page->setData('editercat', $editercat);
    
    $obj_page->setUrlPage('item_boutique/item_boutique_ajouter_editer_categorie');
}

//------------------------------------------------------------------------------
else if($http_request['act']=='ajouterCategorie')
{
    $tab_groupe = ArticleBoutiqueCategorieManager::GetGroupe();
    $obj_page->setData('tab_groupe', $tab_groupe);
    $next_id = ArticleBoutiqueCategorieManager::getNextId();
    $obj_page->setData('next_id', $next_id);
    
    $obj_page->setUrlPage('item_boutique/item_boutique_ajouter_editer_categorie');
}

//------------------------------------------------------------------------------
// ACTIONS
//------------------------------------------------------------------------------

// Insertion d'un nouvel item boutique -----------------------------------------
else if($http_request['act']=='insert')
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $coutRubis = isset($http_request['coutRubis']) && $http_request['coutRubis']!= '' && $http_request['coutRubis']!="0" ? $http_request['coutRubis'] : null;
    $coutPieces = isset($http_request['coutPieces']) && $http_request['coutPieces']!= '' && $http_request['coutPieces']!="0" ? $http_request['coutPieces'] : null;
    $dependance = isset($http_request['dependance']) && $http_request['dependance']!= '' && $http_request['dependance']!="0" ? $http_request['dependance'] : null;
    $idCategorie = isset($http_request['idCategorie']) && $http_request['idCategorie']!= '' ? $http_request['idCategorie'] : null;
    $image = isset($http_request['image']) && $http_request['image']!= '' ? $http_request['image'] : null;
    $niveauMini = isset($http_request['niveauMini']) && $http_request['niveauMini']!= '' && $http_request['niveauMini']!="0" ? $http_request['niveauMini'] : null;
    $reputationMini = isset($http_request['reputationMini']) && $http_request['reputationMini']!= '' && $http_request['reputationMini']!="0" ? $http_request['reputationMini'] : null;
    $etoiles = isset($http_request['etoiles']) && $http_request['etoiles']!= '' ? $http_request['etoiles'] : null;
    $id_liaison = isset($http_request['id_liaison']) && $http_request['id_liaison']!= '' && $http_request['id_liaison']!="0" ? $http_request['id_liaison'] : null;
    
    $obj_article = new ArticleBoutique($id);
    $obj_article->setCoutRubis($coutRubis);
    $obj_article->setCoutPieces($coutPieces);
    $obj_article->setDependance($dependance);
    $obj_article->setIdCategorieBoutique($idCategorie);
    $obj_article->setImage($image);
    $obj_article->setNiveauMin($niveauMini);
    $obj_article->setReputationMin($reputationMini);
    $obj_article->setEtoile($etoiles);
    $obj_article->setIdLiaison($id_liaison);
    if(isset($http_request['valideArticle']) && $http_request['valideArticle']=="on") {
        $obj_article->setValideArticle(1);
    } else {
        $obj_article->setValideArticle(0);
    }

    $tab_retour = ArticleBoutiqueManager::insertBdd($obj_article);
    
    switch($tab_retour[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour[1]);
        break;
    }
    
    redirectBacko(6);
}

// mise à jour d'un item de la boutique ----------------------------------------
else if($http_request['act']=='update')
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $coutRubis = isset($http_request['coutRubis']) && $http_request['coutRubis']!= '' ? $http_request['coutRubis'] : null;
    $coutPieces = isset($http_request['coutPieces']) && $http_request['coutPieces']!= '' ? $http_request['coutPieces'] : null;
    $idCategorie = isset($http_request['idCategorie']) && $http_request['idCategorie']!= '' ? $http_request['idCategorie'] : null;
    $image = isset($http_request['image']) && $http_request['image']!= '' ? $http_request['image'] : null;
    $niveauMini = isset($http_request['niveauMini']) && $http_request['niveauMini']!= '' ? $http_request['niveauMini'] : null;
    $reputationMini = isset($http_request['reputationMini']) && $http_request['reputationMini']!= '' ? $http_request['reputationMini'] : null;
    $etoiles = isset($http_request['etoiles']) && $http_request['etoiles']!= '' ? $http_request['etoiles'] : null;
    $id_liaison = isset($http_request['id_liaison']) && $http_request['id_liaison']!= '' ? $http_request['id_liaison'] : null;
    $dependance = isset($http_request['dependance']) && $http_request['dependance']!= '' ? $http_request['dependance'] : null;
    
    $obj_article = new ArticleBoutique($id);
    $obj_article->setIdCategorieBoutique($idCategorie);
    $obj_article->setImage($image);
    $obj_article->setCoutPieces($coutPieces);
    $obj_article->setCoutRubis($coutRubis);
    $obj_article->setNiveauMin($niveauMini);
    $obj_article->setReputationMin($reputationMini);
    $obj_article->setDependance($dependance);
    $obj_article->setEtoile($etoiles);
    $obj_article->setIdLiaison($id_liaison);
    if(isset($http_request['valideArticle']) && $http_request['valideArticle']=="on") {
        $obj_article->setValideArticle(1);
    } else {
        $obj_article->setValideArticle(0);
    }

    $tab_retour = ArticleBoutiqueManager::updateBdd($obj_article);
    if($dependance==0)
    {
       ArticleBoutiqueManager::updateToNullDependanceBdd($id);                  //met le champ dépendance à null
    }
    if($id_liaison==0)
    {
       ArticleBoutiqueManager::updateToNullLiaisonBdd($id);                     //met le champ liaison à null
    }

    
    switch($tab_retour[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Enregistrement effectué de l'élément <a style='color:blue' href=#$id>$id</a>");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour[1]);
        break;
    }
    redirectBacko(6);
}

// Mise à jour d'une catégorie -------------------------------------------------
else if($http_request['act']=='updateCategorie')
{
    foreach($_POST as $key=>$value)
    {
        $$key = $value;
    }
    $ordre = ArticleBoutiqueCategorieManager::getOrdre($groupe);            //récupération de l'ordre en fonction du groupe choisi
    
    $obj_categorie = new ArticleBoutiqueCategorie($id);
    $obj_categorie->setNom($nom);
    $obj_categorie->setDescription($description);
    $obj_categorie->setGroupe($groupe);
    $obj_categorie->setOrdreCat($ordrecat);
    $obj_categorie->setPicto($picto);
    $obj_categorie->setOrdre($ordre);
    if(isset($http_request['valide']) && $http_request['valide']=="on"){
        $obj_categorie->setValide(1);
    } else {
        $obj_categorie->setValide(0);
    }
    
    $tab_retour = ArticleBoutiqueCategorieManager::updateBdd($obj_categorie);
    
    switch($tab_retour[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Modifications effectuées");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour[1]);
        break;
    }
    
    redirectBacko(6, array('act'=>'listeCategories'));
}

// Insertion d'une nouvelle catégorie ------------------------------------------
else if($http_request['act']=='insertCategorie')
{
    foreach($_POST as $key=>$value)
    {
        $$key = $value;
    }
    $obj_ordre = ArticleBoutiqueCategorieManager::getOrdre($groupe);            //récupération de l'ordre en fonction du groupe choisi
    $ordre = $obj_ordre->getOrdre();
    
    $obj_categorie = new ArticleBoutiqueCategorie();
    $obj_categorie->setNom($nom);
    $obj_categorie->setDescription($description);
    $obj_categorie->setGroupe($groupe);
    $obj_categorie->setOrdreCat($ordrecat);
    $obj_categorie->setPicto($picto);
    $obj_categorie->setOrdre($ordre);
    if(isset($http_request['valide']) && $http_request['valide']=="on") {
        $obj_categorie->setValide(1);
    } else {
        $obj_categorie->setValide(0);
    }
    
    $tab_retour = ArticleBoutiqueCategorieManager::insertBdd($obj_categorie);
    
    switch($tab_retour[0])
    {
        case 0: //Succès de la mise à jour
            setFlashData('message', "Ajout effectué");
        break;
        default: //Problème de mise à jour
            setFlashData('message', $tab_retour[1]);
        break;
    }
    
    redirectBacko(6, array('act'=>'listeCategories'));
}

// Insertion d'une nouvelle liaison --------------------------------------------
else if($http_request['act']=='insertLiaison')
{
    foreach($_GET as $key=>$value)
    {
        $$key = $value;
    }
    $obj_liaison = new ArticleBoutiqueLiaison();
    $obj_liaison->setNomLiaison($nom_liaison);

    ArticleBoutiqueLiaisonManager::insertBdd($obj_liaison);
}

// Update du champ valide à partir de la liste----------------------------------
else if($http_request['act']=='updateValideListe')
{
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $obj_article = new ArticleBoutique($id);
    if(isset($http_request['valideArticle']) && $http_request['valideArticle']=="on") {
        $obj_article->setValideArticle(1);
    } else {
        $obj_article->setValideArticle(0);
    }
    ArticleBoutiqueManager::updateBdd($obj_article);
    
}

?>