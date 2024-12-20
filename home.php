<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once 'head.php';
    ?>
    <link rel="stylesheet" href="resources/css/home.min.css">
    <script src="./js/home.js" defer></script>
</head>
<body>
    <?php
        require_once 'connectDatabase.php';
        require_once 'header.php';
    ?>
    <main>
        <?php
            $sql = file_get_contents('./resources/query/retrieveAllPosts.sql');
            $query = $mysqli->prepare($sql);
            $query->execute();
            $result = $query->get_result();
            $query->close();
            $cardsArray = $result->fetch_all(MYSQLI_ASSOC);
        ?>
        <script>
            let cardsArray = <?php echo json_encode($cardsArray); ?>;
        </script>
        <section id="cardsContainer">

        </section>
    </main>
</body>
</html>