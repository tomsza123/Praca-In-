<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);

    $id = $_GET['id'];
    $zone = mysqli_query($connect,"SELECT * FROM zone WHERE id = $id");

    while($row = mysqli_fetch_array($zone)) 
    {
        $name = $row['zone'];        
        
    } 
    //zabezpieczenie przed wpisaniem w pasku przegladarki nieistniejącego id(przekierowanie na strone główną jesli wystapi blad)
    $result = mysqli_query($connect,"SELECT id FROM zone WHERE id=$id");

    if(!(mysqli_num_rows($result) >0))
    {
        header("Location: main.php");
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

<body onload="typeSelect();">
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

<h1>Edycja strefy</h1>
    
    <div id="loginform">
        <form method="post" id="form">
            <h2>Nazwa</h2>
            <input type="text" name="zone" value="<?php echo $name; ?>" required>
        </form>
            <div class="center">
                <button type="submit" form="form" class="button">Edytuj</button>
                <button class="button" onclick="anuluj()">Anuluj</button>
            </div>
    </div>
</div>
<?php

    if(isset($_POST['zone']))
    {
        
        $zone = $_POST['zone'];
        $connect->query("UPDATE zone SET zone = '$zone' WHERE id = '$id'");
        header('Location: zones.php');
    }
?>
</body>
</html>