#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

DROP DATABASE projet_web;

CREATE DATABASE projet_web CHARACTER SET utf8 COLLATE utf8_general_ci;

#------------------------------------------------------------
# Table: Medecin
#------------------------------------------------------------

CREATE TABLE projet_web.Medecin(
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

CREATE TABLE projet_web.Responsable_d_intervention(
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

CREATE TABLE projet_web.Administrateur(
        IDa    Varchar (25) NOT NULL ,
        Nom    Varchar (25) NOT NULL ,
        Prenom Varchar (25) NOT NULL ,
        PRIMARY KEY (IDa )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Creneaux
#------------------------------------------------------------

CREATE TABLE projet_web.Creneaux(
        IDc                     int (11) Auto_increment  NOT NULL ,
        Date_creneau            Date NOT NULL ,
        Heure_debut             Varchar (25) NOT NULL ,
        Heure_fin               Varchar (25) NOT NULL ,
        Date_priseRDV           Date NOT NULL ,
        IDp                     Int NOT NULL ,
        Nom_intervention        Varchar (25) ,
        Niveau_priorite         Int ,
        Deplacement             Int ,
        PRIMARY KEY (IDc )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Service daccueil
#------------------------------------------------------------

CREATE TABLE projet_web.Service_d_accueil(
        Nom_service Varchar (25) NOT NULL ,
        Facture     Double ,
        PRIMARY KEY (Nom_service)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type dintervention
#------------------------------------------------------------

CREATE TABLE projet_web.Type_d_intervention(
        Nom_intervention Varchar (25) NOT NULL ,
        Duree            Int NOT NULL ,
        IDr              Varchar (25) NOT NULL ,
        PRIMARY KEY (Nom_intervention )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Patient
#------------------------------------------------------------

CREATE TABLE projet_web.Patient(
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

CREATE TABLE projet_web.Pathologie(
        Nom_pathologie Varchar (25) NOT NULL ,
        Niveau_urgence Int NOT NULL ,
        PRIMARY KEY (Nom_pathologie )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE projet_web.Utilisateur(
        IDu       int (11) Auto_increment  NOT NULL ,
        Mdp       Varchar (25) NOT NULL ,
        User_type Varchar (25) NOT NULL ,
        IDm       Varchar (25) ,
        IDr       Varchar (25) ,
        IDa       Varchar (25) ,
        PRIMARY KEY (IDu )
)ENGINE=InnoDB;



#------------------------------------------------------------
# Table: souffre
#------------------------------------------------------------

CREATE TABLE projet_web.souffre(
        Nom_pathologie Varchar (25) NOT NULL ,
        IDp            Int NOT NULL ,
        PRIMARY KEY (Nom_pathologie ,IDp )
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: a comme
#------------------------------------------------------------

CREATE TABLE projet_web.a_comme(
        IDm Varchar (25) NOT NULL ,
        IDp Int NOT NULL ,
        PRIMARY KEY (IDm ,IDp )
)ENGINE=InnoDB;

ALTER TABLE projet_web.Utilisateur ADD CONSTRAINT FK_Utilisateur_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm) ON DELETE CASCADE ;
ALTER TABLE projet_web.Utilisateur ADD CONSTRAINT FK_Utilisateur_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr) ON DELETE CASCADE ;
ALTER TABLE projet_web.Utilisateur ADD CONSTRAINT FK_Utilisateur_IDa FOREIGN KEY (IDa) REFERENCES Administrateur(IDa);
ALTER TABLE projet_web.Medecin ADD CONSTRAINT FK_Medecin_Nom_service FOREIGN KEY (Nom_service) REFERENCES Service_d_accueil(Nom_service) ON DELETE SET NULL;
ALTER TABLE projet_web.Responsable_d_intervention ADD CONSTRAINT FK_Responsable_d_intervention_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention) ON DELETE SET NULL;
ALTER TABLE projet_web.Creneaux ADD CONSTRAINT FK_Creneaux_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE projet_web.Creneaux ADD CONSTRAINT FK_Creneaux_Nom_intervention FOREIGN KEY (Nom_intervention) REFERENCES Type_d_intervention(Nom_intervention) ON DELETE SET NULL;
ALTER TABLE projet_web.Type_d_intervention ADD CONSTRAINT FK_Type_d_intervention_IDr FOREIGN KEY (IDr) REFERENCES Responsable_d_intervention(IDr);
ALTER TABLE projet_web.Patient ADD CONSTRAINT FK_Patient_Nom_service FOREIGN KEY (Nom_service) REFERENCES Service_d_accueil(Nom_service) ON DELETE SET NULL ;
ALTER TABLE projet_web.souffre ADD CONSTRAINT FK_souffre_Nom_pathologie FOREIGN KEY (Nom_pathologie) REFERENCES Pathologie(Nom_pathologie);
ALTER TABLE projet_web.souffre ADD CONSTRAINT FK_souffre_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);
ALTER TABLE projet_web.a_comme ADD CONSTRAINT FK_a_comme_IDm FOREIGN KEY (IDm) REFERENCES Medecin(IDm) ON DELETE CASCADE ;
ALTER TABLE projet_web.a_comme ADD CONSTRAINT FK_a_comme_IDp FOREIGN KEY (IDp) REFERENCES Patient(IDp);