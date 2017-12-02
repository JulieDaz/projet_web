<?php
    $nomPatient = $_POST['Nom_patient'];
    $prenomPatient = $_POST['Prenom_patient'] ;
    $pathologie = $_POST['pathologie'] ;
    $typeIntervention = $_POST['type_intervention'] ;
 ?>


<html>
  <title> Demande d'intervention 2/2 </title>
  <?php
    echo "M/Mme $nomPatient $prenomPatient a rdv pour un(e) $typeIntervention à cause de $pathologie" ;
   ?>
</html>

<?php



?>
