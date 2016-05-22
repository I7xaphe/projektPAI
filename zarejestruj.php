<?php
session_start();
if (isset($_POST['submit'])) {
    $wszystko_OK = true;
    //==========================================================================
    require_once "connect.php";
    require_once "appvars.php";
    //nie pokazywało błedów
    mysqli_report(MYSQLI_REPORT_STRICT);
    if (!$polaczenie = new mysqli($host, $db_user, $db_password, $db_name)) {
        $wszystko_OK = false;
    }
    //Sprawdź poprawność nickname'a
    $nick = $_POST['nick'];
    //Sprawdzenie długości nicka
    if ((strlen($nick) < MM_NICK_MIN) || (strlen($nick) > MM_NICK_MAX)) {
        $wszystko_OK = false;
        $_SESSION['e_nick'] = "Nick musi posiadać od " . MM_NICK_MIN . " do " . MM_NICK_MAX . " znaków!";
    }
    if (ctype_alnum($nick) == false) {
        $wszystko_OK = false;
        $_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
    }
    //==========================================================================
    $imie = $_POST['imie'];
    if (ctype_alpha($imie) == false) {
        $wszystko_OK = false;
        $_SESSION['e_imie'] = "Imie może zawierać tylko litery ";
    }
    //==========================================================================
    $nazwisko = $_POST['nazwisko'];
    if (ctype_alpha($nazwisko) == false) {
        $wszystko_OK = false;
        $_SESSION['e_nazwisko'] = "Nazwisko może zawierać tylko litery ";
    }
    //==========================================================================
    // Sprawdź poprawność adresu email
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $wszystko_OK = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
    }
    //==========================================================================
    // Sprawdź poprawność kontaktu
    $kontakt = mysqli_real_escape_string($polaczenie, $_POST['kontakt']);

    if ($kontakt != $_POST['kontakt']) {
        $wszystko_OK = false;
        $_SESSION['e_kontakt'] = "Podaj poprawny kontakt do siebie";
    }
    //==========================================================================
    //Sprawdź poprawność hasła
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if ((strlen($haslo1) < MM_HASLO_MIN) || (strlen($haslo1) > MM_HASLO_MAX)) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadać od od " . MM_HASLO_MIN . " do " . MM_HASLO_MAX . " znaków!";
    }

    if ($haslo1 != $haslo2) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
    //==========================================================================
    //Zapamiętaj wprowadzone dane
    $_SESSION['fr_nick'] = $nick;
    $_SESSION['fr_imie'] = $imie;
    $_SESSION['fr_nazwisko'] = $nazwisko;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_haslo1'] = $haslo1;
    $_SESSION['fr_haslo2'] = $haslo2;
    $_SESSION['fr_kontakt'] = $kontakt;
    //==========================================================================
    try {
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            //===============================================
            //Czy email już istnieje?
            $rezultat = $polaczenie->query("SELECT id FROM zarejestrowani WHERE email='$email'");
            if (!$rezultat)
                throw new Exception($polaczenie->error);
            if ($rezultat->num_rows > 0) {
                $wszystko_OK = false;
                $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
            }
            //===============================================
            //Czy nick jest już zarezerwowany?
            $rezultat = $polaczenie->query("SELECT id FROM zarejestrowani WHERE nazwauzytkownika='$nick'");
            if (!$rezultat)
                throw new Exception($polaczenie->error);
            if ($rezultat->num_rows > 0) {
                $wszystko_OK = false;
                $_SESSION['e_nick'] = "Istnieje już gracz o takim nicku! Wybierz inny.";
            }
            //===============================================
            if ($wszystko_OK == true) {
                if ($polaczenie->query("INSERT INTO zarejestrowani (id,haslo,nazwauzytkownika,email,imie,nazwisko,datarejestracji,kontakt)VALUES (NULL,'$haslo_hash','$nick', '$email','$imie','$nazwisko',NULL,'$kontakt')")) {
                    echo "<H3 align=center>Zostałeś zarejestrowany</h3>";
                    exit();
                } else {
                    throw new Exception($polaczenie->error);
                }
            }
            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br />Informacja developerska: ' . $e;
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

        <form action="zarejestruj.php" method="post">
            <fieldset>
                <legend>Zarejestruj się</legend>
                <!--==========================================================================-->
                Nazwa Użytkownika: <br /> <input type="text" value="<?php
                if (isset($_SESSION['fr_nick'])) {
                    echo $_SESSION['fr_nick'];
                    unset($_SESSION['fr_nick']);
                }
                ?>" name="nick" /><br />

                <?php
                if (isset($_SESSION['e_nick'])) {
                    echo '<span class="error">' . $_SESSION['e_nick'] . '</span></br>';
                    unset($_SESSION['e_nick']);
                }
                ?>
                <!--==========================================================================-->
                Imię: <br /> <input type="text" value="<?php
                if (isset($_SESSION['fr_imie'])) {
                    echo $_SESSION['fr_imie'];
                    unset($_SESSION['fr_imie']);
                }
                ?>" name="imie" /><br />

                <?php
                if (isset($_SESSION['e_imie'])) {
                    echo '<span class="error">' . $_SESSION['e_imie'] . '</span></br>';
                    unset($_SESSION['e_imie']);
                }
                ?>   
                <!--==========================================================================-->
                Nazwisko: <br /> <input type="text" value="<?php
                if (isset($_SESSION['fr_nazwisko'])) {
                    echo $_SESSION['fr_nazwisko'];
                    unset($_SESSION['fr_nazwisko']);
                }
                ?>" name="nazwisko" /><br />

                <?php
                if (isset($_SESSION['e_nazwisko'])) {
                    echo '<span class="error">' . $_SESSION['e_nazwisko'] . '</span></br>';
                    unset($_SESSION['e_nazwisko']);
                }
                ?>
                <!--==========================================================================-->
                E-mail: <br /> <input type="text" value="<?php
                if (isset($_SESSION['fr_email'])) {
                    echo $_SESSION['fr_email'];
                    unset($_SESSION['fr_email']);
                }
                ?>" name="email" /><br />

                <?php
                if (isset($_SESSION['e_email'])) {
                    echo '<span class="error">' . $_SESSION['e_email'] . '</span></br>';
                    unset($_SESSION['e_email']);
                }
                ?>
                <!--==========================================================================-->
                Kontakt: <br /> <input type="text" value="<?php
                if (isset($_SESSION['fr_kontakt'])) {
                    echo $_SESSION['fr_kontakt'];
                    unset($_SESSION['fr_kontakt']);
                }
                ?>" name="kontakt" /><br />

                <?php
                if (isset($_SESSION['e_kontakt'])) {
                    echo '<span class="error">' . $_SESSION['e_kontakt'] . '</span></br>';
                    unset($_SESSION['e_kontakt']);
                }
                ?>
                <!--==========================================================================-->
                Twoje hasło: <br /> <input type="password"  value="<?php
                if (isset($_SESSION['fr_haslo1'])) {
                    echo $_SESSION['fr_haslo1'];
                    unset($_SESSION['fr_haslo1']);
                }
                ?>" name="haslo1" /><br />


                <!--==========================================================================-->
                Powtórz hasło: <br /> <input type="password" value="<?php
                if (isset($_SESSION['fr_haslo2'])) {
                    echo $_SESSION['fr_haslo2'];
                    unset($_SESSION['fr_haslo2']);
                }
                ?>" name="haslo2" /><br />

                <?php
                if (isset($_SESSION['e_haslo'])) {
                    echo '<span class="error">' . $_SESSION['e_haslo'] . '</span></br>';
                    unset($_SESSION['e_haslo']);
                }
                ?>

                <br />

                <input type="submit" name="submit" value="Zarejestruj się" />
            </fieldset>
        </form>

    </body>
</html>