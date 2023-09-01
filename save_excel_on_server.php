<?php
if (isset($_FILES['excel_file']['tmp_name']) && isset($_FILES['excel_file']['name'])) {
    // Chemin et nom du fichier Excel à enregistrer
    $storagelocation = 'C:/wamp64/www/mesprojets/base_appel/excel/';
    $filename = $storagelocation . $_FILES['excel_file']['name'];

    // Déplacer le fichier Excel temporaire vers le dossier spécifié
    move_uploaded_file($_FILES['excel_file']['tmp_name'], $filename);

    echo "Excel saved on server successfully!";
} else {
    echo "Error: Excel file not received.";
}
?>
