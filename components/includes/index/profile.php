<div class="profile">
    <?php
    if (isset($_SESSION['username'])) {
        echo "<p class='centered'>Bonjour <span class='nickname'>" . $_SESSION['username'] . "</span></p>";
    }
    ?>

    <form class="image-upload" action="upload.php" method="post" enctype="multipart/form-data">
        <label for="uploadppic">
            <div class="profile-pic">
                <div class="pulse1"></div>
                <div class="pulse2"></div>
                <div class="overlay">
                    <div class="text-ppic">Changer photo</div>
                </div>
                <?php 
                if (isset($_SESSION['id'])) {
                    $id = $_SESSION['id'];
                } else {
                    $id = "";
                }
                echo "" . ppic($id) . "";
            ?>
            </div>

        </label>
        <input type="file" name="uploadppic" id="uploadppic" onchange="form.submit()">
    </form>
</div>