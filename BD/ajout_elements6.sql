SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0;

INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_JM1548","Méduse","Jean","Imagerie médicale","jean.meduse@gmail.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_AL4975","Lamin","André","Gynécologie","a.lamin@outlook.fr");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_RD2906","Dupont","Roger","Chirurgie","roger.dupont@gmail.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_MD1094","Daramont","Michelle","Analyse sanguine","michmich_daramont@outlook.fr");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_VD1984","Dunkel","Valentine","Odontologie","val.dunkel@gmail.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_MF5583","Friedman","Marc","Pédiatrie","marc.friedman@outlook.com");
INSERT INTO `medecin` (`IDm`,`Nom`,`Prenom`,`Nom_service`,`Mail`) VALUES ("M_DJ7953","Jackson","Dan","Traumatologie","jackson.d@gmail.com");

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
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Jambe cassée","5");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Hépatite","3");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Cancer","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Diabète","3");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Hémorragie","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Carie","2");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Controle","1");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Bras cassé","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Main cassée","4");
INSERT INTO `pathologie`(`Nom_pathologie`, `Niveau_urgence`) VALUES ("Pied cassé","4");


INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES ("0","Aber","Pierre","0 rue","0628391023","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("1","Bad","Michael","1 rue","0656394725","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("2","Car","Ulysse","2 rue","0610122312","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("3","Denoit","Benoit","3 rue","0625417960","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("4","Eleyta","Yvonne","4 rue","0633740037","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("5","Freiya","Wilfred","5 rue","0626331121","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("6","Huissie","Diane","6 rue","0637774653","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("7","Ino","Ines","7 rue","0600900351","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("8","Juino","Julie","8 rue","0636662531","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("9","Kim","Kang Ho","9 rue","0612532163","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("10","Meunier","Pierre","10 rue","0626194012","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("11","Nouny","Olivier","11 rue","0611114739","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("12","Oryanna","Thomas","12 rue","0609876543","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("13","Pettigrow", "Patrick","13 rue","0612233445","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("14","Quentin","Eva","14 rue","06","012345678","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("15","Romanov","Dymitry","15 rue","0614119976","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("16","Saywer","Amerigo","16 rue","0637102384","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("17","Tontesse","Tim","17 rue","0607987654","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("18","Uvak","Ignacio","18 rue","0634791093","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("19","Victore","Ezio","19 rue","0645872394","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("20","Wilfrid","Will","20 rue","0610923748","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("21","Xanadu","Hypolyte","21 rue","0624509970","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("22","Ynis","Rahim","22 rue","0612654943","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("23","Zebra","Ryan","23 rue","0612731463","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("24","Aeon","Peter","24 rue","0632959001","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("25","Bono","Theriou","25 rue","0676793469","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("26","Cazeniere","Marc","26 rue","0698328570","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("27","Digu","Bastila","27 rue","0612748259","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("28","Expelliar","Zazie","28 rue","0647132959","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("29","Fry","Rita","29 rue","0628734987","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("30","Guanine","Pierre","30 rue","0612837923","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("31","Hyste","Hélène","31 rue","0621736491","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("32","Io","Ico","32 rue","0623712313","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("33","Jan","Gustave","33 rue","0623012885","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("34","Krys","Christophe","34 rue","0647568123","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("35","Lavie","Drago","35 rue","0623987234","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("36","Menelas","Arthur","36 rue","0612221830","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("37","Nono","Nicolas","37 rue","0612837657","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("38","Octopa","Fleur","38 rue","0621387715","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("39","Potter","Tom","39 rue","0623664516","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("40","Quinn","John","40 rue","0623761275","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("41","Rasput","Dartagnan","41 rue","0612387563","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("42","Suinn","David","42 rue","0659281365","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("43","Tomassia","Alex","43 rue","0623809778","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("44","Ulule","Julie","44 rue","0698568097","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("45","Valchier","Calypso","45 rue","0635980718","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("46","Wend","Ren","46 rue","0638600001","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("47","Xyvern","Dazie","47 rue","0641253959","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("48","Yin","Roger","48 rue","0623524231","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("49","Zeb","Aurélie","49 rue","0613875872","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("50","Azea","Ines","50 rue","0613578723","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("51","Bud","Ewan","51 rue","0620846512","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("52","Crap","Christina","52 rue","0635761495","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("53","Dionysos","David","53 rue","0607989848","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("54","Evie","Rachel","54 rue","0623574612","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("55","Firefly","Felicien","55 rue","0639508633","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("56","Glucor","Daz","56 rue","0626351243","0","");
INSERT INTO `patient`(`IDp`,`Nom`, `Prenom`, `Adresse`, `Numero_tel`, `Niveau_priorite`, `Nom_service`) VALUES("57","Hessen","Dominic","57 rue","0668776656","0","");


INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","2");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","3");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","4");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MF5583","5");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_DJ7953","6");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","7");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","8");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","9");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","10");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","11");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","12");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","13");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","14");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","15");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","16");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","17");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","18");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","19");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","20");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","21");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","22");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","23");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","24");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","25");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","26");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","27");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","28");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","29");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","30");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","31");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","32");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","33");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MF5583","34");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_DJ7953","35");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","36");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","37");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","38");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","39");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","40");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MF5583","41");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_DJ7953","42");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","43");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","44");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","45");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","46");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","47");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MF5583","48");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_DJ7953","49");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","50");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_RD2906","51");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_JM1548","52");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_AL4975","53");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_VD1984","54");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MF5583","55");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_DJ7953","56");
INSERT INTO `a_comme`(`IDm`, `IDp`) VALUES ("M_MD1094","57");

INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Imagerie médicale","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Chirurgie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Odontologie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Analyse sanguine","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Gynécologie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Pédiatrie","250");
INSERT INTO `service_d_accueil`(`Nom_service`, `Facture`) VALUES ("Traumatologie","250");

INSERT INTO `creneaux` (`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`, `Deplacement`) VALUES
(0, '2017-12-18', '08:00:00', '09:00:00', '2017-11-18', 4, 'Radiologie', 5, "0"),
(1, '2017-12-18', '09:00:00', '10:00:00', '2017-11-18', 6, 'Radiologie', 5, "0"),
(2, '2017-12-18', '10:00:00', '11:00:00', '2017-11-18', 7, 'Radiologie', 5, "0"),
(3, '2017-12-18', '11:00:00', '12:00:00', '2017-11-18', 8, 'Radiologie', 5, "0"),
(4, '2017-12-18', '12:00:00', '13:00:00', '2017-11-18', 9, 'Radiologie', 5, "0"),
(5, '2017-12-18', '13:00:00', '14:00:00', '2017-11-18', 10, 'Radiologie', 4, "0"),
(6, '2017-12-18', '14:00:00', '15:00:00', '2017-11-18', 12, 'Radiologie', 4, "0"),
(7, '2017-12-18', '16:00:00', '17:00:00', '2017-11-18', 7, 'Radiologie', 3, "0"),
(8, '2017-12-18', '17:00:00', '18:00:00', '2017-11-18', 2, 'Radiologie', 2, "0"),
(9, '2017-12-18', '18:00:00', '19:00:00', '2017-11-18', 3, 'Radiologie', 2, "0"),
(10, '2017-12-18', '19:00:00', '20:00:00', '2017-11-18', 5, 'Radiologie', 2, "0"),
(11, '2017-12-19', '08:00:00', '09:00:00', '2017-11-18', 4, 'Radiologie', 5, "0"),
(12, '2017-12-19', '09:00:00', '10:00:00', '2017-11-18', 6, 'Radiologie', 5, "0"),
(13, '2017-12-19', '10:00:00', '11:00:00', '2017-11-18', 7, 'Radiologie', 5, "0"),
(14, '2017-12-19', '11:00:00', '12:00:00', '2017-11-18', 8, 'Radiologie', 5, "0"),
(15, '2017-12-19', '12:00:00', '13:00:00', '2017-11-18', 9, 'Radiologie', 5, "0"),
(16, '2017-12-19', '13:00:00', '14:00:00', '2017-11-18', 10, 'Radiologie', 4, "0"),
(17, '2017-12-19', '14:00:00', '15:00:00', '2017-11-18', 12, 'Radiologie', 4, "0"),
(18, '2017-12-19', '15:00:00', '16:00:00', '2017-11-18', 6, 'Radiologie', 3, "0"),
(19, '2017-12-19', '16:00:00', '17:00:00', '2017-11-18', 7, 'Radiologie', 3, "0"),
(20, '2017-12-19', '17:00:00', '18:00:00', '2017-11-18', 2, 'Radiologie', 2, "0"),
(21, '2017-12-19', '18:00:00', '19:00:00', '2017-11-18', 3, 'Radiologie', 2, "0"),
(22, '2017-12-19', '19:00:00', '20:00:00', '2017-11-18', 5, 'Radiologie', 2, "0"),
(23, '2017-12-20', '08:00:00', '09:00:00', '2017-11-18', 4, 'Radiologie', 5, "0"),
(24, '2017-12-18', '08:00:00', '11:00:00', '2017-11-18', 2, 'Chirurgie', 5, "0"),
(25, '2017-12-18', '11:00:00', '14:00:00', '2017-11-18', 3, 'Chirurgie', 4, "0"),
(26, '2017-12-18', '14:00:00', '17:00:00', '2017-11-18', 5, 'Chirurgie', 3, "0"),
(27, '2017-12-18', '17:00:00', '20:00:00', '2017-11-18', 6, 'Chirurgie', 2, "0"),
(28, '2017-12-19', '09:00:00', '12:00:00', '2017-11-18', 4, 'Chirurgie', 2, "0"),
(29, '2017-12-18', '08:00:00', '08:30:00', '2017-11-18', 2, 'Prise de sang', 3, "0"),
(30, '2017-12-18', '08:30:00', '09:00:00', '2017-11-18', 12, 'Prise de sang', 1, "0"),
(31, '2017-12-18', '09:00:00', '09:30:00', '2017-11-18', 1, 'Prise de sang', 1, "0"),
(32, '2017-12-18', '09:30:00', '10:00:00', '2017-11-18', 8, 'Prise de sang', 3, "0"),
(33, '2017-12-18', '11:00:00', '11:30:00', '2017-11-18', 9, 'Prise de sang', 3, "0"),
(34, '2017-12-18', '12:00:00', '12:30:00', '2017-11-18', 1, 'Prise de sang', 3, "0"),
(35, '2017-12-18', '12:30:00', '13:00:00', '2017-11-18', 2, 'Prise de sang', 3, "0"),
(36, '2017-12-18', '17:00:00', '17:30:00', '2017-11-18', 3, 'Prise de sang', 3, "0"),
(37, '2017-12-19', '09:00:00', '10:00:00', '2017-11-18', 13, 'IRM', 4, "0"),
(38, '2017-12-19', '10:00:00', '11:00:00', '2017-11-18', 14, 'IRM', 4, "0"),
(39, '2017-12-19', '12:00:00', '13:00:00', '2017-11-18', 15, 'IRM', 4, "0"),
(40, '2017-12-19', '13:30:00', '14:30:00', '2017-11-18', 16, 'IRM', 4, "0"),
(41, '2017-12-19', '14:30:00', '15:30:00', '2017-11-18', 17, 'IRM', 4, "0"),
(42, '2017-12-19', '16:00:00', '17:00:00', '2017-11-18', 18, 'IRM', 4, "0"),
(43, '2017-12-19', '17:00:00', '18:00:00', '2017-11-18', 19, 'IRM', 4, "0"),
(44, '2017-12-19', '18:00:00', '19:00:00', '2017-11-18', 20, 'IRM', 4, "0"),
(45, '2017-12-19', '09:00:00', '09:30:00', '2017-11-18', 21, 'Extraction dentaire', 2, "0"),
(46, '2017-12-19', '09:30:00', '10:00:00', '2017-11-18', 22, 'Extraction dentaire', 2, "0"),
(47, '2017-12-19', '10:00:00', '10:30:00', '2017-11-18', 23, 'Extraction dentaire', 2, "0"),
(48, '2017-12-19', '10:30:00', '11:00:00', '2017-11-18', 24, 'Extraction dentaire', 2, "0"),
(49, '2017-12-19', '11:00:00', '11:30:00', '2017-11-18', 25, 'Extraction dentaire', 2, "0"),
(50, '2017-12-19', '11:30:00', '12:00:00', '2017-11-18', 26, 'Extraction dentaire', 2, "0"),
(51, '2017-12-19', '11:30:00', '12:00:00', '2017-11-18', 27, 'Demande de contraception', 1, "0"),
(52, '2017-12-19', '14:00:00', '14:30:00', '2017-11-18', 28, 'Demande de contraception', 1, "0"),
(53, '2017-12-19', '08:30:00', '11:30:00', '2017-11-18', 29, 'Chirurgie', 5, "0"),
(54, '2017-12-19', '11:30:00', '14:30:00', '2017-11-18', 30, 'Chirurgie', 4, "0"),
(55, '2017-12-19', '14:30:00', '17:30:00', '2017-11-18', 31, 'Chirurgie', 4, "0"),
(56, '2017-12-20', '10:00:00', '13:00:00', '2017-11-18', 32, 'Chirurgie', 4, "0"),
(57, '2017-12-19', '13:00:00', '16:00:00', '2017-11-18', 33, 'Chirurgie', 5, "0"),
(58, '2017-12-20', '10:00:00', '11:00:00', '2017-11-18', 34, 'Radiologie', 5, "0"),
(59, '2017-12-20', '11:00:00', '12:00:00', '2017-11-18', 35, 'Radiologie', 4, "0"),
(60, '2017-12-20', '15:00:00', '16:00:00', '2017-11-18', 36, 'Radiologie', 4, "0"),
(61, '2017-12-20', '16:00:00', '17:00:00', '2017-11-18', 37, 'Radiologie', 5, "0"),
(62, '2017-12-20', '18:00:00', '19:00:00', '2017-11-18', 38, 'Radiologie', 5, "0"),
(63, '2017-12-19', '08:00:00', '08:30:00', '2017-11-18', 39, 'Prise de sang', 3, "0"),
(64, '2017-12-19', '08:30:00', '09:00:00', '2017-11-18', 40, 'Prise de sang', 3, "0"),
(65, '2017-12-19', '09:00:00', '09:30:00', '2017-11-18', 41, 'Prise de sang', 3, "0"),
(66, '2017-12-19', '09:30:00', '10:00:00', '2017-11-18', 42, 'Prise de sang', 3, "0"),
(67, '2017-12-19', '10:00:00', '10:30:00', '2017-11-18', 43, 'Prise de sang', 1, "0"),
(68, '2017-12-19', '10:30:00', '11:00:00', '2017-11-18', 44, 'Prise de sang', 1, "0"),
(69, '2017-12-19', '14:00:00', '14:30:00', '2017-11-18', 45, 'Prise de sang', 3, "0"),
(70, '2017-12-19', '14:30:00', '15:00:00', '2017-11-18', 46, 'Prise de sang', 3, "0"),
(71, '2017-12-19', '15:00:00', '15:30:00', '2017-11-18', 47, 'Prise de sang', 1, "0"),
(72, '2017-12-19', '15:00:00', '16:00:00', '2017-11-18', 48, 'Prise de sang', 3, "0"),
(73, '2017-12-20', '09:00:00', '09:30:00', '2017-11-18', 49, 'Extraction dentaire', 2, "0"),
(74, '2017-12-20', '09:30:00', '10:00:00', '2017-11-18', 50, 'Extraction dentaire', 2, "0"),
(75, '2017-12-20', '10:00:00', '10:30:00', '2017-11-18', 51, 'Extraction dentaire', 2, "0"),
(76, '2017-12-20', '10:30:00', '11:00:00', '2017-11-18', 52, 'Extraction dentaire', 2, "0"),
(77, '2017-12-20', '11:00:00', '11:30:00', '2017-11-18', 53, 'Extraction dentaire', 2, "0"),
(78, '2017-12-20', '11:30:00', '12:00:00', '2017-11-18', 54, 'Extraction dentaire', 2, "0"),
(79, '2017-12-20', '12:00:00', '12:30:00', '2017-11-18', 55, 'Extraction dentaire', 2, "0"),
(80, '2017-12-20', '14:00:00', '14:30:00', '2017-11-18', 56, 'Extraction dentaire', 2, "0"),
(81, '2017-12-19', '14:30:00', '15:00:00', '2017-11-18', 4, 'Extraction dentaire', 2, "0"),
(82, '2017-12-19', '15:00:00', '15:30:00', '2017-11-18', 39, 'Extraction dentaire', 2, "0"),
(83, '2017-12-21', '10:00:00', '11:00:00', '2017-11-18', 40, 'Radiologie', 4, "0"),
(84, '2017-12-21', '11:00:00', '12:00:00', '2017-11-18', 49, 'Radiologie', 4, "0"),
(85, '2017-12-21', '13:00:00', '14:00:00', '2017-11-18', 13, 'Radiologie', 4, "0"),
(86, '2017-12-21', '14:00:00', '15:00:00', '2017-11-18', 12, 'Radiologie', 5, "0"),
(87, '2017-12-21', '15:00:00', '16:00:00', '2017-11-18', 1, 'Radiologie', 5, "0"),
(88, '2017-12-21', '16:00:00', '17:00:00', '2017-11-18', 10, 'Radiologie', 5, "0"),
(89, '2017-12-21', '17:00:00', '18:00:00', '2017-11-18', 29, 'Radiologie', 4, "0"),
(90, '2017-12-21', '18:00:00', '19:00:00', '2017-11-18', 30, 'Radiologie', 5, "0");

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
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","13");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","14");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","15");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","16");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","17");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","18");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","19");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Cancer","20");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","21");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","22");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","23");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","24");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","25");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","26");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Controle","27");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Controle","28");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Main cassée","30");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Bras cassé","31");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Bras cassé","32");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","33");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","34");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Pied cassée","35");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Pied cassée","36");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","37");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","38");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","39");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hépatite","40");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hépatite","41");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hépatite","42");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","43");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hépatite","44");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","45");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","46");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Diabète","47");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Hépatite","48");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","49");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","50");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","51");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","52");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","53");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","54");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","55");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","56");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","4");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Carie","39");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Main cassée","40");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Pied cassé","49");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Pied cassé","13");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","12");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","1");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","10");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Bras cassé","29");
INSERT INTO `souffre`(`Nom_pathologie`, `IDp`) VALUES ("Jambe cassée","30");

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

UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="0";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="1";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="2";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="3";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="4";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="5";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="6";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="7";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="8";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="9";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="10";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="11";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="12";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="13";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="14";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="15";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="16";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="17";
UPDATE `patient` SET `Nom_service`="Pédiatrie" WHERE `IDp`="18";
UPDATE `patient` SET `Nom_service`="Pédiatrie" WHERE `IDp`="19";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="20";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="21";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="22";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="23";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="24";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="25";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="26";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="27";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="28";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="29";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="30";
UPDATE `patient` SET `Nom_service`="Imagerie médicale" WHERE `IDp`="31";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="32";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="33";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="34";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="35";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="36";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="37";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="38";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="39";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="40";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="41";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="42";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="43";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="44";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="45";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="46";
UPDATE `patient` SET `Nom_service`="Chirurgie" WHERE `IDp`="47";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="48";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="49";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="50";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="51";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="52";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="53";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="54";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="55";
UPDATE `patient` SET `Nom_service`="Odontologie" WHERE `IDp`="56";

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET SQL_NOTES=@OLD_SQL_NOTES;
