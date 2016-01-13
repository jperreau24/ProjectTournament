<?php
include('Concurrent.php');

class ConcurrentManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addConcurrent(Concurrent $concurrent)
  {
    $q = $this->_db->prepare('INSERT INTO concurrent SET id_tournoi = :id_tournoi,'
            . ' nom_concurrent = :nom_concurrent,'
            . ' nb_concurrent = :nb_concurrent');
    $q->bindValue(':id_tournoi', $concurrent->getIdTournoi());
    $q->bindValue(':nom_concurrent', $concurrent->getNomConcurrent());
    $q->bindValue(':nb_concurrent', $concurrent->getNbConcurrent());
    echo $concurrent->getNomConcurrent();
    
    $q->execute();
  }

  public function deleteConcurrent(Concurrent $concurrent)
  {
    $this->_db->exec('DELETE FROM concurrent WHERE id_concurrent = '.$concurrent->id());
  }

  public function getByIdConcurrent($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id_concurrent, id_tournoi, nom_concurrent, nb_concurrent FROM concurrent WHERE id_concurrent = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
  
  public function getByNomConcurrentByIdTournoi($id,$nom)
  {
    $q = $this->_db->query('SELECT id_concurrent, id_tournoi, nom_concurrent, nb_concurrent FROM concurrent WHERE id_tournoi = '.$id.' AND nom_concurrent = "'.$nom.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return $donnees;
  }

  public function getListConcurrent($id_tournoi)
  {
    $q = $this->_db->query('SELECT id_concurrent, id_tournoi, nom_concurrent, nb_concurrent FROM concurrent WHERE id_tournoi = '.$id_tournoi.' ORDER BY id_concurrent');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $concurrent = new Concurrent();
      $concurrent->hydrate($donnees);
      $tab_concurrent[] = $concurrent;
    }
    return $tab_concurrent;
  }

  /*public function update(Personnage $perso)
  {
    $q = $this->_db->prepare('UPDATE concurrent SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience WHERE id = :id');

    $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

    $q->execute();
  }*/

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}