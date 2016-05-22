<?php
session_start();
?>
<html lang="pl">
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta name="Author" content="Autor strony" />
  <link rel="stylesheet" href="ourcss.css" type="text/css" />
  <title>Spis treści</title>
</head>
<body>
    <!-- tu dodałem użycie stylu oraz link by ją czytał----------->
    <menu>
<?php
    if(isset($_SESSION['zalogowany'])){
        echo 'Witaj '.$_SESSION['nazwauzytkownika'].'<br />';
        echo '<a target="AktualnaStrona" href="wyloguj.php">Wyloguj</a>';       
    }else{       
        echo '<a target="AktualnaStrona" href="zaloguj.php">Zaloguj</a>';
        echo '<a target="AktualnaStrona" href="zarejestruj.php">Zarejestruj się</a>';     
    }       
?>

<h2>Spis treści:</h2>
    <a target="AktualnaStrona" href="ogloszenie.php">Ogłoszenia</a>
    <a target="AktualnaStrona" href="szukaj.php">Znajdź ogloszenie</a>
    
<?php
    if(isset($_SESSION['zalogowany'])){
       echo ' <a target="AktualnaStrona" href="mojeogloszenia.php">Moje ogłoszenia</a>';
       echo ' <a target="AktualnaStrona" href="dodajogloszenie.php">Dodaj ogloszenie</a>';    
       echo ' <a target="AktualnaStrona" href="konto.php">Moje konto</a>';
    }      
?>
    </menu>
</body>
</html>