<?php
if (!isset($_SESSION['username'])) {
    require_once('config.php');
    require_once('database.php');
    $errorSignUp = '';

    if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])) {

        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($conn, $username);

        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($conn, $email);

        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);

        // If user doesn't exist --> Query step
        if (BDD_check_membre($username) == false) {
            $query = "INSERT into `user` (username, email, password) VALUES ('$username', '$email', '" . hash('sha256', $password) . "')";
            // Query MySQL (connection, query)
            $res = mysqli_query($conn, $query);
            // If query goes true --> Out
            if ($res) {
                echo "<div class='sucess'>
                 <h3>Vous êtes inscrit avec succès.</h3>
                 <p>Cliquez ici pour vous <a href='?id=login'>connecter</a></p>
           </div>";
            } else {
                $errorSignUp = "Erreur de base données";
            }
        } else {
            $errorSignUp = "L'utilisateur existe déjà.";
        }
        // If POST is not complete --> Back to the form
    } else {
?>
        <form action="" method="post">
            <h1>S'inscrire</h1>
            <input type="text" name="username" placeholder="Nom d'utilisateur" />
            <input type="text" name="email" placeholder="Email" />
            <input type="password" name="password" placeholder="Mot de passe" />
            <?php
            if ($errorSignUp != '') {
                echo "<p>" . $errorSignUp . "</p>";
            }
            ?>
            <input type="submit" name="submit" value="S'inscrire" />
            <p>Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
        </form>
<?php
    }
} else {
    header("Location: index.php");
}
?>