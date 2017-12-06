<?php 
include("fonction.php"); 
session_start() ;
?>


<!DOCTYPE html>
<html>
<head>
     <title>Formulaire 2</title>
</head>
<body>

<!-- Retourner au planning -->
<form method="post" action="traitement.php"> 
<input type="submit" value="Retourner au planning" name="retour_planning">
</form>
<br>
<br>

<!--.................SECTION PATHOLOGIE................-->

<!-- Ajouter une pathologie -->

<div class = "patho">
<h2> Formulaire d'ajout d'une pathologie : </h2>
    <form method="post" action=""> 
        <label>Nom de la pathologie</label> : <input type="text" required="on" name="nom_patho">
        <br><br>
        <label>Niveau d'urgence de la pathologie</label> : <select name ="urgence">
            <option value = "1"> Niveau 1 </option>
            <option value = "2"> Niveau 2 </option>
            <option value = "3"> Niveau 3 </option>
            <option value = "4"> Niveau 4 </option>
            <option value = "5"> Niveau 5 </option>
        </select>
        <br><br>
        <input type="submit" value="Ajouter une pathologie" name="bouton_patho_add">
	</form>

    <?php
    if(isset($_POST['bouton_patho_add']))
    {
        $connexion = connect() ;
        $nom_pathologie = $_POST['nom_patho'] ;
        $niveau_urgence = $_POST['urgence'] ;

        if (check_carac($nom_pathologie) == TRUE)
        {
            $req_exist_patho = "SELECT * FROM Pathologie WHERE Nom_pathologie = '$nom_pathologie'" ;
            $exist_patho = do_request($connexion, $req_exist_patho) ;

            if (empty($exist_patho))
            {
                $req_add_patho = "INSERT INTO Pathologie (Nom_pathologie, Niveau_urgence) VALUES ('$nom_pathologie', '$niveau_urgence')" ;
                $add_patho = mysqli_query($connexion, $req_add_patho) ;

                if($add_patho == TRUE)
                {
                    print("La pathologie a été correctement ajouté.") ;
                }
                else { 
                    print("Erreur : La pathologie n'a pas pu être ajoutée.");
                }
            }
            else {
                print("Erreur : cette pathologie existe déjà dans la base de données. Veuillez insérer un autre nom.");
            }
        }
        else {
            print("Erreur : vous avez entré des caractères non tolérés.") ;
        }


        

    }
    ?>
</div>


<!--.................SECTION SERVICE D'ACCUEIL................-->

<!-- Ajouter un service d'accueil -->

<div class = "service_acc">
<h2> Formulaire d'ajout d'un service d'accueil : </h2>
    <form method="post" action=""> 
        <label>Nom du service d'accueil</label> : <input type="text" required="on" name="service_acc">
        <br><br>
        <label>Facturation</label> : <input type="text" required="on" name="bill">
        <br><br>        
        <input type="submit" value="Ajouter une pathologie" name="bouton_accueil_add">
	</form>

    <?php
    if(isset($_POST['bouton_accueil_add']))
    {
        $connexion = connect() ;
        $service_acc = $_POST['service_acc'] ;
        $bill = $_POST['bill'] ;

        if (check_carac($service_acc) == TRUE)
        {
            if (preg_match("#^[1-9][0-9]#", $bill))
            {
                $req_exist_service = "SELECT * FROM Service_d_accueil WHERE Nom_service = '$service_acc'" ;
                $exist_service = do_request($connexion, $req_exist_service) ;

                if(empty($exist_service))
                {
                    $req_add_acc = "INSERT INTO Service_d_accueil (Nom_service, Facture) VALUES ('$service_acc', '$bill')" ;
                    $add_acc = mysqli_query($connexion, $req_add_acc) ;

                    if($add_acc==TRUE)
                    {
                        print("Le service d'accueil a été correctement ajouté");
                    }
                    else
                    {
                        print("Erreur : le service d'accueil n'a pas pu être ajouté.");
                    }
                }
                else {
                    print("Erreur : ce service d'accueil existe déjà dans la base de données. Veuillez insérer un autre nom.");

                }
            }
            else {
                print("Erreur : le montant de la facturation doit être un entier") ;
            }   
        }
        else 
        {
            print("Erreur : le nom du service d'accueille comprend des caractères non tolérés.") ;
        }

        
    }
    ?>
</div>

<!-- Supprimer un service d'accueil -->

<div>
<h2>Formulaire de retrait d'un service d'accueil : </h2>

    <form method = "post" action = "">
        <label>Sélectionner le service d'accueil que vous souhaitez retirer de la base de données :</label>
        <select name="accueil">

        <?php
        $connexion = connect() ;
        $req_select_accueil = "SELECT Nom_service FROM Service_d_accueil" ;
        $select_accueil = do_request($connexion, $req_select_accueil) ;
        foreach ($select_accueil as $value_accueil) {
            echo "<option>$value_accueil[Nom_service]</option>" ;
        }
        ?>
        </select>
        <input type="submit" value="Supprimer un service d'accueil" name="bouton_accueil_supp">

    </form>

    <?php
        if(isset($_POST['bouton_accueil_supp']))
        {
            $connexion = connect() ;
            $accueil_supp = $_POST['accueil'] ;

            $req_supp_accueil = "DELETE FROM Service_d_accueil WHERE Nom_service = '$accueil_supp'" ;
            $supp_accueil = mysqli_query($connexion, $req_supp_accueil) ;

            if($supp_accueil == TRUE)
            {
                print("you're a genius") ;
            }
            else { print("naab") ;
            }
        }
    ?>  

</div>

</body>
</html>