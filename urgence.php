<?php
include("fonction.php");
session_start() ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<h2> Formulaire de demande d'urgence : </h2>
<p>Veuillez renseigner les informations suivantes concernant le patient : </p>
<br>
    <form method="post" action="">
        <label>Nom</label> : <input type="text" required="on" name="nom_pat">
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_pat">
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
        <label>Pathologie</label> : <select name ="nom_patho">

        <?php
        $connexion = connect() ;

        $req_patho = "SELECT Nom_pathologie FROM Pathologie" ;
        $display_patho = do_request($connexion, $req_patho) ;
        foreach ($display_patho as $value) {
            echo "<option>$value[Nom_pathologie]</option>" ;
        }
        ?>
        </select>
        <br><br>
        <input type="submit" value="Demande d'urgence" name="bouton_urgence">
	</form>

    <?php

    if(isset('bouton_urgence'))
    {
        $connexion = connect() ;
        $nom_patient = $_POST['nom_pat'] ;
        $prenom_patient = $_POST['prenom_pat'] ;
        $tel_patient = $_POST['tel'] ;
        $service_acc = $_POST['service_acc'] ;
        $nom_patho = $_POST['nom_patho'] ;

        $req_niveau_prio = "SELECT Niveau_urgence FROM Pathologie WHERE Nom_pathologie = '$nom_patho" ;
        $niveau_prio = do_request($connexion, $req_niveau_prio) ;

        if(check_carac($nom_patient) == TRUE AND check_carac($prenom_patient) == TRUE)
        {
            if (preg_match("#^0[1-8]([-. ]?[0-9]{2}){4}$#", $tel_pat))
            {
                $req_exist_pat = "SELECT * FROM Patient WHERE Nom = '$nom_pat' AND Prenom = '$prenom_pat' AND Numero_tel = '$tel_pat' AND Nom_service = '$service_acc'" ;
                $exist_pat = do_request($connexion, $req_exist_pat) ; 

                if (empty($exist_pat))
                {
                    $req_add_patient = "INSERT INTO Patient (IDp, Nom, Prenom, Numero_tel, Nom_service, Niveau_priorite) VALUES ('','$nom_patient','$prenom_patient', '$tel_patient', '$service_acc', '$niveau_prio')" ;
                    $add_patient = mysqli_query($connexion,$req_add_patient);
                    $IDp = mysqli_insert_id() ; 
                    print($IDp) ;

                    sousbooking($connexion, $type_intervention, $IDp) ;
                        
                }
                else 
                {
                    print("Le patient existe déjà") ;
                    sousbooking($connexion, $type_intervention, $IDp) ;
                }
            }
            else {
                print("Erreur : le numéro de téléphone est invalide.") ;
            }
        }
        else {
            print("Erreur : l'un des champs comprend des caractères non tolérés.") ;
        }

    }



    ?>