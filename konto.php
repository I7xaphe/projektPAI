<link rel="stylesheet" href="ourcss.css" type="text/css" />
<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Ogloszenia lokalne</title>

            
    </head>

    <body>

        <form  method="post" action="kontoDane.php">
            <fieldset>
                
                <?php
                if (isset($_SESSION['aktualizacja_dane'])) {
                    echo '<span class="correct">'.$_SESSION['aktualizacja_dane'].'</span><br />';
                    unset($_SESSION['aktualizacja_dane']);
                }
                ?>
                <legend>Dane Osobowe</legend>  
                <!--==========================================================================-->
                Imię: <br /> <input type="text" value="<?php
                echo $_SESSION['imie'];
                ?>" name="imie" /><br />

                <!--==========================================================================-->
                Nazwisko: <br /> <input type="text" value="<?php
                echo $_SESSION['nazwisko'];
                ?>" name="nazwisko" /><br />

                <!--==========================================================================-->
                E-mail: <br /> <input type="text" value="<?php
                echo $_SESSION['email'];
                ?>" name="email" /><br />

                <!--==========================================================================-->
                Kontakt: <br /> <input type="text" value="<?php
                echo $_SESSION['kontakt'];
                ?>" name="kontakt" /><br />

                <!--==========================================================================-->
                <br />
                <?php
                if (isset($_SESSION['error_dane'])) {
                    echo '<span class="error">'.$_SESSION['error_dane'].'</span><br />';
                    unset($_SESSION['error_dane']);
                }
                ?>

                <center><input type="submit" value="Zmień dane" name="submitDane"/></center>

            </fieldset>
        </form>
        <form  method="post" action="kontoHaslo.php">
            <fieldset>
                <?php
                if (isset($_SESSION['aktualizacja_haslo'])) {
                    echo '<span class="correct">'.$_SESSION['aktualizacja_haslo'].'</span><br />';
                    unset($_SESSION['aktualizacja_haslo']);
                }
                ?>
                <legend>Zmień Hasło</legend>  
                Nowe Hasło: <br /> <input type="password"  name="haslo1" /><br />

                <!--==========================================================================-->
                Powtórz Nowe Hasło: <br /> <input type="password" name="haslo2" /><br />

                <!--==========================================================================-->
                <br />
                <?php
                if (isset($_SESSION['error_haslo'])) {
                    echo '<span class="error">'.$_SESSION['error_haslo'].'</span><br />';
                    unset($_SESSION['error_haslo']);
                }
                ?>
                <center><input type="submit" value="Zmień haslo" name="submitHaslo"  /></center>

            </fieldset>
        </form>

    </body>
</html>