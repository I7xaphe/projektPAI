<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        <link rel="stylesheet" href="ourcss.css" type="text/css" />
        <title>Ogloszenia lokalne</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['autoryzacja'])) {
            if (@$_SERVER['PHP_AUTH_USER'] == $_SESSION['nazwauzytkownika'] && password_verify(@$_SERVER['PHP_AUTH_PW'], $_SESSION['haslo'])) {
                unset($_SESSION['autoryzacja']);
            } else {
                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');
                exit('Musisz podać aktualne nazwe i haslo aby zmienic haslo na nowe.');
            }
        } else {
            $_SESSION['autoryzacja'] = true;
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            exit('Musisz podać aktualne nazwe i haslo aby zmienic haslo na nowe.');
        }
        if (isset($_POST['submitHaslo'])) {
            require_once "connect.php";
            $wszystko_OK = true;
            if ($polaczenie = new mysqli($host, $db_user, $db_password, $db_name)) {
                $haslo1 = $_POST['haslo1'];
                $haslo2 = $_POST['haslo2'];
                $id = $_SESSION['id'];

                if ((strlen($haslo1) < 3) || (strlen($haslo1) > 15)) {
                    $wszystko_OK = false;
                    $_SESSION['error_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
                }
                if ($haslo1 != $haslo2) {
                    $wszystko_OK = false;
                    $_SESSION['error_haslo'] = "Podane hasła nie są identyczne!";
                }
                if ($wszystko_OK == true) {
                    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
                    if ($wynik = $polaczenie->query("UPDATE zarejestrowani SET haslo='$haslo_hash' WHERE id='$id'")) {

                        $_SESSION['haslo'] = $haslo_hash;
                        $_SESSION['aktualizacja_haslo'] = "Hasło zostało zaktualizowane";
                        header('Location: konto.php');
                    } else {
                        echo "Nie udało się dokonać zmian błąd połączenia z bazą danych";
                    }
                } else {
                    header('Location: konto.php');
                }
                $polaczenie->close();
                exit();
            } else {
                echo "Błąd połączenia z Bazą danych";
            }
        }
        ?>
    </body>
</html>
