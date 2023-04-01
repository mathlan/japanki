<div id="cardList">
    <div id="statusOk" class="tabs-container">
        <h1 class="txt-cntr step-title">Évaluez vos connaissances</h1>
        <?php
        if (isset($_POST["newGame"])) {
            $_SESSION['deck'] =  getDeck($_SESSION['id']);
        }
        if(!empty($_SESSION['deck'])) {
        // Nombre de cartes du deck
        $deckLength = count($_SESSION['deck']);
        // Numéro de la carte jouée
        $playedNo = rand(0, $deckLength - 1);
        // Cartes jouée
        $played = $_SESSION['deck'][$playedNo];
        // A chaque choix, le deck perd une carte et le shuffle se fait parmi les cartes restantes (sans perte)
        if (isset($_POST["submit"])) {
        array_splice($_SESSION['deck'], $playedNo, 1);
        }


        // $_SESSION['game'] = rand(1, 10);
    }
                echo "<div class='tab'>";
                echo "<div class='tab-in'>";
                echo "<div class='tab-name '>";
                echo "<h2>" . $played['title'] . "</h2>";
                echo "</div>";
                echo "<div class='tab-section'>";
                echo "<p>" . $played['card'] . "</p>";
                echo "</div>";
                echo "<div class='tab-pic'>";
                echo card_pic($played['id']);
                echo "</div>";
                echo "</div>";
                echo "</div>";
            ?>

<form action="" method="post">
        <input type="submit" class="submitInput" name="newGame" value="Nouvelle partie">
            <input type="submit" class="submitInput" name="submit" value="Test">
        </form>
    </div>
</div>