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


//On crée le planning
$creneaux = get_creneaux($usertype,$id,$connexion);

foreach($creneaux as $creneau) // pour chaque créneau
{
	foreach($creneau as $data) // pour chaque information
	{
		foreach($data as $value) // pour chaque valeur
		{
			if (array_key_exists('Heure_debut', $data)) // si l'information 'Heure_debut' existe
			{
				$date = strtotime($value); // on convertit sa valeur en format date
				$date_rdv[] = date('d/m/y', $date); // on stocke la date de rdv
				$heure_debut[] = date('G:i', $date); // on stocke l'heure de début du rdv
			}
			elseif(array_key_exists('Heure_fin', $data)) // si l'information 'Heure_fin' existe
			{
				$date = strtotime($value); // on convertit sa valeur en format date
				$heure_fin[] = date('G:i', $date); // on stocke l'heure de fin du rdv
			}
			elseif(array_key_exists('Nom', $data)) // si l'information 'Nom' existe
			{
				$nom_patient[] = $value; // on stocke le nom du patient
			}
			elseif(array_key_exists('Prenom',$data)) // si l'information 'Prenom' existe
			{
				$prenom_patient[] = $value; // on stocke le prénom du patient
			}
		}
	}
}
?>


<!--Début de la page HTML, commun à tous les utilisateurs..............................................................................................-->
	<html>
	 <head>
			 <title>Medical Planner</title>
			 <link rel="stylesheet" href="style.css"/>
	 </head>
	 <body>


<!--si l'utilisateur est un médecin.....................................................................................................................-->
		 <?php
		 if ($usertype=="Medecin") {
			 ?>
			 <form method="post">
				 <p> Sélectionnez le type d'intervention souhaitée : </p>
				 <select name="type_d_intervention">
					 <?php
						 $request = "SELECT Nom_intervention FROM type_d_intervention";      //On effectue une requête qui sélectionne les noms des interventions
						 $typeIntervention = do_request($connexion,$request);                //On récupère le résultat de la requête dans un tableau
						 foreach($typeIntervention as $value) {                              //On parcourt ce tableau pour récupérer les types d'intervention 1 à 1
							 echo "<option>$value[Nom_intervention]";                          //On crée le menu déroulant au fil de la lecture du foreach
						 }
					 ?>
				 </select>
			 </form>
		 <?php
		 }


 //----------------------------------------------------------------------------------------------------------------------------------------------------//
 //si l'utilisateur est un admin
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

 <?php
 }
 ?>


<!--Ecriture du planning, commun à tous les utilisateurs..................................................................................................-->
		 <br>
		 <table>
		 <?php
			 $jours_semaine = array(null, "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
			 print("<br>");
			 for($i = 0; $i < sizeof($heure_debut); $i++) // pour chaque créneau stocké
			 {
				 $j=30; // on définit un incrément
				 $jour = ucfirst(nom_jour($date_rdv[$i])); // on récupère le jour de la date
				 $rdv[$jour][$heure_debut[$i]] = "Creneau"; // on crée une première entrée dans $rdv pour chaque créneau
				 while(date("H:i", strtotime("+".$j." minute", strtotime($heure_debut[$i]))) < date("H:i", strtotime($heure_fin[$i]))) // tant que l'heure de début < l'heure de la fin
				 {
					 $h = date("G:i", strtotime("+".$j." minute", strtotime($heure_debut[$i]))); // on crée un mini-créneau pour réprésenter la demi-heure de créneau suivant le demi-créneau précédent
					 $rdv[$jour][$h] = "Creneau"; // on crée une nouvelle entrée dans $rdv pour la demi-heure suivant le début du créneau
					 $j+=30; // on incrémente d'une demi-heure
				 }
			 }

			 echo "<tr><th>Heure</th>";
			 for($x = 1; $x < 8; $x++) // sur une ligne on va afficher le nom des jours
			 {
				 echo "<th>".$jours_semaine[$x]."</th>";
			 }
			 echo "</tr>";
			 for($j = 8; $j < 20; $j += 0.5) // pour chaque demi-heure de la journée
			 {
				 echo "<tr>";
				 for($i = 0; $i < 7; $i++) // pour chaque jour de la semaine
				 {
					 if($i == 0)
					 {
						 $heures = intval($j); // prend la valeur entière de $j
						 $realPart = $j - $heures; // on regarde cb de minutes en "heures" on a
						 $minutes = intval( $realPart * 60); // on récupère le nombre de minutes réel
						 if ($minutes == 0) // si ce nb de minutes = 0, on fait en sorte que l'affichage soit correct par la suite
						 {
							 $minutes = "00";
						 }
						 echo "<td class=\"time\">".$heures.":".$minutes."</td>"; // affichage de l'heure dans la colonne de gauche
					 }
					 echo "<td>";
					 if(isset($rdv[$jours_semaine[$i+1]][$heures.":".$minutes])) // à la case correspondante on affiche le créneau s'il existe
					 {
						 echo $rdv[$jours_semaine[$i+1]][$heures.":".$minutes];
					 }
					 echo "</td>";
				 }
				 echo "</tr>";
			 }
		 ?>
		 </table>
	 </body>
	</html>
