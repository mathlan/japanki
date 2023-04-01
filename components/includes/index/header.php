<header>
    <div class="logo">
        <img src="img/japAnkiLogo.jpg">
    </div>
    <div class="navbar">
        <ul>
            <li><a href="?">Home</a></li>
            <li><a style="color: #e21e42;" href="?id=dashboard">JapAnki</a></li>
            <?php if (empty($_SESSION['username'])) { ?>
            <li><a href="?id=signup">Inscription</a></li>
            <li><a href="?id=login">Connexion</a></li>
            <?php } else { ?>
            <li><a href="?id=logout">Déconnexion</a></li>
            <?php } ?>
            <!-- <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Dropdown</a>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </li> -->
        </ul>
    </div>
    <div class="user-nav">
        <?php
        if (isset($_SESSION['username'])) {
            echo "<p class='txt-cntr'>Bonjour <span class='nickname'>" . $_SESSION['username'] . "</span></p>";
        }
        ?>

        <form class="image-upload" action="components/includes/user/upload.php" method="post"
            enctype="multipart/form-data">
            <label for="uploadppic">
                <div class="profile-pic">
                    <div class="pulse1"></div>
                    <div class="pulse2"></div>
                    <div class="overlay">
                        <div class="text-ppic">Changer</div>
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
</header>