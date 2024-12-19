<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once 'head.php';
    ?>
    <link rel="stylesheet" href="resources/css/home.min.css">
</head>
<body>
    <?php
        require_once 'connectDatabase.php';
        require_once 'header.php';

        if(!isset($_GET['state'])){
            $state = 'login';
        } else {
            $state = $_GET['state'];
        }
    ?>
    <main>
        <?php if($state == 'login'): ?>
            <form action="login.php?state=login" method="post">
                <label for="username">Username</label>
                <input type="username" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Login">
                <p>Don't have an account yet?</p>
                <a href="login.php?state=register">Register</a>
            </form>
        <?php elseif($state == 'register'): ?>
            <form action="login.php?state=register" method="post">

            </form>
        <?php elseif($state == 'logout'): ?>
            <?php
                session_destroy();
                header('Location: home.php');
            ?>
        <?php endif; ?>
    </main>
</body>
</html>