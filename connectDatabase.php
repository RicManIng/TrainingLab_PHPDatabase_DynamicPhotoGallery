<?php
    $indirizzo = "localhost";
    $utente = "root";
    $password = "";
    $database = "dynamicphotogallery";
    
    // Connessione al database a MySQL con l'estensione MySQLi
    
    $mysqli = new mysqli($indirizzo, $utente, $password, $database);
    if ($mysqli->connect_error) {
        header("Location: 404.php&errorno={$mysqli->connect_errno}&error={$mysqli->connect_error}");
    }
?>