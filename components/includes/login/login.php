<?php
if (!isset($_SESSION['username'])) {

    require_once('config.php');

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        login($username, $password, $conn);
    }
?>
    <form action="" method="post" name="login">
        <h1>Connexion</h1>
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="submit" value="Connexion " name="submit">
        <p>Pas encore inscrit ? <a href="index.php?id=signup">S'inscrire</a></p>
        <?php if (!empty($message)) { ?>
            <p class="errorMessage"><?php echo $message; ?></p>
        <?php } ?>
    </form>
<?php
} else {
    header("Location: index.php");
}


// function login($username, $password, $conn)
// {
//     $query = "SELECT * FROM users WHERE username=:username AND password=:password";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':username', $username);
//     $stmt->bindParam(':password', $password);
//     $stmt->execute();

//     $count = $stmt->rowCount();
//     if ($count == 1) {
//         $_SESSION['username'] = $username;
//         header("Location: index.php");
//     } else {
//         $message = "Nom d'utilisateur ou mot de passe incorrect.";
//     }
// }
// 
?>