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

    <body>
        <table align="center">
            <tr>
                <th colspan="2"><iframe frameborder="6" scrolling="no"  height="80" width="888"  name="ogloszenie"  src="ogloszenialokalne.php" ></iframe></th>
               
            
            <tr>
                <td ><iframe id='spis' frameborder="3" scrolling="no"  height="860" width="180"  name="spis"  src="spis.php" ></iframe></td>
                <td><iframe frameborder="3"  scrolling="yes"  height="860" width="700"  name="AktualnaStrona" src="ogloszenie.php" ></iframe></td>
            </tr>
        </table>


    </body>   

</html>