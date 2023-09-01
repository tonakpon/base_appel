<?php
include "conn.php";

$heure = $numero = $nom = $prenoms = $repondant = $contenu = "";
$heure_err = $numero_err = $nom_err = $prenoms_err = $repondant_err = $contenu_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $heure = trim($_POST["heure"]);
    $numero = trim($_POST["numero"]);
    $nom = trim($_POST["nom"]);
    $prenoms = trim($_POST["prenoms"]);
    $repondant = trim($_POST["repondant"]);
    $contenu = trim($_POST["contenu"]);


    if (empty($heure_err) && empty($numero_err) && empty($nom_err) && empty($prenoms_err) && empty($repondant_err) && empty($contenu_err)) {
        $id = $_POST["id"];

        try {

            $sql = "UPDATE enregistrement SET heure=?, numero=?, nom=?, prenoms=?, repondant=?, contenu=? WHERE id=?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$heure, $numero, $nom, $prenoms, $repondant, $contenu, $id]);

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
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM enregistrement WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                header("location: error.php");
                exit();
            }

            $heure = $row["heure"];
            $numero = $row["numero"];
            $nom = $row["nom"];
            $prenoms = $row["prenoms"];
            $repondant = $row["repondant"];
            $contenu = $row["contenu"];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistrement</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body {
            margin-top : 40px ;
            background-color: beige;
        }
        h3 {
            text-align: center;
        }
        fieldset {
            border: 1px solid black;
            width: 1305px;
            margin-left: 28px;
        }
    </style>
</head>
<body>
    <h3>Mise à jour des données</h3><br>
    <fieldset>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="container"><br>
                <div class="row">
                <div class="col-md-2">
                <label>Heure</label>
                <input type="time" name="heure" class="form-control <?php echo (!empty($heure_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $heure; ?>">
                <span class="invalid-feedback"><?php echo $heure_err; ?></span>
            </div><br>
            <div class="col-md-2">
                <label>Numero</label>
                <input type="number" name="numero" class="form-control <?php echo (!empty($numero_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $numero; ?>">
                <span class="invalid-feedback"><?php echo $numero_err; ?></span>
            </div><br>
            <div class="col-md-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nom; ?>">
                <span class="invalid-feedback"><?php echo $nom_err; ?></span>
            </div><br>
            <div class="col-md-3">
                <label>Prénoms</label>
                <input type="text" name="prenoms" class="form-control <?php echo (!empty($prenoms_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prenoms; ?>">
                <span class="invalid-feedback"><?php echo $prenoms_err; ?></span>
            </div><br>
            <div class="col-md-2">
                <label>Repondant</label>
                <input type="text" name="repondant" class="form-control <?php echo (!empty($repondant_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repondant; ?>">
                <span class="invalid-feedback"><?php echo $repondant_err; ?></span>
            </div>
            <div class="">
                <br>
                <label for="contenu">Contenu</label>
                <textarea class="form-control" name="contenu" id="" cols="60" rows="10" required><?php echo $contenu; ?></textarea><br>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>"/> 
            <div>
            <input type="submit" class="btn btn-primary" value="Enregistrer"> <a href="tableau.php" class="btn btn-secondary ml-2">Annuler</a>
            </div>
                </div>
            </div>    
        </form><br><br>
    </fieldset>
    <script src="bootstrap/js/bootstrap.min.css"></script>
</body>
</html>
