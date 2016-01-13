<?php

Class Rencontre
{
    public $id_rencontre;
    public $id_tournoi;
    public $place_rencontre;
    public $id_concurrent_A;
    public $id_concurrent_B;
    public $score_A;
    public $score_B;
    public $vainqueur_rencontre;
    public $date_rencontre;
    public $observation;
    
    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_rencontre'])){$this->setIdRencontre($donnees['id_rencontre']);}
      if (isset($donnees['id_tournoi'])){$this->setIdTournoi($donnees['id_tournoi']);}
      if (isset($donnees['place_rencontre'])){$this->setPlaceRencontre($donnees['place_rencontre']);}
      if (isset($donnees['id_concurrent_A'])){$this->setIdConcurrentA($donnees['id_concurrent_A']);} 
      if (isset($donnees['id_concurrent_B'])){$this->setIdConcurrentB($donnees['id_concurrent_B']);}
      if (isset($donnees['score_A'])){$this->setScoreA($donnees['score_A']);}
      if (isset($donnees['score_B'])){$this->setScoreB($donnees['score_B']);}
      if (isset($donnees['vainqueur_rencontre'])){$this->setVainqueurRencontre($donnees['vainqueur_rencontre']);}
      if (isset($donnees['date_rencontre'])){$this->setDateRencontre($donnees['date_rencontre']);}
      if (isset($donnees['observation'])){$this->setObservation($donnees['observation']);}
    }
   
    public function getIdRencontre(){return $this->id_rencontre;}
    public function getIdTournoi(){return $this->id_tournoi;}
    public function getPlaceRencontre(){return $this->place_rencontre;}
    public function getIdConcurrentA(){return $this->id_concurrent_A;}
    public function getIdConcurrentB(){return $this->id_concurrent_B;}
    public function getScoreA(){return $this->score_A;}
    public function getScoreB(){return $this->score_B;}
    public function getVainqueurRencontre(){return $this->vainqueur_rencontre;}
    public function getDateRencontre(){return $this->date_rencontre;}
    public function getObservation(){return $this->observation;}
    
  
    public function setIdRencontre($id_rencontre)
    {
       if ($id_rencontre > 0 ) {$this->id_rencontre = $id_rencontre;}
    }
    
    public function setIdTournoi($id_tournoi)
    {
       $this->id_tournoi = $id_tournoi;
    }
    
    public function setPlaceRencontre($place_rencontre)
    {
       $this->place_rencontre = $place_rencontre;
    }
    
    public function setIdConcurrentA($id_concurrent_A)
    {
       $this->id_concurrent_A = $id_concurrent_A;
    }
    
    public function setIdConcurrentB($id_concurrent_B)
    {
       $this->id_concurrent_B = $id_concurrent_B;
    }
    
    public function setScoreA($score_A)
    {
       $this->score_A = $score_A;
    }
    
    public function setScoreB($score_B)
    {
       $this->score_B = $score_B;
    }
    
    public function setVainqueurRencontre($vainqueur_rencontre)
    {
       $this->vainqueur_rencontre = $vainqueur_rencontre;
    }
    
    public function setDateRencontre($date_rencontre)
    {
       $this->date_rencontre = $date_rencontre;
    }
    
    public function setObservation($observation)
    {
       $this->observation = $observation;
    }
}

