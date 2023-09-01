<?php
/*if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['pdf_content'])) {
    // Chemin et nom du fichier PDF à enregistrer
    $storagelocation = 'C:/wamp64/www/mesprojets/base_appel/pdf/';
    $filename = $storagelocation . $_FILES['pdf_content']['name'];

    // Récupérer le contenu du PDF envoyé depuis le client
    $pdfContent = file_get_contents($_FILES['pdf_content']['tmp_name']);

    // Enregistrer le PDF dans le dossier spécifié
    file_put_contents($filename, $pdfContent);

    echo "PDF saved on server successfully!";
} else {
    echo "Error: PDF content or filename not received.";
}*/
?>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['pdf_content'])) {
    // Chemin et nom du fichier PDF à enregistrer
    $storagelocation = 'C:/wamp64/www/mesprojets/base_appel/pdf/';
    $filename = $_FILES['pdf_content']['name'];
    $filename_unique = 'donnees_' . date("Y-m-d_H-i-s") . '_' . $filename;
    $file = $storagelocation . $filename_unique;

    // Récupérer le contenu du PDF envoyé depuis le client
    $pdfContent = file_get_contents($_FILES['pdf_content']['tmp_name']);

    // Enregistrer le PDF dans le dossier spécifié
    file_put_contents($file, $pdfContent);

    echo "PDF saved on server successfully!";
} else {
    echo "Error: PDF content or filename not received.";
}
?>

