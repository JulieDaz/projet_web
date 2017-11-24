<?php include("fonction.php");

session_start();

$connexion = connect() ;
$id = $_POST['ID'] ;
$mdp = $_POST['mdp'] ;

print("<br>") ; 

if ($id == "" OR $mdp == ""){
	print("Attention vous n'avez pas rempli tous les champs. Veuillez recommencer.");
 }
else {
	$type= "SELECT User_type, IDu, Mdp FROM Utilisateur WHERE IDu = (SELECT IDu FROM est WHERE IDm= '$id' OR IDa = '$id' OR IDr = '$id')" ;
	$get_type = mysqli_query($connexion,$type) or die('<br>Erreur SQL !<br>'.$type.'<br>'.mysqli_error($connexion));
	$info_user = mysqli_fetch_array($get_type);
	$usertype = $info_user[0];
	$IDu = $info_user[1];
	$pwd = $info_user[2] ;

	if ($pwd != $mdp OR $get_type == FALSE) {
		print("Erreur : vérifiez vos informations de connexion");
	}

	else {
		switch ($usertype) {
		case 'Medecin':
			print("vous êtes un médecin !");
			$_SESSION['ID'] = $id ;
			$_SESSION['type'] = "Medecin" ;
			break;

		case 'Admin':
			print("vous êtes un admin !");
			$_SESSION['ID'] = $id ;
			$_SESSION['type'] = "Administrateur" ;
			break;
		
		case "Responsable":
			print("Vous êtes un responsable !");
			$_SESSION['ID'] = $id ;
			$_SESSION['type'] = "Responsable" ;
			break;
		}
	
	}

}

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
			echo "";
		}
	?>
	</table>



<?php

if ($usertype == "Admin") {
?>
<p>Formulaires :</p>

	<form method="post" action="ajouter.php"> 
	<label id=for="Ajout">Ajouter/retirer un médecin, un responsable d'intervention ou un patient</label>
	<input type="submit" value="Valider">
	</form>

	<form method="post" action="ajouter2.php"> 
	<label for="Ajout2">Ajouter/retirer une pathologie, un service d'intervention ou un service d'accueil</label>
	<input type="submit" value="Valider">
	</form>

<?php }
?>
	
</body>