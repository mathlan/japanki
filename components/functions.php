<?php
require  'database.php';

//? ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~ USERS ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~

//* Test input values ✓✓✓
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//* Check if user already exists in DB ✓✓✓
function BDD_check_membre($user)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = '" . $user . "'");
    $stmt->execute();
    $resUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $resUser > 0 ? $existUser = true : $existUser = false;
    return $existUser;
    Database::disconnect();
}

//* Insert user in DB ✓✓✓
function BDD_insert_user($username, $email, $password)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO user (username, email, password) values(?, ?, ?)";
    $sth = $pdo->prepare($sql);
    $sth->execute(array($username, $email, hash('sha256', $password)));
    Database::disconnect();
}

//* Logging in ✓✓✓
function login($username, $password)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", hash('sha256', $password));
    $stmt->execute();

    // If there is only one line with these data, connection is accepted.
    if ($stmt->rowCount() == 1) {
        $_SESSION['username'] = $username;
        // Retrieving user data to stock them in session.
        $data = $stmt->fetch();
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        header("Location: index.php");
        // If there are more OR no data, connection is refused.
    } else {
        $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        return $message;
    }
}

//? ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~ CARDS ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~

//* Inserting card ✓✓✓
function insert_card($user, $title, $card, $date, $img, $shared, $status)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO card (user, title, card, date, img, shared, status) VALUES (:user, :title, :card, :date, :img, :shared, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':card', $card);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam('img', $img);
    $stmt->bindParam(':shared', $shared);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    Database::disconnect();
}

//* Displaying user cards ✓✓✓ (returning an array)
function fetch_cards($id, $status)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM card WHERE user = :user AND status = :status");
    $stmt->bindValue(":user", $id);
    $stmt->bindValue(":status", $status);
    $stmt->execute();
    $cards = $stmt->fetchAll();
    return $cards;
    Database::disconnect();
}

//* Returning the id of the card owner ✓✓✓
function card_owner($idcard)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT user FROM card WHERE id = :id");
    $stmt->bindValue(":id", $idcard);
    $stmt->execute();
    $owner = $stmt->fetch(PDO::FETCH_ASSOC);
    return $owner["user"];
    Database::disconnect();
}

//* Displaying selected card ✓✓✓
function display_card($idcard)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM card WHERE id = :id");
    $stmt->bindValue(":id", $idcard);
    $stmt->execute();
    $card = $stmt->fetch();
    return $card;
    Database::disconnect();
}

//* Update card ✓✓✓
function update_card($id, $title, $card)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE card SET title=:title, card=:card WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':card', $card);
    $stmt->execute();
    Database::disconnect();
}

//! Delete card ✓✓✓
function delete_card($id)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM card WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    Database::disconnect();
}

//? ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~ UPLOAD / CARD PIC ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~

//* Inserting profile pic ✓✓✓
function insert_card_pic($id_card, $name_pic, $status_pic)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO card_pic (id_card, name_pic, status_pic) VALUES (:id_card, :name_pic, :status_pic)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_card', $id_card);
    $stmt->bindParam(':name_pic', $name_pic);
    $stmt->bindParam(':status_pic', $status_pic);
    $stmt->execute();
    Database::disconnect();
}

//* Displaying profile pic ✓✓✓
function card_pic($id)
{
    $pdo = Database::connect();
    $pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlImg = "SELECT * FROM card_pic WHERE id_card= :id";
    $stmt = $pdo->prepare($sqlImg);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $cardpic = "<img class='updatePic' src='cardpic/no-photo.png'>";
    while ($rowImg = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($rowImg['status_pic'] == 1) {
            $cardpic = "<img class='updatePic' src='cardpic/" . $rowImg['name_pic'] . "'>";
        }
    }
    return $cardpic;
    Database::disconnect();
}

//* Erasing profile pic ✓✓✓
function delete_card_pic($idcard)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM card_pic WHERE id_card = :idcard";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idcard', $idcard);
    $stmt->execute();
    Database::disconnect();
}

//? ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~ UPLOAD / PROFILE PIC ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~

//* Inserting profile pic ✓✓✓
function insert_ppic($iduser, $nameppic, $statusppic)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO user_ppic (id_user, name_ppic, status_ppic) VALUES (:iduser, :nameppic, :statusppic)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':iduser', $iduser);
    $stmt->bindParam(':nameppic', $nameppic);
    $stmt->bindParam(':statusppic', $statusppic);
    $stmt->execute();
    Database::disconnect();
}

//* Displaying profile pic ✓✓✓
function ppic($id)
{
    $pdo = Database::connect();
    $pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlImg = "SELECT * FROM user_ppic WHERE id_user= :id";
    $stmt = $pdo->prepare($sqlImg);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $ppic = "<img src='ppic/no-photo.png'>";
    while ($rowImg = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($rowImg['status_ppic'] == 1) {
            $ppic = "<img src='ppic/" . $rowImg['name_ppic'] . "'>";
        }
    }
    return $ppic;
    Database::disconnect();
}

//* Erasing profile pic ✓✓✓
function delete_ppic($idUser)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM user_ppic WHERE id_user = :idUser";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
    Database::disconnect();
}

//? ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~ PLAY ~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~_~

// Récupère le deck du joueur
function getDeck($id)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM card WHERE user = :user AND status = 2");
    $stmt->bindValue(":user", $id);
    $stmt->execute();
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $cards;
}

// Stock le résultat du joueur
function update_known($id, $known)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE card SET known=:known WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':known', $known);
    $stmt->execute();
    Database::disconnect();
}

// Stats
function fetch_stats($user)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT known FROM card WHERE user = :user");
    $stmt->bindValue(":user", $user);
    $stmt->execute();
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $worst = 0;
    $bad = 0;
    $normal = 0;
    $good = 0;
    $best = 0;

    foreach ($stats as $stat) {
        if ($stat['known'] == 1) {
            $worst++;
        } else if ($stat['known'] == 2) {
            $bad++;
        } else if ($stat['known'] == 3) {
            $normal++;
        } else if ($stat['known'] == 4) {
            $good++;
        } else if ($stat['known'] == 5) {
            $best++;
        }
    }
    $arrayStats = [$worst, $bad, $normal, $good, $best];
    return $arrayStats;
    Database::disconnect();
}
