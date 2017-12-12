<!DOCTYPE html>
<html>
	<head>
		<title>Medical Planner</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>

 

	<h1 id = "title">Welcome to Medical Planner</h1>

	<div class="connexion">

	<form method="post" action="traitement.php">
		<label>ID</label> : <input type="text" required="on" name="ID">
		<br><br>
		<label>Mot de passe</label> : <input type="password" required="on" name="mdp">
		<br><br>
		<input class="bouton_relief" type="submit" value="Se connecter">
	</form>

	<?php
	if (session_start() == TRUE) # si une session est déjà en cours
	{
		if (isset($_SESSION['erreur'])) # si la variable $_SESSION['erreur'] exist --> l'utilisateur s'est trompé de login ou mdp
		{
			print("Erreur : identifiant ou mot de passe incorrect") ; # affiche un message d'erreur
		}
		session_destroy(); # détruit les $_SESSION existant
	}
	?>

	</div>
	</body>
<br><br><br><br><br><br><br><br><br><br><br>
</html>


<?php
print("<br><br>") ;
include("pieddepage.php") ;
?>
