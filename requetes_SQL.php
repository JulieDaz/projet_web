<?php
// ce fichier contient les fonctions de requetes SQL

  include('fonction.php') ;



  //Requête SQL qui renvoie tous les types d'interventions
  function listeTypeIntervention(){

    $connexion = connect();
    $request = "SELECT Nom_intervention FROM type_d_intervention";
    $typeIntervention = do_request($connexion,$request);

    return $typeIntervention;
  }






 ?>
