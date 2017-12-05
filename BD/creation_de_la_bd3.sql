#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

DROP DATABASE projet_web;

CREATE DATABASE projet_web CHARACTER SET utf8 COLLATE utf8_general_ci;

#------------------------------------------------------------
# Table: Medecin
#------------------------------------------------------------

CREATE TABLE Medecin(
        IDm         Varchar (25) NOT NULL ,
        Nom         Varchar (25) NOT NULL ,
        Prenom      Varchar (25) NOT NULL ,
        Nom_service Varchar (25) , 
        Mail        Varchar (25) NOT NULL ,
        PRIMARY KEY (IDm )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Responsable dintervention
#------------------------------------------------------------

CREATE TABLE Responsable_d_intervention(
        IDr              Varchar (25) NOT NULL ,
        Nom              Varchar (25) NOT NULL ,
        Prenom           Varchar (25) NOT NULL ,
        Nom_intervention Varchar (25) ,
        Mail             Varchar (25) NOT NULL ,

        PRIMARY KEY (IDr )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Administrateur
#------------------------------------------------------------

CREATE TABLE Administrateur(
        IDa    Varchar (25) NOT NULL ,
        Nom    Varchar (25) NOT NULL ,
        Prenom Varchar (25) NOT NULL ,
        PRIMARY KEY (IDa )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Creneaux
#------------------------------------------------------------

CREATE TABLE Creneaux(
        IDc                     int (11) Auto_increment  NOT NULL ,
        Date_creneau            Date NOT NULL ,
        Heure_debut             Varchar (25) NOT NULL ,
        Heure_fin               Varchar (25) NOT NULL ,
        Date_priseRDV           Date NOT NULL ,
        IDp                     Int NOT NULL ,
        Nom_intervention        Varchar (25) ,
        Niveau_priorite         Int ,
        PRIMARY KEY (IDc )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Service daccueil
#------------------------------------------------------------

CREATE TABLE Service_d_accueil(
        Nom_service Varchar (25) NOT NULL ,
        Facture     Double ,
        PRIMARY KEY (Nom_service)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type dintervention
#------------------------------------------------------------

CREATE TABLE Type_d_intervention(
        Nom_intervention Varchar (25) NOT NULL ,
        Duree            Int NOT NULL ,
        IDr              Varchar (25) NOT NULL ,
        PRIMARY KEY (Nom_intervention )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Patient
#------------------------------------------------------------

CREATE TABLE Patient(
        IDp             int (11) Auto_increment  NOT NULL ,
        Nom             Varchar (25) NOT NULL ,
        Prenom          Varchar (25) NOT NULL ,
        Adresse         Varchar (25) ,
        Numero_tel      Varchar (25) NOT NULL ,
        Niveau_priorite Int NOT NULL ,
        Nom_service     Varchar (25) ,
        PRIMARY KEY (IDp )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Pathologie
#------------------------------------------------------------

CREATE TABLE Pathologie(
        Nom_pathologie Varchar (25) NOT NULL ,
        Niveau_urgence Int NOT NULL ,
        PRIMARY KEY (Nom_pathologie )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        IDu       int (11) Auto_increment  NOT NULL ,
        Mdp       Varchar (25) NOT NULL ,
        User_type Varchar (25) NOT NULL ,
        IDm       Varchar (25) ,
        IDr       Varchar (25) ,
        IDa       Varchar (25) ,
        PRIMARY KEY (IDu )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: peut visualiser
#------------------------------------------------------------

CREATE TABLE peut_visualiser(
        IDm Varchar (25) ,
        IDc Int NOT NULL ,
        IDr Varchar (25) ,
        IDa Varchar (25) ,
        PRIMARY KEY (IDm ,IDc ,IDr ,IDa )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: souffre
#------------------------------------------------------------

CREATE TABLE souffre(
        Nom_pathologie Varchar (25) NOT NULL ,
        IDp            Int NOT NULL ,
        PRIMARY KEY (Nom_pathologie ,IDp )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: recoit
#------------------------------------------------------------

CREATE TABLE recoit(
        Nom_intervention Varchar (25) NOT NULL ,
        IDp              Int NOT NULL ,
        PRIMARY KEY (Nom_intervention ,IDp )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: a comme
#------------------------------------------------------------

CREATE TABLE a_comme(
        IDm Varchar (25) NOT NULL ,
        IDp Int NOT NULL ,
        PRIMARY KEY (IDm ,IDp )
)ENGINE=InnoDB;

ALTER TABLE Utilisateur ADD CONSTRAINT FK_Utilisateur_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm) ON DELETE CASCADE ;
ALTER TABLE Utilisateur ADD CONSTRAINT FK_Utilisateur_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr) ON DELETE CASCADE ;
ALTER TABLE Utilisateur ADD CONSTRAINT FK_Utilisateur_IDa FOREIGN KEY (IDa) REFERENCES Administrateur(IDa);
ALTER TABLE Medecin ADD CONSTRAINT FK_Medecin_Nom_service FOREIGN KEY (Nom_service) REFERENCES Service_d_accueil(Nom_service) ON DELETE SET NULL;
ALTER TABLE Responsable_d_intervention ADD CONSTRAINT FK_Responsable_d_intervention_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention) ON DELETE SET NULL;
ALTER TABLE Creneaux ADD CONSTRAINT FK_Creneaux_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE Creneaux ADD CONSTRAINT FK_Creneaux_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention) ON DELETE SET NULL;
ALTER TABLE Type_d_intervention ADD CONSTRAINT FK_Type_d_intervention_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr);
ALTER TABLE Patient ADD CONSTRAINT FK_Patient_Nom_service FOREIGN KEY (Nom_service) REFERENCES Service_d_accueil(Nom_service) ON DELETE SET NULL ;
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm) ON DELETE CASCADE ;
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDc FOREIGN KEY (IDc) REFERENCES Creneaux(IDc);
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr) ON DELETE CASCADE;
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDa FOREIGN KEY (IDa) REFERENCES Administrateur(IDa);
ALTER TABLE souffre ADD CONSTRAINT FK_souffre_Nom_pathologie FOREIGN KEY (Nom_pathologie) REFERENCES Pathologie(Nom_pathologie);
ALTER TABLE souffre ADD CONSTRAINT FK_souffre_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE recoit ADD CONSTRAINT FK_recoit_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention) ON DELETE CASCADE ;
ALTER TABLE recoit ADD CONSTRAINT FK_recoit_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE a_comme ADD CONSTRAINT FK_a_comme_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm) ON DELETE CASCADE ;
ALTER TABLE a_comme ADD CONSTRAINT FK_a_comme_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);