<?php

Class Concurrent
{
    public $id_concurrent;
    public $id_tournoi;
    public $nom_concurrent;
    public $nb_concurrent;
    
    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_concurrent'])){$this->setIdConcurrent($donnees['id_concurrent']);}
      if (isset($donnees['id_tournoi'])){$this->setIdTournoi($donnees['id_tournoi']);}
      if (isset($donnees['nom_concurrent'])){$this->setNomConcurrent($donnees['nom_concurrent']);}
      if (isset($donnees['nb_concurrent'])){$this->setNbConcurrent($donnees['nb_concurrent']);}
    }
   
    public function getIdConcurrent(){return $this->id_concurrent;}
    public function getIdTournoi(){return $this->id_tournoi;}
    public function getNomConcurrent(){return $this->nom_concurrent;}
    public function getNbConcurrent(){return $this->nb_concurrent;}
    
  
    public function setIdConcurrent($id_concurrent)
    {
       if ($id_concurrent > 0 ) {$this->id_concurrent = $id_concurrent;}
    }
    
    public function setIdTournoi($id_tournoi)
    {
       $this->id_tournoi = $id_tournoi;
    }
    
    public function setNomConcurrent($Nom_Concurrent)
    {
       $this->nom_concurrent = $Nom_Concurrent;
    }
    
    public function setNbConcurrent($nb_concurrent)
    {
       $this->nb_concurrent = $nb_concurrent;
    }
}

