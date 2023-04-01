<?php
require_once('config.php');

$userName = $email = $password = $password2 = "";
$userNameErr = $emailErr = $passwordErr = "";

// * Check if user isn't connected
if (!isset($_SESSION['username'])) {

    // * Check the inputs
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $userName = test_input($_POST["username"]);
        //? Check if name only contains letters and whitespace
        if (BDD_check_membre($userName) == true) {
            $userNameErr = "L'utilisateur existe déjà.";
        } else if (!preg_match("/^[ A-Za-z0-9_-]*$/", $userName)) {
            $userNameErr = "Les caractères spéciaux sont interdits à l'exception des tirets";
        } else {
            $userNameErr = "";
        }
        //? The preg_match is going wrong when field is empty, the error has to be cancelled with this few lines below.
        if ($userName == "") {
            $userNameErr = "";
        }

        $email = test_input($_POST["email"]);
        //? Check if e-mail address is ok
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Email invalide";
        } else {
            $emailErr = "";
        }
        //? The filter_var is going wrong when field is empty, the error has to be cancelled with this few lines below.
        if ($email == "") {
            $emailErr = "";
        }

        //? REGEX samples
        // Check if password address has at least, one uppercase letter (?=.*[A-Z]), one digit (?=.*[0-9]), one special character (?=.*[^A-Za-z0-9]), and is at least eight characters long(?=.{8,}).
        // (?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,}) --> requires one additional lowercase letter (?=.*[a-z])
        // /^\p{L}[\p{L} _.-]+$/u" --> "Les chiffres et caractères spéciaux sont interdits"
        // Typo: !preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)
        // Working ? (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})$/', $password))

        $password = test_input($_POST['password']);
        if (strlen($password) < 8) {
            $passwordErr = "Le mot de passe doit contenir au moins 8 caractères.";
        } else if (!preg_match("#[0-9]+#", $password)) {
            $passwordErr =  "Le mot de passe doit contenir au moins 1 chiffre.";
        } else if (!preg_match("#[a-zA-Z]+#", $password)) {
            $passwordErr =  "Le mot de passe doit contenir au moins 1 lettre.";
        } else {
            $passwordErr =  "";
        }

        $password2 = test_input($_POST['password2']);
        if ($password != $password2) {
            $passwordErr =  "Les deux mots de passe ne sont pas identiques.";
        }
    }

    //* Save the form

    if (
        $userNameErr == "" && $emailErr == "" && $passwordErr == "" &&
        !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
    ) {
        BDD_insert_user($_POST['username'], $_POST['email'], $_POST['password']);
        //? Reset the var
        $userName = $email = $password = $password2 = "";


?>

        <script>
            window.setTimeout("location=('?id=login');", 3000);
        </script>

        <h1>Inscription enregistrée</h1>

    <?php
    } else {
    ?>
        <div class="txt-cntr">
            <form name="form" action="" method="post">
                <div>
                    <label>Identifiant</label>
                    </br>
                    <input type="text" name="username" value="<?php echo $userName; ?>" />
                    <?php if ($userNameErr != '') {
                        echo  "</br><p class='error-input'>" . $userNameErr . "</p>";
                    } ?>
                </div>

                <br>

                <div>
                    <label>Email</label>
                    </br>
                    <input type="email" name="email" value="<?php echo $email; ?>" />
                    <?php if ($emailErr != '') {
                        echo  "</br><p class='error-input'>" . $emailErr . "</p>";
                    } ?>
                </div>

                <br>

                <div>
                    <label>Mot de passe</label>
                    </br>
                    <input type="password" name="password" value="<?php echo $password; ?>" />
                </div>

                <br>

                <div>
                    <label>Mot de passe (vérification)</label>
                    </br>
                    <input type="password" name="password2" value="<?php echo $password2; ?>" />
                    <?php if ($passwordErr != '') {
                        echo  "</br><p class='error-input'>" . $passwordErr . "</p>";
                    } ?>
                </div>


                <br>
                <div>
                    <input id="subhome-rechercher" name="inscription" type="submit" value="Inscription" />
                </div>
            </form>
        </div>

<?php
    }
    // * Back to the index page if user is logged in
} else {
    $errormsg = true;
    header("Location: index.php");
}
?>