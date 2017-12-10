<?php
include("fonction.php");
session_start() ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Demande d'urgence</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
</body>
</html>

<h2> Formulaire de demande d'urgence : </h2>
<p>Veuillez renseigner les informations suivantes concernant le patient : </p>
<br>
    <form method="post" action="">
        <label>Nom</label> : <input type="text" required="on" name="nom_pat"> <!-- Champ requis pour le nom -->
        <br><br>
        <label>Prénom</label> : <input type="text" required="on" name="prenom_pat"> <!-- Champ requis pour le prénom -->
        <br><br>
        <label>Numéro de téléphone</label> : <input type="text" required="on" name="tel"> <!-- Champ requis pour le numéro de téléphone -->
        <br><br>
        <label>Service d'accueil</label> : <select name ="service_acc"> <!-- menu déroulant pour choisir le service d'accueil -->

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
        <label>Pathologie</label> : <select name ="nom_patho"> <!-- menu déroulant pour choisir la pathologie -->

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

    if(isset($_POST['bouton_urgence'])) # Si l'utilisateur a validé l'envoi du formulaire 
    {
        $connexion = connect() ; # connexion à la BD
        # récupération de tous les champs rentrés/sélectionnés par l'utilisateur
        $nom_patient = $_POST['nom_pat'] ;
        $prenom_patient = $_POST['prenom_pat'] ;
        $tel_patient = $_POST['tel'] ;
        $service_acc = $_POST['service_acc'] ;
        $nom_patho = $_POST['nom_patho'] ;
        $type_intervention = $_SESSION['intervention'] ;

        # requête pour récupérer le niveau 
        $req_niveau_prio = "SELECT Niveau_urgence FROM Pathologie WHERE Nom_pathologie = '$nom_patho'" ;
        $niveau_prio = do_request($connexion, $req_niveau_prio) ;
        $niveau_priorite = $niveau_prio[0]['Niveau_urgence'] ;


        if(check_carac($nom_patient) == TRUE AND check_carac($prenom_patient) == TRUE) # si les champs remplis par l'utilisateur sont conformes 
        {
            if (preg_match("#^0[1-8]([-. ]?[0-9]{2}){4}$#", $tel_patient)) # vérification du numéro de téléphone rentrés par l'utilisateur avec une regex
            {
                # requête pour vérifier si le patient en demande d'urgence existe déjà dans la base de données
                $req_exist_pat = "SELECT * FROM Patient WHERE Nom = '$nom_patient' AND Prenom = '$prenom_patient' AND Numero_tel = '$tel_patient' AND Nom_service = '$service_acc'" ;
                $exist_pat = do_request($connexion, $req_exist_pat) ; 

                if (empty($exist_pat[0])) # le patient n'existe pas dans la BD
                {
                    # on ajoute le patient dans la BD
                    $req_add_patient = "INSERT INTO Patient (IDp, Nom, Prenom, Numero_tel, Nom_service, Niveau_priorite) VALUES ('','$nom_patient','$prenom_patient', '$tel_patient', '$service_acc', '$niveau_priorite')" ;
                    $add_patient = mysqli_query($connexion,$req_add_patient);

                    # on récupère son IDp qui est un autoincrément
                    $req_idpatient = "SELECT IDp FROM Patient WHERE Nom = '$nom_patient' AND Prenom = '$prenom_patient' AND Numero_tel = '$tel_patient' AND Nom_service = '$service_acc'" ;
                    $idpatient = do_request($connexion, $req_idpatient) ;
                    $IDp = $idpatient[0]['IDp'] ; # tableau associatif, donc on récupère la première valeur

                    # on ajoute l'IDp et la patho dans la table souffre
                    $req_add_souffre = "INSERT INTO souffre (Nom_pathologie, IDp) VALUES ('$nom_patho', '$IDp)" ;
                    $add_souffre = mysqli_query($connexion, $req_add_souffre) ;

                    # on appelle la fonction de sousbooking pour gérer l'urgence
                    sousbooking($connexion, $type_intervention, $IDp) ;
                        
                }
                else # le patient existe déjà dans la BD
                {
                    # on récupère l'IDp du patient
                    $req_idpatient = "SELECT IDp FROM Patient WHERE Nom = '$nom_patient' AND Prenom = '$prenom_patient' AND Numero_tel = '$tel_patient' AND Nom_service = '$service_acc'" ;
                    $idpatient = do_request($connexion, $req_idpatient) ;
                    $IDp = $idpatient[0]['IDp'] ;
                    
                    # on vérifie si la pathologie renseignée dans le formulaire déjà présente dans la table souffre pour ce patient
                    $req_patho_patient = "SELECT Nom_pathologie, IDp FROM souffre WHERE Nom_pathologie = '$nom_patho'" ;
                    $patho_patient = do_request($connexion, $req_patho_patient);

                    if (empty($patho_patient)) # si la pathologie de ce patient n'est pas dans souffre
                    {
                        # on ajoute l'association pathologie/IDp
                        $req_add_souffre = "INSERT INTO souffre (Nom_pathologie, IDp) VALUES ('$nom_patho', '$IDp)" ;
                        $add_souffre = mysqli_query($connexion, $req_add_souffre) ;
                    }
                    
                    print("Le patient existe déjà") ;

                    # on appelle la fonction de sousbooking pour gérer l'urgence
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