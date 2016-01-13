<?php 

Class Classement
{
    public $id_classement;
    public $id_tournoi;
    public $id_concurrent;
    public $num_phase;
    public $point;


    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_classement'])){$this->setIdClassement($donnees['id_classement']);}
      if (isset($donnees['id_tournoi'])){$this->setIdTournoi($donnees['id_tournoi']);}
      if (isset($donnees['id_concurrent'])){$this->setIdConcurrent($donnees['id_concurrent']);}
      if (isset($donnees['num_phase'])){$this->setNumPhase($donnees['num_phase']);}
      if (isset($donnees['point'])){$this->setPoint($donnees['point']);}
    }

   
    public function getIdClassement(){return $this->id_classement;}
    public function getIdTournoi(){return $this->id_tournoi;}
    public function getIdConcurrent(){return $this->id_concurrent;}
    public function getNumPhase(){return $this->num_phase;}
    public function getPoint(){return $this->point;}
    
  
    public function setIdClassement($id_classement)
    {
       if ($id_classement > 0 ) {$this->id_classement = $id_classement;}
    }
    
    public function setIdTournoi($id_tournoi)
    {
        $this->id_tournoi = $id_tournoi;
    }
    
    public function setIdConcurrent($id_concurrent)
    {
        $this->id_concurrent = $id_concurrent;
    }
    
    public function setNumPhase($num_phase)
    {
        $this->num_phase = $num_phase;
    }
    
    public function setPoint($point)
    {
       $this->point = $point;
    }
}
