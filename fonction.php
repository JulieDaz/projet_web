<?php

/* Connexion à la base de donnée */
function connect()
  {
      $user = 'root'; // utilisateur
      $mdp = '';  // mot de passe
      $machine = '127.0.0.1'; //serveur sur lequel tourne le SGBD
      $bd = 'projet_web';  // nom de la base de données à laquelle se connecter
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
    $req = mysqli_query($connexion,$request) or die('<br>Erreur SQL !<br>'.$request.'<br>'.mysqli_error($connexion)); // on effectue la requête SQL (si une erreur survient on aura un détail dessus)
    $a = array(); // on crée un tableau vide
    while($row = mysqli_fetch_assoc($req)) // tant qu'on a des résultats dans la requête
    {
        $a[] = $row; // on remplit le tableau de résultats
    }
    mysqli_free_result($req); // on libère la mémoire utilisée pour la requête
    return $a; // on aura un tableau de tableau
}

/* Récupérer les créneaux à afficher selon le type d'utilisateur */
function get_creneaux($job, $ID, $connexion, $dates_semaine,  $intervention_admin_med = NULL)
{
    $date_lundi = date("d-m-Y", strtotime(str_replace('/', '-', $dates_semaine[1])));
    if ($job == "Medecin") // s'il s'agit d'un médecin
    {
        $request_IDp = "SELECT IDp FROM a_comme WHERE IDm='$ID'"; // requête pour récupérer les ID patients du médecin considéré
        $IDp_from_medecin = do_request($connexion,$request_IDp); // on effectue la requête --> tableau de tableau
        $patient_ayant_intervention = 0; // variable de vérification (comptage du nb de patients du médecin ayant une intervention)
        foreach($IDp_from_medecin as $IDp_array) // pour chaque IDp du médecin
        {
            $IDp = $IDp_array['IDp']; // on récupère l'IDp
            $request_infos = "SELECT IDc, Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // on regarde quels créneaux ont l'IDp et l'intervention considérés
            $infos_creneau = do_request($connexion, $request_infos);
            foreach($infos_creneau as $creneau)
            {
                $date = date("d-m-Y", strtotime($creneau['Date_creneau']));
                if(strtotime($date) >= strtotime($date_lundi) and !empty($creneau))
                {
                    $patient_ayant_intervention++; // on incrémente la variable de vérification
                    $IDp_intervention[] = $IDp; // on récupère l'IDp du patient ayant une intervention
                }
            }
        }
        if(empty($IDp_from_medecin[0]) or $patient_ayant_intervention == 0) // si on a pas de créneaux pour ces patients ou le médecin n'a pas de patients
        {
            print("Vos patients n'ont pas de créneaux de ce type ou vous n'avez pas de patients.");
        }
        else
        {
            foreach($IDp_intervention as $IDp) // pour chaque ID patient récupéré
            {
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer l'heure de fin du créneau
                $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer la date du créneau
                $request_IDc = "SELECT IDc FROM creneaux WHERE  Nom_intervention = '$intervention_admin_med' AND IDp = '$IDp'"; // requête pour récupérer les ID créneaux pour chaque patient
                $IDc_array = do_request($connexion, $request_IDc);
                $Date_creneau = do_request($connexion, $request_date_creneau);
                $Heure_debut = do_request($connexion, $request_HDebut);
                $Heure_fin = do_request($connexion, $request_HFin);
            }
            foreach($IDc_array as $IDc_key) // pour chaque créneau récupéré
            {
                $IDc = $IDc_key['IDc']; // on va chercher la valeur contenue par la clé 'IDc'
                $request_nom = "SELECT Nom FROM patient WHERE IDp = (SELECT IDp FROM creneaux WHERE IDc = '$IDc')"; // requête pour récupérer les noms des patients
                $request_prenom = "SELECT Prenom FROM patient WHERE IDp = (SELECT IDp FROM creneaux WHERE IDc = '$IDc')"; // requête pour récupérer les prénoms des patients
                $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer le nom de l'intervention selon l'ID du responsable
                $Nom_intervention = do_request($connexion, $request_intervention); // ces requêtes peuvent renvoyer des résultats différents selon l'IDp
                $Nom = do_request($connexion, $request_nom);
                $Prenom = do_request($connexion, $request_prenom);
                $Nom_array[] = $Nom[0]; // stockage du nom dans un tableau
                $Prenom_array[] = $Prenom[0]; // stockage du prenom dans un tableau
                $Nom_intervention_array[] = $Nom_intervention[0]; // stockage du nom d'intervention dans un tableau
            }
            for($i = 0; $i < sizeof($Heure_debut); $i++) // pour chaque créneau qui existe (représenté par le nb d'heures de début que l'on a récupéré)
            {
                $res[$i] = array($Heure_debut[$i], $Heure_fin[$i], $Date_creneau[$i], $Nom_array[$i], $Prenom_array[$i], $Nom_intervention_array[$i]); // une ligne contiendra l'heure de début, de fin, la date, le nom, le prénom et le nom de l'intervention
            }
            return $res;
        }
    }
    elseif ($job == "Admin")
    {
        $request_intervention = "SELECT IDc, Nom_intervention, Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med'"; // requête pour voir si il existe des créneaux pour ce type d'intervention
        $infos_creneau = do_request($connexion, $request_intervention);
        foreach($infos_creneau as $creneau)
        {
            $date = date("d-m-Y", strtotime($creneau['Date_creneau']));
            if(strtotime($date) >= strtotime($date_lundi))
            {
                $IDc_array[] = $creneau['IDc'];
            }
        }
        if(empty($infos_creneau[0]))
        {
            print("Il n'y a pas de créneaux à récupérer de ce type.");
        }
        elseif(!isset($IDc_array))
        {
            print("Il n'y a pas de créneaux à récupérer de ce type.");
        }
        else
        {
            foreach($IDc_array as $IDc)
            {
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDc = '$IDc'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDc = '$IDc'"; // requête pour récupérer l'heure de fin du créneau
                $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDc = '$IDc'"; // requête pour récupérer la date du créneau
                $request_IDp = "SELECT IDp FROM creneaux WHERE Nom_intervention = '$intervention_admin_med' AND IDc = '$IDc'"; // requête pour récupérer les ID créneaux pour chaque patient
                $Heure_debut = do_request($connexion, $request_HDebut);
                $Heure_fin = do_request($connexion, $request_HFin);
                $Date_creneau = do_request($connexion, $request_date_creneau);
                $IDp = do_request($connexion, $request_IDp);
                $HDebut_array[] = $Heure_debut[0];
                $HFin_array[] = $Heure_fin[0];
                $Date_array[] = $Date_creneau[0];
                $IDp_array[] = $IDp[0];
            }
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
            for($i = 0; $i < sizeof($HDebut_array); $i++)
            {
                $res[$i] = array($HDebut_array[$i], $HFin_array[$i], $Date_array[$i], $Nom_array[$i], $Prenom_array[$i], $Nom_intervention[$i]);
            }
            return $res;
        }
    }
    elseif ($job == "Responsable")
    {
        $request_intervention = "SELECT Nom_intervention FROM type_d_intervention WHERE IDr = '$ID'"; // requête pour voir si il existe des créneaux pour ce type d'intervention
        $nom_intervention_arrays = do_request($connexion, $request_intervention);
        if(empty($nom_intervention_arrays[0]))
        {
            print("Il n'y a pas de créneaux à récupérer de votre type.");
        }
        else
        {
            $nom_intervention = $nom_intervention_arrays[0]['Nom_intervention'];
            $request_infos = "SELECT IDc, Date_creneau FROM creneaux WHERE Nom_intervention = '$nom_intervention'";
            $infos_creneau = do_request($connexion, $request_infos);
            foreach($infos_creneau as $creneau)
            {
                $date = date("d-m-Y", strtotime($creneau['Date_creneau']));
                if(strtotime($date) >= strtotime($date_lundi))
                {
                    $IDc_array[] = $creneau['IDc'];
                }
            }
            if(!isset($IDc_array))
            {
                print("Il n'y a pas de créneaux à récupérer de votre type.");
            }
            else
            {
                foreach($IDc_array as $IDc) // pour chaque nom d'intervention
                {
                    $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer l'heure de début du créneau
                    $request_HFin = "SELECT Heure_fin FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer l'heure de fin du créneau
                    $request_date_creneau = "SELECT Date_creneau FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer la date du créneau
                    $request_IDp = "SELECT IDp FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer l'IDp selon le type d'intervention
                    $Heure_debut = do_request($connexion, $request_HDebut);
                    $Heure_fin = do_request($connexion, $request_HFin);
                    $Date_creneau = do_request($connexion, $request_date_creneau);
                    $IDp = do_request($connexion, $request_IDp);
                    $HDebut_array[] = $Heure_debut[0];
                    $HFin_array[] = $Heure_fin[0];
                    $Date_array[] = $Date_creneau[0];
                    $IDp_array[] = $IDp[0];
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
                for($i = 0; $i < sizeof($HDebut_array); $i++)
                {
                    $res[$i] = array($HDebut_array[$i], $HFin_array[$i], $Date_array[$i], $Nom_array[$i], $Prenom_array[$i], $Nom_intervention_array[$i]);
                }
                return $res;
            }
        }
    }
}

### Fonction permettant de générer automatiquement les identifiants ###
function generate_id($id, $nom, $prenom)
{
    $connexion = connect();
    $first_letter_prenom = $prenom[0] ; # on stocke la première lettre du prénom
    $first_letter_nom = $nom[0] ; # puis celle du nom
    $random_number = rand(0,9).rand(0,9).rand(0,9).rand(0,9) ; # on génère une suite de 4 chiffres aléatoires compris entre 0 et 9
    $login = $first_letter_prenom.$first_letter_nom.$random_number ; # on concatène la première lettre du prénom + du nom + notre suite de chiffres

    switch ($id) { # selon le cas on va ajouter une chose supplémentaire
        case 'IDm': # si c'et un Médecin
            $login_def = "M_".$login ; # on va rajouter 'M_'
            $req_exist_loginM = "SELECT IDm FROM Medecin WHERE IDm = '$login_def' " ; # requête permettant de vérifier l'existence du login générer
            $exist_loginM = do_request($connexion, $req_exist_loginM) ;
            if (!empty($exist_loginM)) { # si la requête renvoie quelque chose -> login présent dans la BD
                generate_id($id, $nom, $prenom) ; # on rappelle la fonction pour générer à nouveau un login
            }
            break;

        case 'IDr': # si c'et un responsable
            $login_def = "R_".$login ; # on rajoute 'R_'
            $req_exist_loginR = "SELECT IDr FROM Responsable_d_intervention WHERE IDr = '$login_def' " ; # reque^te permettant de vérifier l'existence du login générer
            $exist_loginR = do_request($connexion, $req_exist_loginR) ;
            if (!empty($exist_loginR)) { # si la requête renvoie quelque chose -> login présent dans la BD
                generate_id($id, $nom, $prenom) ; # on rappelle la fonction pour générer à nouveau un login
            }
            break;
    }
    return $login_def ;
}

### Fonction pour générer un mot de passe ###
function generate_mdp($prenom)
{
    $prenom=mb_strtolower($prenom) ; # on récupère le prénom de l'utilisateur que l'on convertit en minuscule
    $random_number = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9) ; # on génère 5 chiffres aléatoires
    $mdp = $random_number.$prenom ; # on concatène le prénom + les chiffres aléatoires

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
    $semaine = $semaine * 7; // on multiplie l'argument passé par 7 pour être en "semaine"
    $jours_semaine = array(null, "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    $date = date('d/m/Y'); // on récupère la date d'aujourd'hui
    list($jour,$mois,$annee) = explode("/", $date); // on sépare chaque élément de la date
    $date_du_jour = date('d/m/y', mktime(0,0,0,$mois,$jour+$semaine,$annee)); // on modifie la date d'aujourd'hui pour qu'on soit à la semaine qu'on considère
    $jour_de_date = ucfirst(nom_jour($date_du_jour)); // on récupère le nom du jour
    for($k = 1; $k < sizeof($jours_semaine); $k++) // pour le nb de jours dans la semaine
    {
        if ($jour_de_date == $jours_semaine[$k]) // si le jour que l'on considère est celui qui est en train de tourner
        {
            list($jour,$mois,$annee) = explode("/", $date_du_jour); // on sépare la date
            $days_back = $k+1; // on ajoute 1 à l'index
            $date_lundi = date("d/m/Y", mktime(0,0,0,$mois,$jour-$days_back,$annee)); // on récupère la date du lundi de la semaine en soustrayant l'index
        }
    }
    for($d = 1; $d <= 8; $d++) // pour chaque jour de la semaine
    {
        list($jour,$mois,$annee) = explode("/", $date_lundi); // on sépare la date
        $dates_semaine[] = date("d/m/Y", mktime(0,0,0,$mois,$jour+$d,$annee)); // chaque indice de ce tableau représente la date du jour de la semaine que l'on considère
    }
    return $dates_semaine;
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


function getCreneauxIndisponibles($typeIntervention,$date){
    $connexion = connect();
    $request = "SELECT `Date_creneau`,`Heure_debut`,`Heure_fin`
                FROM `creneaux`
                WHERE `Nom_intervention` LIKE '$typeIntervention' AND `Date_creneau` >= '$date'
                ORDER BY `Date_creneau` ASC, `Heure_debut` ASC  ";
    $reponse = do_request($connexion, $request);
    return $reponse;
}


function get_niveau_priorite($nom_patho){
  $connexion = connect() ;
  $req_niveau_prio = "SELECT Niveau_urgence FROM Pathologie WHERE Nom_pathologie = '$nom_patho'" ;
  $niveau_prio = do_request($connexion, $req_niveau_prio) ;
  $niveau_priorite = $niveau_prio[0]['Niveau_urgence'] ;
  return $niveau_priorite ;
}


### Fonction pour vérifier les caractères entrés par l'utilisateur ###
function check_carac($word)
{
    $word_changed = ucfirst(mb_strtolower($word, 'UTF-8')) ; # quelque soit ce qu'a rentré l'utilisateur on met une majuscule pour le premier caractères, et le reste en minuscule

    if (preg_match("#^[A-Z][a-zàâäéèêëïùüû]+[' -]?[a-zàâäéèêëïùüû]+$#", $word_changed)) # on vérifie les champs correspondent à cette regex (pas de chiffre, accent + tiret + apostrophe autorisés)
    {
        return $word_changed ;
    }
}

### Fonction pour vérifier l'adresse mail rentrée par l'utilisateur ###
function check_mail($mail)
{
    $mail_changed = strtolower($mail) ; # on passe tout en minuscule puisque les adresses mails ne tiennent pas compte de la casse
    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail_changed)) # regex pour vérifier ce qu'à rentrer l'utilisateur
    {
        return $mail_changed ;
    }
}

### Fonction permettant de gérer le sousbooking ###
function sousbooking($connexion, $type_intervention, $IDp)
{
    print("<br>");
    $date = date("Y-m-d"); // date du jour de la demande
    $heure_now = date("H:i:s"); // heure de la demande
    $request_duree = "SELECT Duree FROM type_d_intervention WHERE Nom_intervention = '$type_intervention'"; // requête sur la durée
    $duree = do_request($connexion, $request_duree); // res de la requête
    $duree_intervention = $duree[0]['Duree']; // récupération de la durée

    $request_sous_booking = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$type_intervention' AND TIME(Heure_debut) = '".date("H:i:s", strtotime("-".$duree_intervention." minute", strtotime("20:00:00")))."' AND Date_creneau = '$date'"; // requête pour récupérer le créneau de sous booking
    $creneau_sous_booking = do_request($connexion, $request_sous_booking); // stockage du créneau de sousbooking

    if(empty($creneau_sous_booking[0]) and strtotime($heure_now) < strtotime("-".$duree_intervention." minute", strtotime("20:00:00"))) // si le créneau de sousbooking est libre et que l'heure est inférieure à 20h - la durée d'une intervention
    {
        print("Procédure Sousbooking");
        Print("<br><br>");
        $creneau_flottant['IDp'] = $IDp;
        $creneau_flottant['Niveau_priorite'] = 10;
        $creneau_flottant['Deplacement'] = 0;

        $request_creneaux = "SELECT IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Niveau_priorite, Deplacement FROM creneaux WHERE Nom_intervention = '$type_intervention' AND Date_creneau = DATE('$date')"; // requête de récupération des créneaux du jour
        $creneaux = do_request($connexion, $request_creneaux); // stockage des creneaux

        $nb_creneaux = sizeof($creneaux); // nb de créneaux dans la journée

        for ($i = 0 ; $i < $nb_creneaux ; $i++) // pour chaque créneau dans la journée
        {
            if (strtotime($creneaux[$i]['Date_creneau']." ".$creneaux[$i]['Heure_fin']) < strtotime($date." ".$heure_now)) // on regarde si le créneau a son heure de début < à l'heure et son heure de fin < à l'heure
            {
                unset($creneaux[$i]) ; // on supprime les créneaux que l'on a déjà dépassé dans le temps
                $creneaux_du_jour = array_values($creneaux) ; // on réassigne les index du tableau modifié
            }
        }

        if(!isset($creneaux_du_jour)) // si $creneaux_du_jour et $creneaux sont identiques, il faut l'indiquer
        {
            $creneaux_du_jour = $creneaux;
        }

        if(empty($creneaux_du_jour)) // si le tableau est vide == pas de créneaux dans la journée
        {
            list($heures, $minutes, $secondes) = explode(":", $heure_now);
            if ($minutes < 30) // on arrondit à la demi-heure supérieure
            {
                $creneau_heure_debut = date("H:i:s", mktime($heures,30,0));
            }
            elseif ($minutes >= 30) // on arrondit à la demi-heure supérieure
            {
                $creneau_heure_debut = date("H:i:s", mktime($heures+1,0,0));
            }
            $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneau_heure_debut)));
            if(strtotime($creneau_heure_fin) < strtotime("20:00:00")) // si l'heure de fin du créneau que l'on veut créer ne dépasse pas 20:00
            {
                print("Le dernier créneau inséré aura lieu le ".$date." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date', '$creneau_heure_debut', '$creneau_heure_fin', '$date', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].", ".$creneau_flottant['Deplacement'].")";
                mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                return;
            }
        }
        else // si le tableau de créneau n'est pas vide
        {
            $size = sizeof($creneaux_du_jour) ;

            $i = 0 ;

            while ($i < $size) // tant que l'on a pas parcouru tous les créneaux
            {
                if($i != $size - 1) // si on a pas atteint l'avant dernier créneau
                {
                    if($i == 0)
                    {
                        if(strtotime("-".$duree_intervention." minute", strtotime($creneaux_du_jour[$i]['Heure_debut'])) > strtotime($heure_now)) // si l'heure de début - duree intervention > heure de maintenant
                        {
                            $creneau_heure_debut = date("H:i:s", strtotime("-".$duree_intervention." minute", strtotime($creneaux_du_jour[$i]['Heure_debut'])));
                            $creneau_heure_fin = date("H:i:s", strtotime($creneaux_du_jour[$i]['Heure_debut']));
                            print("Le dernier créneau inséré aura lieu le ".$date." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                            $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date', '$creneau_heure_debut', '$creneau_heure_fin', '$date', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].", ".$creneau_flottant['Deplacement'].")";
                            mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                            return;
                        }
                    }

                    if($creneaux_du_jour[$i]['Heure_fin'] != $creneaux_du_jour[$i+1]['Heure_debut']) // si l'heure de fin du créneau n'est pas égale à l'heure de début du créneau suivant -> trou
                    {
                        $creneau_heure_debut = $creneaux_du_jour[$i]['Heure_fin'];
                        $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneaux_du_jour[$i]['Heure_fin'])));
                        print("Le dernier créneau inséré aura lieu le ".$date." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                        $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date', '$creneau_heure_debut', '$creneau_heure_fin', '$date', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].", ".$creneau_flottant['Deplacement'].")";
                        mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                        return;
                    }
                }
                else
                {
                    if(strtotime($creneaux_du_jour[$i]['Heure_fin']) <= strtotime("-".$duree_intervention." minute", strtotime("20:00:00"))) // si l'heure de fin du dernier créneau de la journée < 20:00 - duree intervention
                    {
                        $creneau_heure_debut = date("H:i:s", strtotime($creneaux_du_jour[$i]['Heure_fin']));
                        $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneau_heure_debut)));
                        print("Le dernier créneau inséré aura lieu le ".$date." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                        $insert_request = "INSERT INTO creneaux(IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date', '$creneau_heure_debut', '$creneau_heure_fin', '$date', '".$creneau_flottant['IDp']."', '$type_intervention', '".$creneau_flottant['Niveau_priorite']."', ".$creneau_flottant['Deplacement'].")";
                        mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                        return;
                    }
                }
                if ( $creneau_flottant['Niveau_priorite'] > $creneaux_du_jour[$i]['Niveau_priorite'] and $heure_now < $creneaux_du_jour[$i]['Heure_debut']) // si le créneau flottant a un niveau de priorité > au créneau du jour considéré
                {
                    print("Le créneau flottant concerne le patient d'ID ".$creneau_flottant['IDp'].".");
                    print("<br>");
                    print("Le créneau que l'on va déplacer est : ".$creneaux_du_jour[$i]['Heure_debut']."-".$creneaux_du_jour[$i]['Heure_fin']." le ".$creneaux_du_jour[$i]['Date_creneau'].".");
                    print("<br><br>");

                    $substitution['IDp'] = $creneau_flottant['IDp'] ;
                    $substitution['Niveau_priorite'] = $creneau_flottant['Niveau_priorite'] ;
                    $substitution['Deplacement'] = $creneau_flottant['Deplacement'];

                    $creneau_flottant['IDp'] = $creneaux_du_jour[$i]['IDp'] ;
                    $creneau_flottant['Niveau_priorite'] = $creneaux_du_jour[$i]['Niveau_priorite'] ;
                    $creneau_flottant['Deplacement'] = $creneaux_du_jour[$i]['Deplacement'];

                    $creneaux_du_jour[$i]['IDp'] = $substitution['IDp'] ;
                    $creneaux_du_jour[$i]['Deplacement'] = $substitution['Deplacement'] + 1;
                    $ajout_priorite = intval($creneaux_du_jour[$i]['Deplacement']);
                    $creneaux_du_jour[$i]['Niveau_priorite'] = $substitution['Niveau_priorite'] + $ajout_priorite;

                    $update_request = "UPDATE creneaux SET IDp = ".$creneaux_du_jour[$i]['IDp']." , Niveau_priorite = ".$creneaux_du_jour[$i]['Niveau_priorite'].", Deplacement = '".$creneau_flottant['Deplacement']."' WHERE IDc = ".$creneaux_du_jour[$i]['IDc'];
                    mysqli_query($connexion,$update_request) or die('<br>Erreur SQL !<br>'.$update_request.'<br>'.mysqli_error($connexion));
                }
                ++$i ;
            }
        }

    }
    elseif(!empty($creneau_sous_booking[0]) and $heure_now > strtotime("-".$duree_intervention." minute", strtotime("20:00:00"))) // si le créneau de sous-booking est pris et que l'heure de demande est après 20:00
    {
        print("Procédure Surbooking +1");
        Print("<br><br>");
        surbooking($connexion, $type_intervention, $IDp, $duree_intervention, $nb_jours = 1);
    }
    else // si le créneau de sous booking est pris
    {
        print("Procédure Surbooking");
        Print("<br><br>");
        surbooking($connexion, $type_intervention, $IDp, $duree_intervention);
    }
}

### Fonction permettant de gérer le surbooking ###
function surbooking($connexion, $type_intervention, $IDp, $duree_intervention, $nb_jours = 0, $creneau_flottant = NULL, $heure_now = NULL)
{
    print("<br>");
    $date_du_jour = date("Y-m-d"); // on récupère la date du jour
    list($annee, $mois, $jour) = explode("-", $date_du_jour);
    $date_considérée = date("Y-m-d", mktime(0,0,0,$mois, $jour+$nb_jours, $annee)); // on décale le jour si on est dans la récursivité

    if(!isset($heure_now)) // lorsqu'on appelle la fonction pour la première fois et que $heure_now n'existe pas
    {
        $heure_now = date("H:i:s");
    }

    if(!isset($creneau_flottant)) // si le créneau flottant n'existe pas
    {
        $creneau_flottant['IDp'] = $IDp;
        $creneau_flottant['Niveau_priorite'] = 10;
        $creneau_flottant['Deplacement'] = 0;
    }

    $request_creneaux = "SELECT IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Niveau_priorite, Deplacement FROM creneaux WHERE Nom_intervention = '$type_intervention' AND Date_creneau = DATE('$date_considérée')"; // requête pour récupérer les créneaux du jour
    $creneaux = do_request($connexion, $request_creneaux); // stockage des créneaux

    $nb_creneaux = sizeof($creneaux); // stockage du nb de créneaux

    for ($i = 0 ; $i < $nb_creneaux ; $i++) // pour chaque créneau
    {
        if (strtotime($creneaux[$i]['Heure_debut']) < strtotime($heure_now) or strtotime($creneaux[$i]['Heure_fin']) < strtotime($heure_now)) // si l'heure de début et de fin sont < à l'heure de maintenant
        {
            unset($creneaux[$i]) ; // on supprime le créneau
            $creneaux_du_jour = array_values($creneaux) ; // on réindexe le tableau
        }
    }

    if(!isset($creneaux_du_jour)) // si $creneaux_du_jour et $creneaux sont identiques
    {
        $creneaux_du_jour = $creneaux; // on fait en sorte qu'ils le soient
    }

    if(empty($creneaux_du_jour)) // si on a aucun créneau dans la journée
    {
        if(strtotime($heure_now) > strtotime("-".$duree_intervention." minute", strtotime("20:00:00"))) // si l'heure de maintenant > 20:00 - duree intervention
        {
            $nb_jours++;
            surbooking($connexion, $type_intervention, $IDp, $duree_intervention, $nb_jours, $creneau_flottant, "08:00:00");
        }
        else // sinon cela veut dire qu'on a changé de jour et que tous les créneaux sont disponibles
        {
            $creneau_heure_debut = "08:00:00"; // on passe l'heure à 8h
            $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneau_heure_debut)));
            print("Le dernier créneau inséré aura lieu le ".$date_considérée." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
            $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date_considérée', '$creneau_heure_debut', '$creneau_heure_fin', '$date_du_jour', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].", ".$creneau_flottant['Deplacement'].")";
            mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
            return;
        }
    }
    else
    {
        $size = sizeof($creneaux_du_jour) ;

        $i = 0 ;

        while ($i < $size) // on parcourt les créneaux de la journée
        {
            if($i != $size - 1) // tant qu'on a pas atteint le dernier créneau
            {
                if($i == 0) // si on considère le premier créneau
                {
                    if(strtotime("-".$duree_intervention." minute", strtotime($creneaux_du_jour[$i]['Heure_debut'])) > strtotime($heure_now)) // si l'heure de début - duree intervention > heure de maintenant
                    {
                        $creneau_heure_debut = date("H:i:s", strtotime("-".$duree_intervention." minute", strtotime($creneaux_du_jour[$i]['Heure_debut'])));
                        $creneau_heure_fin = date("H:i:s", strtotime($creneaux_du_jour[$i]['Heure_debut']));
                        print("Le dernier créneau inséré aura lieu le ".$date_considérée." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                        $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date_considérée', '$creneau_heure_debut', '$creneau_heure_fin', '$date_du_jour', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].", ".$creneau_flottant['Deplacement'].")";
                        mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                        return;
                    }
                }
                elseif($i == 0 and $i == $size - 1)
                {
                    $duree_intervention_x2 = $duree_intervention * 2;
                    if(strtotime($creneaux_du_jour[$i]['Heure_fin']) <= strtotime("-".$duree_intervention_x2." minute", strtotime("20:00:00")))
                    {
                        $creneau_heure_debut = date("H:i:s", strtotime($creneaux_du_jour[$i]['Heure_fin']));
                        $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneau_heure_debut)));
                        print("Le dernier créneau inséré aura lieu le ".$date_considérée." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                        $insert_request = "INSERT INTO creneaux(IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date_considérée', '$creneau_heure_debut', '$creneau_heure_fin', '$date_du_jour', '".$creneau_flottant['IDp']."', '$type_intervention', '".$creneau_flottant['Niveau_priorite']."', ".$creneau_flottant['Deplacement'].")";
                        mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                        return;
                    }
                }

                if($creneaux_du_jour[$i]['Heure_fin'] != $creneaux_du_jour[$i+1]['Heure_debut'])
                {
                    $creneau_heure_debut = $creneaux_du_jour[$i]['Heure_fin'];
                    $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneaux_du_jour[$i]['Heure_fin'])));
                    print("Le dernier créneau inséré aura lieu le ".$date_considérée." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                    $insert_request = "INSERT INTO creneaux (IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date_considérée', 'creneau_heure_debut', '$creneau_heure_fin', '$date_du_jour', ".$creneau_flottant['IDp'].", '$type_intervention', ".$creneau_flottant['Niveau_priorite'].", ".$creneau_flottant['Deplacement'].")";
                    mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                    return;
                }
            }
            else
            {
                $duree_intervention_x2 = $duree_intervention * 2;
                if(strtotime($creneaux_du_jour[$i]['Heure_fin']) <= strtotime("-".$duree_intervention_x2." minute", strtotime("20:00:00")))
                {
                    $creneau_heure_debut = date("H:i:s", strtotime($creneaux_du_jour[$i]['Heure_fin']));
                    $creneau_heure_fin = date("H:i:s", strtotime("+".$duree_intervention." minute", strtotime($creneau_heure_debut)));
                    print("Le dernier créneau inséré aura lieu le ".$date_considérée." entre ".$creneau_heure_debut." et ".$creneau_heure_fin);
                    $insert_request = "INSERT INTO creneaux(IDc, Date_creneau, Heure_debut, Heure_fin, Date_priseRDV, IDp, Nom_intervention, Niveau_priorite, Deplacement) VALUES ('', '$date_considérée', '$creneau_heure_debut', '$creneau_heure_fin', '$date_du_jour', '".$creneau_flottant['IDp']."', '$type_intervention', '".$creneau_flottant['Niveau_priorite']."', ".$creneau_flottant['Deplacement'].")";
                    mysqli_query($connexion,$insert_request) or die('<br>Erreur SQL !<br>'.$insert_request.'<br>'.mysqli_error($connexion));
                    return;
                }
            }

            if ( $creneau_flottant['Niveau_priorite'] > $creneaux_du_jour[$i]['Niveau_priorite'])
            {
                print("Le créneau flottant concerne le patient d'ID ".$creneau_flottant['IDp'].".");
                print("<br>");
                print("Le créneau que l'on va déplacer est : ".$creneaux_du_jour[$i]['Heure_debut']."-".$creneaux_du_jour[$i]['Heure_fin']." le ".$creneaux_du_jour[$i]['Date_creneau'].".");
                print("<br><br>");

                $substitution['IDp'] = $creneau_flottant['IDp'] ;
                $substitution['Niveau_priorite'] = $creneau_flottant['Niveau_priorite'] ;
                $substitution['Deplacement'] = $creneau_flottant['Deplacement'];

                $creneau_flottant['IDp'] = $creneaux_du_jour[$i]['IDp'] ;
                $creneau_flottant['Niveau_priorite'] = $creneaux_du_jour[$i]['Niveau_priorite'] ;
                $creneau_flottant['Deplacement'] = $creneaux_du_jour[$i]['Deplacement'];

                $creneaux_du_jour[$i]['IDp'] = $substitution['IDp'] ;
                $creneaux_du_jour[$i]['Deplacement'] = $substitution['Deplacement'] + 1;
                $ajout_priorite = intval($creneaux_du_jour[$i]['Deplacement']/5);
                $creneaux_du_jour[$i]['Niveau_priorite'] = $substitution['Niveau_priorite'] + $ajout_priorite;

                $update_request = "UPDATE creneaux SET IDp = ".$creneaux_du_jour[$i]['IDp']." , Niveau_priorite = ".$creneaux_du_jour[$i]['Niveau_priorite'].", Deplacement = '".$creneau_flottant['Deplacement']."' WHERE IDc = ".$creneaux_du_jour[$i]['IDc'];
                mysqli_query($connexion,$update_request) or die('<br>Erreur SQL !<br>'.$update_request.'<br>'.mysqli_error($connexion));
            }
            ++$i ;
        }
        $nb_jours++;
        surbooking($connexion, $type_intervention, $IDp, $duree_intervention, $nb_jours, $creneau_flottant, "08:00:00");
    }
}


// Requête permettant de voir si le patient existe déjà dans la base de données
function verif_patient($nomPatient,$prenomPatient) {
    $connexion = connect() ;
    $request = "SELECT *
                FROM `patient`
                WHERE `Nom` LIKE '$nomPatient' AND `Prenom` LIKE '$prenomPatient'" ;
    $reponse = do_request($connexion,$request) ;
    return $reponse ;
}


function select_IDpatient($nomPatient,$prenomPatient) {
    $connexion = connect() ;
    $request = "SELECT `IDp`
                FROM `patient`
                WHERE `Nom` LIKE '$nomPatient' AND `Prenom` LIKE '$prenomPatient'" ;
    $reponse = do_request($connexion,$request) ;

    foreach ($reponse as $value) {
      $IDp[] = $value['IDp'];
    }

    return $IDp[0] ;
}
?>
