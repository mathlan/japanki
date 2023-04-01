<?php

require 'database.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM user where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Read</title>
</head>

<body>
    <h1>Read</h1>

    <div style="margin-top: 40px">
        <div>
            <label style="font-size: 25px;"> Nom </label>
            <label style="margin-left: 200px;">
                <?php echo $data['name']; ?>
            </label>
        </div>

        <div>
            <label style="font-size: 25px;"> Email </label>
            <label style="margin-left: 100px;">
                <?php echo $data['email']; ?>
            </label>
        </div>

        <div>
            <label style="font-size: 25px;"> Mobile </label>
            <label style="margin-left: 100px;">
                <?php echo $data['mobile']; ?>
            </label>
        </div>

        <div style="margin-top: 40px">
            <a href="index.php">Retour</a>
        </div>
    </div>


</body>

</html>