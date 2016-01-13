<?php

Class Sport
{
    public $id_sport;
    public $nom_sport;


    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_sport'])){$this->setIdSport($donnees['id_sport']);}
      if (isset($donnees['nom_sport'])){$this->setNomSport($donnees['nom_sport']);}
    }
   
    public function getIdSport(){return $this->id_sport;}
    public function getNomSport(){return $this->nom_sport;}
    
    public function setIdSport($id_sport)
    {
       if ($id_sport > 0 ) {$this->id_sport = $id_sport;}
    }
    
    public function setNomSport($nom_sport)
    {
        $this->nom_sport = $nom_sport;
    }

}

