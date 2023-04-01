<?php
if (isset($_SESSION['username'])) {
    if (session_destroy()) {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
