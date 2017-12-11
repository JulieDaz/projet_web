<?php include("fonction.php");

session_start();

?>

<!--Début de la page HTML, commune à tous les utilisateurs..............................................................................................-->
	<html>
	<head>
		<title>Medical Planner</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>

	<br>

<div class = "deco">
<img src = "images/penguin.png" height = "50" width = "50">

<?php

$connexion = connect() ;

if(isset($_SESSION['ID']))
{
	$id = $_SESSION['ID'];
	$mdp = $_SESSION['mdp'];
}
else
{
	$id = $_POST['ID'] ;
	$mdp = $_POST['mdp'] ;
}

print("<br>") ;

if ($id == "" OR $mdp == "")
{
	print("Attention vous n'avez pas rempli tous les champs. Veuillez recommencer.");
}
else 
{
	$type= "SELECT User_type, IDu, Mdp FROM Utilisateur WHERE IDm= '$id' OR IDa = '$id' OR IDr = '$id'" ;
	$get_type = mysqli_query($connexion,$type) or die('<br>Erreur SQL !<br>'.$type.'<br>'.mysqli_error($connexion));
	$info_user = mysqli_fetch_array($get_type);
	$usertype = $info_user[0];
	$IDu = $info_user[1];
	$pwd = $info_user[2] ;
}

if ($pwd != $mdp OR $get_type == FALSE) {
	$_SESSION['erreur'] = "Login ou mdp invalide" ;
	header("Location:index.php") ;
}
else {
	switch ($usertype) {
	case 'Medecin':
		$_SESSION['ID'] = $id ;
		$_SESSION['mdp'] = $mdp;
		$_SESSION['type'] = "Medecin" ;
		$_SESSION['table_id'] = "IDm" ;
		break;

	case 'Admin':
		$_SESSION['ID'] = $id ;
		$_SESSION['mdp'] = $mdp;
		$_SESSION['type'] = "Administrateur" ;
		$_SESSION['table_id'] = "IDa" ;
		break;

	case "Responsable":
		$_SESSION['ID'] = $id ;
		$_SESSION['mdp'] = $mdp;
		$_SESSION['type'] = "Responsable_d_intervention" ;
		$req_intervention = "SELECT Nom_intervention FROM Responsable_d_intervention WHERE IDr = '$id'" ;
		$_SESSION['table_id'] = "IDr" ;
		$intervention = do_request($connexion, $req_intervention) ;
		$_SESSION['intervention'] = $intervention[0]['Nom_intervention'] ;
		break;
	}

}

$req_display_name = "SELECT Nom, Prenom FROM ".$_SESSION['type']." WHERE ".$_SESSION['table_id']." = '$id'";
$display_name = do_request($connexion, $req_display_name) ;
print($display_name[0]['Prenom']." ".$display_name[0]['Nom']) ;

?>
<br><br>


</div>
<a class="bouton_deco" href="index.php">Déconnexion</a>



<!--si l'utilisateur est un médecin ou un admin.....................................................................................................................-->
<!-- Quel type d'intervention veut-on visualiser -->

<form action="traitement.php" method="post">
	<label>Sélectionnez le type d'intervention</label> : <select name="type_d_intervention">
		<?php
			$request = "SELECT Nom_intervention FROM type_d_intervention";      //On effectue une requête qui sélectionne les noms des interventions
			$typeIntervention = do_request($connexion,$request);                //On récupère le résultat de la requête dans un tableau
			foreach($typeIntervention as $value)                               //On parcourt ce tableau pour récupérer les types d'intervention 1 à 1
			{
				if(isset($_SESSION['type_d_intervention']) and $_SESSION['type_d_intervention'] == $value['Nom_intervention'])
				{
					echo "<option selected = \"selected\">$value[Nom_intervention]</option>"; // affichage par défaut du nom de l'intervention
				}
				else
				{
					echo "<option>$value[Nom_intervention]</option>"; //On crée le menu déroulant au fil de la lecture du foreach
				}
			}
		?>
 		<input type="submit" value="Valider quel type d'intervention à visualiser" name="intervention">
 	</select>
 </form>

<!--Ecriture du planning, commun à tous les utilisateurs..................................................................................................-->
		<?php
			$connexion = connect() ;
			$jours_semaine = array(null, "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
			if(!isset($_SESSION['nb_semaine'])) // si cette variable n'existe pas, on la crée
			{
				$_SESSION['nb_semaine'] = 0; // variable pour indiquer dans quelle semaine on se trouve
			}
			if(isset($_POST['semaine_précédente']) and $_SESSION['nb_semaine'] > 0) //  quand on clique sur le bouton "<<" et que session[nb_semaine] est supérieur à 0
			{
				$_SESSION['nb_semaine']--; // on enlève -1 à la variable session[nb_semaine]
			}
			elseif(isset($_POST["semaine_suivante"])) // quand on clique sur le bouton ">>"
			{
				$_SESSION['nb_semaine']++; // on ajoute +1 à la variable session[nb_semaine]
			}
			elseif(isset($_POST["reset_time"])) // quand on clique sur le bouton Aujourd'hui
			{
				$_SESSION['nb_semaine'] = 0; // on revient à la semaine courante
			}

			$dates_semaine = get_dates_semaines($_SESSION['nb_semaine']); // on récupère un tableau avec les dates de la semaine que l'on veut regarder (selon le $semaine)

			$dates_semaine_en_cours = get_dates_semaines(0);

			if ($usertype=="Medecin" OR $usertype =="Admin")
			{
				if(!isset($_POST["intervention"]) and !isset($_SESSION['type_d_intervention'])) // si pas de clic et pas de $_SESSION existant --> on vient d'arriver sur la page
				{
					$_SESSION['type_d_intervention'] = $typeIntervention[0]['Nom_intervention']; // on affecte la valeur par défaut du menu déroulant à $_SESSION
				}
				elseif(isset($_POST["intervention"]) and !isset($_SESSION['type_d_intervention'])) // si clic mais pas de $_SESSION existant --> on veut changer de visualisation
				{
					$_SESSION['type_d_intervention'] = $_POST["type_d_intervention"]; // on récupère la valeur donnée dans le menu déroulant après clic
				}
				elseif(isset($_POST["intervention"]) and isset($_SESSION['type_d_intervention'])) // si clic et $_SESSION existant --> on a déjà changé de visualisation et on veut rechanger
				{
					$_SESSION['type_d_intervention'] = $_POST["type_d_intervention"]; // on réaffecte $_SESSION à la valeur du menu déroulant
				}
				print("Vous visualisez les créneaux de ".$_SESSION['type_d_intervention']); // on indique le type d'intervention des créneaux que l'on visualise
				print("<br><br>");
			}

			// Récupération des créneaux //
			if($usertype == 'Responsable')
			{
				$_SESSION['type_d_intervention'] = NULL; // dans le cas où on considère un responsable, on a pas besoin du type d'intervention
			}
			
			$super_tableau_creneaux = get_creneaux($usertype,$id,$connexion, $dates_semaine_en_cours, $_SESSION['type_d_intervention']);
			
			// print_r($super_tableau_creneaux);
			
			if(isset($super_tableau_creneaux)) // on vérifie que des créneaux existent
			{
				foreach($super_tableau_creneaux as $creneau) // pour chaque créneau
				{
					foreach($creneau as $key) // pour chaque clé
					{
						foreach($key as $value) // pour chaque valeur associée à la clé
						{
							if (array_key_exists('Heure_debut', $key)) // si l'information 'Heure_debut' existe
							{
								$heureDebut = strtotime($value); // on convertit sa valeur en format date
								$heure_debut[] = date("G:i", $heureDebut); // on stocke l'heure de début du rdv
							}
							elseif(array_key_exists('Heure_fin', $key)) // si l'information 'Heure_fin' existe
							{
								$heureFin = strtotime($value); // on convertit sa valeur en format date
								$heure_fin[] = date("G:i", $heureFin); // on stocke l'heure de fin du rdv
							}
							elseif(array_key_exists('Date_creneau',$key))
							{
								$date = strtotime($value);
								$date_creneau[] = date('d/m/Y', $date);
							}
							elseif(array_key_exists('Nom', $key)) // si l'information 'Nom' existe
							{
								$nom_patient[] = $value; // on stocke le nom du patient
							}
							elseif(array_key_exists('Prenom',$key)) // si l'information 'Prenom' existe
							{
								$prenom_patient[] = $value; // on stocke le prénom du patient
							}
							elseif(array_key_exists('Nom_intervention',$key)) // si l'information 'Nom_intervention' existe
							{
								$nom_intervention[] = $value; // on stocke le type de l'intervention
							}
						}
					}
				}
			}
			?>

			<br>
			<table>
			<br>
			<form method = "POST" action = "traitement.php">
				<input type="submit" value="<<" name="semaine_précédente">
				<input type="submit" value="Semaine en cours" name="reset_time">
				<input type="submit" value=">>" name="semaine_suivante">
			</form>
			<br>
			<br>

			<?php
			if(isset($super_tableau_creneaux))
			{
				for($i = 0; $i < sizeof($heure_debut); $i++) // pour chaque créneau stocké
				{
					$j=30; // on définit un incrément
					$jour = ucfirst(nom_jour($date_creneau[$i])); // on récupère le jour de la date
					$rdv[$jour." ".$date_creneau[$i]][$heure_debut[$i]] = $prenom_patient[$i]." ".$nom_patient[$i]; // on crée une première entrée dans $rdv pour chaque créneau
					while(date("H:i", strtotime("+".$j." minute", strtotime($heure_debut[$i]))) < date("H:i", strtotime($heure_fin[$i]))) // tant que l'heure de début < l'heure de la fin
					{
						$h = date("G:i", strtotime("+".$j." minute", strtotime($heure_debut[$i]))); // on crée un mini-créneau pour réprésenter la demi-heure de créneau suivant le demi-créneau précédent
						$rdv[$jour." ".$date_creneau[$i]][$h] = $prenom_patient[$i]." ".$nom_patient[$i];
						$j+=30; // on incrémente d'une demi-heure
					}
				}
			}
			echo "<tr><th>Heure</th>";
			for($x = 1; $x < 8; $x++) // sur une ligne on va afficher le nom des jours
			{
				$date_jour[$x-1] = $jours_semaine[$x]." ".$dates_semaine[$x]; // on ajoute dans un tableau les valeurs des dates de la semaine
				echo "<th>".$date_jour[$x-1]."</th>"; // affichage de la date dans le haut du tableau
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
					if(isset($rdv[$date_jour[$i]][$heures.":".$minutes])) // à la case correspondante on affiche le créneau s'il existe
					{
						echo $rdv[$date_jour[$i]][$heures.":".$minutes];
					}
					echo "</td>";
				}
				echo "</tr>";
			}
		?>
	</table>


<!--si l'utilisateur est un admin-->
<?php
if ($usertype == "Admin") {
 	?>
 	<h3>Formulaires :</h3>
	<p>Ajouter/retirer un médecin, un responsable d'intervention ou un patient :</p>
	<a class="bouton_relief" href="ajouter.php">Accéder au formulaire</a>

	<p>Ajouter/retirer une pathologie ou un service d'accueil :</p>
	<a class="bouton_relief" href="ajouter2.php">Accéder au formulaire</a>

<?php
}

 //----- Si l'utilisateur est un médecin -----//
elseif ($usertype == "Medecin") {
	?>
	<br>
	<a class="bouton_relief" href="demande_intervention.php">Demande d'intervention </a>

<?php
}

elseif ($usertype == "Responsable") {
	#REQUETE POUR RECUPERER LE TYPE D'INTERVENTION
	?>
	<br>
	<p>Effectuer une demande d'urgence : </p>
	<a class="bouton_relief" href="urgence.php">Demande d'urgence</a>

<?php
}
print("<br><br>") ;
include("pieddepage.php") ;
?>
