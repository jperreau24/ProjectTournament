<?php
//include('Tournoi.php');

class TournoiManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addTournoi(Tournoi $tournoi)
  {
    $q = $this->_db->prepare('INSERT INTO tournoi SET id_organisateur = :id_organisateur, nom_tournoi = :nom_tournoi, sport = :sport, nb_equipe = :nb_equipe, type_tournoi = :type_tournoi');
    //$q->bindValue(':id_tournoi', $tournoi->getIdTournoi());
    $q->bindValue(':id_organisateur', $tournoi->getIdOrganisateur());
    $q->bindValue(':nom_tournoi', $tournoi->getNomTournoi());
    $q->bindValue(':sport', $tournoi->getSport());
    $q->bindValue(':nb_equipe', $tournoi->getNbEquipe());
    $q->bindValue(':type_tournoi', $tournoi->getTypeTournoi());
    echo $tournoi->getNomTournoi();
    
    $q->execute();
  }

  public function deleteTournoi(Tournoi $tournoi)
  {
    $this->_db->exec('DELETE FROM tournoi WHERE id_tournoi = '.$tournoi->id());
  }

  public function getByIdTournoi($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id_tournoi, id_organisateur, nom_tournoi, vainqueur_tournoi, sport, nb_equipe, type_tournoi FROM tournoi WHERE id_tournoi = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
 
  public function getByNomTournoi($nom)
  {
    $q = $this->_db->query('SELECT id_tournoi, id_organisateur, nom_tournoi, vainqueur_tournoi, sport, nb_equipe, type_tournoi FROM tournoi WHERE nom_tournoi = "'.$nom.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    var_dump($donnees);
    return $donnees;
  }
  
  public function getLastId()
  {
     //$lastid = $this->_db->exec('SELECT LAST_INSERT_ID() FROM tournoi');
      $lastid = $this->_db->lastInsertId(); 
    return $lastid;
  }
  
  public function updateVainqueurTournoi(Tournoi $tournoi)
  {
    $q = $this->_db->prepare('UPDATE tournoi SET'
            . ' vainqueur_tournoi = :vainqueur_tournoi'
            . ' WHERE id_tournoi = :id_tournoi');
    
    $q->bindValue(':vainqueur_tournoi', $tournoi->getVainqueurTournoi(), PDO::PARAM_INT);
    $q->bindValue(':id_tournoi', $tournoi->getIdTournoi(), PDO::PARAM_INT);
    
    $q->execute();
  }
  
public function getListTournoiTermine()
{
  $q = $this->_db->query('SELECT id_tournoi, id_organisateur, nom_tournoi, vainqueur_tournoi, sport, nb_equipe, type_tournoi FROM tournoi WHERE vainqueur_tournoi <> "" ORDER BY id_tournoi desc Limit 0,5');

  while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
  {
    $tournoi = new Tournoi();
    $tournoi->hydrate($donnees);
    $tab_tournoi_termine[] = $tournoi;
  }

  return $tab_tournoi_termine;
}

public function getListTournoiRecent()
{
  $q = $this->_db->query('SELECT id_tournoi, id_organisateur, nom_tournoi, vainqueur_tournoi, sport, nb_equipe, type_tournoi FROM tournoi ORDER BY id_tournoi desc Limit 0,5');

  while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
  {
    $tournoi = new Tournoi();
    $tournoi->hydrate($donnees);
    $tab_tournoi_recent[] = $tournoi;
  }

  return $tab_tournoi_recent;
}

public function getListTournoiByIdOrganisateur($id_organisateur)
  {
    $q = $this->_db->query('SELECT id_tournoi, id_organisateur, nom_tournoi, vainqueur_tournoi, sport, nb_equipe, type_tournoi FROM tournoi WHERE id_organisateur = '.$id_organisateur.' ORDER BY id_tournoi');

  while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
  {
    $tournoi = new Tournoi();
    $tournoi->hydrate($donnees);
    $tab_tournoi_organisateur[] = $tournoi;
  }

  return $tab_tournoi_organisateur;
  }


  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}


