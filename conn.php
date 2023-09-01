<?php        
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "essaie";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo $sqpl . "<br>" . $e->getMessage();
        }
?>
