<?php
include_once("../../../config.php");

try {
	$db = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Échec lors de la connexion : ' . $e->getMessage();
}

$email_input = test_input($_POST["email"]);
if (empty($_POST['email']) || empty($_POST['password'])) { //*? Redirige vers la page connexion si l'utilisateur n'a pas rempli les champs Email ou Password
	$_SESSION['erreur'] = "invalid";
	redirection('?id=connection', $msg = "", $tps = 0);
} else if (!preg_match("/^[a-zA-Z0-9]*$/", $email_input)) { //*? Redirige vers la page connexion si l'utilisateur a utilisé des caractères spéciaux dans son identifiant
	$_SESSION['erreur'] = "spe_cara";
	redirection('?id=connection', $msg = "", $tps = 0);
} else {

	$select = $db->prepare('SELECT email FROM user WHERE email=:email');

	if (isset($_POST['email']) && isset($_POST['password'])) // Si les input email & password sont remplis.
	{

		//TODO Connecter à SQL et vérif les données

		$ldap_email = $_POST['email'];
		$ldap_password = $_POST['password'];

		$_SESSION['email'] = $_POST['email'];;

		redirection('?', $msg = "", $tps = 0);
	} else	// Sinon on renvoie une erreur
	{
		$_SESSION['erreur'] = "Erreur inconnue, veuillez contacter l'administrateur.";
	}
}
