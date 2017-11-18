#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: M�decin
#------------------------------------------------------------

CREATE TABLE Medecin(
        IDm    Varchar (25) NOT NULL ,
        Nom    Varchar (25) NOT NULL ,
        Prenom Varchar (25) NOT NULL ,
        Mdp    Varchar (25) NOT NULL ,
        PRIMARY KEY (IDm )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Responsable d'intervention
#------------------------------------------------------------

CREATE TABLE Responsable_d_intervention(
        IDr              Varchar (25) NOT NULL ,
        Nom              Varchar (25) NOT NULL ,
        Prenom           Varchar (25) NOT NULL ,
        Mdp              Varchar (25) NOT NULL ,
        Nom_intervention Varchar (25) NOT NULL ,
        PRIMARY KEY (IDr )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Administrateur
#------------------------------------------------------------

CREATE TABLE Administrateur(
        IDa    Varchar (25) NOT NULL ,
        Nom    Varchar (25) NOT NULL ,
        Prenom Varchar (25) NOT NULL ,
        Mdp    Varchar (25) NOT NULL ,
        PRIMARY KEY (IDa )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Planning
#------------------------------------------------------------

CREATE TABLE Planning(
        IDc               int (11) Auto_increment  NOT NULL ,
        Date_creneau      Date NOT NULL ,
        Heure_debut       Datetime NOT NULL ,
        Heure_fin         Datetime NOT NULL ,
        Date_priseRDV     Date NOT NULL ,
        Type_intervention Varchar (25) NOT NULL ,
        PRIMARY KEY (IDc )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Service d'accueil
#------------------------------------------------------------

CREATE TABLE Service_d_accueil(
        Nom_service Varchar (25) NOT NULL ,
        Facture     Double NOT NULL ,
        IDm         Varchar (25) NOT NULL ,
        IDp         Int NOT NULL ,
        PRIMARY KEY (Nom_service )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type d'intervention
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
        Adresse         Varchar (25) NOT NULL ,
        Numero_tel      Varchar (25) NOT NULL ,
        Niveau_priorite Int NOT NULL ,
        IDc             Int NOT NULL ,
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
# Table: peut visualiser
#------------------------------------------------------------

CREATE TABLE peut_visualiser(
        IDm Varchar (25) NOT NULL ,
        IDc Int NOT NULL ,
        IDr Varchar (25) NOT NULL ,
        IDa Varchar (25) NOT NULL ,
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
# Table: re�oit
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

ALTER TABLE Responsable_d_intervention ADD CONSTRAINT FK_Responsable_d_intervention_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention);
ALTER TABLE Service_d_accueil ADD CONSTRAINT FK_Service_d_accueil_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm);
ALTER TABLE Service_d_accueil ADD CONSTRAINT FK_Service_d_accueil_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE Type_d_intervention ADD CONSTRAINT FK_Type_d_intervention_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr);
ALTER TABLE Patient ADD CONSTRAINT FK_Patient_IDc FOREIGN KEY (IDc) REFERENCES Planning(IDc);
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm);
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDc FOREIGN KEY (IDc) REFERENCES Planning(IDc);
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr);
ALTER TABLE peut_visualiser ADD CONSTRAINT FK_peut_visualiser_IDa FOREIGN KEY (IDa) REFERENCES Administrateur(IDa);
ALTER TABLE souffre ADD CONSTRAINT FK_souffre_Nom_pathologie FOREIGN KEY (Nom_pathologie) REFERENCES Pathologie(Nom_pathologie);
ALTER TABLE souffre ADD CONSTRAINT FK_souffre_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE recoit ADD CONSTRAINT FK_recoit_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention);
ALTER TABLE recoit ADD CONSTRAINT FK_recoit_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE a_comme ADD CONSTRAINT FK_a_comme_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm);
ALTER TABLE a_comme ADD CONSTRAINT FK_a_comme_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
