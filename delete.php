<?php
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($heure_err) && empty($numero_err) && empty($nom_err) && empty($prenoms_err) && empty($repondant_err) && empty($contenu_err)) {
        $id = $_POST["id"];

        try {

            $sql = "DELETE FROM enregistrement WHERE id=?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

            header("location: tableau.php");
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        $conn = null;
    }
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id =  trim($_GET["id"]);

        try {
           
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        $conn = null;
    } else {
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer l'enregistrement</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Supprimer l'enregistremnt</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            
                            <p>Etes vous sûr de vouloir supprimer l'enregistrement n° : <?php echo '<strong>' .$id ;?> ?</p>
                            <p>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/> 
                                <input type="submit" value="OUI" class="btn btn-danger">
                                <a href="tableau.php" class="btn btn-secondary">NON</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>