<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html 
    PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Ogloszenia lokalne</title>
        <link rel="stylesheet" href="ourcss.css" type="text/css" />
        <script src="outjs.js"></script>
    </head>
    <body>
        <H3 align=center class="correct">Zostałeś zalogowany</h3>
        <script>
            refresh_spis();
        </script>
    </body>
</html>