<?php
function login2($username, $password)
{
    // Prepare and execute the statement
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = :username');
    $stmt->execute(array('username' => $username));
    $result = $stmt->fetch();

    // Verify the password
    if ($result && password_verify($password, $result['password'])) {
        // Login successful
        // session_start();
        $_SESSION['user_id'] = $result['id'];
        header("Location: index.php");
        exit();
    } else {
        // Login failed
        header('Location: login.php?error=1');
        exit();
    }
}

function login3($username, $password)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", hash('sha256', $password));
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

//! TEST TEST TEST TEST TEST

function session($username)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch();

    $_SESSION['id'] = $result['id'];
}
