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
        $request_IDp = "SELECT IDp FROM a_comme WHERE IDm='$ID'"; // première requête pour récupérer les ID patients du médecin considéré
        $IDp_from_medecin = do_request($connexion,$request_IDp); // on effectue la requête --> tableau de tableau
        foreach($IDp_from_medecin as $IDp_array) // pour chaque ID patient récupéré
        {
            $IDp = $IDp_array['IDp']; // on va chercher la valeur contenue par la clé 'IDp'
            $request_IDc = "SELECT IDc FROM creneaux WHERE IDp = '$IDp'"; // deuxième requête pour récupérer les ID créneaux pour chaque patient
            $IDc_from_patient = do_request($connexion, $request_IDc); // on effectue la requête --> tableau de tableau
        }
        foreach($IDc_from_patient as $IDc_array) // pour chaque créneau récupéré
        {
            $IDc = $IDc_array['IDc']; // on va chercher la valeur contenue par la clé 'IDc'
            $request_HDebut = "SELECT Heure_debut FROM creneaux WHERE IDc = $IDc"; // requête pour récupérer l'heure de début du créneau
            $request_HFin = "SELECT Heure_fin FROM creneaux WHERE IDc = $IDc"; // requête pour récupérer l'heure de fin du créneau
            $Heure_debut = do_request($connexion, $request_HDebut); // on effectue la requête
            $Heure_fin = do_request($connexion, $request_HFin); // on effectue la requête
        }
        return array($Heure_debut,$Heure_fin); // on retourne un tableau de 2 tableaux dans lequel le premier contient les heures de début des créneaux et le deuxième contient les heures de fin
    }
    // if ($job == "")
}

function print_request($array)
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

function print_creneaux($array)
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

?>