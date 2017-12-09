<?php
  include('fonction.php');
  $connexion = connect() ;
 ?>


<html>


  <title> Demande d'intervention - 1/2 </title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css"/>

  <body>
    <form method="post" action="">
      <label>Nom du patient</label> : <input type="text" required="on" name="Nom_patient">    <!--Champ pour indiquer le nom du patient-->
      <br>
      <label>Prénom du patient</label> : <input type="text" required="on" name="Prenom_patient">    <!--Champ pour indiquer le prénom du patient-->
      <br>
      <label>Sélectionnez la pathologie</label> : <select name="pathologie">    <!--Menu déroulant des différentes pathologies-->
        <?php
          $request = "SELECT Nom_pathologie FROM pathologie";      //On effectue une requête qui sélectionne les pathologies
          $pathologie = do_request($connexion,$request);                //On récupère le résultat de la requête dans un tableau
          foreach($pathologie as $value) {                              //On parcourt ce tableau pour récupérer les pathologies 1 à 1
            echo "<option value='$value[Nom_pathologie]'> $value[Nom_pathologie] </option>";                          //On crée le menu déroulant au fil de la lecture du foreach
          }
        ?>
      </select>
      <br>
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

    <a class="bouton_relief" href="traitement.php">Annuler</a>


  </body>



</html>



<?php
if ($_POST == TRUE) {
  $nomPatient = $_POST['Nom_patient'];
  $prenomPatient = $_POST['Prenom_patient'] ;
  $pathologie = $_POST['pathologie'] ;
  $typeIntervention = $_POST['type_intervention'] ;

  //     // date()         -> renvoie un string
  //     // date_create()  -> renvoie une date
  //     // date_format()  -> renvoie un string
  //     // mktime()       -> renvoie un int (timestamp)
  $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));   //date du lendemain à 8h00, date à laquelle nous allons commencer la recherche de créneau disponible
  list($date,$horaire) = explode(" ", $creneauRecherche);  //on récupère la date et l'heure du créneau
  $creneauxProposes= array() ;   //on initialise un tableau vide
  $j=0;

  $dureeIntervention = getDureeIntervention($typeIntervention);   //on récupère la durée de l'intervention demandée
  $creneauxIndisponibles = getCreneauxIndisponibles($typeIntervention,$date) ;    // On récupère les créneaux disponibles

  foreach ($creneauxIndisponibles as $value) {    // On parcourt le tableau contenant l'ensemble des créneaux indisponibles
    $date_creneau[] = $value['Date_creneau'] ;
    $heure_debut_creneau[] = $value['Heure_debut'] ;
    $heure_fin_creneau[] = $value['Heure_fin'] ;
  }

  for($i = 0 ; $i < count($creneauxIndisponibles) ; $i++) {
    // echo "heure : $horaire </br>" ;
    // echo "horaire créneau : $heure_debut_creneau[$j]</br>" ;
    // echo "date : $date</br>" ;
    // echo "date du créneau : $date_creneau[$j]</br>" ;

    if ($date != $date_creneau[$j] OR $horaire != $heure_debut_creneau[$j]) {   // On vérifie si le créneau est déjà pris ou pas
      $creneauxProposes[] = $creneauRecherche;    // Si le créneau est disponible alors on l'enregistre
      $i--;
    } else {

      if($j < count($creneauxIndisponibles)-1)
      $j++;
    }

    if (date_format(date_create($creneauRecherche),'H:i') == '18:00') {   // Quand on est à 18h on passe au jour suivant
      $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
      $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
      list($date,$horaire) = explode(" ", $creneauRecherche);

      if (date_format(date_create($creneauRecherche),'D') == 'Sat') {   // Quand on est à samedi, on passe à lundi
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+2 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

    }else{
      $creneauRecherche = date_modify(date_create($creneauRecherche), "+$dureeIntervention minutes");
      $creneauRecherche = date_format($creneauRecherche,'Y-m-d H:i:s') ;
      list($date,$horaire) = explode(" ", $creneauRecherche);
    }

    if (count($creneauxProposes) == 10) {    // On sort du for dès qu'on a 5 créneaux proposés
      break ;
    }
  }


  while (count($creneauxProposes) < 10) {
    if (date_format(date_create($creneauRecherche),'H:i') == '18:00') {   // Quand on est à 18h on passe au jour suivant
      $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
      $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
      list($date,$horaire) = explode(" ", $creneauRecherche);

      if (date_format(date_create($creneauRecherche),'D') == 'Sat') {   // Quand on est à samedi, on passe à lundi
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+2 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);
      }

    }else{
      $creneauxProposes[] = $creneauRecherche ;
      $creneauRecherche = date_modify(date_create($creneauRecherche), "+$dureeIntervention minutes");
      $creneauRecherche = date_format($creneauRecherche,'Y-m-d H:i:s') ;
      list($date,$horaire) = explode(" ", $creneauRecherche);
    }
  }
}

  ?><p>Veuillez sélectionner une date de rdv</p> <br ><?php
  foreach ($creneauxProposes as $value) {
  ?>
  <form method= "post" action= "traitementRDV.php">
    <input type= "radio" value="<?php echo $value ?>" name="date" >
    <label> <?php echo date_format(date_create($value),'l d F Y H:i') ?> </label > <br >
    <?php
  }?>
    <input type="submit"/>
  </form>
