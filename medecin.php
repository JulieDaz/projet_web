<?php
  include('requetes_SQL.php');
 ?>



<html>
  <body>

      <form method="post">
        <p> Sélectionnez le type d'intervention souhaitée : </p>
        <select name="type_d_intervention">
          <?php
            $typeIntervention=listeTypeIntervention();                          //On récupère le résultat de la requête SQL dans un tableau
            foreach($typeIntervention as $value) {                              //On parcourt ce tableau pour récupérer les types d'intervention 1 à 1
              echo "<option>$value[Nom_intervention]";                          //On crée le menu déroulant au fil de la lecture du foreach
            }
          ?>

        </select>
      </form>

  </body>
</html>
