<?php
    $sql = file_get_contents('./resources/query/retrieveHeaderMenu.sql');
    $query = $mysqli->prepare($sql);

    if(!isset($_SESSION['username'])) {
        $active = 0;
        $query->bind_param('i', $active);
        $query->execute();
        $result = $query->get_result(); 
        $query->close();
        $active = 1;
        $query = $mysqli->prepare($sql);
        $query->bind_param('i', $active);
        $query->execute();
        $result1 = $query->get_result();
        $query->close();
    } else {
        $active = 0;
        $query->bind_param('i', $active);
        $query->execute();
        $result = $query->get_result(); 
        $query->close();
        $active = 2;
        $query = $mysqli->prepare($sql);
        $query->bind_param('i', $active);
        $query->execute();
        $result1 = $query->get_result();
        $query->close();
    }


    $menuArray = $result->fetch_all(MYSQLI_ASSOC);
    $menuArray1 = $result1->fetch_all(MYSQLI_ASSOC);
    $menuArray = array_merge($menuArray, $menuArray1);


?>
<header>
    <nav>
        <?php foreach($menuArray as $menu): ?>
            <li><a href="<?php echo $menu['paginaAssociata']; ?>"><?php echo $menu['nome']; ?></a></li>
        <?php endforeach; ?>
    </nav>
</header>
