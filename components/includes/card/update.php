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
        if (isset($_POST['save'])) {
            $titleUpdate = htmlspecialchars($_POST['titleUpdate'], ENT_QUOTES, 'UTF-8');
            $cardUpdate = htmlspecialchars($_POST['cardUpdate'], ENT_QUOTES, 'UTF-8');
            if (empty($titleUpdate) && !empty($cardUpdate)) {
                //* Make sure the truncated card does not cut off a word and does not exceed 20 characters.
                $pos = strpos($cardUpdate, ' ', 15);
                if ($pos) {
                    $titleUpdate = substr($cardUpdate, 0, $pos);
                } else {
                    $titleUpdate = substr($cardUpdate, 0, 15);
                }
            }
            if (!empty($_SESSION['id'] && !empty($cardUpdate))) {
                update_card($idcard, $titleUpdate, $cardUpdate);
                $cardUpdate = "";
                header("Location: index.php?id=dashboard");
            }
            exit();
        }
?>
<!-- Update card -->

<!-- <label for="card">Titre:</label> -->

<div class="updatecardGrid">
    <form id="create-card" class="updatecard centered" method="post">
        <input id="title" class="updatecardInput" name="titleUpdate" type="text" placeholder="Titre"
            value="<?php echo $card['title']; ?>"></input>
        </br>
        <input id="card" class="updatecardInput updatecardContent" name="cardUpdate" type="text" placeholder="card"
            value="<?php echo $card['card']; ?>"></input>

        <div class="jse">
            <input type="submit" class="submitInput" name="cancel" value="Annuler">
            <input type="submit" class="submitInput" name="save" value="Enregistrer">
        </div>
    </form>
    <div id="pic" class="updatePic centered" name="picUpdate">
        <form class="image-upload" action="components/includes/card/upload.php?idcard=<?php echo $card['id'] ?>"
            method="post" enctype="multipart/form-data">
            <label for="uploadcardpic">
                <?php
                        if (isset($card['id'])) {
                            $cardId = $card['id'];
                        } else {
                            $cardId = "";
                        }
                        echo "" . card_pic($cardId) . "";
                        ?>

            </label>
            <input type="file" name="uploadcardpic" id="uploadcardpic" onchange="form.submit()">
        </form>
    </div>
</div>

<?php
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}