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

    $creneauxIndisponibles = getCreneauxIndisponibles($typeIntervention);   //on récupère le résultat de la requete contenant les heures de début et de fin des créneaux indisponibles
    $dureeIntervention = getDureeIntervention($typeIntervention);   //on récupère la durée de l'intervention demandée
    // date()         -> renvoie un string
    // date_create()  -> renvoie une date
    // date_format()  -> renvoie un string
    // mktime()       -> renvoie un int (timestamp)
    $creneauRecherche  = date('Y-m-d H:i:s',mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));   //date du lendemain à 8h00, date à laquelle nous allons commencer la recherche de créneau disponible
    list($date,$horaire) = explode(" ", $creneauRecherche);  //on récupère la date et l'heure du créneau
    $creneauxProposes= array() ;   //on initialise un tableau vide

    foreach ($creneauxIndisponibles as $value) {    // On parcourt le tableau contenant l'ensemble des créneaux indisponibles
      $date_creneau[] = $value['Date_creneau'] ;
      $heure_debut_creneau[] = $value['Heure_debut'] ;
      $heure_fin_creneau[] = $value['Heure_fin'] ;
    }

    // for($i = 0; $i < count($creneauxIndisponibles); $i++)
    // {
    //     $creneauxIndispo[$i] = array($date_creneau[$i],$heure_debut_creneau[$i],$heure_fin_creneau[$i]);
    // }


    while (count($creneauxProposes) < 100) {   // Tant qu'on n'a pas 5 créneaux à proposer

      for ($i=0; $i < count($creneauxIndisponibles) ; $i++) { 

        if ($date == $date_creneau[$i] && $horaire == $heure_debut_creneau[$i]) {   // On vérifie si le créneau est déjà pris ou pas
          $creneauRecherche = $value['Date_creneau'].' '.$value['Heure_fin'] ;     // Si c'est le cas, on passe directement au créneau suivant
        }

      }


      //si le créneau est libre, alors on le stocke dans une liste de créneaux proposés
      $creneauxProposes[] = $creneauRecherche;

      if (date_format(date_create($creneauRecherche),'H:i') == '18:00') {
        $creneauRecherche = date_modify(date_create($creneauRecherche), "+1 day");
        $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
        list($date,$horaire) = explode(" ", $creneauRecherche);

        if (date_format(date_create($creneauRecherche),'D') == 'Sat') {
          $creneauRecherche = date_modify(date_create($creneauRecherche), "+2 day");
          $creneauRecherche = date_format($creneauRecherche,'Y-m-d 08:00:00') ;
          list($date,$horaire) = explode(" ", $creneauRecherche);
        }
      }

        else {
          $creneauRecherche = date_modify(date_create($creneauRecherche), "+$dureeIntervention minutes");
          $creneauRecherche = date_format($creneauRecherche,'Y-m-d H:i:s') ;
          list($date,$horaire) = explode(" ", $creneauRecherche);
        }

      }

    foreach ($creneauxProposes as$value) {
      echo $value ;
      echo '</br>' ;
    }

  }







    //$creneauRecherche = date("Y-m-d H:i:s",$creneauRecherche) ;   //on enregistre la date du lendemain sous le même format que dans la base de données

    // var_dump($creneauRecherche) ;

    // $intervalString = 'PT'.$dureeIntervention.'M';
    // $interval = new DateInterval($intervalString);

    // echo $creneauRecherche += $interval;


    //list($heure,$minutes,$jour,$mois,$annee) = explode("/", $creneauRecherche);  //on sépare chaque composant de la date et on stocke le tout dans une liste

    // $creneauxProposes= array() ;   //on initialise un tableau vide
    //
    // while (count($creneauxProposes) <= 5) {    //on veut que le site propose les 5 créneaux les + proches
    //   foreach($creneauxIndisponibles as $valeur) {
    //     if ($creneauRecherche == $creneauxIndisponibles['Heure_debut'])
    //       $creneauRecherche = $creneauxIndisponibles['Heure_fin'] ;   //si le creneau n'est pas dispo alors on passe directement à la fin du créneau qui est pris
    //     else {
    //       $creneauRechercheSlash=date_format($creneauRecherche, 'Y/m/d/H/i') ;
    //       list($annee,$mois,$jour,$heure,$minutes) = explode("/", $creneauRechercheSlash);   //ces deux lignes permettent de récupérer heure, minutes, jour, etc dans des variables séparées
    //       $finRecherche = date('Y-m-d H:i:s', mktime($heure,$minutes+$dureeIntervention,0,$jour,$mois,$annee));
    //
    //       while ($creneauRecherche != $finRecherche) {
    //         if ($creneauRecherche == $creneauxIndisponibles['Heure_debut'])
    //           $creneauRecherche = $creneauxIndisponibles['Heure_fin'] ;
    //         $creneauxProposes=$creneauxProposes[];
    //       }
    //     }
    //   }
    // }


    //$date = date_create($date);
    //$dateDebutRecherche = mktime(0,0,0,$mois,$jour+$d,$annee) ;
    //date_add($date, date_interval_create_from_date_string(' 1 days'));


    // $req_add_doc = "INSERT INTO Medecin (IDm, Nom, Prenom, Nom_service) VALUES ('$id_medecin','$name_med','$prenom_med','$service_med')" ;
    // $add_doc = mysqli_query($connexion,$req_add_doc);
    //
    // $req_add_userM = "INSERT INTO Utilisateur (IDu, Mdp, User_type, IDm) VALUES ('', '$mdp_med', 'Medecin', '$id_medecin')";
    // $add_userM = mysqli_query($connexion,$req_add_userM);


 ?>
