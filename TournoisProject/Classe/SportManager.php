<?php
include('Sport.php');

class SportManager
{
    private $_db; // Instance de PDO

    public function __construct($db)
    {
      $this->setDb($db);
    }

    public function getListSport()
    {
      $q = $this->_db->query('SELECT id_sport, nom_sport FROM sport ORDER BY nom_sport');

      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $sport = new Sport();
        $sport->hydrate($donnees);
        $tab_sport[] = $sport;
      }

      return $tab_sport;
    }

    public function setDb(PDO $db)
    {
      $this->_db = $db;
    }
}