<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .material-icons {
            width: 50px;
        }
        .table-header {
            background-color: #f2f2f2;
            font-weight: bold;
            color: blue;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exporter vers Excel ou PDF</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Inclure la bibliothèque SheetJS via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <!-- Inclure la bibliothèque jsPDF via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
    <!-- Inclure le plugin jsPDF autotable via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
    <!-- Inclure la bibliothèque html2pdf.js via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>

<?php  
include 'conn.php';
echo '<br>';
echo "<div class='container'>";
echo "<div class='row'>";
echo '<h1>Vos sauvegardes</h1>';
echo "<div>";
echo '<a href="/mesprojets/base_appel/enregistrement.php" class="btn btn-outline-primary">NOUVEL ENREGISTREMENT</a>';
echo "&nbsp;&nbsp;";
echo "<button class='btn btn-success' onclick='exportToExcel()'>Exporter vers Excel</button>";
echo "&nbsp;&nbsp;";
echo "<button class='btn btn-danger' onclick='exportToPdf()'>Télécharger format Pdf</button>";
echo "&nbsp;&nbsp;";
echo '<button class="btn btn-primary" onclick="saveToFile()">Enregistrer dans un fichier</button>';
echo '<br>';
echo '<br>';
echo "</div>";
echo "</div>";
echo "</div>";

try {
    $sql = "SELECT id, heure, numero, nom, prenoms, repondant, contenu, reg_date FROM enregistrement ORDER BY id DESC ";
    $result = $conn->query($sql);
    
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<table id='tableau' border='2' class='table table-striped table-bordered' style='border-collapse: collapse; width : 100%;'>";
    echo "<tr><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>ID</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Heure</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Numéro</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Nom</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Prénoms</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Répondant</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Contenu</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Date</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Action</th></tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['heure'] . "</td>";
        echo "<td>" . $row['numero'] . "</td>";
        echo "<td>" . $row['nom'] . "</td>";
        echo "<td>" . $row['prenoms'] . "</td>";
        echo "<td>" . $row['repondant'] . "</td>";
        echo "<td>" . $row['contenu'] . "</td>";
        // Remplacer les caractères '-' par des caractères '_' dans la date
        $reg_date = str_replace('-', '_', $row['reg_date']);
        echo "<td>" . $reg_date . "</td>";
        echo "<td>";
        echo "<form action='/mesprojets/base_appel/edit.php' method='get' style='display: inline;'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<button type='submit' class='btn btn-primary' style='margin-right: 5px;'>Modifier</button>";
        echo "</form>";
        echo "<form action='/mesprojets/base_appel/delete.php' method='get' style='display: inline;'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<button type='submit' class='btn btn-danger'>Supprimer</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
    echo "</div>";
    echo "</div>";
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
$conn = null;
?>

<script>
    function exportToExcel() {
        const tableau = document.getElementById('tableau');
        const dateEnregistrement = new Date().toISOString().slice(0, 10).replace(/-/g, '_'); // Remplacer les '-' par des '_' dans la date
        const nomFichier = 'donnees_' + dateEnregistrement + '.xlsx';
        
        // Copier le tableau pour effectuer les modifications
        const tableauModifie = tableau.cloneNode(true);

        // Supprimer la colonne "Action" du tableau à exporter
        const colonneActionCells = tableauModifie.querySelectorAll('td:nth-child(9), th:nth-child(9)');
        colonneActionCells.forEach(cell => cell.remove());

        const classeur = XLSX.utils.table_to_book(tableauModifie);

        XLSX.writeFile(classeur, nomFichier);
    }

    function exportToPdf() {
        const dateEnregistrement = new Date().toISOString().slice(0, 10).replace(/-/g, '_'); // Remplacer les '-' par des '_' dans la date
        const nomFichier = 'donnees_' + dateEnregistrement + '.pdf';

        const content = document.getElementById('tableau');

        // Options pour la génération du PDF
        const options = {
            margin: 11,
            filename: nomFichier,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        // Générer le PDF
        html2pdf().from(content).set(options).save();
    }

    function saveToFile()  {
        // Récupérer le tableau complet
        const table = document.getElementById('tableau');

        // Supprimer la colonne "Action" du tableau à exporter
        const actionColumnIndex = table.rows[0].cells.length - 1;
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].deleteCell(actionColumnIndex);
        }

        // Obtenir le contenu HTML du tableau modifié (sans la colonne "Action")
        const tableContent = table.outerHTML;
        
        // Créer un formulaire invisible
        const form = document.createElement('form');
        form.method = 'post';
        form.action = 'save_to_file.php'; // Chemin vers votre fichier PHP pour enregistrer le tableau

        // Ajouter un champ caché contenant les données à exporter
        const dataInput = document.createElement('input');
        dataInput.type = 'hidden';
        dataInput.name = 'table_data';
        dataInput.value = tableContent;
        form.appendChild(dataInput);

        // Ajouter le formulaire à la page et le soumettre
        document.body.appendChild(form);
        form.submit();
    }

</script>

</body>
</html>
