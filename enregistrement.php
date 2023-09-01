<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement d'appel</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mesprojets/base_appel/enregistrement.css">
    <style>
        .error {
            color: #FF0000;
        }
        fieldset {
            border: 1px solid black;
            width: 1305px;
            margin-left: 28px;
        }
    </style>
</head>
<body>
    <h1>Enregistrement d'appel</h1>
    <fieldset>
       <!--<form action="traitement.php" method="post">
            Heure d'appel : <input type="time" name = "heure"> Numéro <input type="text" name = "numero">
            Nom <input type="text" name ="nom"> Prénoms <input type="text" name ="prenom">
            Qui a prit l'appel ? <input type="text" name ="repondant"> <br><br>
            Contenu de l'appel <br><textarea name="contenu" id="" cols="60" rows="10"></textarea> <br><br>
            <button type="submit" class="btn btn-outline-primary">Enregistrer</button>
        </form>-->
       <form action="traitement.php" method="post">
            <div class="container">
                <div class="row">
                <p><span class="error">* champ obligatioire</span></p><br>
                    <div class="col-md-2">
                        <label for="heure" class="form-label">Heure</label><span class="error">*</span>
                        <input type="time" class="form-control" id="" value="" name="heure" required>
                    </div>
                    <div class="col-md-2">
                        <label for="numrero" class="form-label">Numéro </label><span class="error">*</span>
                        <input type="number" class="form-control" id="" value="" name="numero" maxlength="12" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nom" class="form-label">Nom</label>
                        <div class="input-group has-validation">
                        <input type="text" class="form-control" name="nom" id="" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="prenoms" class="form-label">Prénoms</label>
                        <input type="text" class="form-control" name="prenom" id="" maxlength="50" >
                    </div>
                    <div class="col-md-2">
                        <label for="repondant" class="form-label">Repondant</label><span class="error">*</span>
                        <input type="text" class="form-control" name="repondant" id="" maxlength="50" required>
                    </div>
                    <div class="">
                        <label for="contenu" class="form-label">Contenu<span class="error">*</span></label><br>
                        <textarea class="form-control" name="contenu" id="" cols="60" rows="10" maxlength="250" required></textarea>
                    </div>
                    <div>
                        <br>
                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                    </div>
                 </div>     
            </div>
        </form><br>
    </fieldset><br><br><br>

    <script src="bootstrap/js/bootstrap.min.css"></script>
</body>
</html>