SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0; 

INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_JMeduse","Méduse","Jean","94803jean");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_ALamin","Lamin","André","06478andre");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_RDupont","Dupont","Roger","39489roger");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_MDaramont","Daramont","Michelle","93849michelle");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_VDunkel","Dunkel","Valentine","09483valentine");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_MFriedman","Friedman","Marc","10293marc");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Mdp`) VALUES ("M_DJackson","Jackson","Dan","18946dan");

INSERT INTO `administrateur`(`IDa`, `Nom`, `Prenom`, `Mdp`) VALUES ("A_ISomer","Somer","Ian","29481somer");

INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`) VALUES ("Radio","60");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`) VALUES ("Prise_de_sang","30");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`) VALUES ("IRM","60");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`) VALUES ("Chirurgie","180");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`) VALUES ("Dentisterie","30");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`) VALUES ("Gynécologie","60");

INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Mdp`, `Nom_intervention`) VALUES ("R_JMRadioguy","Radioguy","Jean-Michel","34908jean-michel","Radio");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Mdp`, `Nom_intervention`) VALUES ("R_HBloodman","Bloodman","Henri","18610henri","Prise de sang");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Mdp`, `Nom_intervention`) VALUES ("R_MIrman","Irman","Marcus","23098marcus","IRM");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Mdp`, `Nom_intervention`) VALUES ("R_MChirurguy","Chirurguy","Miles","18642miles","Chirurgie");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Mdp`, `Nom_intervention`) VALUES ("R_JDentis","Dentis","Jeanne","13587jeanne","Dentisterie");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Mdp`, `Nom_intervention`) VALUES ("R_EOlvira","Olvira","Etienne","78634etienne","Gynécologie");

INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Rhume","1");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Grippe","2");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Membre_cassé","5");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Hépatite","3");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Cancer","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Diabète","3");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Hémorragie","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Carie","2");

INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("0","Aber","Pierre","0 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("1","Bad","Michael","1 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("2","Car","Ulysse","2 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("3","Denoit","Benoit","3 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("4","Eleyta","Yvonne","4 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("5","Freiya","Wilfred","5 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("6","Huissie","Diane","6 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("7","Ino","Ines","7 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("8","Juino","Julie","8 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("9","Kim","Kang Ho","9 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("10","Meunier","Pierre","10 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("11","Nouny","Olivier","11 rue","06","0","","");
INSERT INTO `patient`(`IDp`, `Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `IDc`, `Nom_service`) VALUES ("12","Oryanna","Thomas","12 rue","06","0","","");

INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JMeduse","0");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JMeduse","7");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VDunkel","5");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MDaramont","11");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MFriedman","3");

INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`, `IDm`) VALUES ("Radiologie","250","M_JMeduse");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`, `IDm`) VALUES ("Chirurgie","250","M_VDunkel");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`, `IDm`) VALUES ("Dentisterie","250","M_MDaramont");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`, `IDm`) VALUES ("Analyse_sanguine","250","M_MFriedman");

INSERT INTO `planning`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `Nom_intervention`) VALUES ("1","2017-11-19","2017-11-19 08:00:00","2017-11-19 09:00:00","2017-11-18","Radio");
INSERT INTO `planning`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `Nom_intervention`) VALUES ("2","2017-11-19","2017-11-19 08:00:00","2017-11-19 08:30:00","2017-11-18","Prise_de_sang");
INSERT INTO `planning`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `Nom_intervention`) VALUES ("3","2017-11-19","2017-11-19 08:00:00","2017-11-19 11:00:00","2017-11-18","Prise_de_sang");
INSERT INTO `planning`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `Nom_intervention`) VALUES ("4","2017-11-19","2017-11-19 11:00:00","2017-11-19 14:00:00","2017-11-18","Dentisterie");
INSERT INTO `planning`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `Nom_intervention`) VALUES ("5","2017-11-19","2017-11-19 09:00:00","2017-11-19 10:00:00","2017-11-18","Radio");

INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Rhume","0");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Rhume","1");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hémorragie","2");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Membre_cassé","3");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Membre_cassé","4");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Grippe","5");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Grippe","6");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carrie","7");
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

UPDATE `patient` SET `IDc`="1" WHERE `IDp`="3";
UPDATE `patient` SET `IDc`="2" WHERE `IDp`="9";
UPDATE `patient` SET `IDc`="3" WHERE `IDp`="12";
UPDATE `patient` SET `IDc`="5" WHERE `IDp`="4";
UPDATE `patient` SET `IDc`="4" WHERE `IDp`="7";

UPDATE `patient` SET `Niveau_priorite`=(SELECT `Niveau_urgence` FROM `pathologie` WHERE `Nom_pathologie`="Membre_cassé") WHERE `IDc`="1";
UPDATE `patient` SET `Niveau_priorite`=(SELECT `Niveau_urgence` FROM `pathologie` WHERE `Nom_pathologie`="Membre_cassé") WHERE `IDc`="5";
UPDATE `patient` SET `Niveau_priorite`=(SELECT `Niveau_urgence` FROM `pathologie` WHERE `Nom_pathologie`="Diabète") WHERE `IDc`="2";
UPDATE `patient` SET `Niveau_priorite`=(SELECT `Niveau_urgence` FROM `pathologie` WHERE `Nom_pathologie`="Hépatite") WHERE `IDc`="3";
UPDATE `patient` SET `Niveau_priorite`=(SELECT `Niveau_urgence` FROM `pathologie` WHERE `Nom_pathologie`="Carie") WHERE `IDc`="4";

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET SQL_NOTES=@OLD_SQL_NOTES; 
