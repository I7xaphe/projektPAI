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
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <script> function refresh_spis() {
                parent.spis.location.reload();
            }</script>      
    </head>

    <body>

        <form  method="post" action="kontoDane.php">
            <fieldset>
                
                <?php
                if (isset($_SESSION['aktualizacja_dane'])) {
                    echo '<span style="color:green;">'.$_SESSION['aktualizacja_dane'].'</span>';
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
                    echo '<span style="color:red;">'.$_SESSION['error_dane'].'</span>';
                    unset($_SESSION['error_dane']);
                }
                ?>

                <input type="submit" value="Zmień dane" name="submitDane"/>

            </fieldset>
        </form>
        <form  method="post" action="kontoHaslo.php">
            <fieldset>
                <?php
                if (isset($_SESSION['aktualizacja_haslo'])) {
                    echo '<span style="color:green;">'.$_SESSION['aktualizacja_haslo'].'</span>';
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
                    echo '<span style="color:red;">'.$_SESSION['error_haslo'].'</span>';
                    unset($_SESSION['error_haslo']);
                }
                ?>
                <input type="submit" value="Zmień haslo" name="submitHaslo"  />

            </fieldset>
        </form>

    </body>
</html>