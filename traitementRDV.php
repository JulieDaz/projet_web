<?php

include('fonction.php');


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
$insertRequest = "INSERT INTO `creneaux` (`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`)
VALUES (NULL, '$date', '$heure', '$heureFin', '$aujourdhui',
  (SELECT IDp
    FROM patient
    WHERE IDp = '$IDp'),

    (SELECT Nom_intervention
      FROM type_d_intervention
      WHERE Nom_intervention LIKE '$typeIntervention') , NULL)";

      mysqli_query($connexion, $insertRequest) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
?>


<p> Le rendez-vous a bien été enregistré </p>
<a class="bouton_relief" href="traitement.php">Retourner au planning</a>
