<?php
include('Rencontre.php');

class RencontreManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addRencontre(Rencontre $rencontre)
  {
    $q = $this->_db->prepare('INSERT INTO rencontre SET id_tournoi = :id_tournoi,'
            . ' place_rencontre = :place_rencontre,'
            . ' id_concurrent_A = :id_concurrent_A,'
            . ' id_concurrent_B = :id_concurrent_B');
    $q->bindValue(':id_tournoi', $rencontre->getIdTournoi());
    $q->bindValue(':place_rencontre', $rencontre->getPlaceRencontre());
    $q->bindValue(':id_concurrent_A', $rencontre->getIdConcurrentA());
    $q->bindValue(':id_concurrent_B', $rencontre->getIdConcurrentB());
    
    $q->execute();
  }

  public function deleteRencontre(Rencontre $rencontre)
  {
    $this->_db->exec('DELETE FROM rencontre WHERE id_rencontre = '.$rencontre->id());
  }

  public function getByIdRencontre($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B, score_A, score_B, vainqueur_rencontre, date_rencontre, observation FROM rencontre WHERE id_rencontre = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
  
  public function getByIdTournoiAndPlaceRencontre($id_tournoi, $place_rencontre)
  {
    $id_tournoi = (int) $id_tournoi;

    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B, score_A, score_B, vainqueur_rencontre, date_rencontre, observation FROM rencontre WHERE id_tournoi = '.$id_tournoi.' AND place_rencontre = "'.$place_rencontre.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
  
  /*public function getByPlaceRencontre($place)
  {
    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, nom_rencontre, vainqueur_rencontre, sport, nb_equipe, type_rencontre FROM rencontre WHERE nom_rencontre = "'.$nom.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    var_dump($donnees);
    return $donnees;
  }*/

  public function getListRencontre($id_tournoi)
  {
    $id_tournoi = (int) $id_tournoi;
    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B, score_A, score_B, vainqueur_rencontre, date_rencontre FROM rencontre WHERE id_tournoi = '.$id_tournoi.' ORDER BY id_rencontre');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $rencontre = new Rencontre();
      $rencontre->hydrate($donnees);
      $tab_rencontre[] = $rencontre;
    }

    return $tab_rencontre;
  }
  
  public function getListRencontreGroup($id_tournoi)
  {
     $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B, score_A, score_B, vainqueur_rencontre, date_rencontre FROM rencontre WHERE id_tournoi = '.$id_tournoi.' AND place_rencontre like "G%" ORDER BY id_rencontre');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $rencontre = new Rencontre();
      $rencontre->hydrate($donnees);
      $tab_rencontre[] = $rencontre;
    }

    return $tab_rencontre;
  }
  
  public function getListRencontreByGroup($id_tournoi,$num_group)
  {
    $id_tournoi = (int) $id_tournoi;
    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B, score_A, score_B, vainqueur_rencontre, date_rencontre FROM rencontre WHERE id_tournoi = '.$id_tournoi.' AND place_rencontre like "G'.$num_group.'%" ORDER BY id_rencontre');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $rencontre = new Rencontre();
      $rencontre->hydrate($donnees);
      $tab_rencontre[] = $rencontre;
    }

    return $tab_rencontre;
  }
  
  public function getListConcurrentByGroupe($id_tournoi,$ngpr)
  {
    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B FROM rencontre WHERE id_tournoi = '.$id_tournoi.' AND (place_rencontre = "G'.$ngpr.'M1" OR place_rencontre = "G'.$ngpr.'M2")');
     while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
         $tab_concurrent_groupe[] = $donnees;
    }

    return $tab_concurrent_groupe;
  }
  
  public function getConcurrentByGroupe($id_tournoi,$ngpr)
  {
    $q = $this->_db->query('SELECT id_rencontre, id_tournoi, place_rencontre, id_concurrent_A, id_concurrent_B FROM rencontre WHERE id_tournoi = '.$id_tournoi.' AND (place_rencontre = "G'.$ngpr.'M1" OR place_rencontre = "G'.$ngpr.'M2")');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
  
  public function getLastIdRencontre()
  {
     //$lastid = $this->_db->exec('SELECT LAST_INSERT_ID() FROM tournoi');
      $lastid = $this->_db->lastInsertId(); 
    return $lastid;
  }

  public function updateRencontre(Rencontre $rencontre)
  {
      
    $q = $this->_db->prepare('UPDATE rencontre SET'
            . ' score_A = :score_A,'
            . ' score_B = :score_B,'
            . ' vainqueur_rencontre = :vainqueur_rencontre,'
            . ' date_rencontre = :date_rencontre,'
            . ' observation = :observation'
            . ' WHERE id_rencontre = :id_rencontre');
    
    $q->bindValue(':score_A', $rencontre->getScoreA(), PDO::PARAM_INT);
    $q->bindValue(':score_B', $rencontre->getScoreB(), PDO::PARAM_INT);
    $q->bindValue(':vainqueur_rencontre', $rencontre->getVainqueurRencontre(), PDO::PARAM_INT);
    $q->bindValue(':date_rencontre', $rencontre->getDateRencontre(), PDO::PARAM_INT);
    $q->bindValue(':observation', $rencontre->getObservation(), PDO::PARAM_INT);
    $q->bindValue(':id_rencontre', $rencontre->getIdRencontre(), PDO::PARAM_INT);
    
    $q->execute();
  }
  
  public function updateVainqueurRencontre(Rencontre $rencontre)
  {
    $q = $this->_db->prepare('UPDATE rencontre SET'
            . ' vainqueur_rencontre = :vainqueur_rencontre'
            . ' WHERE id_rencontre = :id_rencontre');
    
    $q->bindValue(':vainqueur_rencontre', $rencontre->getVainqueurRencontre(), PDO::PARAM_INT);
    $q->bindValue(':id_rencontre', $rencontre->getIdRencontre(), PDO::PARAM_INT);
    
    $q->execute();
  }
  
  public function updateRencontreGroupeBracket(Rencontre $rencontre)
  {      
    $q = $this->_db->prepare('UPDATE rencontre SET'
            . ' id_concurrent_A = :id_concurrent_A,'
            . ' id_concurrent_B = :id_concurrent_B'
            . ' WHERE id_tournoi = :id_tournoi AND place_rencontre = :place_rencontre');
    
    $q->bindValue(':id_concurrent_A', $rencontre->getIdConcurrentA(), PDO::PARAM_INT);
    $q->bindValue(':id_concurrent_B', $rencontre->getIdConcurrentB(), PDO::PARAM_INT);
    $q->bindValue(':place_rencontre', $rencontre->getPlaceRencontre(), PDO::PARAM_INT);
    $q->bindValue(':id_tournoi', $rencontre->getIdTournoi(), PDO::PARAM_INT); 
    $q->execute();
  }
  
  public function updateNewRencontre(Rencontre $rencontre)
  {
    $id_concurrent_A = "";
    $id_concurrent_B = "";
    if($rencontre->getIdConcurrentA() != ""){ $id_concurrent_A ='id_concurrent_A = :id_concurrent_A';}
    else if($rencontre->getIdConcurrentB() != ""){ $id_concurrent_B ='id_concurrent_B = :id_concurrent_B';}
    $q = $this->_db->prepare('UPDATE rencontre SET'
            . ' place_rencontre = :place_rencontre, '
            . $id_concurrent_A
            . $id_concurrent_B
            . ' WHERE id_rencontre = :id_rencontre');
    
    $q->bindValue(':place_rencontre', $rencontre->getPlaceRencontre(), PDO::PARAM_INT);
    if($rencontre->getIdConcurrentA() != ""){ $q->bindValue(':id_concurrent_A', $rencontre->getIdConcurrentA(), PDO::PARAM_INT);}
    else if($rencontre->getIdConcurrentB() != ""){ $q->bindValue(':id_concurrent_B', $rencontre->getIdConcurrentB(), PDO::PARAM_INT);}
    $q->bindValue(':id_rencontre', $rencontre->getIdRencontre(), PDO::PARAM_INT);
    
    $q->execute();
  }
  

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}



