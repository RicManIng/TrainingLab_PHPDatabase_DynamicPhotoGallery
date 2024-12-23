<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once 'head.php';
    ?>
    <link rel="stylesheet" href="resources/css/post.min.css">
    <script src="./js/post.js" defer></script>
</head>
<body>
    <?php
        require_once 'connectDatabase.php';
        require_once 'header.php';

        $sql = file_get_contents('./resources/query/retrievePost.sql');
        $query = $mysqli->prepare($sql);
        $query->bind_param('i', $_GET['id']);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        $postInfoArray = $result->fetch_assoc();

        #print_r($result->fetch_assoc());

        $sql = file_get_contents('./resources/query/retrieveAllPostLikes.sql');
        $query = $mysqli->prepare($sql);
        $query->bind_param('i', $_GET['id']);
        $query->execute();
        $result1 = $query->get_result();
        $query->close();
        $likes = $result1->fetch_all(MYSQLI_ASSOC);

        #print_r($result->fetch_all(MYSQLI_ASSOC));
    ?>
    <main>
        <section id="postInfo">
            <img src="<?= $postInfoArray['linkImmagine']; ?>" alt="immagine non trovata">
            <div id="generalInfo">
                <p><?= $postInfoArray['data']; ?></p>
                <p><?= $postInfoArray['username']; ?></p>
            </div>
            <div id="description">
                <h2>Descrizione</h2>
                <p><?= $postInfoArray['descrizione']; ?></p>
            </div>
        </section>
        <section id="postLikes">
            <h1>Likes</h1>
            <script>
                const likes = <?php echo json_encode($likes); ?>;
            </script>
            <div id="likesContainer">

            </div>
        </section>
    </main>
</body>
</html>