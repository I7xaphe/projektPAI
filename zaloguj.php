
<?php
session_start();

if (isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submitLogin'])) {
    require_once "connect.php";
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    if ($polaczenie->connect_errno != 0) {
        echo "Error: " . $polaczenie->connect_errno;
    } else {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];
        $zapytanie = 'SELECT * FROM zarejestrowani WHERE nazwauzytkownika="' . mysqli_real_escape_string($polaczenie, $login) . '"';
        if ($rezultat = $polaczenie->query($zapytanie)) {
            if ($rezultat->num_rows) {
                $wiersz = $rezultat->fetch_assoc();
                if (password_verify($haslo, $wiersz['haslo'])) {
                    if ($_POST['zapamietaj'] != null) {
                        setcookie('username', $login, time() + (86400 * 30), "/");
                        setcookie('password', $haslo, time() + (86400 * 30), "/");
                    }
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
                    header('Location: zaloguj2.php');
                } else {
                    $_SESSION['blad'] = '<span class="error">Nieprawidłowe hasło!</span>';
                }
            } else {
                $_SESSION['blad'] = '<span class="error">Nieprawidłowy login!</span>';
            }
        }

        $polaczenie->close();
    }
}
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Ogloszenia lokalne</title>
        <link rel="stylesheet" href="ourcss.css" type="text/css" />
    </head>
    <body>

        <form method="post">
            <fieldset>
                <legend>Zaloguj się</legend>
                Login: <br /> <input type="text" name="login" value=' ' /> <br />
                Hasło: <br /> <input type="password" name="haslo" value='' /> <br />
                Zapamietaj mnie:<br /><input type="checkbox" name="zapamietaj" /><br />
                <?php
                if (isset($_SESSION['blad'])) {
                    echo $_SESSION['blad'] . "<br />";
                }
                unset($_SESSION['blad']);
                ?>
                <input type="submit" value="Zaloguj się" name="submitLogin" />
            </fieldset>
        </form>

    </body>
</html>