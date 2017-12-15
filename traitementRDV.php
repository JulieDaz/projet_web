<?php
include('fonction.php');
  if(!isset($_SESSION['medecin']))
{
    header("Location:index.php") ;
}
 ?>

<title> Demande d'intervention - 1/2 </title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css"/>

<<<<<<< HEAD
<?php

include('includes/fonction.php');
=======
>>>>>>> 80d513a7f6ab9ee67d478e9283204272b6e4fc94

$nomPatient = $_POST['nomPatient'];
$prenomPatient = $_POST['prenomPatient'] ;
$pathologie = $_POST['pathologie'] ;
$typeIntervention = $_POST['typeIntervention'] ;

$aujourdhui = date('Y-m-d') ;

$creneau = $_POST['date'] ;
list($date,$heure) = explode(" ", $creneau);

$dureeIntervention = $_POST['dureeIntervention'] ;

$finCreneau = date_modify(date_create($creneau), "+$dureeIntervention minutes") ;
$heureFin = date_format($finCreneau,'H:i:s') ;

$IDp = select_IDpatient($nomPatient,$prenomPatient) ;

$connexion = connect();

// On vérifie que le patient n'a pas déjà rdv ce jour là
$verif_rdv_patient = do_request($connexion,"SELECT `Nom_intervention` FROM `creneaux` WHERE `Date_creneau` LIKE '$date' AND `Heure_debut` LIKE '$heure' AND `IDp` LIKE '$IDp'") ;
if (!empty($verif_rdv_patient)) {
  echo "Attention, ce patient a déjà un rdv pour ce créneau</br></br>" ;?>
  <a class="access_form" href="demande_intervention.php">Retourner au formulaire de demande d'intervention </a>
  <?php
}else{
  $insertRequest = "INSERT INTO `creneaux` (`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`)
  VALUES (NULL, '$date', '$heure', '$heureFin', '$aujourdhui',
    (SELECT IDp
      FROM patient
      WHERE IDp = '$IDp'),

      (SELECT Nom_intervention
        FROM type_d_intervention
        WHERE Nom_intervention LIKE '$typeIntervention') , NULL)";

        mysqli_query($connexion, $insertRequest) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));


    header('Location: traitement.php');
    }
      ?>
