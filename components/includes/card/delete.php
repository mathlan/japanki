<?php

//TODO Check card, update.

if (isset($_SESSION['username'])) {
    //?  Display the card only if connected user is its owner.
    $idcard = $_GET['card'];
    if (card_owner($idcard) === $_SESSION['id']) {
        $card = display_card($idcard);
        if (isset($_POST['cancel'])) {
            header('Location: index.php?id=dashboard');
            exit();
        }
        if (isset($_POST['delete'])) {
            delete_card($idcard);
            header('Location: index.php?id=dashboard');
            exit();
        }

?>
<!-- Update card -->
<div class="centered">
    <h1><?php echo $card['title']; ?></h1>
    <br>
    <input class="deleteInput" value="<?php echo $card['card']; ?>" disabled></input>
    <form class="jsb" action="" method="post">
        <input type="submit" class="submitInput" name="cancel" value="Annuler">
        <input type="submit" class="submitInput" name="delete" value="Supprimer">
    </form>
</div>
<?php
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}