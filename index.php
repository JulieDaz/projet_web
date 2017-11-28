<?php

if (session_start() == TRUE)
{
  session_destroy();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Medical Planner</title>
</head>
<body>


<h1>Welcome to Medical Planner</h1>


<form method="post" action="traitement.php">
  <label>ID</label> : <input type="text" required="on" name="ID">
  <br><br>
  <label>Mot de passe</label> : <input type="password" required="on" name="mdp">
  <br><br>
  <input type="submit" value="Se connecter">
</form>


</body>
</html>










