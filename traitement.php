<?php include("fonction.php");

$connexion = connect() ;
$id = $_POST['ID'] ;

$mdp = $_POST['mdp'] ;



$login = "SELECT * FROM Medecin WHERE IdM = '$id' AND Mdp = '$mdp'" ;

$verif = do_request($login, $connexion);

print("<br>") ; 

if ($verif==FALSE)
	{
		print("Vérifier votre identifiant ou votre mot de passe") ;
	}
else 
	{ 
		print("coucou ça marche") ;
	}
?>
