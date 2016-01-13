<?php

Class Arbitre
{
    public $id_arbitre;
    public $id_supporter;
    public $id_tournoi;

    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_arbitre'])){$this->setIdArbitre($donnees['id_arbitre']);}
      if (isset($donnees['id_supporter'])){$this->setIdSupporter($donnees['id_supporter']);}
      if (isset($donnees['id_tournoi'])){$this->setIdTournoi($donnees['id_tournoi']);}
    }

   
    public function getIdArbitre(){return $this->id_arbitre;}
    public function getIdSupporter(){return $this->id_supporter;}
    public function getIdTournoi(){return $this->id_tournoi;}

    public function setIdArbitre($id_arbitre)
    {
       if ($id_arbitre > 0 ) {$this->id_arbitre = $id_arbitre;}
    }
    public function setIdSupporter($id_supporter)
    {
       if ($id_supporter > 0 ) {$this->id_supporter = $id_supporter;}
    }
    public function setIdTournoi($id_tournoi)
    {
       if ($id_tournoi > 0 ) {$this->id_tournoi = $id_tournoi;}
    }
}

