<?php

Class Supporter
{
    public $id_supporter;
    public $nom;
    public $prenom;
    public $login;
    public $mdp;
    public $email;


    public function hydrate(array $donnees)
    {
      if (isset($donnees['id_supporter'])){$this->setIdSupporter($donnees['id_supporter']);}
      if (isset($donnees['nom'])){$this->setNom($donnees['nom']);}
      if (isset($donnees['prenom'])){$this->setPrenom($donnees['prenom']);}
      if (isset($donnees['login'])){$this->setLogin($donnees['login']);}
      if (isset($donnees['mdp'])){$this->setMdp($donnees['mdp']);}
      if (isset($donnees['email'])){$this->setEmail($donnees['email']);}
    }

   
    public function getIdSupporter(){return $this->id_supporter;}
    public function getNom(){return $this->nom;}
    public function getPrenom(){return $this->prenom;}
    public function getLogin(){return $this->login;}
    public function getMdp(){return $this->mdp;}
    public function getEmail(){return $this->email;}
    
  
    public function setIdSupporter($id_supporter)
    {
       if ($id_supporter > 0 ) {$this->id_supporter = $id_supporter;}
    }
    
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    
    public function setLogin($login)
    {
        $this->login = $login;
    }
    
    public function setMdp($mdp)
    {
       $this->mdp = $mdp;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }

}

