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
                exit('<H3 align=center class="error">Musisz podać nick i haslo aby zmienic dane osobowe.</h3>');
            }
        } else {
            $_SESSION['autoryzacja'] = true;
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            exit('<H3 align=center class="error">Musisz podać nick i haslo aby zmienic dane osobowe.</h3>');
        }
        if (isset($_POST['submitDane'])) {
            require_once "connect.php";
            if ($polaczenie = new mysqli($host, $db_user, $db_password, $db_name)) {
                $id = mysqli_real_escape_string($polaczenie, $_SESSION['id']);
                $email = mysqli_real_escape_string($polaczenie, $_POST['email']);
                $imie = mysqli_real_escape_string($polaczenie, $_POST['imie']);
                $nazwisko = mysqli_real_escape_string($polaczenie, $_POST['nazwisko']);
                $kontakt = mysqli_real_escape_string($polaczenie, $_POST['kontakt']);
                $wszystko_OK = true;
                //==========================================================================
                if (ctype_alpha($imie) == false) {
                    $wszystko_OK = false;
                    $_SESSION['error_dane'] = "Imie może zawierać tylko litery";
                }
                //==========================================================================
                if (ctype_alpha($nazwisko) == false) {
                    $wszystko_OK = false;
                    $_SESSION['error_dane'] = "Nazwisko może zawierać tylko litery";
                }
                //==========================================================================
                $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
                if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
                    $wszystko_OK = false;
                    $_SESSION['error_dane'] = "Podaj poprawny adres e-mail!";
                }
                //==========================================================================
                $rezultat = $polaczenie->query("SELECT id FROM zarejestrowani WHERE email='$email' AND id!=$id");
                if ($rezultat->num_rows > 0) {
                    $wszystko_OK = false;
                    $_SESSION['error_dane'] = "Istnieje już konto przypisane do tego adresu e-mail!";
                }
                //==========================================================================
                if ($wszystko_OK == true) {
                    if ($wynik = $polaczenie->query("UPDATE zarejestrowani SET email='$email',imie='$imie',nazwisko='$nazwisko',kontakt='$kontakt' WHERE id='$id'")) {
                        $_SESSION['email'] = $email;
                        $_SESSION['imie'] = $imie;
                        $_SESSION['nazwisko'] = $nazwisko;
                        $_SESSION['kontakt'] = $kontakt;

                        $_SESSION['aktualizacja_dane'] = "Dane zostały zaktualizowane";
                        header('Location: konto.php');
                    } else {
                        echo "Błąd podczas zmian";
                    }
                } else {
                    header('Location: konto.php');
                }
            } else {
                echo "Błąd połączenia z Bazą danych";
            }
            $polaczenie->close();
        }
        ?>
    </body>
</html>
