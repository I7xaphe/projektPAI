<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}
?>

<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Ogloszenia lokalne</title>
    </head>
    <body>
        <H3 align=center>Ogloszenie zostało dodane do twojego konta</h3>
    </body>
</html>