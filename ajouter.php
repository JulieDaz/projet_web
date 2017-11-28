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

<!-- Retourner au planning -->
<form method="post" action="traitement.php"> 
<input type="submit" value="Retourner au planning" name="retour_planning">
</form>

<!-- SECTION Medecin -->

<div id="medecin">

<h2> Formulaire d'ajout d'un médecin : </h2>
    <form method="post" action=""> 
        <label>Nom</label> : <input type="text" required="on" name="nom_med">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_med">
        <br><br>        
        <label>Service d'accueil</label> : <select name ="service_acc">
        
        <?php 
        $connexion = connect() ;

        $req_service = "SELECT Nom_service FROM Service_d_accueil" ;
        $display_service = do_request($connexion, $req_service) ;
        foreach ($display_service as $value) {
            echo "<option>$value[Nom_service]</option>" ;
        }
        ?>
        </select>
        <input type="submit" value="Ajouter un médecin" name="bouton_med">
	</form>

        <?php

        if (isset($_POST['bouton_med']))
        {
            $connexion = connect() ;
            $name_med = $_POST['nom_med'] ;
            $prenom_med = $_POST['prenom_med'] ;
            $service_med = $_POST['service_acc'] ;
            $id_med = "IDm" ;
            $id_medecin = generate_id($id_med, $name_med, $prenom_med) ;
            $mdp_med = generate_mdp($prenom_med) ;

            $req_add_doc = "INSERT INTO Medecin (IDm, Nom, Prenom, Nom_service) VALUES ('$id_medecin','$name_med','$prenom_med','$service_med')" ;
            $add_doc = mysqli_query($connexion,$req_add_doc);

            $req_add_userM = "INSERT INTO Utilisateur (IDu, Mdp, User_type, IDm) VALUES ('', '$mdp_med', 'Medecin', '$id_medecin')";
            $add_userM = mysqli_query($connexion,$req_add_userM);

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

        $req_add_resp = "INSERT INTO Responsable_d_intervention (IDr, Nom, Prenom) VALUES ('$id_responsable','$name_resp','$prenom_resp')" ;
        $add_resp = mysqli_query($connexion,$req_add_resp);

        $req_intervention = "INSERT INTO Type_d_intervention (Nom_intervention, Duree, IDr) VALUES ('$service_int', '$time', '$id_responsable')" ;
        $add_intervention = mysqli_query($connexion,$req_intervention) ;

        $req_update_resp = "UPDATE Responsable_d_intervention SET Nom_intervention='$service_int' WHERE IDr='$id_responsable'";
        $update_resp = mysqli_query($connexion,$req_update_resp);

        $req_add_userR = "INSERT INTO est (IDu, IDr) VALUES ('','$id_responsable')" ;
        $add_userR = mysqli_query($connexion,$req_add_userR);
        
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
        <label>Numéro de téléphone</label> : <input type="text" required="on" name="tel">
        <br><br>
        <label>Service d'accueil</label> : <select name ="service_acc">
        
        <?php 
        $connexion = connect() ;

        $req_service = "SELECT Nom_service FROM Service_d_accueil" ;
        $display_service = do_request($connexion, $req_service) ;
        foreach ($display_service as $value) {
            echo "<option>$value[Nom_service]</option>" ;
        }
        ?>
        </select>

        <br><br>
        <input type="submit" value="Ajouter un patient" name="bouton_patient">

	</form>

        <?php

        if (isset($_POST['bouton_patient']))
        {
            $connexion = connect() ;
            $nom_pat = $_POST['nom_patient'] ;
            $prenom_pat = $_POST['prenom_patient'] ;
            $tel_pat = $_POST['tel'] ;
            $service_acc = $_POST['service_acc'] ;

            $req_add_patient = "INSERT INTO Patient (IDp, Nom, Prenom, Numero_tel, Nom_service) VALUES ('','$nom_pat','$prenom_pat', '$tel_pat', '$service_acc')" ;
            $add_patient = mysqli_query($connexion,$req_add_patient);
            if($add_patient == TRUE)
            { print("ok le patient a été ajouté");
            }
            else {print("try again");}
        }
        ?>


</div>


</body>
</html>