<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <?php
        if (isset($_GET['errorno']) && isset($_GET['error'])) {
            echo "<h1>Errore {$_GET['errorno']}</h1>";
            echo "<p>{$_GET['error']}</p>";
        } else {
            echo "<h1>Errore sconosciuto</h1>";
        }
    ?>
</body>
</html>