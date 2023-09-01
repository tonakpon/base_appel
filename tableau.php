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
    <link rel="stylesheet" href="font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclure la bibliothèque SheetJS via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <!-- Inclure la bibliothèque jsPDF via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
    <!-- Inclure le plugin jsPDF autotable via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
    <!-- Inclure la bibliothèque html2pdf.js via CDN 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>-->
    <!-- Inclure la bibliothèque jsPDF via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- Inclure le plugin jsPDF autotable via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
       icons de bootstrap -->
</head>
<body>

<?php  
include 'conn.php';
echo '<br>';
echo "<div class='container'>";
echo "<div class='row'>";
echo '<h1>Historique des enregistrements</h1>';
echo "<div>";
echo '<a href="/mesprojets/base_appel/enregistrement.php" class="btn btn-outline-primary">NOUVEL ENREGISTREMENT</a>';
echo "&nbsp;&nbsp;";
echo "<button class='btn btn-outline-success' onclick='exportToExcel()'>Télécharger format Excel</button>";
echo "&nbsp;&nbsp;";
echo "<button class='btn btn-outline-danger' onclick='exportToPdf()'>Télécharger format Pdf</button>";
echo "&nbsp;&nbsp;";
/*echo '<button class="btn btn-primary" onclick="saveToFile()">Enregistrer HTML sur server</button>';
echo "&nbsp;&nbsp;";
echo "<button class='btn btn-danger' onclick='exportTableToPdf()'>Enregistrer PDF sur server</button>";
echo '<br>';
echo "&nbsp;&nbsp;";
echo '<br>';
echo '<button class="btn btn-success" onclick="exportTableToExcel()">Enregistrer Excel sur server</button>';*/
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
    echo "<tr><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>#</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Heure</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Numéro</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Nom</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Prénoms</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Répondant</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Contenu</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Date</th><th style='background-color: #f2f2f2; font-weight: bold; color: blue;'>Action</th></tr>";

    // Introduce a variable to keep track of the row number
    $rowNumber = 1;

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        echo "<tr>";
        echo "<td>" . $rowNumber . "</td>"; // Affiche le numéro de ligne
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
        echo "<button type='submit' class='btn btn-primary' style='margin-right: 5px;'><i class='bi bi-pencil-square'></i></button>";
        echo "</form>";
        echo "<form action='/mesprojets/base_appel/delete.php' method='get' style='display: inline;'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<button type='submit' class='btn btn-danger'><i class='bi bi-trash'></i></button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";

        // Incrémente le numéro de ligne pour la prochaine itération
        $rowNumber++;
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
        const nomFichier = 'Historique_de_' + dateEnregistrement + '.xlsx';
        
        // Copier le tableau pour effectuer les modifications
        const tableauModifie = tableau.cloneNode(true);

        // Supprimer la colonne "Action" du tableau à exporter
        const colonneActionCells = tableauModifie.querySelectorAll('td:nth-child(9), th:nth-child(9)');
        colonneActionCells.forEach(cell => cell.remove());

        const classeur = XLSX.utils.table_to_book(tableauModifie);

        XLSX.writeFile(classeur, nomFichier);
    }

    function exportToPdf() {
        const tableau = document.getElementById('tableau');
        const dateEnregistrement = new Date().toISOString().slice(0, 10).replace(/-/g, '_');
        const nomFichier = 'Historique_de_' + dateEnregistrement + '.pdf';

        // Clone the table to perform modifications without affecting the original table
        const tableauModifie = tableau.cloneNode(true);

        // Remove the "Action" column from the table to be exported
        const colonneActionCells = tableauModifie.querySelectorAll('td:nth-child(9), th:nth-child(9)');
        colonneActionCells.forEach(cell => cell.remove());

        // Options for PDF generation
        const options = {
            filename: nomFichier,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Generate the PDF
        html2pdf().from(tableauModifie).set(options).save();
    }
    
    /*function saveToFile()  {
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
    }*/

    function saveToFile() {
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

    // Envoyer le formulaire via une requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_to_file.php'); // Chemin vers votre fichier PHP pour enregistrer le tableau
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = xhr.responseText; // Récupérer la réponse de la requête
                console.log(response); // Afficher la réponse dans la console
                alert(response); // Afficher un message de succès à l'utilisateur
            } else {
                console.error('Error saving table on server:', xhr.statusText);
                alert('Error saving table on server. Please try again.');
            }
        }
    };
    xhr.send(new FormData(form));
}


    /*function exportTableToPdf() {
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
    html2pdf().from(content).set(options).outputPdf().then(function (pdf) {
        // Envoyer le contenu du PDF au serveur
        savePdfOnServer(pdf, nomFichier);
    });
    }
    function savePdfOnServer(pdfContent, filename) {
    // Créer un objet FormData pour envoyer le contenu du PDF au serveur
    const formData = new FormData();
    formData.append('pdf_content', pdfContent);
    formData.append('filename', filename);

    // Envoyer le contenu du PDF au serveur via une requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_pdf_on_server.php'); // Chemin vers votre fichier PHP pour enregistrer le PDF
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log('PDF saved on server successfully!');
            } else {
                console.error('Error saving PDF on server:', xhr.statusText);
            }
        }
    };
    xhr.send(formData);
    }*/

    function exportTableToPdf() {
    const dateEnregistrement = new Date().toISOString().slice(0, 10).replace(/-/g, '_'); // Remplacer les '-' par des '_' dans la date
    const nomFichier = 'donnees_' + dateEnregistrement + '.pdf';

    // Copier le contenu du tableau pour effectuer les modifications sans affecter le tableau original
    const content = document.getElementById('tableau').cloneNode(true);

    // Supprimer la colonne "Action" du tableau à exporter
    const actionColumnIndex = content.rows[0].cells.length - 1;
    for (let i = 0; i < content.rows.length; i++) {
        content.rows[i].deleteCell(actionColumnIndex);
    }

    // Options pour la génération du PDF
    const options = {
        margin: { top: 10, right: 10, bottom: 10, left: 10 },
        filename: nomFichier,
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4'
    };

    // Générer le PDF
    const doc = new jsPDF(options);

    // Ajouter le contenu du tableau dans le PDF avec le plugin jspdf-autotable
    doc.autoTable({ html: content });

    // Récupérer le contenu du PDF sous forme de blob
    const pdfBlob = doc.output('blob');

    // Envoyer le contenu du PDF au serveur
    savePdfOnServer(pdfBlob, nomFichier);
    }

    function savePdfOnServer(pdfBlob, filename) {
    // Générer un nom de fichier unique en ajoutant un horodatage au nom de fichier
    const dateEnregistrement = new Date().toISOString().slice(0, 10).replace(/-/g, '_');
    const nomFichierUnique = 'donnees_' + dateEnregistrement + '_' + filename;

    // Créer un objet FormData pour envoyer le contenu du PDF au serveur
    const formData = new FormData();
    formData.append('pdf_content', pdfBlob, nomFichierUnique);

    // Envoyer le contenu du PDF au serveur via une requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_pdf_on_server.php'); // Chemin vers votre fichier PHP pour enregistrer le PDF
    xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = xhr.responseText; // Récupérer la réponse de la requête
            console.log(response); // Afficher la réponse dans la console
            alert(response); // Afficher un message de succès à l'utilisateur
        } else {
            console.error('Error saving PDF on server:', xhr.statusText);
            alert('Error saving PDF on server. Please try again.');
        }
    }
    };
    xhr.send(formData);
    }

    
    function exportTableToExcel() {
    const tableau = document.getElementById('tableau');
    const dateEnregistrement = new Date().toISOString().slice(0, 10).replace(/-/g, '_'); // Remplacer les '-' par des '_' dans la date
    const nomFichier = 'donnees_' + dateEnregistrement + '.xlsx';
    
    // Copier le tableau pour effectuer les modifications
    const tableauModifie = tableau.cloneNode(true);

    // Supprimer la colonne "Action" du tableau à exporter
    const colonneActionCells = tableauModifie.querySelectorAll('td:nth-child(9), th:nth-child(9)');
    colonneActionCells.forEach(cell => cell.remove());

    const classeur = XLSX.utils.table_to_book(tableauModifie);

    // Générer le contenu Excel
    const excelContent = XLSX.write(classeur, { type: 'array', bookType: 'xlsx' });

    // Envoyer le contenu du fichier Excel au serveur
    saveExcelOnServer(excelContent, nomFichier);
    }
    function saveExcelOnServer(excelContent, filename) {
    // Créer un objet FormData pour envoyer le contenu du fichier Excel au serveur
    const formData = new FormData();
    const excelBlob = new Blob([excelContent], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    formData.append('excel_file', excelBlob, filename);

    // Envoyer le contenu du fichier Excel au serveur via une requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_excel_on_server.php'); // Chemin vers votre fichier PHP pour enregistrer l'Excel
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = xhr.responseText; // Récupérer la réponse de la requête
                console.log(response); // Afficher la réponse dans la console
                alert(response); // Afficher un message de succès à l'utilisateur
            } else {
                console.error('Error saving Excel on server:', xhr.statusText);
                alert('Error saving Excel on server. Please try again.');
            }
        }
    };
    xhr.send(formData);
    }
</script>

</body>
</html>
