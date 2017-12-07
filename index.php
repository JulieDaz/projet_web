<!DOCTYPE html>
<html>
	<head>
		<title>Medical Planner</title>
		<link rel="stylesheet" type="text/css" href="style.css">

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
	if (session_start() == TRUE)
	{
		if (isset($_SESSION['erreur']))
		{
			print("Erreur : identifiant ou mot de passe incorrect") ;
		}
		session_destroy();
	}
	?>

	</div>
	</body>
</html>
