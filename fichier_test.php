<?php
include("fonction.php");

$connexion = connect();
$type_intervention = "Radio";
surbooking($connexion,$type_intervention, 0);
?>