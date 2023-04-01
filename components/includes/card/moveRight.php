<?php

//TODO Check card, update.

if (isset($_SESSION['username'])) {
    //?  Display the card only if connected user is its owner.
    $idcard = $_GET['card'];
    $card = display_card($idcard);
    //* If new status exceeds 3, card wont move.
    $move = $card['status'] + 1;
    if (card_owner($idcard) === $_SESSION['id'] && in_array($move, [1, 2])) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE card SET status=:status WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $move);
        $stmt->bindParam(':id', $idcard);
        $stmt->execute();
        Database::disconnect();
        header("Location: index.php?id=dashboard");
    } else {
        header("Location: index.php?id=dashboard");
    }
} else {
    header("Location: index.php?id=dashboard");
}