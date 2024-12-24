<?php
    require_once 'connectDatabase.php';
    require_once 'head.php';

    $username = $_SESSION['username'];
    $sql = file_get_contents('./resources/query/deleteUser.sql');
    $query = $mysqli->prepare($sql);
    $query->bind_param('s', $username);
    $query->execute();
    $query->close();
    session_destroy();
    header('Location: ./home.php');
?>