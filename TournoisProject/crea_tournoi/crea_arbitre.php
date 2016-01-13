<?php
function creaArbitre($id_tournoi,$tab_arbitre, $nb_arbitre)
{
    $manager_supporter = connect('Supporter');
    $manager_arbitre = connect('Arbitre');
   
    for($i=1 ; $i<=$nb_arbitre ; $i++)
    {
        $arbitre_login = $tab_arbitre['nom_arbitre_'.$i];
        $arbitre_mail = $tab_arbitre['mail_arbitre_'.$i];

        $id_supporter = $manager_supporter->getUserByLoginByMail($arbitre_login,$arbitre_mail);
        
        $arbitre = new Arbitre();
        $arbitre->setIdSupporter($id_supporter);
        $arbitre->setIdTournoi($id_tournoi);

        $manager_arbitre->addArbitre($arbitre);
    }
}