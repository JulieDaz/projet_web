<?php include("fonction.php");

$connexion = connect() ;
$id = $_POST['ID'] ;
$mdp = $_POST['mdp'] ;

print("<br>") ; 

<<<<<<< HEAD
$test="utilisateur";

switch ($test) {
	case 1:
		$user = 'Medecin' ;
		echo "coucou ya qqn?";
		print($user);
		break;
	case 2:
		$user = 'Responsable_d_intervention' ;
		print($user);
		break;
}
=======

$login = "SELECT * FROM Medecin WHERE IdM = '$id' AND Mdp = '$mdp'" ;

$verif = do_request($login, $connexion);
>>>>>>> 6b41591332d343d85f00ea427e5bc9d733622553

$login = "SELECT * FROM $user WHERE IdM = '$id' AND Mdp = '$mdp'" ;
$verif = mysqli_query($connexion, $login) ;

if ($verif==FALSE)
	{
		print("Vérifier votre identifiant ou votre mot de passe") ;
	}
else 
	{ 
		print("coucou ça marche") ;
	}
?>
