<?php
//* Data
$id = $_SESSION['id'];
$card = "";
$date = date('Ymd');

if (isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $card = htmlspecialchars($_POST['card'], ENT_QUOTES, 'UTF-8');
    }
    if (empty($title) && !empty($card)) {
        //* Make sure the truncated card does not cut off a word and does not exceed 20 characters.
        $pos = strpos($card, ' ', 15);
        if ($pos) {
            $title = substr($card, 0, $pos);
        } else {
            $title = substr($card, 0, 15);
        }
    }
    if (!empty($_SESSION['id'] && !empty($card))) {
        insert_card($id, $title, $card, $date, 0, 0, 1);
        $card = "";
        header("Location: index.php?id=dashboard");
    }
?>
<!-- Insert card-->
<div>
    <form id="create-card" method="post">
        <label for="card">Titre:</label>
        <textarea id="title" name="title" type="text" placeholder="Titre"
            value="<?php echo !empty($title) ? $title : ''; ?>"></textarea>
        <br>
        <label for="card">Carte:</label>
        <textarea id="card" name="card" type="text" placeholder="card"
            value="<?php echo !empty($card) ? $card : ''; ?>"></textarea>
        <br>
        <input type="submit" value="Enregistrer">
    </form>
</div>
<?php
} else {
    header("Location: index.php");
}