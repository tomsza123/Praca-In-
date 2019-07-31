<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
<title>Identy</title>
<meta charset='utf-8'> 
<!-- mobile meta tag -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="style.css">
<script src="http://code.jquery.com/jquery-latest.pack.js" type="text/javascript"></script>
</head>
<script type="text/javascript" src="script.js"></script>
<body>



<header>
    <div id="logo"></div>
        <a href="#" class="btn open-menu">&#9776;</a>
	    <nav class="clearfix">
		    <a href="#" class="btn hide">&laquo; Zamknij</a>
            <a href="logout.php" class="btn">Wyloguj</a>
            
            				
	    </nav>
</header>
<section class="container">

<?php    
    echo "<p><h1>Witaj ".$_SESSION['login']."!</h1></p>";    
?>
<div id="addmenu">
<ul>
    <li><a href="registration.php" >Dodaj nowego administratora</a></li>
    <li><a href="add_ident.php" >Dodaj identyfikator</a></li>
    <li><a href="add_ident_type.php">Dodaj nowy typ identyfikatora</a></li>    
    <li><a href="add_zone.php">Dodaj strefę</a></li>
</ul>
</div>

<div id="editmenu">
<ul>
    <li><a href="idents.php" >Pokaż identyfikatory</a></li>
    <li><a href="ident_types.php" >Pokaż typy identyfikatorów</a></li>
</ul>
</div>





</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>

</body>

</html>