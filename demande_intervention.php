<?php
  include('fonction.php');
  $connexion = connect() ;
 ?>


<html>


  <title> Demande d'intervention - 1/2 </title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css"/>

  <body>
    <h2> Formulaire de demande d'intervention : </h2>
    <form method="post" action="">
      <label>Nom du patient</label> : <input type="text" required="on" name="Nom_patient">    <!--Champ pour indiquer le nom du patient-->
      <br><br>
      <label>Prénom du patient</label> : <input type="text" required="on" name="Prenom_patient">    <!--Champ pour indiquer le prénom du patient-->
      <br><br>
      <label>Sélectionnez la pathologie</label> : <select name="pathologie">    <!--Menu déroulant des différentes pathologies-->
        <?php
          $request = "SELECT Nom_pathologie FROM pathologie";      //On effectue une requête qui sélectionne les pathologies
          $pathologie = do_request($connexion,$request);                //On récupère le résultat de la requête dans un tableau
          foreach($pathologie as $value) {                              //On parcourt ce tableau pour récupérer les pathologies 1 à 1
            echo "<option value='$value[Nom_pathologie]'> $value[Nom_pathologie] </option>";                          //On crée le menu déroulant au fil de la lecture du foreach
          }
        ?>
      </select>
      <br><br>
      <label>Type d'intervention souhaitée</label> : <select name="type_intervention">    <!--Menu déroulant des différents types d'intervention-->
        <?php
          $request = "SELECT Nom_intervention FROM type_d_intervention";      //On effectue une requête qui sélectionne les noms des interventions
          $typeIntervention = do_request($connexion,$request);               //On récupère le résultat de la requête dans un tableau
          foreach($typeIntervention as $value) {                              //On parcourt ce tableau pour récupérer les types d'intervention 1 à 1
            echo "<option value='$value[Nom_intervention]'> $value[Nom_intervention] </option>";                          //On crée le menu déroulant au fil de la lecture du foreach
          }
        ?>
      <input type="submit" value="Soumettre">
    </form>

    <a class="access_form" href="traitement.php">Annuler</a>


  </body>

</html>



<?php
if ($_POST == TRUE) {   // On vérifie que le formulaire a été envoyé
  // On stocke les variables
  $nomPatient = $_POST['Nom_patient'];
  $prenomPatient = $_POST['Prenom_patient'] ;
  $pathologie = $_POST['pathologie'] ;
  $typeIntervention = $_POST['type_intervention'] ;

  if (empty(verif_patient($nomPatient,$prenomPatient))) {   // On vérifie que le patient existe bien dans la base de données
    echo "</br>Le patient $nomPatient $prenomPatient n'existe pas dans la base de données</br>" ;
  }

  else {
    $creneauxProposes= array() ;   //on initialise un tableau vide
    $j=0;

    $niveau_priorite = get_niveau_priorite($pathologie) ;   // On récupère le niveau de priorité de la pathologie

    if ($niveau_priorite == 1) {    // Minimum 1 semaine de délai pour un niveau 1
      $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+7, date("Y")));   //date 7 jours plus tard à 8h00, date à laquelle nous allons commencer la recherche de créneau disponible
      list($date,$horaire) = explode(" ", $creneauRecherche);  //on récupère la date et l'heure du créneau
    }
    elseif ($niveau_priorite == 2) {    // 5 jours de délai pour un niveau 2
      $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+5, date("Y")));
      list($date,$horaire) = explode(" ", $creneauRecherche);
    }
    elseif ($niveau_priorite == 3) {    // 4 jours de délai pour un niveau 3
      $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+3, date("Y")));
      list($date,$horaire) = explode(" ", $creneauRecherche);
    }
    elseif ($niveau_priorite == 4) {    // 2 jours de délai pour un niveau 4
      $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+2, date("Y")));
      list($date,$horaire) = explode(" ", $creneauRecherche);
    }
    else {    // On commence la recherche au lendemain à 8h00 dans les autres cas
      $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
      list($date,$horaire) = explode(" ", $creneauRecherche);
    }

    $dureeIntervention = getDureeIntervention($typeIntervention);   //on récupère la durée de l'intervention demandée
    $creneauxIndisponibles = getCreneauxIndisponibles($typeIntervention,$date) ;    // On récupère les créneaux disponibles

    foreach ($creneauxIndisponibles as $value) {    // On parcourt le tableau contenant l'ensemble des créneaux indisponibles et on stocke séparément l'heure et la date
      $date_creneau[] = $value['Date_creneau'] ;
      $heure_debut_creneau[] = $value['Heure_debut'] ;
    }

    for($i = 0 ; $i < count($creneauxIndisponibles) ; $i++) {   // Cette boucle for va parcourir le tableau des créneaux indisponibles pour vérifier un à un chaque créneau

      if ($date != $date_creneau[$j] OR $horaire != $heure_debut_creneau[$j]) {   // On vérifie si le créneau est déjà pris ou pas
        $creneauxProposes[] = $creneauRecherche;    // Si le créneau est disponible alors on l'enregistre
        $i--;
      } else {

        if($j < count($creneauxIndisponibles)-1)    // On incrémente le j tant qu'on n'est pas sortis du tableau
        $j++;
      }

      if (date_format(date_create($creneauRecherche),'H:i') == '18:00' OR date_format(date_create($creneauRecherche),'H:i') == '20:00') {   // Quand il est 18h (ou 20h pour gérer les opérations chirurgicales) on passe au jour suivant
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      elseif (date_format(date_create($creneauRecherche),'D') == 'Sat') {   // Quand on est à samedi, on passe à lundi
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+2 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      elseif (date_format(date_create($creneauRecherche),'D') == 'Sun') {   // Quand on est à samedi, on passe à lundi
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      else{
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+$dureeIntervention minutes");   //A chaque tour de la boucle for, on incrémente le temps de "durée intervention"
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d H:i:s') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      if (count($creneauxProposes) == 10) {    // On s'arrête dès que l'on a 10 créneaux proposés
        break ;
      }
    }


    // Si on n'a toujours pas 10 créneaux proposés à l'issue du for, on va incrémenter de manière systématique notre tableau de créneaux proposés
    while (count($creneauxProposes) < 10) {
      if (date_format(date_create($creneauRecherche),'H:i') == '18:00' OR date_format(date_create($creneauRecherche),'H:i') == '20:00') {   // Quand il est 18h (ou 20h pour gérer les opérations chirurgicales) on passe au jour suivant
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      elseif (date_format(date_create($creneauRecherche),'D') == 'Sat') {   // Quand on est à samedi, on passe à lundi
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+2 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      elseif (date_format(date_create($creneauRecherche),'D') == 'Sun') {   // Quand on est à samedi, on passe à lundi
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

      else{
        $creneauxProposes[] = $creneauRecherche ;
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+$dureeIntervention minutes");   //A chaque tour de la boucle for, on incrémente le temps de "durée intervention"
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d H:i:s') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }
    }


    ?><p>Veuillez sélectionner une date de rdv</p> <br ><?php
    foreach ($creneauxProposes as $value) {   // On récupère les dates disponibles préalablement stockées dans le tableau "creneauxProposes"
      ?>
      <form method= "post" action= "traitementRDV.php">
        <input type= "radio" name="date" value="<?php echo $value ?>" >
        <label> <?php echo date_format(date_create($value),'l d F Y H:i') ?> </label > <br >
          <!-- On envoie en caché dans le formulaire les variables qui vont nous servier à implémenter la base de données -->
          <input type ="hidden" name = "nomPatient" value = <?php echo $nomPatient ?> >
          <input type ="hidden" name = "prenomPatient" value = <?php echo $prenomPatient ?> >
          <input type ="hidden" name = "pathologie" value = <?php echo $pathologie ?> >
          <input type ="hidden" name = "typeIntervention" value = <?php echo $typeIntervention ?> >
          <input type ="hidden" name = "dureeIntervention" value = <?php echo $dureeIntervention ?> >
          <?php
        }?>
        <input type="submit" name = "soumission_demande_intervention"/>
      </form>

      <?php

    }
  }
  ?>
