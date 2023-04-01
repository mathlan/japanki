<?php
//* Data
$id = $_SESSION['id'];
$date = date('Ymd');

if (isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titleInput = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $cardInput = htmlspecialchars($_POST['card'], ENT_QUOTES, 'UTF-8');
    }
    if (empty($titleInput) && !empty($cardInput)) {
        //* Make sure the truncated card does not cut off a word and does not exceed 20 characters.
        $pos = strpos($cardInput, ' ', 15);
        if ($pos) {
            $titleInput = substr($cardInput, 0, $pos);
        } else {
            $titleInput = substr($cardInput, 0, 15);
        }
    }
    if (!empty($_SESSION['id'] && !empty($cardInput))) {
        insert_card($id, $titleInput, $cardInput, $date, 0, 0, 1);
        $cardInput = "";
        header("Location: index.php?id=dashboard");
    }
?>
<div id="cardList">

    <div id="statusOk" class="tabs-container">
        <h1 class="txt-cntr step-title">Active(s)</h1>
        <?php
            $status = fetch_cards($_SESSION['id'], 1);
            foreach ($status as $card) {
                echo "<div class='tab'>";
                echo "<div class='tab-in'>";
                echo "<div class='tab-btn '>";
                echo "<a href='index.php?id=update&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-feather fav-feather'></i></a>";
                // echo "<i class='fa-regular fa-image fav-img'></i>";
                echo "<a href='index.php?id=delete&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-trash fav-trash'></i></a>";
                echo "</div>";
                echo "<div class='tab-name '>";
                echo "<h2>" . $card['title'] . "</h2>";
                echo "</div>";
                echo "<div class='tab-swap '>";
                //* No left arrow if card is a "To Do"
                if (in_array($card['status'], [2])) {
                    echo "<a href='index.php?id=moveLeft&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-arrow-left fav-feather'></i></a>";
                }
                //* No right arrow if card is a "Done"
                if (in_array($card['status'], [1])) {
                    echo "<a href='index.php?id=moveRight&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-arrow-right inProgressFont'></i></a>";
                }
                echo "</div>";
                echo "<div class='tab-section'>";
                echo "<p>" . $card['card'] . "</p>";
                echo "</div>";
                echo "<div class='tab-pic'>";
                echo "" . card_pic($card['id']) . "";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
    </div>
    <div id="statusNok" class="tabs-container">
        <h1 class="txt-cntr step-title">Désactivée(s)</h1>
        <?php
            $statusNok = fetch_cards($_SESSION['id'], 2);
            foreach ($statusNok as $card) {
                echo "<div class='tab'>";
                echo "<div class='tab-in'>";
                echo "<div class='tab-btn '>";
                echo "<a href='index.php?id=update&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-feather fav-feather'></i></a>";
                // echo "<i class='fa-regular fa-image fav-img'></i>";
                echo "<a href='index.php?id=delete&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-trash fav-trash'></i></a>";
                echo "</div>";
                echo "<div class='tab-name '>";
                echo "<h2>" . $card['title'] . "</h2>";
                echo "</div>";
                echo "<div class='tab-swap '>";
                //* No left arrow if card is a "To Do"
                if (in_array($card['status'], [2])) {
                    echo "<a href='index.php?id=moveLeft&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-arrow-left inProgressFont'></i></a>";
                }
                //* No right arrow if card is a "Done"
                if (in_array($card['status'], [1])) {
                    echo "<a href='index.php?id=moveRight&card=" . urlencode($card['id']) . "'><i class='fa-solid fa-arrow-right fav-feather'></i></a>";
                }
                echo "</div>";
                echo "<div class='tab-section'>";
                echo "<p>" . $card['card'] . "</p>";
                echo "</div>";
                echo "<div class='tab-pic'>";
                echo "" . card_pic($card['id']) . "";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
    </div>

    <div id="addCard" class="tabs-container">
        <h1 class="txt-cntr step-title">Ajouter une carte</h1>
        <div class="insert">
            <!-- Insert card-->
            <div>
                <form id="create-card" class="centered" method="post">
                    <label for="card">Titre:</label>
                    <textarea id="title" class="titleInput" name="title" type="text" placeholder="Max 15 caractères"
                        value="<?php echo !empty($title) ? $title : ''; ?>"></textarea>
                    <br>
                    <label for="card">Carte:</label>
                    <textarea id="card" class="cardInput" name="card" type="text" placeholder="Max 225 caractères"
                        value="<?php echo !empty($card) ? $card : ''; ?>"></textarea>
                    <div class="daytime">
                        <p class="date"><?php echo "Date du jour: " . date("d-m-Y"); ?></p>
                        <!-- <p class="time"><?php echo "Heure: " . date("H:i:s"); ?></p> -->
                    </div>
                    <input type="submit" class="submitInput" value="Enregistrer">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
} else {
    header("Location: index.php");
}
?>