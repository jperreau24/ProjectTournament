<?php
include('Arbitre.php');

class ArbitreManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addArbitre(Arbitre $arbitre)
  {
    $q = $this->_db->prepare('INSERT INTO arbitre SET id_supporter = :id_supporter, id_tournoi = :id_tournoi');
    $q->bindValue(':id_supporter', $arbitre->getIdSupporter());
    $q->bindValue(':id_tournoi', $arbitre->getIdTournoi());
    
    $q->execute();
  }

  
public function getListArbitreByIdTournoi($id_tournoi) //pour envoyer des mail/notif/feuille de match
{
  $q = $this->_db->query('SELECT id_arbitre, id_supporter, id_tournoi FROM arbitre WHERE id_tournoi = '.$id_tournoi);

  while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
  {
    $arbitre = new Arbitre();
    $arbitre->hydrate($donnees);
    $tab_arbitre_tournoi[] = $arbitre;
  }
  if(isset($tab_arbitre_tournoi))
  {
    return $tab_arbitre_tournoi;
  }
}

public function getListTournoiWhereSupporterArbitre($id_supporter) //obtien la liste ou le supporter en est l'arbitre
{
  $q = $this->_db->query('SELECT id_arbitre, id_supporter, id_tournoi FROM arbitre WHERE id_supporter = '.$id_supporter);

  while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
  {
    $arbitre = new Arbitre();
    $arbitre->hydrate($donnees);
    $tab_supporter_arbitre[] = $arbitre;
  }

  return $tab_supporter_arbitre;
}

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}


