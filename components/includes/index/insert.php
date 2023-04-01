<div class="insert">
    <h1 class="txt-cntr">Nouvelle carte</h1>

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