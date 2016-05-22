<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html 
    PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html lang="pl">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
        <meta name="Author" content="Autor strony" />
        <title>Ogłoszenia Lokalne</title>

        <link rel="stylesheet" href="ourcss.css" type="text/css" />
        <script src="outjs.js"></script>
        <style type="text/css">

            input.upload { display: block; }

        </style>
    </head>

    <body>  
        <?php
        if (isset($_POST['tytul'])) {
            require_once("connect.php");
            require_once('appvars.php');
            mysqli_report(MYSQLI_REPORT_STRICT);
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            $tytul = mysqli_real_escape_string($polaczenie, $_POST['tytul']);
            $tresc = mysqli_real_escape_string($polaczenie, $_POST['tresc']);
            $id = $_SESSION['id'];
            try {
                if ($polaczenie->query("INSERT INTO ogloszenia (idogloszenia,idzarejestrowanego,tytul,tresc,dataogloszenia)VALUES (NULL,'$id','$tytul', '$tresc',NULL)")) {
                    //============================zdjęcia=============================== 
                    $wynik = $polaczenie->query("SELECT idogloszenia FROM ogloszenia ORDER BY idogloszenia DESC LIMIT 1");
                    $r = mysqli_fetch_object($wynik);
                    $idogloszenia = $r->idogloszenia;
                    $nrZdjecia = 0;
                    $czyJestZdjaca = true;
                    while ($czyJestZdjaca) {
                        $new_picture = mysqli_real_escape_string($polaczenie, $_FILES['new_picture']['name'][$nrZdjecia]);
                        $new_picture_type = $_FILES['new_picture']['type'][$nrZdjecia];
                        $new_picture_size = $_FILES['new_picture']['size'][$nrZdjecia];
                        list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name'][$nrZdjecia]);
                        // Walidacja i (w razie potrzeby) przenoszenie przesłanego pliku graficznego.
                        if (!empty($new_picture)) {
                            if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
                                    ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
                                    ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
                                if ($_FILES['new_picture']['error'][$nrZdjecia] == 0) {
                                    // Przenoszenie pliku do docelowego katalogu.
                                    $target = MM_UPLOADPATH . basename($new_picture);
                                    if (move_uploaded_file($_FILES['new_picture']['tmp_name'][$nrZdjecia], $target)) {
                                        $polaczenie->query("INSERT INTO zdjecia (idogloszenia,zdjecie)VALUES ('$idogloszenia','$new_picture')");
                                    } else {
                                        @unlink($_FILES['new_picture']['tmp_name'][$nrZdjecia]);
                                    }
                                }
                            } else {
                                @unlink($_FILES['new_picture']['tmp_name'][$nrZdjecia]);
                                echo '<H3 align=center class="correct">Musisz wybrać plik graficzny GIF, JPEG lub PNG o rozmiarze nie większym niż ' . (MM_MAXFILESIZE / 1024) .
                                ' (w kilobajtach) i ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' (w pikselach).</h3>';
                                exit();
                            }
                        } else {
                            $czyJestZdjaca = false;
                        }
                        $nrZdjecia++;
                    }
                    //==================================================================
                    header('Location: dodajogloszenie2.php');
                } else {
                    throw new Exception($polaczenie->error);
                }
            } catch (Exception $e) {
                echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                echo '<br />Informacja developerska: ' . $e;
            }
            $polaczenie->close();
            exit();
        }
        ?>

        <form method="post" enctype="multipart/form-data" >
            <fieldset>
                <legend>Dodaj Ogłoszene</legend>  
                Tytuł: <br /> <input type="text" name="tytul"  /> <br />
                Treść: <br /> <textarea  name="tresc" cols="60" rows="25"></textarea> <br />
                Zdjęcie:  
                <!-------------------------------------------//-->        
                <div class="upload" id="pliki">
                    <input type="button" value="Dodaj zdjęcie" onclick="dodaj_element('pliki');" />
                    <br />
                </div> 
                <!-------------------------------------------//-->           
                <br /> <input type="submit" value="Zatwierdź" />
            </fieldset>
        </form>



    </body>
</html>