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
                $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer l'heure de début du créneau
                $request_HFin = "SELECT Heure_fin FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer l'heure de fin du créneau
                $request_IDc = "SELECT IDc FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer les ID créneaux pour chaque patient
                $IDc_super_array[] = do_request($connexion, $request_IDc);
                $Heure_debut[] = do_request($connexion, $request_HDebut); // on effectue la requête
                $Heure_fin[] = do_request($connexion, $request_HFin); // on effectue la requête
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
            return array($Heure_debut,$Heure_fin,$Nom,$Prenom); // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient pour chaque créneau
        }
    }
    elseif ($job == "Admin")
    {
        $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE Nom_intervention = '$intervention_admin'";              
        $Nom_intervention[] = do_request($connexion, $request_intervention);
        if(empty($Nom_intervention[0]))
        {
            print("Il n'y a pas de créneaux à récupérer de ce type.");
        }
        else
        {
            $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$intervention_admin'"; // requête pour récupérer l'heure de début du créneau
            $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$intervention_admin'"; // requête pour récupérer l'heure de fin du créneau
            $request_IDp = "SELECT IDp FROM creneaux WHERE Nom_intervention = '$intervention_admin'";
            $Heure_debut[] = do_request($connexion, $request_HDebut); // on effectue la requête
            $Heure_fin[] = do_request($connexion, $request_HFin); // on effectue la requête
            $IDp_super_array[] = do_request($connexion, $request_IDp);
            foreach($IDp_super_array as $IDp_arrays)
            {
                foreach($IDp_arrays as $IDp_array)
                {
                    $IDp = $IDp_array['IDp'];
                    $request_nom = "SELECT Nom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les noms des patients
                    $request_prenom = "SELECT Prenom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les prénoms des patients
                    $request_intervention = "SELECT Nom_intervention FROM creneaux WHERE Nom_intervention = '$intervention_admin'"; // requête pour récupérer le type d'intervention    
                    $Nom_intervention[] = do_request($connexion, $request_intervention);
                    $Nom[] = do_request($connexion, $request_nom);
                    $Prenom[] = do_request($connexion, $request_prenom);
                }
            }
            return array($Heure_debut,$Heure_fin,$Nom,$Prenom,$Nom_intervention); // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
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
                $request_IDp = "SELECT IDp FROM creneaux WHERE Nom_intervention = '$nom_intervention'"; // requête pour récupérer l'IDp selon le type d'intervention
                $Heure_debut[] = do_request($connexion, $request_HDebut); // on effectue la requête
                $Heure_fin[] = do_request($connexion, $request_HFin); // on effectue la requête
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
            return array($Heure_debut,$Heure_fin,$Nom,$Prenom,$Nom_intervention); // super tableau dans lequel on a l'heure de debut et fin, le nom et prenom du patient et le type d'intervention pour chaque créneau
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

function sousbooking($connexion, $type_intervention)
{
    $request_sous_booking = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$type_intervention' AND TIME(Heure_debut) = '18:00:00'";
    $creneau_sous_booking = do_request($connexion, $request_sous_booking);
    if(empty($creneau_sous_booking[0]))
    {
        print("Le créneau de sous-booking est vide");

    }
}

function surbooking($connexion, $type_intervention, $IDp)
{
    $date_du_jour = date("Y-m-d");
    $request_creneaux_du_jour = "SELECT Heure_debut, IDp, Niveau_priorite FROM creneaux WHERE Nom_intervention = '$type_intervention'";
    $creneaux_du_jour = do_request($connexion, $request_creneaux_du_jour);
    for($i=0; $i < sizeof($creneaux_du_jour); $i++)
    {
        $creneaux_du_jour[$i]['Niveau_priorité'] = $niveau_priorité[$i][0]['Niveau_priorite'];
    }
    $nb_creneau = 0;
    $creneau_déplacé['Heure_début'] = '';
    $creneau_déplacé['IDp'] = $IDp;
    $creneau_déplacé['Niveau_priorite'] = 10;
    print_r($creneau_déplacé);
    while($creneau_déplacé['Niveau_priorite'] != 1 or date('G:i', $creneau_déplacé['Heure_debut']) < date('G:i', mktime(18,0,0,0,0,0)))
    {
        $creneau_déplacé = array_shift($creneaux_du_jour[$nb_creneau]);
        list($annee,$mois,$jour) = explode("-", $date_du_jour);
        $date_du_jour = date("Y-m-d", mktime(0,0,0,$mois,$jour+1,$annee));
        $nb_creneau++;
    }
}

?>
