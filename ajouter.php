<?php 
include("fonction.php"); 
session_start() ;
?>


<!DOCTYPE html>
<html>
<head>
     <title>Formulaire 1</title>
</head>
<body>

<!-- SECTION Medecin -->

<div id="medecin">

<h2> Formulaire d'ajout d'un médecin : </h2>
    <form method="post" action=""> 
        <label>Nom</label> : <input type="text" required="on" name="nom_med">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_med">
        <br><br>
        <label>Service d'accueil</label> : <select >
        <input type="submit" value="Ajouter un médecin" name="bouton_med">
	</form>

    <?php

    if (isset($_POST['bouton_med']))
    {
        $connexion = connect() ;
        $name_med = $_POST['name_med'] ;
        $prenom_med = $_POST['prenom_med'] ;
        //$service = $_POST[''] ;

        // $req_add_doc = "INSERT INTO Medecin ('IDm', 'Nom', 'Prenom', 'Nom_service') VALUES ('$id','$name_med','$prenom_med','$service')" ;
        // $add_doc = do_request($connexion,$req_add_doc);
    }
    ?>

</div>

<!-- SECTION RESPONSABLE -->

<div id="responsable">

<h2> Formulaire d'ajout d'un responsable d'intervention et du service d'intervention correspondant : </h2>

    <form method="post" action=""> 
        <label>Nom</label> : <input type="text" required="on" name="nom_resp">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_resp">
        <br><br>
        <label>Nom du service d'intervention</label> : <input type="text" required="on" name="intervention">
        <br><br>
        <label>Durée de l'intervention (en minutes)</label> : <input type="text" required="on" name="time">
        <input type="submit" value="Ajouter un responsable d'intervention" name="bouton_resp">
	</form>

    <?php

    if (isset($_POST['bouton_resp']))
    {
        $connexion = connect() ;
        $name_resp = $_POST['nom_resp'] ;
        $prenom_resp = $_POST['prenom_resp'] ;
        $service_int = $_POST['intervention'] ;
        $time = $_POST['time'] ;
        $id_resp = "IDr" ;
        $id_responsable = generate_id($id_resp, $name_resp, $prenom_resp) ;

        $req_add_resp = "INSERT INTO Responsable_d_intervention (IDr, Nom, Prenom, Nom_intervention) VALUES ('$id_responsable','$name_resp','$prenom_resp','$service_int')" ;
        $add_resp = do_request($connexion,$req_add_resp);
        $req_intervention = "INSERT INTO Type_d_intervention (Nom_intervention, Duree, IDr) VALUES ('$service_int', '$time', '$id_responsable')" ;
        $add_intervention = do_request($connexion,$req_intervention) ;
        
    }
    ?>



</div>

<!-- SECTION PATIENT -->

<div id="patient">

<h2> Formulaire d'ajout d'un patient : </h2>

    <form method="post" action=""> 
        <label>Nom</label> : <input type="text" required="on" name="nom_patient">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_patient">
        <br><br>
        <label>Pathologie</label> : <input type="text" required="on" name="patho">
        <input type="submit" value="Ajouter un patient" name="bouton_patient">
	</form>



</div>


</body>
</html>