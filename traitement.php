<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traitement</title>
</head>
<body>
    <?php
        include 'conn.php';

        $heure = $_POST['heure'] ;
        $numero = $_POST['numero'] ;
        $nom = $_POST['nom'] ;
        $prenom = $_POST['prenom'] ; 
        $repondant = $_POST['repondant'] ;
        $contenu = $_POST['contenu'] ;

        if (!empty($_POST['heure']) && !empty($_POST['numero']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['repondant']) && !empty($_POST['contenu'])) {

        } else {
            echo 'Veuillez entrer des données exactes';
        } 
        try {
            $stmt = $conn->prepare("INSERT INTO enregistrement(heure, numero, nom, prenoms, repondant, contenu)
            VALUES (:heure, :numero, :nom, :prenom, :repondant, :contenu)");

            $stmt->bindParam(':heure',$heure);
            $stmt->bindParam(':numero',$numero);
            $stmt->bindParam(':nom',$nom);
            $stmt->bindParam(':prenom',$prenom);
            $stmt->bindParam(':repondant',$repondant);
            $stmt->bindParam(':contenu',$contenu);


            $stmt->execute();
            header("location:tableau.php");
        } catch (PDOException $e) {
            echo "Error: " . "<br>" . $e->getMessage();
        }

        $conn = null;
    ?>
    <?php 

    ?>
</body>
</html>