<?php
  include('fonction.php');
  $connexion = connect() ;
 ?>


<html>


  <title> Demande d'intervention - 1/2 </title>

  <body>
    <form method="post" action="demande_intervention2.php">
      <label>Nom du patient</label> : <input type="text" required="on" name="Nom_patient">    <!--Champ pour indiquer le nom du patient-->
      <br>
      <label>Prénom du patient</label> : <input type="text" required="on" name="Prenom_patient">    <!--Champ pour indiquer le prénom du patient-->
      <br>
      <label>Sélectionnez la pathologie</label> : <select name="pathologie">    <!--Menu déroulant des différentes pathologies-->
        <?php
          $request = "SELECT Nom_pathologie FROM pathologie";      //On effectue une requête qui sélectionne les pathologies
          $pathologie = do_request($connexion,$request);                //On récupère le résultat de la requête dans un tableau
          foreach($pathologie as $value) {                              //On parcourt ce tableau pour récupérer les pathologies 1 à 1
            echo "<option>$value[Nom_pathologie]";                          //On crée le menu déroulant au fil de la lecture du foreach
          }
        ?>
      </select>
      <br>
      <label>Type d'intervention souhaitée</label> : <select name="type_d_intervention">    <!--Menu déroulant des différents types d'intervention-->
        <?php
          $request = "SELECT Nom_intervention FROM type_d_intervention";      //On effectue une requête qui sélectionne les noms des interventions
          $typeIntervention = do_request($connexion,$request);               //On récupère le résultat de la requête dans un tableau
          foreach($typeIntervention as $value) {                              //On parcourt ce tableau pour récupérer les types d'intervention 1 à 1
            echo "<option>$value[Nom_intervention]";                          //On crée le menu déroulant au fil de la lecture du foreach
          }
        ?>
      <input type="submit" value="Soumettre">
    </form>

    <form method="post" action="traitement.php">
      <input type="submit" value="Annuler">
    </form>


</html>
