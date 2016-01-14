<?php
if (!defined('LUDOFACTORY')) exit('appel direct non autorisé');

$obj_page->addJS('backoffice/commun.js');
$obj_page->addJS('backoffice/highcharts.js');
$obj_page->addJS('backoffice/modules/exporting.js');
$obj_page->addJS('backoffice/themes/ludo.js');

// -----------------------------------------------------------------------------
if (!isset($http_request['act']))
{
    $obj_page->addJS('backoffice/service_client.js');
    $obj_page->setUrlPage('service_client/service_client');
}

// -----------------------------------------------------------------------------
else if($http_request['act']=='detail')
{
    if(isset($http_request['id']) && !empty($http_request['id']))
    {
        $id = intval($http_request['id']);
        $obj_question = ServiceClientManager::get($id);
        $obj_page->setData('question', $obj_question);
        $tab_sujets = ServiceClientManager::getSujets();
        $sujet = $tab_sujets[$obj_question->getSujet()-1];
        $obj_page->setData('sujet', $sujet);
        $obj_page->setData('sujet_reponse', 'Tooki Island - '.$sujet);
    }
    $obj_page->setData('message', getFlashData('message'));
    $obj_page->setUrlPage('service_client/service_client_detail');
}

// -----------------------------------------------------------------------------
else if($http_request['act']=='repondre')
{
    if(isset($http_request['id']) && !empty($http_request['id']))
    {
        $id = intval($http_request['id']);
        if(isset($http_request['reponse']) && !empty($http_request['reponse'])
                && isset($http_request['sujet_reponse']) && !empty($http_request['sujet_reponse']))
        {

            $reponse = $http_request['reponse'];
            $sujet_reponse = $http_request['sujet_reponse'];
            if(!is_null($obj_question = ServiceClientManager::get($id))) // ou new ServiceClient(), mais besoin des info plus bas
            {
                $obj_question->setDateReponse(now());
                $obj_question->setReponse($reponse);
                $tab_retour = ServiceClientManager::updateBdd($obj_question);
                if(!$tab_retour[0])
                {
                    /* TRADUCTION ************/
                    $obj_membre = MembreManager::get($obj_question->getIdMembre());
                    configurerTraduction($obj_membre->getLangue(), '../');
//                    if(!in_array($obj_membre->getLangue(), Config::get('tab_lang'))) {
//                        $lang = Config::get('lang_defaut');
//                    } else {
//                        $lang = $obj_membre->getLangue();
//                    }
//                    define('LANG_APP', $lang);
//                    require_once Config::get('fichier_langue');
                    /*************************/
                    
                    $obj_message = new MessageCompte();
                    $contenu = tradTxt("Votre question :").' '.$obj_question->getQuestion();
                    $contenu.= ' <br/><br/> '.tradTxt("Notre réponse :").' '.nl2br($reponse);
                    $obj_message->setContenu($contenu);
                    //$obj_message->setDateEnvoi($date); // défini dans l'insert
                    $obj_message->setIdMembre($obj_question->getIdMembre());
                    $sujet = tradTxt("Réponse à votre question du").' '.formaterDate($obj_question->getDate());
                    $obj_message->setSujet($sujet);
                    $obj_message->setValide(1);
                    $tab_retour = MessageCompteManager::insertBdd($obj_message);
                    
                    // envoi également d'un email
                    
                    loadLibs('mail');
                    $reponse_email = tradTxt("Bonjour") . ' ' . $obj_membre->getPrenom() . ', ' . "\r\n\r\n";
                    $reponse_email.= tradTxt("Vous recevez ce mail car vous avez posé une question à notre service client.") . "\r\n\r\n";
                    $reponse_email.= '1)' . tradTxt("Votre question") . "\r\n\r\n";
                    $reponse_email.= $obj_question->getQuestion() . "\r\n\r\n";
                    $reponse_email.= '2)' . tradTxt("Notre réponse") . "\r\n\r\n";
                    $reponse_email.= $reponse . "\r\n\r\n";
                    $reponse_email.= tradTxt("Avons-nous répondu à votre question ? N'hésitez pas à nous écrire si vous rencontrez d'autres problèmes ou si vous souhaitez nous faire part d'améliorations que nous pouvons apporter à notre application.") . "\r\n\r\n";
                    $reponse_email.= tradTxt("Bien cordialement,") . "\r\n";
                    $reponse_email.= tradTxt("L'équipe de Tooki Island");
                    sendMailText($obj_membre->getEmail(), $sujet_reponse, $reponse_email);
                    // ---
                    
                    if(!$tab_retour[0])
                    {
                        // tout ok
                        setFlashData('message', "Réponse envoyée");
                    }
                    else
                    {
                        // pb maj
                        setFlashData('message', $tab_retour[1]);
                    }
                }
                else
                {
                    // pb maj
                    setFlashData('message', $tab_retour[1]);
                }
            }
            else
            {
                // question pas trouvé
                setFlashData('message', 'Question introuvable');
            }
        }
        else
        {
            // réponse non renseignée
            setFlashData('message', "Réponse non renseignée");
        }
        redirectBacko(8, array('act'=>'detail', 'id'=>$id));
    }
    else
    {
        // erreur identifiant
    }
}

// -----------------------------------------------------------------------------
else if($http_request['act']=='annuler')
{
    if(isset($http_request['id']) && !empty($http_request['id']))
    {
        $id = intval($http_request['id']);
        $obj_question = new ServiceClient($id);
        $obj_question->setValide(0);
        $tab_retour = ServiceClientManager::updateBdd($obj_question);
        if(!$tab_retour[0])
        {
            setFlashData('message', "Annulation confirmée");
        }
        else
        {
            setFlashData('message', $tab_retour[1]);
        }
    }
    else
    {
        // erreur identifiant
        setFlashData('message', "Problème identifiant");
    }
    redirectBacko(8);
}

// -----------------------------------------------------------------------------
else if($http_request['act']=='liste_traites')
{
    $days = 30;
    $date = date('Y-m-d', strtotime("-$days days"));
    $tab_questions = ServiceClientManager::getListDerniersTraites($date);
    $obj_page->setData('questions', $tab_questions);
    $obj_page->setData('jours', $days);
    $obj_page->setUrlPage('service_client/service_client_liste_traites');
}

//------------------------------------------------------------------------------
else if ($http_request['act']=='detail_message')
{
    $tab_messages = ServiceClientManager::getListMessageByMembre($http_request['id']);
    $obj_page->setData('messages', $tab_messages);
    
    $tab_sujets = ServiceClientManager::getSujets();
    $obj_page->setData('sujet', $tab_sujets);
    $obj_page->setAppelAjax(true);
    $obj_page->setUrlPage('service_client/service_client_conversation');
    
}

//------------------------------------------------------------------------------
else if ($http_request['act']=='update_valide')
{    
    $id = isset($http_request['id']) && $http_request['id']!= '' ? $http_request['id'] : null;
    $valide_message = isset($http_request['valide_message']) && $http_request['valide_message']!= '' ? $http_request['valide_message'] : null;
    $obj_message = new ServiceClient($id);
    if($valide_message=="on")
   {
       $obj_message->setValide(1);
   }
   else
   {
       $obj_message->setValide(0);
   }
   
   ServiceClientManager::updateBdd($obj_message);   
}

//------------------------------------------------------------------------------
else if ($http_request['act']=='liste_question_membre')
{
    if (isset($http_request['choix']) && $http_request['choix']=="non_traites")
    {
        $tab_joueurs = ServiceClientManager::getListNonTraitesMembre();
    }
    else
    {
        $tab_joueurs = ServiceClientManager::getListMembre();  
    }
    $obj_page->setData('joueurs', $tab_joueurs);
    $obj_page->setAppelAjax(true);
    $obj_page->setUrlPage('service_client/service_client_membre');
}

?>