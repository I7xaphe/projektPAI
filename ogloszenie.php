<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <?php
    session_start();
    ?>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href="ourcss.css" type="text/css" />
        <title>Ogloszenia lokalne</title>

    </head>
    <body >
        <?php
        require_once "connect.php";
        require_once "./appvars.php";
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        $wynik = $polaczenie->query("SELECT * FROM zarejestrowani RIGHT JOIN ogloszenia ON ogloszenia.idzarejestrowanego=zarejestrowani.id "
                . "LEFT JOIN zdjecia ON ogloszenia.idogloszenia=zdjecia.idogloszenia "
                . "ORDER BY dataogloszenia DESC")
                or die('Błąd zapytania');

        if (mysqli_num_rows($wynik) > 0) {
            $num_rows = mysqli_num_rows($wynik);
            $row = 0;
            while ($r[] = mysqli_fetch_object($wynik));
            for ($row = 0; $row < $num_rows; $row++) {
                echo '<form >';
                echo ' <fieldset> ';
                echo ' Tytuł: <br /> <input type="text" readonly  value="'. $r[$row]->tytul .'" /> <br />  ';
                echo ' Treść: <br /> <textarea cols="60" rows="25" readonly>' . $r[$row]->tresc . '</textarea> <br /> ';
                echo ' Data: <br /> <input type="text" value="' . $r[$row]->dataogloszenia . '" readonly /> <br />';
                echo 'Użytkownik: <br /> <input type="text" value="' . $r[$row]->nazwauzytkownika . '" readonly /> <br />';
                echo 'Kontakt: <br /> <input type="text" value="' . $r[$row]->kontakt . '" readonly/> <br />';
                while (is_file(MM_UPLOADPATH . $r[$row]->zdjecie)) {
                    echo '<img src="' . MM_UPLOADPATH . $r[$row]->zdjecie . '"/>';
                    echo '<input type="hidden" value="' . $r[$row]->zdjecie . '" name="zdjecie"  />';
                    if ($r[$row]->idogloszenia == @$r[++$row]->idogloszenia) {
                        
                    } else {
                        $row--;
                        break;
                    }
                }
                echo '</fieldset></form>';
            }
            $polaczenie->close();
        }
        ?> 
    </body>
</html>