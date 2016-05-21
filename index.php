<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    require_once "connect.php";
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $zapytanie = 'SELECT * FROM zarejestrowani WHERE nazwauzytkownika="' . mysqli_real_escape_string($polaczenie, $_COOKIE['username']) . '"';
    if ($rezultat = $polaczenie->query($zapytanie)) {
        if ($rezultat->num_rows) {
            $wiersz = $rezultat->fetch_assoc();
            if (password_verify($_COOKIE['password'], $wiersz['haslo'])) {
                session_start();
                $_SESSION['zalogowany'] = true;
                $_SESSION['haslo'] = $wiersz['haslo'];
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['nazwauzytkownika'] = $wiersz['nazwauzytkownika'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['imie'] = $wiersz['imie'];
                $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                $_SESSION['datarejestracji'] = $wiersz['datarejestracji'];
                $_SESSION['kontakt'] = $wiersz['kontakt'];
                unset($_SESSION['blad']);
                $rezultat->free_result();
            }
        }
    }
}
?>
<!DOCTYPE html 
    PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html lang="pl">
    <head>
        <meta charset="iso-8859-2"/>
        <title>Ogłoszenia Lokalne</title>
        <link rel="stylesheet" href="ourcss.css" type="text/css" />
    </head>
    <frameset cols="300,*" border="10" frameborder="10" framespacing="0">
        <frame name="spis"  frameborder="10" src="spis.php" />
        <frame name="AktualnaStrona" frameborder="10" src="ogloszenie.php" />
    </frameset>
</html>