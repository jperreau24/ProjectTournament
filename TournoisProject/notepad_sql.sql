CREATE TABLE supporter
(id_supporter integer AUTO_INCREMENT, 
nom varchar (50) NOT NULL,
prenom varchar (50) NOT NULL,
login varchar (50) NOT NULL,
mdp varchar (50) NOT NULL,
email varchar(50) NOT NULL,
PRIMARY KEY (id_supporter));


CREATE TABLE tournoi
(id_tournoi integer AUTO_INCREMENT,
id_organisateur integer, 
nom_tournoi varchar (50) NOT NULL,
vainqueur_tournoi varchar (50) NOT NULL,
sport varchar (50) NOT NULL,
nb_equipe integer NOT NULL,
type_tournoi varchar(50),
PRIMARY KEY (id_tournoi),
Foreign Key (id_organisateur) references supporter (id_supporter));


CREATE TABLE arbitre
(id_arbitre integer AUTO_INCREMENT,
id_supporter integer,
id_tournoi integer,
PRIMARY KEY (id_arbitre),
Foreign Key (id_supporter) references supporter (id_supporter),
Foreign Key (id_tournoi) references tournoi (id_tournoi));



CREATE TABLE joueur
(id_joueur integer AUTO_INCREMENT, 
nom_joueur varchar (50) NOT NULL,
email_joueur varchar (50) NOT NULL,
PRIMARY KEY (id_joueur));

CREATE TABLE concurrent
(id_concurrent integer AUTO_INCREMENT, 
id_tournoi integer,
nom_concurrent varchar (50),
nb_concurrent integer (2),
PRIMARY KEY (id_concurrent),
Foreign Key (id_tournoi) references tournoi (id_tournoi));



CREATE TABLE appartient_concurrent   /* liaison table joueur-concurrent*/
(id_appartient_concurrent integer AUTO_INCREMENT,
id_concurrent integer,
id_joueur integer,
PRIMARY KEY(id_appartient_concurrent, id_concurrent, id_joueur),
Foreign Key (id_concurrent) references concurrent (id_concurrent),
Foreign Key (id_joueur) references joueur (id_joueur));


CREATE TABLE rencontre
(id_rencontre integer AUTO_INCREMENT,
id_tournoi integer,
place_renconte varchar(10),
id_concurrent_A integer,
id_concurrent_B integer,
score_A integer,
score_B integer,
vainqueur_rencontre varchar (50),
date_rencontre DATETIME,
observation text,
id_arbitre integer,
PRIMARY KEY(id_rencontre),
Foreign Key (id_tournoi) references tournoi (id_tournoi),
Foreign Key (id_concurrent_A) references concurrent (id_concurrent),
Foreign Key (id_concurrent_B) references concurrent (id_concurrent),
Foreign Key (id_arbitre) references arbitre (id_arbitre));


CREATE TABLE commentaire
(id_com integer AUTO_INCREMENT,
id_supporter integer,
id_rencontre integer,
com_text text,
date_com DATETIME,
PRIMARY KEY(id_com),
Foreign Key (id_supporter) references supporter(id_supporter),
Foreign Key (id_rencontre) references rencontre (id_rencontre));

CREATE TABLE sport
(id_sport integer AUTO_INCREMENT,
nom_sport varchar(50) NOT NULL,
team integer NOT NULL,
PRIMARY KEY (id_sport));

CREATE TABLE typetournoi
(id_type integer AUTO_INCREMENT,
nom_type varchar(50) NOT NULL,
PRIMARY KEY (id_type));

CREATE TABLE personnalise
(id_personnalise integer AUTO_INCREMENT,
id_tournoi integer,
nb_phase integer,
PRIMARY KEY(id_personnalise),
Foreign Key (id_tournoi) references tournoi (id_tournoi));

CREATE TABLE appartient_type_tournoi
(id_appartient_type_tournoi integer AUTO_INCREMENT,
id_personnalise integer,
id_type integer,
PRIMARY KEY(id_appartient_type_tournoi),
Foreign Key (id_type) references typetournoi(id_type),
Foreign Key (id_personnalise) references personnalise (id_personnalise));

CREATE TABLE classement
(id_classement integer AUTO_INCREMENT,
id_tournoi integer,
id_concurrent integer,
num_phase integer,
point integer,
PRIMARY KEY(id_classement),
Foreign Key (id_tournoi) references tournoi(id_tournoi),
Foreign Key (id_concurrent) references concurrent (id_concurrent));

/*************************************************************/

