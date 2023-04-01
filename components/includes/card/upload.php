<?php
session_start();
require_once('../../functions.php');

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// ? Variables
$id = $_GET['idcard'];
$target_dir = "../../../cardpic/"; // Server directory
$file_name = $_FILES["uploadcardpic"]["name"]; // Client name
$file_tmpname = $_FILES["uploadcardpic"]["tmp_name"]; // Temp file name
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION); // Client file extension
$file_new_name = $id . "." . $file_ext; // Server name
$target_file = $target_dir . $id . "." . $file_ext; // Directory + ID(file name) + File extension
$check_file = $target_dir . $id . ".*"; // Directory + ID + any ext.
$sameidfiles = glob($check_file); // Creates an array with all the files having the same ID (then we can delete them all in a row)
$uploadOk = 1; // Upload is ok at first sight
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Temp file name to lower
$error = []; // Array to catch errors, only the first [0] is shown at the end since it is the first error to come

// ? Check if image file is an actual or fake image + if it has been uploaded with HTTP POST
// if (isset($_POST["submit"])) {
if (is_uploaded_file($file_tmpname)) {
    // Notice how to grab MIME type.
    $mime_type = mime_content_type($file_tmpname);

    // If you want to allow certain files
    $allowed_file_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
    if (!in_array($mime_type, $allowed_file_types)) {
        array_push($error, "Désolé, seuls les formats JPG, JPEG, PNG & GIF sont autorisés.");
        $uploadOk = 0;
    }
} else {
    array_push($error, "Désolé, ce format d'image ne convient pas, certaines résolutions HD ne sont pas acceptées");
    $uploadOk = 0;
}
// }

// ? Check file size
if ($_FILES["uploadcardpic"]["size"] > 2000000) {
    array_push($error, "Désolé, votre fichier est trop volumineux. (max. 2000ko)");
    $uploadOk = 0;
}

// ? Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    array_push($error, "Désolé, seuls les formats JPG, JPEG, PNG & GIF sont autorisés.");
    $uploadOk = 0;
}
// ? Check if $uploadOk is set to 0 = error
if ($uploadOk == 0) {
    echo $error[0];
    // if everything is ok, try to upload file
} else {
    // ? First, deletes the line of the user in DB, then, deletes the pic in local
    if (!empty(glob($check_file))) {
        // * Deletes image sql info
        delete_card_pic($id);

        // * Deletes image(s) in the local folder

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT name_pic FROM card_pic WHERE id_card= '" . $id . "'";
        $res = $pdo->query($sql);
        $fichier = $res->fetchColumn();
        Database::disconnect();

        // * Catch multiples files with the same ID
        foreach ($sameidfiles as $todelete) {
            unlink($todelete);
        }
    }

    // ? Creates a new local file
    if (move_uploaded_file($_FILES["uploadcardpic"]["tmp_name"], $target_file)) {

        // ? And a new DB line
        insert_card_pic($id, $file_new_name, $uploadOk);
        echo "Le fichier " . htmlspecialchars(basename($_FILES["uploadcardpic"]["name"])) . " a bien été téléchargé.";
        header("Location: ../../../index.php?id=dashboard");
    } else {
        echo "Désolé, une erreur innatendue est survenue, veuillez contacter le responsable du site si le problème persiste.";
    }
}