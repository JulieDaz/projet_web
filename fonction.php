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
    return $connexion;
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
function get_creneaux($job, $ID, $connexion)
{
    if ($job == "Medecin") // s'il s'agit d'un médecin
    {
        $request_IDp = "SELECT IDp FROM a_comme WHERE IDm='$ID'"; // requête pour récupérer les ID patients du médecin considéré
        $IDp_from_medecin = do_request($connexion,$request_IDp); // on effectue la requête --> tableau de tableau
        foreach($IDp_from_medecin as $IDp_array) // pour chaque ID patient récupéré
        {
            $IDp = $IDp_array['IDp']; // on va chercher la valeur contenue par la clé 'IDp'
            $request_nom = "SELECT Nom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les noms des patients
            $request_prenom = "SELECT Prenom FROM patient WHERE IDp ='$IDp'"; // requête pour récupérer les prénoms des patients
            $request_IDc = "SELECT IDc FROM creneaux WHERE IDp = '$IDp'"; // requête pour récupérer les ID créneaux pour chaque patient
            $Nom = do_request($connexion, $request_nom);
            $Prenom = do_request($connexion, $request_prenom);
            $IDc_arrays = do_request($connexion, $request_IDc);
        }
        foreach($IDc_arrays as $IDc_array) // pour chaque créneau récupéré
        {
            $IDc = $IDc_array['IDc']; // on va chercher la valeur contenue par la clé 'IDc'
            $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer l'heure de début du créneau
            $request_HFin = "SELECT Heure_fin FROM creneaux WHERE IDc = '$IDc'"; // requête pour récupérer l'heure de fin du créneau
            $Heure_debut = do_request($connexion, $request_HDebut); // on effectue la requête
            $Heure_fin = do_request($connexion, $request_HFin); // on effectue la requête
        }
        return array($Heure_debut,$Heure_fin,$Nom,$Prenom); // on retourne un tableau de 4 tableaux --> heure début, heure fin, nom patient, prenom patient (chaque ligne concerne un seul créneau)
    }
    elseif ($job == "Admin")
    {

    }
    elseif ($job == "Responsable")
    {
        $request_intervention = "SELECT Nom_intervention FROM type_d_intervention WHERE IDr = '$ID'"; // requête pour récupérer le nom de l'intervention selon l'ID du responsable
        $nom_intervention_arrays = do_request($connexion, $request_intervention);
        foreach($nom_intervention_arrays as $nom_intervention_array) // pour chaque nom d'intervention
        {
            $nom_intervention = $nom_intervention_array['Nom_intervention']; // on récupère le nom de l'intervention
            $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE Nom_intervention = '$nom_intervention'"; // requête pour récupérer l'heure de début du créneau
            $request_HFin = "SELECT Heure_fin FROM creneaux WHERE Nom_intervention = '$nom_intervention'"; // requête pour récupérer l'heure de fin du créneau
            $Heure_debut = do_request($connexion, $request_HDebut); // on effectue la requête
            $Heure_fin = do_request($connexion, $request_HFin); // on effectue la requête
        }
        return array($Heure_debut,$Heure_fin);
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




function nom_jour($date) // fonction pour récupérer le jour de la date donné
{
   $jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche");

   list($annee, $mois, $jour) = explode ("/", $date);

   $timestamp = mktime(0,0,0, date($mois), date($jour), date($annee));
   $njour = date("N",$timestamp);

   return $jour_semaine[$njour];
}
?>
