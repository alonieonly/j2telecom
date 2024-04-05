<?php
    session_start();
    $_SESSION["logged_user"] = null;
    header("Location: http://localhost/inter-2024/login.php");
?>