<?php
// ini_set('display_errors', 0);
session_start();
include('components/functions.php');
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="styles/styles.css">
    <title>Japanki</title>
</head>

<body>
    <?php
    // $_SESSION['id_user'] = "1";
    include("components/includes/index/header.php");
    include("components/includes/index/nav.php");
    // include("components/includes/index/aside.php");
    ?>

    <section>
        <?php
        // Création d'une variable ID pour éviter les erreurs d'ID vide.
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if (empty($id)) {
            require_once("components/includes/index/home.php");
        }
        if ($id == 'signup') {
            include("components/includes/login/signup.php");
        }
        if ($id == 'login') {
            include("components/includes/login/login.php");
        }
        if ($id == 'logout') {
            include("components/includes/login/logout.php");
        }
        if ($id == 'cardManager') {
            include("components/includes/user/cardManager.php");
        }
        if ($id == 'play') {
            include("components/includes/user/play.php");
        }
        // if ($id == 'dashboard') {
        //     include("components/includes/user/dashboard.php");
        // }
        if ($id == 'create') {
            include("components/includes/card/create.php");
        }
        if ($id == 'update') {
            include("components/includes/card/update.php");
        }
        if ($id == 'delete') {
            include("components/includes/card/delete.php");
        }
        if ($id == 'moveRight') {
            include("components/includes/card/moveRight.php");
        }
        if ($id == 'moveLeft') {
            include("components/includes/card/moveLeft.php");
        }
        if ($id == 'cardPic') {
            include("components/includes/card/cardpic.php");
        }
        if ($id == 'uploadcardPic') {
            include("components/includes/card/upload.php");
        }
        if ($id == 'test1') {
            include("test1.php");
        }
        if ($id == 'test2') {
            include("test2.php");
        }
        if ($id == 'test3') {
            include("test3.php");
        }
        ?>
    </section>

    <?php
    // include("components/includes/index/main.php");
    include("components/includes/index/footer.php");
    ?>
</body>

</html>