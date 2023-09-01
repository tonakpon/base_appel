<?php
$storagelocation = 'C:/wamp64/www/mesprojets/base_appel/html/';
$file = $storagelocation . 'myfile1.html';

if (isset($_POST['table_data'])) {
    $data = $_POST['table_data'];
    $fp = fopen($file, "w") or die("Couldn't open $file for writing!");
    fwrite($fp, $data) or die("Couldn't write values to file!");
    fclose($fp);
    echo "Saved to $file successfully!";
}
?>