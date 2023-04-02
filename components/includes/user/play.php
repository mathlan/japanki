<div id="cardList">
    <div id="statusOk" class="tabs-container">
        <h1 class="txt-cntr step-title">Connaissez vous ce kanji ?</h1>
        <?php
        // Une nouvelle session de jeu doit être créée pour éviter que le jeu ne recommence à chaque refresh
        if (isset($_POST["newGame"])) {
            $_SESSION['deck'] =  getDeck($_SESSION['id']);
        }

        // Nombre de cartes du deck
        $deckLength = count($_SESSION['deck']);
        // Deck vide = Fin de partie -> Renvoie vers les stats
        if ($deckLength == 0) {
            header("Location: index.php?id=stats");
        }

        if (!empty($_SESSION['deck'])) {
            // Numéro de la carte jouée
            $playedNo = rand(0, $deckLength - 1);
            // Cartes jouée
            $played = $_SESSION['deck'][$playedNo];
            // A chaque choix, le deck perd une carte et le shuffle se fait parmi les cartes restantes (sans perte) + on update la stat de la carte
            if (isset($_POST["worst"])) {
                array_splice($_SESSION['deck'], $playedNo, 1);
                update_known($played['id'], 1);
            }
            if (isset($_POST["bad"])) {
                array_splice($_SESSION['deck'], $playedNo, 1);
                update_known($played['id'], 2);
            }
            if (isset($_POST["normal"])) {
                array_splice($_SESSION['deck'], $playedNo, 1);
                update_known($played['id'], 3);
            }
            if (isset($_POST["good"])) {
                array_splice($_SESSION['deck'], $playedNo, 1);
                update_known($played['id'], 4);
            }
            if (isset($_POST["best"])) {
                array_splice($_SESSION['deck'], $playedNo, 1);
                update_known($played['id'], 5);
            }
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
        </br>
        <form action="" method="post">
            <div style="display: flex; justify-content: space-between; width: 100%;">
                <input type="submit" class="submitInput" name="worst" style="font-family: FontAwesome; color:crimson;" value="&#xf2fe;">
                <input type="submit" class="submitInput" name="bad" style="font-family: FontAwesome; color:crimson;" value="&#xf583;">
                <input type="submit" class="submitInput" name="normal" style="font-family: FontAwesome; color:blue;" value="&#xf118;">
                <input type="submit" class="submitInput" name="good" style="font-family: FontAwesome; color:green;" value="&#xf4da;">
                <input type="submit" class="submitInput" name="best" style="font-family: FontAwesome; color:green;" value="&#xf584;">
            </div>
            </br>
            <div style="width: 100%;" class="centered">
                <input type="submit" class="submitInput" name="newGame" value="Nouvelle partie">
            </div>
        </form>
    </div>
</div>