<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name); 
    $types = mysqli_query($connect,"SELECT * FROM ident_type");

 /*    if(isset($_POST['identtype']))
    {
        $_SESSION['type2'] = $_POST['identtype'];         
    } */
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

<h1>Nowy identyfikator</h1>
<div id="loginform">

    <h2>Wybierz rodzaj identyfikatora:</h2>  
    <form method="post" id="form"> 
    <?php
        if(mysqli_num_rows($types) > 0) 
        { 
            echo '<select id="selected_type" name="identtype" onchange="typeSelect();">';
            
            echo'<option value="Pusty|" >';
            while($r = mysqli_fetch_assoc($types)) 
            { 
                echo '<option value="'.$r['type_2'].'|'.$r['type'].'" >';
                echo $r['type'];
                echo '</option>';
            }  
            echo '</select>';
        }
        if(isset($_POST['identtype']))
        {
            //$_SESSION['type2'] = $_POST['identtype'];
            $stype = explode("|",$_POST['identtype']);

        }
        

        $zones = mysqli_query($connect,"SELECT * FROM zone");
?>
<div id="zone" style="display: none;">

<?php
    if(mysqli_num_rows($zones) > 0) 
    { 
        echo '<select id="zone" name="zone" onchange=typeSelect();>';
        echo'<option value="" selected>';
        while($r = mysqli_fetch_assoc($zones)) 
        {  
            echo '<option value="'.$r['zone'].'" >';
            echo $r['zone'];
            echo '</option>';
        }  
    }
    echo '</select>'
?>

</div>

<div id="demo"></div>

<div class="center">       
    
    <button type="submit" form="form" class="button" id="add" style="display: none;">Dodaj</button>       
    <button class="button" onclick="anuluj()">Anuluj</button>

</div>

<?php

    if(isset($_POST['identtype']))
    {
        $zone = $_POST['zone'];

        $name = $_POST['name'];
        $name2 = $_POST['name2'];
        $lastname = $_POST['lastname'];
        $number = $_POST['number'];

        $madeby = $_SESSION['login'];
        $seltype = $stype[1];
        $type = $stype[0];
        
        switch($type)
        {
            case('Identyfikator bezstrefowy'):
            for($i=0;$i<$number;$i++)
            {
                $connect->query("INSERT INTO ident VALUES (NULL, '$name','$name2','$lastname','$madeby',NULL,'$seltype',NULL)");
            }
            break;
            case('Identyfikator strefowy'):
            for($i=0;$i<$number;$i++)
            {
                $connect->query("INSERT INTO ident VALUES (NULL, '$name','$name2','$lastname','$madeby',NULL,'$seltype','$zone')");
            }
            break;
            case('Wjazdówka'):
                $connect->query("INSERT INTO ident VALUES (NULL, '$name',NULL,NULL,'$madeby',NULL,'$seltype','$zone')");
            break;
        }
            
        if($number>1)
        {
            echo '<script>alert("Dodano identyfikatory");</script>';
        }
        else
        {
            echo '<script>alert("Dodano identyfikator");</script>';
        }
    }
?>

</body>
</html>