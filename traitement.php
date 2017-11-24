<?php include("fonction.php");

$connexion = connect() ;
$id = $_POST['ID'] ;
$mdp = $_POST['mdp'] ;

print("<br>") ; 

if ($id == "" OR $mdp == ""){
	print("Attention vous n'avez pas rempli tous les champs. Veuillez recommencer.");
 }
else {
	$allusers= "SELECT 'UserType' FROM Utilisateurs WHERE ID ='".$id."' AND Mdp = '".$mdp."'" ;
	$getallusers = do_request($getallusers,$connexion) ;
	$getallusers = mysqli_fetch_array($getallusers) ;
	$getuser = $getallusers[0] ;
 }


// if ($id == "" OR $mdp == "") {
// 	print("Attention vous n'avez pas rempli tous les champs. Veuillez recommencer.");
// }
// else {
// 	$user="Medecin" ;
// 	$identifiant = "IDm" ;
// 	$login = "SELECT * FROM $user WHERE $identifiant = '$id' AND Mdp = '$mdp'" ;
// 	$verif = do_request($login, $connexion);
// 	if ($verif == TRUE) {
// 		print("Connexion réussie : vous êtes un médecin");
// 		}
// 	elseif ($verif == FALSE) {
// 		$user="Responsable_d_intervention" ;
// 		$identifiant = "IDr" ;
// 		$login = "SELECT * FROM $user WHERE $identifiant = '$id' AND Mdp = '$mdp'" ;
// 		$verif2 = do_request($login, $connexion);
// 		if ($verif2 == TRUE) {
// 			print("Connexion réussie : vous êtes un responsable");
// 				}
// 		elseif ($verif2 == FALSE) {
// 				$user="Administrateur" ;
// 				$identifiant = "IDa" ;
// 				$login = "SELECT * FROM $user WHERE $identifiant = '$id' AND Mdp = '$mdp'" ;
// 				$verif3 = do_request($login, $connexion);
// 				if ($verif3 == TRUE) {
// 					print("Connexion réussie : vous êtes un admin");
// 					}
// 				else {	
// 					print("va te faire foutre enculé de ta mère") ;
// 				}	
// 			}
// 		}
// 	}

//print($user);