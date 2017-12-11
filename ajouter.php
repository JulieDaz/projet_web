<?php
include("fonction.php");
session_start() ;
?>


<!DOCTYPE html>
<html>
<head>
    <title>Formulaire 1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<!-- Retourner au planning -->
<a class="bouton_relief" href="traitement.php">Retourner au planning</a>
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
        # affichage des services d'accueil dans un menu déroulant

        $connexion = connect() ; # connexion à la BD 

        # requête permettant de sélectionner toues les services d'accueil de la BD

        $req_service = "SELECT Nom_service FROM Service_d_accueil" ; 
        $display_service = do_request($connexion, $req_service) ;
        foreach ($display_service as $value) { # pour chaque service d'accueil récupéré avec la requête
            echo "<option>$value[Nom_service]</option>" ; # on affiche le nom
        }
        ?>
        </select>
        <input type="submit" value="Ajouter un médecin" name="bouton_med">
	</form>

        <?php

        if (isset($_POST['bouton_med']))
        {
            $connexion = connect() ; # connexion à la BD 
            # récupération de toutes les données du formulaire 
            $name_med = $_POST['nom_med'] ;
            $prenom_med = $_POST['prenom_med'] ;
            $service_med = $_POST['service_acc'] ;
            $mail_med = $_POST['mail_med'] ;
            $id_med = "IDm" ; # permet la sélection dans le switch de la fonction generate_id
            $id_medecin = generate_id($id_med, $name_med, $prenom_med) ; # appel à la fonction pour générer l'IDm
            $mdp_med = generate_mdp($prenom_med) ; # appel à la fonction pour générer le mdp

            if (check_carac($name_med) == TRUE AND check_carac($prenom_med) == TRUE) # si les champs rentrés par l'utilisateur respectent les conditions
            {
                $nom_medecin = check_carac($name_med) ;
                $prenom_medecin = check_carac($prenom_med) ;

                if (check_mail($mail_med) == TRUE) # si la structure de l'email est respecté suivant la fonction check_mail
                {
                    $mail_medecin = check_mail($mail_med) ;
                    # requête pour vérifier si le médecin existe déjà dans la BD
                    $req_exist_med = "SELECT * FROM Medecin WHERE Nom = '$nom_medecin' AND Prenom = '$prenom_medecin' AND Mail = '$mail_medecin' AND Nom_service = '$service_med'" ;
                    $exist_med = do_request($connexion, $req_exist_med) ; 

                    if (empty($exist_med)) # si la requête renvoie un résultat vide => le médecin n'existe pas
                    {
                        # requête permettant d'ajouter le médecin dans la table Medecin
                        $req_add_doc = "INSERT INTO Medecin (IDm, Nom, Prenom, Nom_service, Mail) VALUES ('$id_medecin','$nom_medecin','$prenom_medecin','$service_med', 'mail_medecin')" ;
                        $add_doc = mysqli_query($connexion,$req_add_doc);

                        # requête permettant d'ajouter le médecin dans la table Utilisateur
                        $req_add_userM = "INSERT INTO Utilisateur (IDu, Mdp, User_type, IDm) VALUES ('', '$mdp_med', 'Medecin', '$id_medecin')";
                        $add_userM = mysqli_query($connexion,$req_add_userM);

                        if($add_doc == TRUE AND $add_userM == TRUE ) # si les deux requêtes se sont bien réalisées
                        {
                            print("Le médecin a été ajouté avec succès.") ;
                            print("<br>Les identifiants de connexion sont les suivants : login = "."$id_medecin"." et mot de passe = "."$mdp_med") ;

                        }
                        else { # sinon affichage d'un message d'erreur
                            print("Erreur : une erreur s'est produite") ;
                        }
                    }
                    else { # message d'erreur si le médecin est déjà dans la BD
                        print("Ce médecin existe déjà dans la base de données.") ;
                    }
                }
                else { # message d'erreur si l'adresse est invalide
                    print("Erreur : l'adresse mail est invalide.") ;
                }
            }
            else { # message d'erreur si l'utilisateur a rentré des caractères spéciaux
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
        <br><br>
        <select name="med_supp">

        <?php
        # affichage de tous les médecins de la BD 
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
            $supp_med = mysqli_query($connexion, $req_supp_med) ; #or die('<br>Erreur SQL !<br>'.$req_supp_med.'<br>'.mysqli_error($connexion)) ;

            if($supp_med == TRUE)
            {
                print("Le médecin a été correctement supprimé de la base de donnée.") ;
            }
            else {
                print("Une erreur est survenue : le médecin n'a pas pu être supprimé.") ;
            }
            
        }
    ?>  

</div>

<!--........................SECTION RESPONSABLE.........................-->

<!-- Ajouter un responsable -->

<div id="responsable">
<br>
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
        $connexion = connect() ; # connexion à la BD 
        # récupération de toutes les données du formulaire 
        $name_resp = $_POST['nom_resp'] ;
        $prenom_resp = $_POST['prenom_resp'] ;
        $service_int = $_POST['intervention'] ;
        $time = $_POST['time'] ;
        $mail_resp = $_POST['mail_resp'] ;
        $id_resp = "IDr" ; # permet la sélection dans le switch de la fonction generate_id
        $id_responsable = generate_id($id_resp, $name_resp, $prenom_resp) ; # appel à la fonction pour générer l'IDr
        $mdp_resp = generate_mdp($prenom_resp) ; # appel à la fonction pour générer le mdp

        # si tous les champs rentrés par l'utilisateur respectent les conditions de la fonction 'check_carac'
        if (check_carac($name_resp) == TRUE AND check_carac($prenom_resp) == TRUE AND check_carac($service_int) == TRUE)
        {
            $nom_responsable = check_carac($name_resp) ;
            $prenom_responsable = check_carac($prenom_resp) ;
            $service_intervention = check_carac($service_int) ;

            if (check_mail($mail_resp)==TRUE) # si le mail rentré par l'utilisateur respecte la structure de la fonction 'check_mail'
            {
                $mail_responsable = check_mail($mail_resp) ;
                # on vérifie que l'utilisateur a entré une durée qui est un multiple de 30 (créneaux de minimum 30 min)
                $modulo = $time%30 ; 
                if($modulo == 0 )
                {
                    # requête pour vérifier si le responsable existe déjà dans la BD 
                    $req_exist_resp = "SELECT * FROM Responsable_d_intervention WHERE Nom = '$nom_responsable' AND Prenom = '$prenom_responsable' AND Mail = '$mail_responsable'" ;
                    $exist_resp = do_request($connexion, $req_exist_resp) ;

                    if (empty($exist_resp)) # s'il n'existe pas 
                    {
                        # requête pour vérifier si le type d'intervention existe déjà dans la BD 
                        $req_exist_intervention = "SELECT * FROM Type_d_intervention WHERE Nom_intervention = '$service_intervention'" ;
                        $exist_intervention = do_request($connexion, $req_exist_intervention) ;

                        if (empty($exist_intervention)) # si le type d'intervention n'existe pas
                        {
                            # requête pour ajouter le responsable d'intervention
                            $req_add_resp = "INSERT INTO Responsable_d_intervention (IDr, Nom, Prenom, Mail) VALUES ('$id_responsable','$nom_responsable','$prenom_responsable', '$mail_responsable')" ;
                            $add_resp = mysqli_query($connexion,$req_add_resp);

                            # requête pour ajouter le type d'intervention
                            $req_intervention = "INSERT INTO Type_d_intervention (Nom_intervention, Duree, IDr) VALUES ('$service_intervention', '$time', '$id_responsable')" ;
                            $add_intervention = mysqli_query($connexion,$req_intervention) ;

                            # requête pour mettre à ajour le responsable d'intervention, en ajoutant le type d'intervention
                            $req_update_resp = "UPDATE Responsable_d_intervention SET Nom_intervention='$service_intervention' WHERE IDr='$id_responsable'";
                            $update_resp = mysqli_query($connexion,$req_update_resp);

                            # insertion du responsable dans la table utilisateur
                            $req_add_userR = "INSERT INTO Utilisateur (IDu, Mdp, User_type, IDr) VALUES ('', '$mdp_resp', 'Responsable', '$id_responsable')" ;
                            $add_userR = mysqli_query($connexion,$req_add_userR);

                            # si tout s'est bien passé 
                            if ($add_intervention == TRUE AND $add_resp == TRUE AND $update_resp==TRUE AND $add_userR == TRUE)
                            {
                                # message de confirmation
                                print("L'ajout d'un responsable d'intervention et de son service ont été réalisé avec succès.") ;
                                print("<br>Les identifiants de connexion sont les suivants : login = "."$id_responsable"." et mot de passe = "."$mdp_resp") ;
                            }
                            else {
                                print("Erreur : une erreur s'est produite." );
                            }
                        }
                        else { # message d'erreur si l'intervention existe déjà
                            print("Erreur : le type d'intervention existe déjà dans la base de données.") ;
                        }
                    }
                    else { # message d'erreur si le responsable existe déjà
                        print("Erreur : ce responsable existe déjà dans la base de données.") ;
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
        <br><br>
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


            if($supp_resp == TRUE AND $supp_intervention == TRUE)
            {
                print("Le responsable d'intervention a été correctement supprimé de la base de donnée.") ;
            }
            else {
                print("Une erreur est survenue : le responsable d'intervention et son service d'intervention n'ont pas pu être supprimé.") ;
            }
        }
    ?>  

</div>


<!--.........................SECTION PATIENT.......................-->

<div id="patient">
<br>
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
            $connexion = connect() ; # connexion à la BD 
            # récupération des données du formulaire 
            $nom_pat = $_POST['nom_patient'] ;
            $prenom_pat = $_POST['prenom_patient'] ;
            $tel_pat = $_POST['tel'] ;
            $service_acc = $_POST['service_acc'] ;

            # si les champs remplis par l'utilisateur sont conformes à la fonction check_carac
            if (check_carac($nom_pat) == TRUE AND check_carac($prenom_pat) == TRUE)
            {
                $nom_patient = check_carac($nom_pat) ;
                $prenom_patient = check_carac($prenom_pat) ;

                # si le numéro de téléphone respecte la regex
                if (preg_match("#^0[1-8]([-. ]?[0-9]{2}){4}$#", $tel_pat))
                {
                    # on vérifie si le patient n'existe pas déjà dans la BD 
                    $req_exist_pat = "SELECT * FROM Patient WHERE Nom = '$nom_patient' AND Prenom = '$prenom_patient' AND Numero_tel = '$tel_pat' AND Nom_service = '$service_acc'" ;
                    $exist_pat = do_request($connexion, $req_exist_pat) ; 

                    if (empty($exist_pat)) # s'il n'existe pas 
                    {
                        # on ajoute le patient dans la BD 
                        $req_add_patient = "INSERT INTO Patient (IDp, Nom, Prenom, Numero_tel, Nom_service) VALUES ('','$nom_patient','$prenom_patient', '$tel_pat', '$service_acc')" ;
                        $add_patient = mysqli_query($connexion,$req_add_patient);
                        
                        if($add_patient == TRUE) # si la requête se passe bien 
                        { 
                            print("Le patient a été ajouté avec succès.");
                        }
                        else 
                        {
                            print("Erreur : le patient n'a pas pu être ajouté.");
                        }
                    }
                    else 
                    {
                        print("Ce patient existe déjà dans la base de données.") ;
                    } 
                } 
                else {
                    print("Erreur : le numéro de téléphone est invalide.") ;
                }
            }
            else 
            {
                print("Erreur : l'un des champs comprend des caractères non tolérés.") ;
            }
        }
        ?>


</div>

</body>

</html>
