<?php  

/***** Connexion à la base de donnée ******/
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

/*****deconnexion a la base de donnée****/

function deconnect($connexion)
{
	mysqli_close($connexion);
}

function do_request($request,$connexion)
{
    $req = mysqli_query($connexion,$request) or die('Erreur SQL !<br>'.$request.'<br>'.mysqli_error());
    $a = array();
    while($row = mysqli_fetch_assoc($req))
    {
        $a[] = $row;
    }
    mysqli_free_result($req);
    return $a;
}

function print_request($array) // en cours de réalisation
{
    for($i=0;$i<sizeof($array);$i++)
    {
        $row = $array[$i];
        foreach($row as $data)
        {
            print($data);
            print("<br>");
        }
    }
}

?>