<?php
include('Supporter.php');

class SupporterManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function addSupporter(Supporter $supporter)
  {
    $q = $this->_db->prepare('INSERT INTO supporter SET login = :login, mdp = :mdp, email = :email');
    $q->bindValue(':login', $supporter->getLogin());
    $q->bindValue(':mdp', $supporter->getMdp());
    $q->bindValue(':email', $supporter->getEmail());
    echo $supporter->getNom();
    
    $q->execute();
  }
  
  public function checkLogin($login, $mdp)
  {
    $q = $this->_db->query('SELECT login, mdp FROM supporter WHERE login = "'.$login.'" AND mdp = "'.$mdp.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    
    if(array_key_exists('login', $donnees)){return true;}
    else{return false;}   
  }
  
  public function delete(Supporter $supporter)
  {
    $this->_db->exec('DELETE FROM supporter WHERE id = '.$supporter->id());
  }

  public function getById($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id_supporter, nom, prenom, login, mdp, email FROM supporter WHERE id_supporter = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }
  
  public function getByNom($nom)
  {
    $q = $this->_db->query('SELECT id_supporter, nom, prenom, login, mdp, email FROM supporter WHERE nom = "'.$nom.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    var_dump($donnees);
    return $donnees;
  }
  
  public function getUserById($login) {
    $q = $this->_db->query('SELECT id_supporter FROM supporter WHERE login = "'.$login.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    $id = $donnees['id_supporter'];
    return $id;
  }
  
   public function getUserByLoginByMail($login,$mail) {
    
     $q = $this->_db->query('SELECT id_supporter FROM supporter WHERE login = "'.$login.'" AND email= "'.$mail.'"');
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    $id = $donnees['id_supporter'];
    return $id;
  }
  

  /*public function getList()
  {
    $supporters = [];

    $q = $this->_db->query('SELECT id_supporter, nom, prenom, login, mdp, email FROM supporter ORDER BY nom');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $supporters[] = new Supporter($donnees);
    }

    return $supporters;
  }*/

  /*public function update(Personnage $perso)
  {
    $q = $this->_db->prepare('UPDATE supporter SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience WHERE id = :id');

    $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

    $q->execute();
  }*/

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
    
/*$db = new PDO('mysql:host=localhost;dbname=project_tournament', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$manager = new SupporterManager($db);*/

//ajouter un utilisateur
/*$manager->add($supporter);*/

//récupère un supporter par son nom
/*$tab=$manager->getByNom('nom1');
$supporter = new Supporter();
$supporter->hydrate($tab);
echo $supporter->getNom();
echo $supporter->getPrenom();*/

//récupére un supporter par son id
/*$id=2;
$tab2=$manager->getById($id);
$supporter2 = new Supporter();
$supporter2->hydrate($tab2);
echo $supporter2->getNom();
echo $supporter2->getPrenom();*/



/*try
{
    $bdd = new PDO('mysql:host=localhost;dbname=project_tournament;charset=utf8', 'root', '');

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
echo "ok";

$request = $bdd->query('SELECT id_supporter, nom, prenom, login, mdp, email FROM supporter WHERE supporter');
$donnees = $request->fetch(PDO::FETCH_ASSOC); // Chaque entrée sera récupérée et placée dans un array.
  
  $perso = new Supporter($donnees['id_supporter'],$donnees['nom'],$donnees['prenom'],$donnees['login'],$donnees['mdp'],$donnees['email']);

  echo $perso->getNom(), ' prenom ', $perso->getPrenom(), ' login, ', $perso->getLogin(), ' mdp, ', $perso->getMdp(), ' email ', $perso->getEmail();
*/