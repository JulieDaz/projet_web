<?php

/* Connexion à la base de donnée */
function connect()
  {
      $user = 'root'; // utilisatrice
      $mdp = '';  // mot de passe
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
        $patient_ayant_intervention = 0;
        foreach($IDp_from_medecin as $IDp_array)
        {
            $IDp = $IDp_array['IDp'];
            $request_IDc_patients = "SELECT IDc FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'";
            $IDc_patients = do_request($connexion, $request_IDc_patients);
            if(!empty($IDc_patients[0]))
            {
                $patient_ayant_intervention++;
            }
        }
        if(empty($IDp_from_medecin[0]) or $patient_ayant_intervention == 0)
        {
            print("Vos patients n'ont pas de créneaux de ce type ou vous n'avez pas de patients.");
        }
        else
        {
            foreach($IDp_from_medecin as $IDp_array) // pour chaque ID patient récupéré
            {
                $IDp = $IDp_array['IDp']; // on va chercher la valeur contenue par la clé 'IDp'
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer l'heure de fin du créneau
                $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'";
                $request_IDc = "SELECT IDc FROM creneaux WHERE  Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer les ID créneaux pour chaque patient
                $IDc_array = do_request($connexion, $request_IDc);
                $Date_creneau = do_request($connexion, $request_date_creneau);
                $Heure_debut = do_request($connexion, $request_HDebut); // on effectue la requête
                $Heure_fin = do_request($connexion, $request_HFin); // on effectue la requête
            }
            foreach($IDc_array as $IDc_key) // pour chaque créneau récupéré
            {
                $IDc = $IDc_key['IDc']; // on va chercher la valeur contenue par la clé 'IDc'
                $request_nom = "SELECT Nom FROM patient WHERE IDp = (SELECT IDp FROM creneaux WHERE IDc = '$IDc')"; // requête pour récupérer les noms des patients
                $request_prenom = "SELECT Prenom FROM patient WHERE IDp = (SELECT IDp FROM creneaux WHERE IDc = '$IDc')"; // requête pour récupérer les prénoms des patients
                $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer le nom de l'intervention selon l'ID du responsable                
                $Nom_intervention = do_request($connexion, $request_intervention);
                $Nom = do_request($connexion, $request_nom);
                $Prenom = do_request($connexion, $request_prenom);
                $Nom_array[] = $Nom[0];
                $Prenom_array[] = $Prenom[0];
                $Nom_intervention_array[] = $Nom_intervention[0];
            }
            for($i = 0; $i < sizeof($Heure_debut); $i++)
            {
                $res[$i] = array($Heure_debut[$i], $Heure_fin[$i], $Date_creneau[$i], $Nom_array[$i], $Prenom_array[$i], $Nom_intervention_array[$i]);
            }
            return $res; // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
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
            $Heure_debut = do_request($connexion, $request_HDebut); // on effectue la requête
            $Heure_fin = do_request($connexion, $request_HFin); // on effectue la requête
            $Date_creneau = do_request($connexion, $request_date_creneau);
            $IDp_array = do_request($connexion, $request_IDp);
            foreach($IDp_array as $IDp_key)
            {
                $IDp = $IDp_key['IDp'];
                $request_nom = "SELECT Nom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les noms des patients
                $request_prenom = "SELECT Prenom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les prénoms des patients
                $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'"; // requête pour récupérer le type d'intervention
                $Nom_intervention = do_request($connexion, $request_intervention);
                $Nom = do_request($connexion, $request_nom);
                $Prenom = do_request($connexion, $request_prenom);
                $Nom_array[] = $Nom[0];
                $Prenom_array[] = $Prenom[0];
            }

            for($i = 0; $i < sizeof($Heure_debut); $i++)
            {
                $res[$i] = array($Heure_debut[$i], $Heure_fin[$i], $Date_creneau[$i], $Nom_array[$i], $Prenom_array[$i], $Nom_intervention[$i]);
            }
            return $res; // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
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
                $Heure_debut = do_request($connexion, $request_HDebut); // on effectue la requête
                $Heure_fin = do_request($connexion, $request_HFin); // on effectue la requête
                $Date_creneau = do_request($connexion, $request_date_creneau);
                $IDp_array = do_request($connexion, $request_IDp); // on effectue la requête
            }
            foreach($IDp_array as $IDp_key)
            {
                $IDp = $IDp_key['IDp'];
                $request_nom = "SELECT Nom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les noms des patients
                $request_prenom = "SELECT Prenom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les prénoms des patients
                $Nom_intervention = do_request($connexion, $request_intervention);
                $Nom = do_request($connexion, $request_nom);
                $Prenom = do_request($connexion, $request_prenom);
                $Nom_array[] = $Nom[0];
                $Prenom_array[] = $Prenom[0];
                $Nom_intervention_array[] = $Nom_intervention[0];
            }
            for($i = 0; $i < sizeof($Heure_debut); $i++)
            {
                $res[$i] = array($Heure_debut[$i], $Heure_fin[$i], $Date_creneau[$i], $Nom_array[$i], $Prenom_array[$i], $Nom_intervention_array[$i]);
            }
            return $res; // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
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
    $prenom=mb_strtolower($prenom) ;
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


function check_carac($word)
{
    $word_changed = ucfirst(mb_strtolower($word, 'UTF-8')) ;

    if (preg_match("#^[A-Z][a-zàâäéèêëïùüû]+[' -]?[a-zàâäéèêëïùüû]+$#", $word_changed))
    {
        return $word_changed ;
    }
}

function check_mail($mail)
{
    $mail_changed = strtolower($mail) ;
    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail_changed))
    {
        return $mail_changed ;
    }
}

// function check_number($number, $type)
// {
//     switch ($type) {
//         case 'phone':
//             if (preg_match("#^0[1-8]([-. ]?[0-9]{2}){4}$#", $number))
//             {
//                 print("Le numéro de téléphone est valide") ;
//             }
//             else {
//                 print("caca") ;
//             }
//             break;

//         case 'bill':
//             if (preg_match("#^[1-9][0-9]#", $number))
//             {
//                 print("Le chiffre est valide") ;
//             }
//             else {
//                 print("caca") ;
//             }
//             break;

//         case 'time':
//             $modulo = $number % 30 ;
//             if ($modulo == 0)
//             {
//                 print("La durée est bien un multiple de 30") ;
//             }
//             else
//             {
//                 print("prout") ;
//             }
//             break;
//     }
// }


function sousbooking($connexion, $type_intervention, $IDp)
{
    $date = date("Y-m-d");
    $request_duree = "SELECT Duree FROM type_d_intervention WHERE Nom_intervention = '$type_intervention'";
    $duree = do_request($connexion, $request_duree);
    $duree_intervention = $duree[0]['Duree'];

    $request_sous_booking = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$type_intervention' AND TIME(Heure_debut) = '".date("H:i:s", strtotime("-".$duree_intervention." minute", strtotime("20:00:00")))."' AND Date_creneau = '$date'";
    $creneau_sous_booking = do_request($connexion, $request_sous_booking);

    if(empty($creneau_sous_booking[0]))
    {
        $creneau_flottant['Heure_debut'] = '';
        $creneau_flottant['IDp'] = $IDp;
        $creneau_flottant['Niveau_priorite'] = 10;

        $duree = do_request($connexion, $request_durée);
        $request_creneaux = "SELECT IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Niveau_priorite FROM creneaux WHERE Nom_intervention = '$type_intervention' AND Date_creneau = '$date_considérée'";
        $creneaux = do_request($connexion, $request_creneaux);
    
        $duree_intervention = $duree[0]['Duree'];
    
        $taille = sizeof($creneaux);
    
        for ($i = 0 ; $i < $taille ; $i++)
        {
            if (strtotime($creneaux[$i]['Date_creneau']." ".$creneaux[$i]['Heure_debut']) <= strtotime($date_considérée." ".$heure_now))
            {
                unset($creneaux[$i]) ;
                $creneaux_du_jour = array_values($creneaux) ;
            }
        }
    
        if(!isset($creneaux_du_jour))
        {
            $creneaux_du_jour = $creneaux;
        }
    
        $i = 0 ;
        $size = sizeof($creneaux_du_jour) ;    

        while ($i < $size) 
        {
            print($creneaux_du_jour[$i-1]['Heure_fin']);
            print($creneaux_du_jour[$i]['Heure_debut']);
            if($creneaux_du_jour[$i-1]['Heure_fin'] != $creneaux_du_jour[$i]['Heure_debut'])
            {
                print("Y a un trou!");
            }
            elseif ( $creneau_flottant['Niveau_priorite'] > $creneaux_du_jour[$i]['Niveau_priorite'])
            {
                $test['IDp'] = $creneau_flottant['IDp'] ;
                $test['Niveau_priorite'] = $creneau_flottant['Niveau_priorite'] ;
    
                $creneau_flottant['IDp'] = $creneaux_du_jour[$i]['IDp'] ;
                $creneau_flottant['Niveau_priorite'] = $creneaux_du_jour[$i]['Niveau_priorite'] ;
    
                $creneaux_du_jour[$i]['IDp'] = $test['IDp'] ;
                $creneaux_du_jour[$i]['Niveau_priorite'] = $test['Niveau_priorite'] ;
    
                $update_request = "UPDATE creneaux SET IDp = ".$creneaux_du_jour[$i]['IDp']." , Niveau_priorite = ".$creneaux_du_jour[$i]['Niveau_priorite']." WHERE IDc = ".$creneaux_du_jour[$i]['IDc'];
                mysqli_query($connexion,$update_request) or die('<br>Erreur SQL !<br>'.$update_request.'<br>'.mysqli_error($connexion));
            }
            ++$i ;
        } 
    }
    else
    {
        surbooking($connexion, $type_intervention, $IDp);
    }
}


function surbooking($connexion, $type_intervention, $IDp, $nb_jours = 0, $creneau_flottant = NULL)
{
    $connexion = connect();
    $date_du_jour = date("Y-m-d");
    list($annee, $mois, $jour) = explode("-", $date_du_jour);
    $date_considérée = date("Y-m-d", mktime(0,0,0,$mois, $jour+$nb_jours, $annee));
    $heure_now = date("H:i:s");

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
            unset($creneaux[$i]) ;
            $creneaux_du_jour = array_values($creneaux) ;
        }
    }

        print($date_considérée);
    print("<br><br>");    
    print_r($creneaux);
    print("<br><br>");

    print_r($creneaux_du_jour);

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

    $i = 0 ;
    $size = sizeof($creneaux_du_jour) ;

    print("<br><br>");

    while ($i < $size) {

        if ( $creneau_flottant['Niveau_priorite'] > $creneaux_du_jour[$i]['Niveau_priorite'])
        {
            $test['IDp'] = $creneau_flottant['IDp'] ;
            $test['Niveau_priorite'] = $creneau_flottant['Niveau_priorite'] ;

            $creneau_flottant['IDp'] = $creneaux_du_jour[$i]['IDp'] ;
            $creneau_flottant['Niveau_priorite'] = $creneaux_du_jour[$i]['Niveau_priorite'] ;

            $creneaux_du_jour[$i]['IDp'] = $test['IDp'] ;
            $creneaux_du_jour[$i]['Niveau_priorite'] = $test['Niveau_priorite'] ;

            $update_request = "UPDATE creneaux SET IDp = ".$creneaux_du_jour[$i]['IDp']." , Niveau_priorite = ".$creneaux_du_jour[$i]['Niveau_priorite']." WHERE IDc = ".$creneaux_du_jour[$i]['IDc'];
            mysqli_query($connexion,$update_request) or die('<br>Erreur SQL !<br>'.$update_request.'<br>'.mysqli_error($connexion));
        }
        ++$i ;
    }

    if(empty($creneaux_du_jour))
    {
        if($date_du_jour < $date_considérée)
        {
            $heure_now = "08:00:00";
        }
        if(strtotime($heure_now) > strtotime("-".$duree_intervention." minute", strtotime("20:00:00")))
        {
            deconnect($connexion);
            $nb_jours++;
            surbooking($connexion, $type_intervention, $IDp, $nb_jours, $creneau_flottant);
        }
        else
        {
            $creneau_heure_debut = "08:00:00";
            $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneau_heure_debut)));
            $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite) VALUES ('', '$date_considérée', '$creneau_heure_debut', '$creneau_heure_fin', '$date_du_jour', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].")";
            mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
        }
    }
    else
    {
        $dernier_creneau = date("H:i:s", strtotime($creneaux_du_jour[$i-1]['Heure_fin']));
        if($dernier_creneau <= date("H:i:s", strtotime("-".$duree_intervention." minute", strtotime("20:00:00"))))
        {
            $heure_fin_intervention = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($dernier_creneau)));
            $insert_request = "INSERT INTO creneaux(IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite) VALUES ('', '$date_considérée', '".$dernier_creneau."', '$heure_fin_intervention', '$date_du_jour', '".$creneau_flottant['IDp']."', '$type_intervention', '".$creneau_flottant['Niveau_priorite']."')";
            mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
        }
        else
        {
            deconnect($connexion);
            $nb_jours++;
            surbooking($connexion, $type_intervention, $IDp, $nb_jours, $creneau_flottant);
        }
    }
}

?>
