<link rel="stylesheet" href="ourcss.css" type="text/css" />
<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}
require_once "connect.php";
require_once "appvars.php";
$id = $_SESSION['id'];
//===============================================================================
if (isset($_POST['usun'])) {
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $idogloszenia = $_POST['idogloszenia'];
    if ($polaczenie->query("DELETE ogloszenia.*,zdjecia.* FROM ogloszenia LEFT JOIN zdjecia ON zdjecia.idogloszenia=ogloszenia.idogloszenia WHERE ogloszenia.idogloszenia='$idogloszenia'")) {
        $i = 0;
        while (isset($_POST['zdjecie'][$i])) {
            @unlink(MM_UPLOADPATH . $_POST['zdjecie'][$i++]);
        }

        echo "Ogloszenie " . $idogloszenia . " zostało usunięte";
    } else {
        echo "Błąd ogloszenie nie zstało usunięte";
    }
    $polaczenie->close();
    exit();
}
//===============================================================================
if (isset($_POST['zmien'])) {
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $idogloszenia = $_POST['idogloszenia'];
    $tresc = $_POST['tresc'];
    $tytul = $_POST['tytul'];
    if ($polaczenie->query("UPDATE ogloszenia SET tytul='$tytul',tresc='$tresc',dataogloszenia=CURRENT_TIMESTAMP WHERE idogloszenia='$idogloszenia'")) {
        echo "Ogloszenie " . $idogloszenia . " zostało zmienione";
    } else {
        echo "Błąd ogloszenie nie zostało zmienione";
    }
    $polaczenie->close();
    exit();
}
//===============================================================================
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$wynik = $polaczenie->query("SELECT ogloszenia.idogloszenia,tytul,tresc,dataogloszenia,zdjecie FROM ogloszenia LEFT JOIN zdjecia ON zdjecia.idogloszenia=ogloszenia.idogloszenia WHERE"
        . "(idzarejestrowanego='$id') ORDER BY dataogloszenia DESC")
        or die('Błąd zapytania');

if (mysqli_num_rows($wynik) > 0) {
    $num_rows = mysqli_num_rows($wynik);
    $row = 0;
    while ($r[] = mysqli_fetch_object($wynik));
    for ($row = 0; $row < $num_rows; $row++) {
        echo '<form  method="post" onsubmit="return confirm("czy napewno chcesz modyfikować ogłoszenie?")">';
        echo ' <fieldset> ';
        echo '<input type="hidden" value="' . $r[$row]->idogloszenia . '" name="idogloszenia"/>';
        echo ' Tytuł: <br /> <input type="text" name="tytul" value="' . $r[$row]->tytul . '"  /> <br />   ';
        echo ' Treść: <br /> <textarea cols="60" rows="25" name="tresc" >' . $r[$row]->tresc . '</textarea> <br />';
        echo ' Data : <br /> <input type="text" readonly value="' . $r[$row]->dataogloszenia . '"  /> <br />';
        while (is_file(MM_UPLOADPATH . $r[$row]->zdjecie)) {
            echo '<img src="' . MM_UPLOADPATH . $r[$row]->zdjecie . '"/>';
            echo '<input type="hidden" value="' . $r[$row]->zdjecie . '" name="zdjecie[]"  />';

            if ($r[$row]->idogloszenia == @$r[++$row]->idogloszenia) {       
            } else {
                $row--;
                break;
            }
        }
        echo '  <br /> <input type="submit"  value="Usuń" name="usun" /> ';
        echo '  <input type="submit"  value="Zmień" name="zmien" /><br /> ';
        echo '  </fieldset></form>';
    }
}
$polaczenie->close();
?> 