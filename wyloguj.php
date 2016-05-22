<?php
session_start();
//  unset($_SESSION('zalogowany'));
setcookie('username', "", time() - (86400 * 30), "/");
setcookie('password', "", time() - (86400 * 30), "/");
session_unset();
?>

<!DOCTYPE html 
    PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html lang="pl">
    <head>
        <meta charset="iso-8859-2"/>
        <title>Ogłoszenia Lokalne</title>
        <script src="outjs.js"></script>
    </head>
    <body>
        <H3 align=center>Zostałeś wylogowany</h3>
        <script>
            refresh_spis();
        </script>
    </body>

</html>