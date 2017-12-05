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
<br>
<br>

<!--.....................SECTION Medecin.....................-->

<!-- Ajouter un Medecin -->

<div id="medecin">

<h2> Formulaire d'ajout d'un médecin : </h2>
    <form method="post" action="">
        <label>Nom</label> : <input type="text" required="on" name="nom_med">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_med">
        <br><br>
        <label>Adresse email</label> : <input type="text" required="on" name="mail_med">
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
            $mail_med = $_POST['mail_med'] ;
            $id_med = "IDm" ;
            $id_medecin = generate_id($id_med, $name_med, $prenom_med) ;
            $mdp_med = generate_mdp($prenom_med) ;

            if (check_carac($name_med) == TRUE AND check_carac($prenom_med) == TRUE)
            {
                if (check_mail($mail_med == TRUE))
                {
                    $req_add_doc = "INSERT INTO Medecin (IDm, Nom, Prenom, Nom_service) VALUES ('$id_medecin','$name_med','$prenom_med','$service_med')" ;
                    $add_doc = mysqli_query($connexion,$req_add_doc);

                    $req_add_userM = "INSERT INTO Utilisateur (IDu, Mdp, User_type, IDm) VALUES ('', '$mdp_med', 'Medecin', '$id_medecin')";
                    $add_userM = mysqli_query($connexion,$req_add_userM);
                }
                else {
                    print("Erreur : l'adresse mail est invalide.") ;
                }
            }
            else {
                print("Erreur : l'un des champs comprend des caractères non tolérés.") ;
            }

    

        }
        ?>
</div>

<!-- Supprimer un médecin-->

<div>
<h2>Formulaire de retrait d'un médecin : </h2>

    <form method = "post" action = "">
        <label>Sélectionner le médecin que vous souhaitez retirer de la base de données :</label>
        <select name="med_supp">

        <?php
        $connexion = connect() ;
        $req_select_med = "SELECT IDm, Nom, Prenom, Nom_service FROM Medecin" ;
        $select_med = do_request($connexion, $req_select_med) ;
        
        foreach ($select_med as $med) {
            echo "<option value=$med[IDm]>$med[Nom] $med[Prenom] : $med[Nom_service]</option>" ;
         }
        ?>
        <select>
        <input type="submit" value="Supprimer un médecin" name="bouton_med_supp">

    </form>

    <?php
        if(isset($_POST['bouton_med_supp']))
        {
            $connexion = connect() ;
            $med_supp = $_POST['med_supp'] ; //Récupère l'ID du médecin

            $req_supp_med = "DELETE FROM Medecin WHERE IDm = '$med_supp'" ;
            $supp_med = mysqli_query($connexion, $req_supp_med) or die('<br>Erreur SQL !<br>'.$req_supp_med.'<br>'.mysqli_error($connexion)) ;


            if($supp_med == TRUE)
            {
                print("Le médecin a été correctement supprimé de la base de donnée.") ;
            }
        }
    ?>  

</div>

<!--........................SECTION RESPONSABLE.........................-->

<!-- Ajouter un responsable -->

<div id="responsable">

<h2> Formulaire d'ajout d'un responsable d'intervention et du service d'intervention correspondant : </h2>

    <form method="post" action="">
        <label>Nom</label> : <input type="text" required="on" name="nom_resp">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_resp">
        <br><br>
        <label>Adresse email</label> : <input type="text" required="on" name="mail_resp">
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
        $mail_resp = $_POST['mail_resp'] ;
        $id_resp = "IDr" ;
        $id_responsable = generate_id($id_resp, $name_resp, $prenom_resp) ;
        $mdp_resp = generate_mdp($prenom_resp) ;

        if (check_carac($name_resp) == TRUE AND check_carac($prenom_resp) == TRUE AND check_carac($service_int) == TRUE)
        {
            if (check_mail($mail_resp)==TRUE)
            {
                $modulo = $time%30 ;
                if($modulo == 0 )
                {
                    $req_add_resp = "INSERT INTO Responsable_d_intervention (IDr, Nom, Prenom) VALUES ('$id_responsable','$name_resp','$prenom_resp')" ;
                    $add_resp = mysqli_query($connexion,$req_add_resp);

                    $req_intervention = "INSERT INTO Type_d_intervention (Nom_intervention, Duree, IDr) VALUES ('$service_int', '$time', '$id_responsable')" ;
                    $add_intervention = mysqli_query($connexion,$req_intervention) ;

                    $req_update_resp = "UPDATE Responsable_d_intervention SET Nom_intervention='$service_int' WHERE IDr='$id_responsable'";
                    $update_resp = mysqli_query($connexion,$req_update_resp);

                    $req_add_userR = "INSERT INTO Utilisateur (IDu, Mdp, User_type, IDr) VALUES ('', '$mdp_resp', 'Responsable', '$id_responsable')" ;
                    $add_userR = mysqli_query($connexion,$req_add_userR);

                    if ($add_intervention == TRUE )
                    {
                        print("L'ajout d'un responsable d'intervention et de son service ont été réalisé avec succès.") ;
                        print("<br>Vos identifiants sont les suivants : login = "."$id_responsable"." et mot de passe = "."$mdp_resp") ;
                    }
                    else {
                        print("Erreur : le type d'intevention existe déjà dans la base de données.") ;
                    }
                }
                else {
                    print("Erreur : la durée d'intervention est invalide. Merci de rentrer une durée en minutes et qui soit un multiple de 30.");
                }
            }
            else {
                print("Erreur : l'adresse email est invalide.") ;
            }
        }
        else {
            print("Erreur : l'un des champs comprend des caractères non tolérés.") ; 
        }
    }
    ?>

</div>

<!-- Supprimer un responsable -->

<div>
<h2>Formulaire de retrait d'un responsable : </h2>

    <form method = "post" action = "">
        <label>Sélectionner le responsable d'intervention que vous souhaitez retirer de la base de données :</label>
        <select name="resp_supp">

        <?php
        $connexion = connect() ;
        $req_select_resp = "SELECT IDr, Nom, Prenom, Nom_intervention FROM Responsable_d_intervention" ;
        $select_resp = do_request($connexion, $req_select_resp) ;
        
        foreach ($select_resp as $resp) {
            echo "<option value=$resp[IDr]>$resp[Nom] $resp[Prenom] : $resp[Nom_intervention]</option>" ;
         }
        ?>
        <select>
        <input type="submit" value="Supprimer un responsable" name="bouton_resp_supp">

    </form>

    <?php
        if(isset($_POST['bouton_resp_supp']))
        {
            $connexion = connect() ;
            $resp_supp = $_POST['resp_supp'] ; //Récupère l'ID du médecin

            $req_supp_intervention = "DELETE FROM Type_d_intervention WHERE IDr = '$resp_supp'" ;
            $supp_intervention = mysqli_query($connexion, $req_supp_intervention) or die('<br>Erreur SQL !<br>'.$req_supp_intervention.'<br>'.mysqli_error($connexion)) ;

            $req_supp_resp = "DELETE FROM Responsable_d_intervention WHERE IDr = '$resp_supp'" ;
            $supp_resp = mysqli_query($connexion, $req_supp_resp) or die('<br>Erreur SQL !<br>'.$req_supp_resp.'<br>'.mysqli_error($connexion)) ;


            if($supp_resp == TRUE)
            {
                print("Le responsable d'intervention a été correctement supprimé de la base de donnée.") ;
            }
        }
    ?>  

</div>


<!--.........................SECTION PATIENT.......................-->

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
            { print("Le patient a été ajouté avec succès.");
            }
            else {print("try again");}
        }
        ?>


</div>


</body>

</html>
