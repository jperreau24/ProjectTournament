<?php 
include('../Classe/SupporterManager.php');
include('../ConnectBDD.php');

if (!isset($_REQUEST['act']))
{
    header('Location: inscription_vue.php');
}

else if ($_REQUEST['act'] == 'inscription')
{
    $manager_supporter = connect('Supporter');
    
    $login = isset($_REQUEST['login']) && $_REQUEST['login']!= '' ? $_REQUEST['login'] : null;
    $pass = isset($_REQUEST['pass']) && $_REQUEST['pass']!= '' ? $_REQUEST['pass'] : null;
    $email = isset($_REQUEST['email']) && $_REQUEST['email']!= '' ? $_REQUEST['email'] : null;
    
    $mdp = sha1($pass);
    
    $supporter = new Supporter();
    $supporter->setLogin($login);
    $supporter->setMdp($mdp);
    $supporter->setEmail($email);
    
    $manager_supporter->addSupporter($supporter);
    
    header('Location: ../index.php');
}