<?php
    session_start();
    include('Classe/SupporterManager.php');
    include('ConnectBDD.php');
    $manager = connect('Supporter');

    if(!empty($_POST['pseudo']) && !empty($_POST['mdp']))
    {
        $login = $_POST['pseudo'];
        $mdp = sha1($_POST['mdp']);
      
        //si login ok
        if($manager->checkLogin($login,$mdp))
        {
            
            $_SESSION['logged'] = true;
            $_SESSION['login'] = $login;
            
            $id_supporter = $manager->getUserById($login);
            $_SESSION['id_supporter'] = $id_supporter;
            header("location:index.php");
            
        }
        else
        {
            $_SESSION['logged'] = false;
             header("location:index.php");
            
           
        }
    }
    else if(empty($_POST['pseudo']) || empty($_POST['mdp']))
    {
        $_SESSION['logged'] = false;
        header("location:index.php");
    }   
?>
