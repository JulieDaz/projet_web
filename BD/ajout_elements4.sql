SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0;

INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_JMeduse","Méduse","Jean","Radiologie");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_ALamin","Lamin","André","Radiologie");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_RDupont","Dupont","Roger","Chirurgie");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_MDaramont","Daramont","Michelle","Chirurgie");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_VDunkel","Dunkel","Valentine","Dentisterie");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_MFriedman","Friedman","Marc","Analyse_sanguine");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`) VALUES ("M_DJackson","Jackson","Dan","Analyse_sanguine");

INSERT INTO `administrateur`(`IDa`, `Nom`, `Prenom`) VALUES ("A_ISomer","Somer","Ian");

INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Radio","60", "R_JMRadioguy");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Prise_de_sang","30", "R_HBloodman");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("IRM","60", "R_MIrman");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Chirurgie","180", "R_MChirurguy");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Dentisterie","30", "R_JDentis");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Gynécologie","60", "R_EOlvira");

INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`) VALUES ("R_JMRadioguy","Radioguy","Jean-Michel","Radio");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`) VALUES ("R_HBloodman","Bloodman","Henri","Prise de sang");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`) VALUES ("R_MIrman","Irman","Marcus","IRM");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`) VALUES ("R_MChirurguy","Chirurguy","Miles","Chirurgie");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`) VALUES ("R_JDentis","Dentis","Jeanne","Dentisterie");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`) VALUES ("R_EOlvira","Olvira","Etienne","Gynécologie");

INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Rhume","1");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Grippe","2");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Membre_cassé","5");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Hépatite","3");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Cancer","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Diabète","3");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Hémorragie","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Carie","2");

INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES ("0","Aber","Pierre","0 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("1","Bad","Michael","1 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("2","Car","Ulysse","2 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("3","Denoit","Benoit","3 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("4","Eleyta","Yvonne","4 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("5","Freiya","Wilfred","5 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("6","Huissie","Diane","6 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("7","Ino","Ines","7 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("8","Juino","Julie","8 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("9","Kim","Kang Ho","9 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("10","Meunier","Pierre","10 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("11","Nouny","Olivier","11 rue","06","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("12","Oryanna","Thomas","12 rue","06","0","");

INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JMeduse","0");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JMeduse","7");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VDunkel","5");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MDaramont","11");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MFriedman","3");

INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Radiologie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Chirurgie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Dentisterie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Analyse_sanguine","250");

INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`) VALUES ("0","2017-11-28","08:00:00","09:00:00","2017-11-18","3","Radio");
INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`) VALUES ("1","2017-12-05","08:00:00","08:30:00","2017-11-18","9","Prise_de_sang");
INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`) VALUES ("2","2017-12-05","09:00:00","09:30:00","2017-11-18","12","Prise_de_sang");
INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`) VALUES ("3","2017-12-04","11:00:00","14:00:00","2017-11-18","7","Dentisterie");
INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`) VALUES ("4","2017-11-28","09:00:00","10:00:00","2017-11-18","4","Radio");
INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`) VALUES ("5","2017-12-06","09:00:00","10:00:00","2017-11-18","6","Radio");

-- Test surbooking
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`) VALUES ("7","2017-12-02","09:00:00","10:00:00","2017-11-18","6","Radio","5");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`) VALUES ("8","2017-12-02","10:00:00","11:00:00","2017-11-18","7","Radio","5");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("9","2017-12-02","11:00:00","12:00:00","2017-11-18","8","Radio","5");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("10","2017-12-02","12:00:00","13:00:00","2017-11-18","9","Radio","5");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("11","2017-12-02","13:00:00","14:00:00","2017-11-18","10","Radio","4");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("13","2017-12-02","14:00:00","15:00:00","2017-11-18","12","Radio","4");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("14","2017-12-02","15:00:00","16:00:00","2017-11-18","6","Radio","3");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("15","2017-12-02","16:00:00","17:00:00","2017-11-18","7","Radio","3");
INSERT INTO `creneaux`(`IDc`,`Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`,`Niveau_priorite`) VALUES ("16","2017-12-02","17:00:00","18:00:00","2017-11-18","2","Radio","2");


INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Rhume","0");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Rhume","1");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hémorragie","2");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Membre_cassé","3");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Membre_cassé","4");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Grippe","5");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Membre_cassé","6");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","7");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Grippe","8");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","9");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","10");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","11");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","12");

INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Radio","3");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Radio","4");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Dentisterie","7");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Prise_de_sang","9");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Prise_de_sang","12");

INSERT INTO `peut_visualiser`(`IDm`, `IDc`, `IDr`, `IDa`) VALUES ("M_JMeduse","1","R_JMRadioguy","A_ISomer");
INSERT INTO `peut_visualiser`(`IDm`, `IDc`, `IDr`, `IDa`) VALUES ("M_ALamin","2","R_HBloodman","A_ISomer");
INSERT INTO `peut_visualiser`(`IDm`, `IDc`, `IDr`, `IDa`) VALUES ("M_RDupont","3","R_MChirurguy","A_ISomer");
INSERT INTO `peut_visualiser`(`IDm`, `IDc`, `IDr`, `IDa`) VALUES ("M_RDupont","4","R_MChirurguy","A_ISomer");
INSERT INTO `peut_visualiser`(`IDm`, `IDc`, `IDr`, `IDa`) VALUES ("M_MFriedman","5","R_JMRadioguy","A_ISomer");

INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("0", "94803jean", "Medecin","M_JMeduse");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("1", "06478andre", "Medecin","M_ALamin");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("2", "39489roger", "Medecin","M_RDupont");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("3", "93849michelle", "Medecin","M_MDaramont");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("4", "93389marc", "Medecin","M_MFriedman");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("5", "09483valentine", "Medecin","M_VDunkel");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("6", "18946dan", "Medecin","M_DJackson");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDa`) VALUES ("7","29481somer", "Admin","A_ISomer");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("8", "34908jean-michel", "Responsable","R_JMRadioguy");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("9","18610henri", "Responsable","R_HBloodman");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("10","23098marcus", "Responsable","R_MIrman");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("11","18642miles", "Responsable","R_MChirurguy");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("12","13587jeanne", "Responsable","R_JDentis");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("13","78634etienne", "Responsable","R_EOlvira");

UPDATE `type_d_intervention` SET `IDr`="R_JMRadioguy" WHERE `Nom_intervention`="Radio";
UPDATE `type_d_intervention` SET `IDr`="R_HBloodman" WHERE `Nom_intervention`="Prise_de_sang";
UPDATE `type_d_intervention` SET `IDr`="R_MIrman" WHERE `Nom_intervention`="IRM";
UPDATE `type_d_intervention` SET `IDr`="R_MChirurguy" WHERE `Nom_intervention`="Chirurgie";
UPDATE `type_d_intervention` SET `IDr`="R_JDentis" WHERE `Nom_intervention`="Dentisterie";
UPDATE `type_d_intervention` SET `IDr`="R_EOlvira" WHERE `Nom_intervention`="Gynécologie";

UPDATE `patient` SET `Nom_service`="Radiologie" WHERE `IDp`="3";
UPDATE `patient` SET `Nom_service`="Radiologie" WHERE `IDp`="4";
UPDATE `patient` SET `Nom_service`="Dentisterie" WHERE `IDp`="7";
UPDATE `patient` SET `Nom_service`="Analyse_sanguine" WHERE `IDp`="9";
UPDATE `patient` SET `Nom_service`="Analyse_sanguine" WHERE `IDp`="12";

UPDATE `patient` SET `Niveau_priorite`= "5" WHERE `IDp`= "3";
UPDATE `patient` SET `Niveau_priorite`= "5" WHERE `IDp`= "4";
UPDATE `patient` SET `Niveau_priorite`= "2" WHERE `IDp`= "7";
UPDATE `patient` SET `Niveau_priorite`= "3" WHERE `IDp`= "9";
UPDATE `patient` SET `Niveau_priorite`= "3" WHERE `IDp`= "12";

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET SQL_NOTES=@OLD_SQL_NOTES;
