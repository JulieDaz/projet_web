<?php 
include("includes/fonction.php"); 
session_start() ;
if(!isset($_SESSION['admin']))
{
    header("Location:index.php") ;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Formulaire 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<div class="deco">
<img src = "images/penguin.png" height = "50" width = "50">

<?php
print($_SESSION['prenom']." ".$_SESSION['nom']) ;
?>
<br><br>

</div> 

<a class="bouton_deco" href="index.php">Déconnexion</a>

<br><br><br><br>
<!--.................SECTION PATHOLOGIE................-->

<!-- Ajouter une pathologie -->

<div class="section">
<div class = "formulaire">
<fieldset>
<legend><h3> Formulaire d'ajout d'une pathologie</h3></legend>
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
        $connexion = connect() ; # connexion à la base de données
        # on récupère les données du formulaires
        $nom_pathologie = $_POST['nom_patho'] ; 
        $niveau_urgence = $_POST['urgence'] ;

        if (check_carac($nom_pathologie) == TRUE) # si le nom de la pathologie ne comporte pas de caractères spéciaux
        {
            $pathologie = check_carac($nom_pathologie) ; # on remplace le nom de la pathologie rentrée par l'utilisateur par la sortie de la fonction

            # on vérifie si la pathologie existe déjà dans la BD 
            $req_exist_patho = "SELECT * FROM Pathologie WHERE Nom_pathologie = '$pathologie'" ;
            $exist_patho = do_request($connexion, $req_exist_patho) ;

            if (empty($exist_patho)) # si la pathologie n'existe pas 
            {
                # requêter d'ajout de la pathologie dans la BD 
                $req_add_patho = "INSERT INTO Pathologie (Nom_pathologie, Niveau_urgence) VALUES ('$pathologie', '$niveau_urgence')" ;
                $add_patho = mysqli_query($connexion, $req_add_patho) ;

                if($add_patho == TRUE) # si la requête s'est effectuée correctement 
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
</fieldset>
</div>
</div>


<!--.................SECTION SERVICE D'ACCUEIL................-->

<!-- Ajouter un service d'accueil -->

<div class="section">
<div class = "formulaire">
<fieldset>
<legend><h3> Formulaire d'ajout d'un service d'accueil : </h3></legend>
    <form method="post" action=""> 
        <label>Nom du service d'accueil</label> : <input type="text" required="on" name="service_acc">
        <br><br>
        <label>Facturation</label> : <input type="text" required="on" name="bill">
        <br><br>        
        <input type="submit" value="Ajouter un service d'intervention" name="bouton_accueil_add">
	</form>

    <?php
    if(isset($_POST['bouton_accueil_add']))
    {
        $connexion = connect() ; # connexion à la BD 
        # on récupère les données du formulaire 
        $service_acc = $_POST['service_acc'] ;
        $bill = $_POST['bill'] ;

        if (check_carac($service_acc) == TRUE) # si les caractères respectent les conditions de la fonctions
        {
            $service_accueil = check_carac($service_acc) ; # on remplace le nom du service d'accueil  rentré par l'utilisateur par la sortie de la fonction
            
            if (preg_match("#^[1-9][0-9]#", $bill)) # on vérifie que le montant a payé soit un entier
            {
                # requête pour vérifier si le service d'accueil existe déjà dans la BD 
                $req_exist_service = "SELECT * FROM Service_d_accueil WHERE Nom_service = '$service_accueil'" ;
                $exist_service = do_request($connexion, $req_exist_service) ;

                if(empty($exist_service)) # si le service d'accueil n'existe pas 
                {
                    # requête d'ajout du service d'accueil dans la BD 
                    $req_add_acc = "INSERT INTO Service_d_accueil (Nom_service, Facture) VALUES ('$service_accueil', '$bill')" ;
                    $add_acc = mysqli_query($connexion, $req_add_acc) ;

                    if($add_acc==TRUE) # si la requête s'est exécutée 
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
</fieldset>
</div>

<!-- Supprimer un service d'accueil -->

<div class = "formulaire">
<fieldset>
<legend><h3>Formulaire de retrait d'un service d'accueil</h3></legend>

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
                print("Le service d'accueil a été supprimé avec succès.") ;
            }
            else { print("Erreur : un problème est survenu lors de la suppression.") ;
            }
        }
    ?>  
</fieldset>
</div>
</div>

<a class="return_planning" href="traitement.php">Retourner au planning</a>

</body>
</html>