<?php include("fonction.php");

$connexion = connect() ;
$id = $_POST['ID'] ;
$mdp = $_POST['mdp'] ;

print("<br>") ; 

if ($id == "" OR $mdp == "") {
	print("Attention vous n'avez pas rempli tous les champs. Veuillez recommencer.");
}
else {
	$user="Medecin" ;
	$identifiant = "IDm" ;
	$login = "SELECT * FROM $user WHERE $identifiant = '$id' AND Mdp = '$mdp'" ;
	$verif = do_request($connexion,$login);
	if ($verif == TRUE) {
		print("Connexion réussie : vous êtes un médecin");
		}
		elseif ($verif == FALSE) {
			$user="Responsable_d_intervention" ;
			$identifiant = "IDr" ;
			$login = "SELECT * FROM $user WHERE $identifiant = '$id' AND Mdp = '$mdp'" ;
			$verif2 = do_request($connexion, $login);
			if ($verif2 == TRUE) {
				print("Connexion réussie : vous êtes un responsable");
				}
			elseif ($verif2 == FALSE) {
				$user="Administrateur" ;
				$identifiant = "IDa" ;
				$login = "SELECT * FROM $user WHERE $identifiant = '$id' AND Mdp = '$mdp'" ;
				$verif3 = do_request($connexion,$login);
				if ($verif3 == TRUE) {
					print("Connexion réussie : vous êtes un admin");
					}
				else {	
					print("Veuillez vérifier votre identifiant ou votre mot de passe") ;
				}	
			}
		}
	}

$creneaux = get_creneaux($user,$id,$connexion);

print_creneaux($creneaux);

?>

<head>
    <title>Medical Planner</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
	<br>
	<table>
	<?php
		$jour = array(null, "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
		$rdv["Dimanche"]["16:30"] = "Dermatologue";
		$rdv["Dimanche"]["17"] = "Dermatologue";
		$rdv["Lundi"]["9"] = "Mémé -_-";
		echo "<tr><th>Heure</th>";
		for($x = 1; $x < 8; $x++)
			echo "<th>".$jour[$x]."</th>";
		echo "</tr>";
		for($j = 8; $j < 20; $j += 0.5) {
			echo "<tr>";
			for($i = 0; $i < 7; $i++) {
				if($i == 0) {
					$heure = str_replace(".5", ":30", $j);
					echo "<td class=\"time\">".$heure."</td>";
				}
				echo "<td>";
				if(isset($rdv[$jour[$i+1]][$heure])) {
					echo $rdv[$jour[$i+1]][$heure];
				}
				echo "</td>";
			}
			echo "</tr>";
		}
	?>
	</table>
</body>