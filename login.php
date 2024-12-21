<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once 'head.php';
    ?>
    <link rel="stylesheet" href="resources/css/login.min.css">
    <script src="./js/login.js" defer></script>
</head>
<body>
    <?php
        require_once 'connectDatabase.php';
        require_once 'header.php';

        $error = '';

        if(!isset($_GET['state'])){
            $state = 'login';
        } else {
            $state = $_GET['state'];
        }

        if(isset($_POST['Login'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $sql = file_get_contents('./resources/query/retrieveUser.sql');
            $query = $mysqli->prepare($sql);
            $query->bind_param('s', $username);
            $query->execute();
            $result = $query->get_result();
            $query->close();
            $user = $result->fetch_assoc();
            if($user == null){
                $error = 'Invalid username';
            } else {
                $hashedPassword = hash('sha256', $password);
                if($hashedPassword == $user['password']){
                    $_SESSION['username'] = $user['username'];
                    header('Location: home.php');
                } else {
                    $error = 'Invalid password';
                }
            }
        }
    ?>
    <script>
        let page_status = '';
    </script>
    <main>
        <?php if($state == 'login'): ?>
            <script>
                page_status = 'login';
            </script>
            <form action="login.php?state=login" method="post">
                <label for="username">Username</label>
                <input type="username" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" name="Login" value="Login">
                <p class="error"><?= $error; ?></p>
                <p>Don't have an account yet?</p>
                <a href="login.php?state=register">Register</a>
            </form>
        <?php elseif($state == 'register'): ?>
            <script>
                page_status = 'register';
            </script>
            <form action="login.php?state=register" method="post">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" required>
                <label for="birth-date">Birth Date</label>
                <input type="text" name="birth-date" id="birth-date" required>
                <label for="username">Username</label>
                <input type="username" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <label for="confirm-password">Confirm Password</label>
                <input type="password" name="confirm-password" id="confirm-password" required>
                <input type="submit" value="Register" disabled>
                <p>Already have an account?</p>
                <a href="login.php?state=login">Login</a>
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