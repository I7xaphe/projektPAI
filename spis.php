<?php
session_start();
?>
<html lang="pl">
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta name="Author" content="Autor strony" />
  <title>Spis treści</title>
</head>
<body>
<?php
    if(isset($_SESSION['zalogowany'])){
        echo 'Witaj '.$_SESSION['nazwauzytkownika'].'<br />';
        echo '<a target="AktualnaStrona" href="wyloguj.php">Wyloguj</a><br />';       
    }else{       
        echo '<a target="AktualnaStrona" href="zaloguj.php">Zaloguj</a><br />';
        echo '<a target="AktualnaStrona" href="zarejestruj.php">Zarejestruj się</a><br />';     
    }       
?>

<h2>Spis treści:</h2>
    <a target="AktualnaStrona" href="ogloszenie.php">Ogłoszenia</a><br />
    <a target="AktualnaStrona" href="szukaj.php">Znajdź ogloszenie</a><br />
    
<?php
    if(isset($_SESSION['zalogowany'])){
       echo ' <a target="AktualnaStrona" href="mojeogloszenia.php">Moje ogłoszenia</a><br />';
       echo ' <a target="AktualnaStrona" href="dodajogloszenie.php">Dodaj ogloszenie</a><br />';    
       echo ' <a target="AktualnaStrona" href="konto.php">Moje konto</a><br />';
    }      
?>
</body>
</html>