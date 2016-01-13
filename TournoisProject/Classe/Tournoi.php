<?php

Class Tournoi 
{
    public $id_tournoi;
    public $id_organisateur;
    public $nom_tournoi;
    public $vainqueur_tournoi;
    public $sport;
    public $nb_equipe;
    public $type_tournoi;

    /*public function __construct($id_tournoi, $id_organisateur, $nom_tournoi, $sport, $nb_equipe, $type_tournoi) 
    {
        $this->id_tournoi = $id_tournoi;
        $this->id_organisateur = $id_organisateur;
        $this->nom_tournoi = $nom_tournoi;
        $this->sport = $sport;
        $this->nb_equipe = $nb_equipe;
        $this->type_tournoi = $type_tournoi;
    }*/
    
    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_tournoi'])){$this->setIdTournoi($donnees['id_tournoi']);}
      if (isset($donnees['id_organisateur'])){$this->setIdOrganisateur($donnees['id_organisateur']);}
      if (isset($donnees['nom_tournoi'])){$this->setNomTournoi($donnees['nom_tournoi']);} 
      if (isset($donnees['vainqueur_tournoi'])){$this->setVainqueurTournoi($donnees['vainqueur_tournoi']);}
      if (isset($donnees['sport'])){$this->setSport($donnees['sport']);}
      if (isset($donnees['nb_equipe'])){$this->setNbEquipe($donnees['nb_equipe']);}
      if (isset($donnees['Type_tournoi'])){$this->setTypeTournoi($donnees['Type_tournoi']);}
    }
   
    public function getIdTournoi(){return $this->id_tournoi;}
    public function getIdOrganisateur(){return $this->id_organisateur;}
    public function getNomTournoi(){return $this->nom_tournoi;}
    public function getVainqueurTournoi(){return $this->vainqueur_tournoi;}
    public function getSport(){return $this->sport;}
    public function getNbEquipe(){return $this->nb_equipe;}
    public function getTypeTournoi(){return $this->type_tournoi;}
    
  
    public function setIdTournoi($id_tournoi)
    {
       if ($id_tournoi > 0 ) {$this->id_tournoi = $id_tournoi;}
    }
    
    public function setIdOrganisateur($id_organisateur)
    {
       $this->id_organisateur = $id_organisateur;
    }
    
    public function setNomTournoi($nom_tournoi)
    {
       $this->nom_tournoi = $nom_tournoi;
    }
    
    public function setVainqueurTournoi($vainqueur_tournoi)
    {
       $this->vainqueur_tournoi = $vainqueur_tournoi;
    }
    
    public function setSport($sport)
    {
       $this->sport = $sport;
    }
    
    public function setNbEquipe($nb_equipe)
    {
       $this->nb_equipe = $nb_equipe;
    }
    
    public function setTypeTournoi($type_tournoi)
    {
       $this->type_tournoi = $type_tournoi;
    }
}

