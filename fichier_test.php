<?php
include("fonction.php");

$connexion = connect();
$type_intervention = "Radiologie";
// sousbooking($connexion, $type_intervention, 0);
surbooking($connexion,$type_intervention, 0);
?>