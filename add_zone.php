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
<title>Nowy identyfikator</title>
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
            <a href="main.php" class="btn">Panel administratora</a>
            <a href="logout.php" class="btn">Wyloguj</a> 
            				
	    </nav>
</header>
<section class="container">

<h1>Dodaj nową strefę(dot. identyfikatorów strefowych)</h1>
<div id="loginform">
    <form method="post" id="form">
        <h2>Nazwa</h2>
        <input type="text" name="zone" required>
    </form>
        <div class="center">
            <button type="submit" form="form" class="button">Dodaj</button>
            <button class="button" onclick="anuluj()">Anuluj</button>
        </div>
   

</div>

</section>


</body>

<?php

    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name); 
    //$zones = mysqli_query($connect,"SELECT * FROM ident_type");

    if(isset($_POST['zone']))
    {
        $zone = $_POST['zone'];

        $connect->query("INSERT INTO zone VALUES(NULL,'$zone')");
        

        echo '<script>alert("Dodano strefę");</script>';
    }

?>