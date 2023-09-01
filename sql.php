<?php
    include 'conn.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE TABLE enregistrement ( 
            id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            heure VARCHAR(5) NOT NULL,
            numero VARCHAR(12) NOT NULL,
            nom VARCHAR(50) NULL,
            prenoms VARCHAR(50) NULL,
            repondant VARCHAR(50) NOT NULL,
            contenu VARCHAR(250) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
        $conn->exec($sql);
            echo 'La table enregistrement est créé avec succès';

            $conn->exec($sql);
        
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
?>