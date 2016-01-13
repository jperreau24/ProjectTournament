<?php
include('Classement.php');

class ClassementManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addClassement(Classement $classement)
  {
    $q = $this->_db->prepare('INSERT INTO classement SET id_tournoi = :id_tournoi, id_concurrent = :id_concurrent, num_phase = :num_phase, point = :point');
    $q->bindValue(':id_tournoi', $classement->getIdTournoi());
    $q->bindValue(':id_concurrent', $classement->getIdConcurrent());
    $q->bindValue(':num_phase', $classement->getNumPhase());
    $q->bindValue(':point', $classement->getPoint());
    
    $q->execute();
  }

  public function getClassementByIdTournoiByIdConcurrent($id_tournoi, $id_concurrent)
  {
    $q = $this->_db->query('SELECT id_classement, id_tournoi, id_concurrent, num_phase, point FROM classement WHERE id_tournoi = '.$id_tournoi.' AND id_concurrent = '.$id_concurrent);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
  
  public function getClassementByIdTournoiTriByPoint($id_tournoi)
  {
    $q = $this->_db->query('SELECT C.id_classement, C.id_tournoi, C.id_concurrent,P.nom_concurrent, C.num_phase, C.point FROM classement C INNER JOIN concurrent P ON C.id_concurrent = P.id_concurrent WHERE C.id_tournoi = '.$id_tournoi.' ORDER BY point desc');
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
         $tab_concurrent_tri[] = $donnees;
    }
    if(isset($tab_concurrent_tri))
    {
        return $tab_concurrent_tri;
    }
     
  }
  
    public function getClassementByIdTournoiUpBracket($id_tournoi,$limit)
    {
        $q = $this->_db->query('SELECT C.id_classement, C.id_tournoi, C.id_concurrent,P.nom_concurrent, C.num_phase, C.point FROM classement C INNER JOIN concurrent P ON C.id_concurrent = P.id_concurrent INNER JOIN rencontre R ON P.id_tournoi = R.id_tournoi WHERE C.id_tournoi = '.$id_tournoi.' AND R.place_rencontre like "G1%" ORDER BY C.point desc Limit 0,'.$limit.'');
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
             $tab_concurrent_up[] = $donnees;
        }
            return $tab_concurrent_up;
    }


  public function updateClassement(Classement $classement)
  {
    $q = $this->_db->prepare('UPDATE classement SET point = :point WHERE id_tournoi = :id_tournoi AND id_concurrent = :id_concurrent');
    
    $q->bindValue(':point', $classement->getPoint(), PDO::PARAM_INT);
    $q->bindValue(':id_tournoi', $classement->getIdTournoi(), PDO::PARAM_INT);
    $q->bindValue(':id_concurrent', $classement->getIdConcurrent(), PDO::PARAM_INT);
    
    $q->execute();
  }
  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}