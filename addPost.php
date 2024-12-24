<!DOCTYPE html>
<html lang="it">
<head>
    <?php
        require_once 'head.php';
    ?>
    <link rel="stylesheet" href="resources/css/addPost.min.css">
    <script src="./js/addPost.js" defer></script>
</head>
<body>
    <?php
        require_once 'connectDatabase.php';
        require_once 'header.php';

        if(isset($_POST['Modify'])){

            $modify_error = '';

            $sql = file_get_contents('./resources/query/updatePostDescription.sql');
            $query = $mysqli->prepare($sql);
            $query->bind_param('si', $_POST['description'], $_GET['postId']);
            $query->execute();
            $query->close();

            if(isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE){
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png');

                if(in_array($fileActualExt, $allowed)){
                    if($fileError === 0){
                        if($fileSize < 2000000){
                            $sql = file_get_contents('./resources/query/retrievePost.sql');
                            $query = $mysqli->prepare($sql);
                            $query->bind_param('i', $_GET['postId']);
                            $query->execute();
                            $result = $query->get_result();
                            $post = $result->fetch_assoc();
                            $query->close();

                            if(unlink($post['linkImmagine'])){
                                $fileNameNew = uniqid('', true).".".$fileActualExt;
                                $fileDestination = './resources/img/'.$fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);

                                $sql = file_get_contents('./resources/query/updatePostFile.sql');
                                $query = $mysqli->prepare($sql);
                                $query->bind_param('si', $fileDestination, $_GET['postId']);
                                $query->execute();
                                $query->close();
                                header('Location: ./myContents.php');
                            } else {
                                $modify_error = 'There was an error deleting the old file!';
                            }
                        } else {
                            $modify_error = 'Your file is too big!';
                        }
                    } else {
                        $modify_error = 'There was an error uploading your file!';
                    }
                } else {
                    $modify_error = 'You cannot upload files of this type!';
                }
            } else {
                header('Location: ./myContents.php');
            }
        }

        if(isset($_POST['Add'])){

            $add_errors = [];

            if(isset($_FILES['file'])){
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png');

                if(in_array($fileActualExt, $allowed)){
                    if($fileError === 0){
                        if($fileSize < 2000000){
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = './resources/img/'.$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);

                            $sql = file_get_contents('./resources/query/retrieveUser.sql');
                            $query = $mysqli->prepare($sql);
                            $query->bind_param('s', $_SESSION['username']);
                            $query->execute();
                            $result = $query->get_result();
                            $user = $result->fetch_assoc();
                            $query->close();

                            $sql = file_get_contents('./resources/query/addNewPost.sql');
                            $query = $mysqli->prepare($sql);
                            $data = date('Y-m-d');
                            $query->bind_param('isss', $user['idUtente'], $fileDestination, $data, $_POST['description']);
                            $query->execute();
                            $query->close();
                            header('Location: ./myContents.php');
                        } else {
                            $add_errors[] = 'Your file is too big!';
                        }
                    } else {
                        $add_errors[] = 'There was an error uploading your file!';
                    }
                } else {
                    $add_errors[] = 'You cannot upload files of this type!';
                }
            } else {
                $add_errors[] = 'You must upload a file!';
            }     
        }
    ?>
    <main>
        <?php if($_GET['state'] == 'add'): ?>
            <form action="addPost?state=add" method="POST" enctype="multipart/form-data">
                <label for="file">Add image file</label>
                <input type="file" name="file" id="file" accept="image/*">
                <label for="description">Insert your description</label>
                <textarea name="description" id="description" rows="10" placeholder="insert here your description"></textarea>
                <input type="submit" name="Add" value="Add">
                <?php if(isset($add_errors) && count($add_errors) > 0): ?>
                    <?php foreach($add_errors as $error): ?>
                        <p><?= $error; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </form>
        <?php elseif($_GET['state'] == 'delete'): ?>
            <?php
                $postId = $_GET['postId'];
                $sql = file_get_contents('./resources/query/deletePost.sql');
                $query = $mysqli->prepare($sql);
                $query->bind_param('i', $postId);
                $query->execute();
                $query->close();
                header('Location: ./myContents.php');
            ?>
        <?php elseif($_GET['state'] == 'modify'): ?>
            <?php
                $postId = $_GET['postId'];
                $sql = file_get_contents('./resources/query/retrievePost.sql');
                $query = $mysqli->prepare($sql);
                $query->bind_param('i', $postId);
                $query->execute();
                $result = $query->get_result();
                $post = $result->fetch_assoc();
                $query->close();
            ?>
            <form action="addPost?state=modify&postId=<?= $postId; ?>" method="POST" enctype="multipart/form-data">
                <p>Actual Image</p>
                <img src="<?= $post['linkImmagine']; ?>" alt="Immagine attuale">
                <label for="file">Modify image file</label>
                <input type="file" name="file" id="file" accept="image/*">
                <label for="description">Change your description</label>
                <textarea name="description" id="description" rows="10"><?= $post['descrizione']; ?></textarea>
                <input type="submit" name="Modify" value="Modify">
                <?php if(@$modify_error != ''): ?>
                    <p><?= $modify_error; ?></p>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>