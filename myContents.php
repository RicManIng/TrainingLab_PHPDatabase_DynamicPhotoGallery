<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once 'head.php';
    ?>
    <link rel="stylesheet" href="resources/css/myContents.min.css">
    <script src="./js/myContents.js" defer></script>
</head>
<body>
    <?php
        require_once 'connectDatabase.php';
        require_once 'header.php';
    ?>
    <main>
        <section id="welcome">
            <video autoplay muted loop id="backgroundVideo">
                <source src="resources/video/backgroundVideo.mp4" type="video/mp4">
                Wrong video format
            </video>
            <div id="welcomeContent">
                <h1>Hi <?= $_SESSION['username']; ?>!</h1>
                <p>Here you can see all the contents you have uploaded</p>
            </div>
        </section>
        <h1>Look at your contents</h1>
        <section id="loadedContents">
            <?php
                $sql = file_get_contents('./resources/query/retrieveUserPosts.sql');
                $query = $mysqli->prepare($sql);
                $query->bind_param('s', $_SESSION['username']);
                $query->execute();
                $result = $query->get_result();
                $query->close();
            ?>
            <script>
                let loadedContents = <?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>;
                let username = '<?php echo $_SESSION['username']; ?>';
            </script>
        </section>
        <section id="generalCommands">
            <button id="addContent">Add Content</button>
            <button id="deleteAccount">Delete Account</button>
        </section>
    </main>
</body>
</html>