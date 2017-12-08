SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0;

INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_JM1548","Méduse","Jean","Imagerie médicale","jean.meduse@gmail.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_AL4975","Lamin","André","Imagerie médicale","a.lamin@outlook.fr");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_RD2906","Dupont","Roger","Chirurgie","roger.dupont@gmail.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_MD1094","Daramont","Michelle","Chirurgie","michmich_daramont@outlook.fr");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_VD1984","Dunkel","Valentine","Odontologie","val.dunkel@gmail.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_MF5583","Friedman","Marc","Pédiatrie","marc.friedman@outlook.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_DJ7953","Jackson","Dan","Pédiatrie","jackson.d@gmail.com");

INSERT INTO `administrateur`(`IDa`, `Nom`, `Prenom`) VALUES ("A_IS3894","Somer","Ian");

INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Radiologie","60", "R_JR3942");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Prise de sang","30", "R_HB1029");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("IRM","60", "R_MI0398");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Chirurgie","180", "R_MC1290");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Extraction dentaire","30", "R_JD5903");
INSERT INTO `type_d_intervention`(`Nom_intervention`, `Duree`, `IDr`) VALUES ("Demande de contraception","60", "R_EO1647");

INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`,`Mail`) VALUES ("R_JR3942","Radioguy","Jean-Michel","Radiologie","j-m.radioguy@gmail.com");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`,`Mail`) VALUES ("R_HB1029","Bloodman","Henri","Prise de sang","henri.bloodman@gmail.com");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`,`Mail`) VALUES ("R_MI0398","Irman","Marcus","IRM","irman_marcus@gmail.com");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`,`Mail`) VALUES ("R_MC1290","Chirurguy","Miles","Chirurgie","miles.chirurguy@outlook.fr");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`,`Mail`) VALUES ("R_JD5903","Dentis","Jeanne","Extraction dentaire","jeanne_dentis@gmail.com");
INSERT INTO `responsable_d_intervention`(`IDr`, `Nom`, `Prenom`, `Nom_intervention`,`Mail`) VALUES ("R_EO1647","Olvira","Etienne","Demande de contraception","etienne_ol@gmail.com");

INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Rhume","1");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Grippe","2");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Jambe cassé","5");
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

INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","0");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","7");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","5");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","11");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MF5583","3");

INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Imagerie médicale","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Chirurgie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Odontologie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Pédiatrie","250");

INSERT INTO `creneaux` (`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`, `Deplacement`) VALUES
(0, '2017-11-28', '08:00:00', '09:00:00', '2017-11-18', 3, 'Radiologie', NULL, "0"),
(1, '2017-12-08', '08:00:00', '08:30:00', '2017-11-18', 9, 'Prise de sang', NULL, "0"),
(2, '2017-12-08', '09:00:00', '09:30:00', '2017-11-18', 12, 'Prise de sang', NULL, "0"),
(3, '2017-12-04', '11:00:00', '14:00:00', '2017-11-18', 7, 'Extraction dentaire', NULL, "0"),
(4, '2017-11-28', '09:00:00', '10:00:00', '2017-11-18', 4, 'Radiologie', NULL, "0"),
(5, '2017-12-05', '09:00:00', '10:00:00', '2017-11-18', 6, 'Radiologie', NULL, "0"),
(6, '2017-12-08', '08:00:00', '09:00:00', '2017-11-18', 4, 'Radiologie', 5, "0"),
(7, '2017-12-08', '09:00:00', '10:00:00', '2017-11-18', 6, 'Radiologie', 5, "0"),
(8, '2017-12-08', '10:00:00', '11:00:00', '2017-11-18', 7, 'Radiologie', 5, "0"),
(9, '2017-12-08', '11:00:00', '12:00:00', '2017-11-18', 8, 'Radiologie', 5, "0"),
(10, '2017-12-08', '12:00:00', '13:00:00', '2017-11-18', 9, 'Radiologie', 5, "0"),
(11, '2017-12-08', '13:00:00', '14:00:00', '2017-11-18', 10, 'Radiologie', 4, "0"),
(13, '2017-12-08', '14:00:00', '15:00:00', '2017-11-18', 12, 'Radiologie', 4, "0"),
(15, '2017-12-08', '16:00:00', '17:00:00', '2017-11-18', 7, 'Radiologie', 3, "0"),
(16, '2017-12-08', '17:00:00', '18:00:00', '2017-11-18', 2, 'Radiologie', 2, "0"),
(17, '2017-12-08', '18:00:00', '19:00:00', '2017-11-18', 3, 'Radiologie', 2, "0"),
(18, '2017-12-08', '19:00:00', '20:00:00', '2017-11-18', 5, 'Radiologie', 2, "0"),
(19, '2017-12-11', '08:00:00', '09:00:00', '2017-11-18', 4, 'Radiologie', 5, "0"),
(20, '2017-12-11', '09:00:00', '10:00:00', '2017-11-18', 6, 'Radiologie', 5, "0"),
(21, '2017-12-11', '10:00:00', '11:00:00', '2017-11-18', 7, 'Radiologie', 5, "0"),
(22, '2017-12-11', '11:00:00', '12:00:00', '2017-11-18', 8, 'Radiologie', 5, "0"),
(23, '2017-12-11', '12:00:00', '13:00:00', '2017-11-18', 9, 'Radiologie', 5, "0"),
(24, '2017-12-11', '13:00:00', '14:00:00', '2017-11-18', 10, 'Radiologie', 4, "0"),
(25, '2017-12-11', '14:00:00', '15:00:00', '2017-11-18', 12, 'Radiologie', 4, "0"),
(26, '2017-12-11', '15:00:00', '16:00:00', '2017-11-18', 6, 'Radiologie', 3, "0"),
(27, '2017-12-07', '16:00:00', '17:00:00', '2017-11-18', 7, 'Radiologie', 3, "0"),
(28, '2017-12-07', '17:00:00', '18:00:00', '2017-11-18', 2, 'Radiologie', 2, "0"),
(29, '2017-12-07', '18:00:00', '19:00:00', '2017-11-18', 3, 'Radiologie', 2, "0"),
(30, '2017-12-07', '19:00:00', '20:00:00', '2017-11-18', 5, 'Radiologie', 2, "0"),
(31, '2017-12-07', '08:00:00', '09:00:00', '2017-11-18', 4, 'Radiologie', 5, "0"),
(32, '2017-12-08', '08:00:00', '11:00:00', '2017-11-18', 2, 'Chirurgie', 5, "0"),
(33, '2017-12-08', '11:00:00', '14:00:00', '2017-11-18', 3, 'Chirurgie', 4, "0"),
(34, '2017-12-08', '14:00:00', '17:00:00', '2017-11-18', 5, 'Chirurgie', 3, "0"),
(35, '2017-12-08', '17:00:00', '20:00:00', '2017-11-18', 4, 'Chirurgie', 2, "0");


INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Rhume","0");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Rhume","1");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hémorragie","2");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","3");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","4");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Grippe","5");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","6");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","7");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Grippe","8");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","9");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","10");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","11");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","12");

INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Radiologie","3");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Radiologie","4");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Extraction dentaire","7");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Prise de sang","9");
INSERT INTO `recoit`(`Nom_intervention`, `IDp`) VALUES ("Prise de sang","12");

INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("0", "94803jean", "Medecin","M_JM1548");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("1", "06478andre", "Medecin","M_AL4975");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("2", "39489roger", "Medecin","M_RD2906");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("3", "93849michelle", "Medecin","M_MD1094");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("4", "93389marc", "Medecin","M_MF5583");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("5", "09483valentine", "Medecin","M_VD1984");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDm`) VALUES ("6", "18946dan", "Medecin","M_DJ7953");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDa`) VALUES ("7","29481somer", "Admin","A_IS3894");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("8", "34908jean-michel", "Responsable","R_JR3942");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("9","18610henri", "Responsable","R_HB1029");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("10","23098marcus", "Responsable","R_MI0398");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("11","18642miles", "Responsable","R_MC1290");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("12","13587jeanne", "Responsable","R_JD5903");
INSERT INTO `utilisateur`(`IDu`, `Mdp`, `User_type`,`IDr`) VALUES ("13","78634etienne", "Responsable","R_EO164");

UPDATE `patient` SET `Nom_service`="Radiologie" WHERE `IDp`="3";
UPDATE `patient` SET `Nom_service`="Radiologie" WHERE `IDp`="4";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="7";
UPDATE `patient` SET `Nom_service`="Pédiatrie" WHERE `IDp`="9";
UPDATE `patient` SET `Nom_service`="Pédiatrie" WHERE `IDp`="12";

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
