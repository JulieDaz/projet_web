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

<!-- SECTION Pathologie -->

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
        <input type="submit" value="Ajouter une pathologie" name="bouton_patho">
	</form>

    <?php
    if(isset($_POST['bouton_patho']))
    {
        $connexion = connect() ;
        $nom_pathologie = $_POST['nom_patho'] ;
        $niveau_urgence = $_POST['urgence'] ;

        $req_add_patho = "INSERT INTO Pathologie (Nom_pathologie, Niveau_urgence) VALUES ('$nom_pathologie', '$niveau_urgence')" ;
        $add_patho = mysqli_query($connexion, $req_add_patho) ;

        if($add_patho == TRUE)
        {
            print("you're a genius") ;
        }
        else { print("naab");}

    }
    ?>

</div>


<!-- SECTION Service accueil -->

<div class = "service_acc">
<h2> Formulaire d'ajout d'un service d'accueil : </h2>
    <form method="post" action=""> 
        <label>Nom du service d'accueil</label> : <input type="text" required="on" name="service_acc">
        <br><br>
        <label>Facturation</label> : <input type="text" required="on" name="bill">
        <br><br>        
        <input type="submit" value="Ajouter une pathologie" name="bouton_accueil">
	</form>

    <?php
    if(isset($_POST['bouton_accueil']))
    {
        $connexion = connect() ;
        $service_acc = $_POST['service_acc'] ;
        $bill = $_POST['bill'] ;

        $req_add_acc = "INSERT INTO Service_d_accueil (Nom_service, Facture) VALUES ('$service_acc', '$bill')" ;
        $add_acc = mysqli_query($connexion, $req_add_acc) ;

        if($add_acc==TRUE)
        {
            print("you're a genius");
        }
        else{
            print("you're a caca");
        }
    }
    ?>


</div>




</body>
</html>