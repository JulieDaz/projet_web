<?php

/* Connexion à la base de donnée */
function connect()
  {
      $user = 'root'; // utilisatrice
      $mdp = 'phpmyadmin';  // mot de passe
      $machine = '127.0.0.1'; //serveur sur lequel tourne le SGBD
      $bd = 'projet_web';  // base de données à laquelle se connecter
      $connexion = mysqli_connect($machine, $user, $mdp, $bd);

      mysqli_set_charset($connexion, "utf8");

  	if (mysqli_connect_errno()) // erreur si > 0
      {
          printf("Échec de la connexion :%s", mysqli_connect_error());
      }
      return $connexion ;
  }

/* Déconnexion a la base de données */

function deconnect($connexion)
{
	mysqli_close($connexion);
}

/*****fonction permettant de faire des requêtes*****/
function do_request($connexion,$request)
{
    $req = mysqli_query($connexion,$request) or die('<br>Erreur SQL !<br>'.$request.'<br>'.mysqli_error($connexion));
    $a = array();
    while($row = mysqli_fetch_assoc($req))
    {
        $a[] = $row;
    }
    mysqli_free_result($req);
    return $a;
}

/* Récupérer les créneaux à afficher selon le type d'utilisateur */
function get_creneaux($job, $ID, $connexion, $intervention_admin_med = NULL)
{
    if ($job == "Medecin") // s'il s'agit d'un médecin
    {
        $request_IDp = "SELECT IDp FROM a_comme WHERE IDm='$ID'"; // requête pour récupérer les ID patients du médecin considéré
        $IDp_from_medecin = do_request($connexion,$request_IDp); // on effectue la requête --> tableau de tableau
        $request_intervention = "SELECT IDc FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'";
        $Nom_intervention = do_request($connexion, $request_intervention);
        if(empty($IDp_from_medecin[0]) or empty($Nom_intervention[0]))
        {
            print("Vos patients n'ont pas de créneaux de ce type ou vous n'avez pas de patients.");
        }
        else
        {
            foreach($IDp_from_medecin as $IDp_array) // pour chaque ID patient récupéré
            {
                $IDp = $IDp_array['IDp']; // on va chercher la valeur contenue par la clé 'IDp'
<<<<<<< HEAD
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer l'heure de fin du créneau
                $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'";
                $request_IDc = "SELECT IDc FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer les ID créneaux pour chaque patient
=======
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer l'heure de fin du créneau
                $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'";
                $request_IDc = "SELECT IDc FROM creneaux WHERE  Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer les ID créneaux pour chaque patient
>>>>>>> cb45e208db2ef38e0a2e675f900aaea5c24fa121
                $IDc_super_array[] = do_request($connexion, $request_IDc);
                $Date_creneau[] = do_request($connexion, $request_date_creneau);
                $Heure_debut[] = do_request($connexion, $request_HDebut); // on effectue la requête
                $Heure_fin[] = do_request($connexion, $request_HFin); // on effectue la requête
<<<<<<< HEAD
                $Date_creneau[] = do_request($connexion, $request_date_creneau);
=======
>>>>>>> cb45e208db2ef38e0a2e675f900aaea5c24fa121
            }
            foreach($IDc_super_array as $IDc_arrays) // super tableau
            {
                foreach($IDc_arrays as $IDc_array) // pour chaque créneau récupéré
                {
                    $IDc = $IDc_array['IDc']; // on va chercher la valeur contenue par la clé 'IDc'
                    $request_nom = "SELECT Nom FROM patient WHERE IDp = (SELECT IDp FROM creneaux WHERE IDc = '$IDc')"; // requête pour récupérer les noms des patients
                    $request_prenom = "SELECT Prenom FROM patient WHERE IDp = (SELECT IDp FROM creneaux WHERE IDc = '$IDc')"; // requête pour récupérer les prénoms des patients
                    $Nom[] = do_request($connexion, $request_nom);
                    $Prenom[] = do_request($connexion, $request_prenom);
                }
            }
            return array($Heure_debut,$Heure_fin,$Date_creneau,$Nom,$Prenom); // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient pour chaque créneau
        }
    }
    elseif ($job == "Admin")
    {
        $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'";
        $Nom_intervention[] = do_request($connexion, $request_intervention);
        if(empty($Nom_intervention[0]))
        {
            print("Il n'y a pas de créneaux à récupérer de ce type.");
        }
        else
        {
            $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'"; // requête pour récupérer l'heure de début du créneau
            $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'"; // requête pour récupérer l'heure de fin du créneau
            $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'";
            $request_IDp = "SELECT IDp FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'";
            $Heure_debut[] = do_request($connexion, $request_HDebut); // on effectue la requête
            $Heure_fin[] = do_request($connexion, $request_HFin); // on effectue la requête
            $Date_creneau[] = do_request($connexion, $request_date_creneau);
            $IDp_super_array[] = do_request($connexion, $request_IDp);
            foreach($IDp_super_array as $IDp_arrays)
            {
                foreach($IDp_arrays as $IDp_array)
                {
                    $IDp = $IDp_array['IDp'];
                    $request_nom = "SELECT Nom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les noms des patients
                    $request_prenom = "SELECT Prenom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les prénoms des patients
                    $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'"; // requête pour récupérer le type d'intervention
                    $Nom_intervention[] = do_request($connexion, $request_intervention);
                    $Nom[] = do_request($connexion, $request_nom);
                    $Prenom[] = do_request($connexion, $request_prenom);
                }
            }
            return array($Heure_debut,$Heure_fin,$Date_creneau,$Nom,$Prenom,$Nom_intervention); // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
        }
    }
    elseif ($job == "Responsable")
    {
        $request_intervention = "SELECT Nom_intervention FROM type_d_intervention WHERE IDr = '$ID'"; // requête pour récupérer le nom de l'intervention selon l'ID du responsable
        $nom_intervention_arrays = do_request($connexion, $request_intervention);
        if(empty($nom_intervention_arrays[0]))
        {
            print("Il n'y a pas de créneaux à récupérer de votre type.");
        }
        else
        {
            foreach($nom_intervention_arrays as $nom_intervention_array) // pour chaque nom d'intervention
            {
                $nom_intervention = $nom_intervention_array['Nom_intervention']; // on récupère le nom de l'intervention
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$nom_intervention'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$nom_intervention'"; // requête pour récupérer l'heure de fin du créneau
                $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$nom_intervention'";
                $request_IDp = "SELECT IDp FROM creneaux WHERE Nom_intervention = '$nom_intervention'"; // requête pour récupérer l'IDp selon le type d'intervention
                $Heure_debut[] = do_request($connexion, $request_HDebut); // on effectue la requête
                $Heure_fin[] = do_request($connexion, $request_HFin); // on effectue la requête
                $Date_creneau[] = do_request($connexion, $request_date_creneau);
                $IDp_super_array[] = do_request($connexion, $request_IDp); // on effectue la requête
            }
            foreach($IDp_super_array as $IDp_arrays)
            {
                foreach($IDp_arrays as $IDp_array)
                {
                    $IDp = $IDp_array['IDp'];
                    $request_nom = "SELECT Nom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les noms des patients
                    $request_prenom = "SELECT Prenom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les prénoms des patients
                    $Nom_intervention[] = do_request($connexion, $request_intervention);
                    $Nom[] = do_request($connexion, $request_nom);
                    $Prenom[] = do_request($connexion, $request_prenom);
                }
            }
            return array($Heure_debut,$Heure_fin,$Date_creneau,$Nom,$Prenom,$Nom_intervention); // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
        }
    }
}

function print_request($array) // pas d'utilité
{
    for($i=0;$i<sizeof($array);$i++)
    {
        $row = $array[$i];
        foreach($row as $data)
        {
            print($data);
            print("\t");
        }
        print("<br>");
    }
}

function print_creneaux($array) // pas d'utilité
{
    // $array
    for($i=0;$i<sizeof($array);$i++)
    {
        $limites = $array[$i];
        foreach($limites as $limite)
        {
            if (array_key_exists('Heure_debut',$limite))
            {
                print($limite['Heure_debut']);
            }
            else
            {
                print($limite['Heure_fin']);
            }
            print("<br>");
        }
    }
}

function generate_id($id, $nom, $prenom)
{
    $first_letter = $prenom[0] ;
    $login = $first_letter.$nom ;

    switch ($id) {
        case 'IDm':
            $login_def = "M_".$login ;
            break;
        case 'IDr':
            $login_def = "R_".$login ;
            break;
    }
    return $login_def ;
}

function generate_mdp($prenom)
{
    $random_number = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9) ;
    $mdp = $random_number.$prenom ;

    return $mdp ;
}

function nom_jour($date) // fonction pour récupérer le jour de la date donnée
{
    $jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche"); // tableau avec les jours de la semaine
    list($jour, $mois, $annee) = explode ("/", $date);  // on récupère chaque élément de la date donnée
    $timestamp = mktime(0,0,0, $mois, $jour, $annee); // on récupère le timestamp
    $njour = date("N",$timestamp); // on récupère le numéro du jour de la semaine du timestamp
    return $jour_semaine[$njour]; // on renvoie le jour correspondant au numéro du jour de la semaine
}

// fonction pour récupérer les dates des jours de la semaine pour l'affichage de l'edt
function get_dates_semaines($semaine) // argument = nb de semaines passées ou futures
{
    $semaine = $semaine * 7;
    $jours_semaine = array(null, "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    $date = date('d/m/Y');
    list($jour,$mois,$annee) = explode("/", $date);
    $date_du_jour = date('d/m/y', mktime(0,0,0,$mois,$jour+$semaine,$annee));
    $jour_de_date = ucfirst(nom_jour($date_du_jour));
    for($k = 1; $k < sizeof($jours_semaine); $k++)
    {
        if ($jour_de_date == $jours_semaine[$k])
        {
            list($jour,$mois,$annee) = explode("/", $date_du_jour);
            $days_back = $k+1;
            $date_lundi = date("d/m/Y", mktime(0,0,0,$mois,$jour-$days_back,$annee));
        }
    }
    for($d = 1; $d <= 8; $d++)
    {
        list($jour,$mois,$annee) = explode("/", $date_lundi);
        $dates_semaine[] = date("d/m/Y", mktime(0,0,0,$mois,$jour+$d,$annee));
    }
    return $dates_semaine;
}

function getCreneauxIndisponibles($typeIntervention){
  $connexion = connect();
  $request = "SELECT `Date_creneau`,`Heure_debut`,`Heure_fin`
            FROM `creneaux`
            WHERE `Nom_intervention` LIKE '$typeIntervention'";
  $reponse = do_request($connexion, $request);
  return $reponse;    //On récupère les creneaux indisponibles
}


function getDureeIntervention($typeIntervention){
  $connexion = connect();
  $request = "SELECT `Duree`
              FROM `type_d_intervention`
              WHERE `Nom_intervention` LIKE '$typeIntervention'";
  $reponse = do_request($connexion, $request) ;

  foreach($reponse as $value)
  {
    $duree = $value['Duree'];
  }

  return $duree;
}


// function getCreneauxDisponibles($date, $duree){
//  $connection = connect();
//  $request = "SELECT *
//              FROM creneaux
//              WHERE Heure_debut LIKE '$date'";
//  $reponse = do_request($connexion, $request);
//
// //si la requête SQL renvoie un résultat vide alors le créneau est disponible (car absent de la BD)
//    if(empty($reponse)){
//      // $date = date_create($date);
//      // $dateDebutRecherche = date_add($date, date_interval_create_from_date_string($duree.' minutes'));
//      // $date = date_format($date, 'Y-m-d H:i:s');
//      $date = date("Y-m-d 8:00") ;   //donne la date du jour à 8h00
//      $dateDebutRecherche = date_add($date, date_interval_create_from_date_string('1 days'));
//      $request = "SELECT * FROM creneaux WHERE Heure_debut LIKE $date";
//      $reponse = do_request($connexion, $request);
//
//        if (empty($reponse))
//         return TRUE;
//       else
//         return FALSE;
//
//   }
//  }

//mktime(0,0,0,$mois,$jour+$d,$annee)

function sousbooking($connexion, $type_intervention)
{
    $request_sous_booking = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$type_intervention' AND TIME(Heure_debut) = '18:00:00'";
    $creneau_sous_booking = do_request($connexion, $request_sous_booking);
    if(empty($creneau_sous_booking[0]))
    {
        print("Le créneau de sous-booking est vide");

    }
}

function surbooking($connexion, $type_intervention, $IDp, $nb_jours = 0, $creneau_flottant = NULL)
{
    $date_du_jour = date("Y-m-d");
    list($annee, $mois, $jour) = explode("-", $date_du_jour);
    $date_considérée = date("Y-m-d", mktime(0,0,0,$mois, $jour+$nb_jours, $annee));
    // print($date_considérée);
    $heure_now = '08:00:00' ;
    // $heure_now = date("G:i:s");

    print($heure_now) ;
    print("<br><br>");

    $request_durée = "SELECT Duree FROM type_d_intervention WHERE Nom_intervention = '$type_intervention'";
    $duree = do_request($connexion, $request_durée);
    $request_creneaux = "SELECT IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Niveau_priorite FROM creneaux WHERE Nom_intervention = '$type_intervention' AND Date_creneau = '$date_considérée'";
    $creneaux = do_request($connexion, $request_creneaux);

    $duree_intervention = $duree[0]['Duree'];

    $taille = sizeof($creneaux);

    for ($i = 0 ; $i < $taille ; $i++)
    {
        if (strtotime($creneaux[$i]['Date_creneau']." ".$creneaux[$i]['Heure_debut']) <= strtotime($date_considérée." ".$heure_now))
        {
            print("stuff");
            unset($creneaux[$i]) ;
            $creneaux_du_jour = array_values($creneaux) ;
        }
    }

    if(!isset($creneau_flottant))
    {
        $creneau_flottant['Heure_debut'] = '';
        $creneau_flottant['IDp'] = $IDp;
        $creneau_flottant['Niveau_priorite'] = 10;
    }

    if(!isset($creneaux_du_jour))
    {
        $creneaux_du_jour = $creneaux;
    }

    print_r($creneaux_du_jour) ;
    print("<br>") ;
    print("<br>") ;
    print_r($creneau_flottant);

    $i = 0 ;
    $size = sizeof($creneaux_du_jour) ;

    while ($i < $size) {

        if ( $creneau_flottant['Niveau_priorite'] > $creneaux_du_jour[$i]['Niveau_priorite'])
        {
            print("<br><br>") ;
            print("avant switch flottant = ");
            print_r($creneau_flottant);
            print("<br>");
            print("avant switch jour = ");
            print_r($creneaux_du_jour[$i]);
            print("<br>");

            $test['IDp'] = $creneau_flottant['IDp'] ;
            $test['Niveau_priorite'] = $creneau_flottant['Niveau_priorite'] ;

            $creneau_flottant['IDp'] = $creneaux_du_jour[$i]['IDp'] ;
            $creneau_flottant['Niveau_priorite'] = $creneaux_du_jour[$i]['Niveau_priorite'] ;

            $creneaux_du_jour[$i]['IDp'] = $test['IDp'] ;
            $creneaux_du_jour[$i]['Niveau_priorite'] = $test['Niveau_priorite'] ;

            print(" le niveau est : ") ;
            print($creneau_flottant['Niveau_priorite']) ;
            print("<br>") ;
            print("i = ") ;
            print($i) ;
            print("<br>") ;
            print("creneau flottant = ") ;
            print_r($creneau_flottant);
            print("<br>") ;
            print("creneaux du jour = ") ;
            print_r($creneaux_du_jour[$i]);

            $update_request = "UPDATE creneaux SET IDp = ".$creneaux_du_jour[$i]['IDp']." , Niveau_priorite = ".$creneaux_du_jour[$i]['Niveau_priorite']." WHERE IDc = ".$creneaux_du_jour[$i]['IDc'];
            mysqli_query($connexion,$update_request) or die('<br>Erreur SQL !<br>'.$request.'<br>'.mysqli_error($connexion));
        }
        ++$i ;
    }

    $dernier_creneau = date("G:i:s", strtotime($creneaux_du_jour[$i-1]['Heure_fin']));

    if($dernier_creneau <= "18:00:00")
    {
        if($dernier_creneau + $duree_intervention <= "18:00:00")
        {
            $heure_fin_intervention = date("G:i:s", strtotime("+".$duree." minute", strtotime($creneaux_du_jour[$i]['Heure_debut'])));
            $insert_request = "INSERT INTO `creneaux`(`IDc`, `Date_creneau`, `Heure_debut`, `Heure_fin`, `Date_priseRDV`, `IDp`, `Nom_intervention`, `Niveau_priorite`) VALUES ('', '$date_considérée', '$creneaux_du_jour[$i]['Heure_fin']', '$heure_fin_intervention', '$date_du_jour', '$creneaux_du_jour[$i]['IDp']', '$type_intervention', '$creneaux_du_jour[$i]['Niveau_priorite']')";
            mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$request.'<br>'.mysqli_error($connexion));
        }
        else
        {
            surbooking($connexion, $type_intervention, $IDp, $nb_jours++, $creneau_flottant);
        }
    }
}

?>
