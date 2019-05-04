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

    if(isset($_POST['identtype']))
    {
        $_SESSION['type2'] = $_POST['identtype'];
        //echo $_SESSION['type2'];
        //include('add_ident_pt2.php'); //wysyla typ identyfikatora nie jego nazwe, trza naprawić
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
            				
	    </nav>
</header>
<section class="container">

<h1>Nowy identyfikator</h1>
<div id="loginform">

    
    <h2>Wybierz rodzaj identyfikatora:</h2>  
    <form method="post">
    <?php
        if(mysqli_num_rows($types) > 0) 
        { 
            echo '<select id="selected_type" name="identtype" onchange="typeSelect();">';
            
            echo'<option value="" selected>';
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

<div id="demo"></div>
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


<h2>Nazwa</h2>
<input type="text" name="name(2)">
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="name_2(2)">
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="lastname(2)">
<h2>Ilość</h2>
<input type="number" name="number" min="1" value=1>



</div>



<div id="nonzone" style="display: none;">


<h2>Nazwa</h2>
<input type="text" name="name">
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="name_2">
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="lastname">
<h2>Ilość</h2>
<input type="number" name="number" min="1" value=1>


</div>

<div id="drive" style="display: none;">


<h2>Numer rejestracyjny</h2>
<input type="text" name="drive">

</div>

<div class="center">
        
    <button type=submit class="button" >Dodaj</button>  
        
</div>
</form>

<?php

    if(isset($_POST['identtype']))
    {
        

        //$stype = $res_explode[1];
        //$stype = $_POST['identtype'];
        $name = $_POST['name'];
        $name_2 = $_POST['name_2'];
        $lastname = $_POST['lastname'];
        $name2 = $_POST['name(2)'];
        $name_22 = $_POST['name_2(2)'];
        $lastname2 = $_POST['lastname(2)'];
        $madeby = $_SESSION['login'];  
        $type = $_SESSION['type2']; 
        $zone = $_POST['zone'];
        $drive = $_POST['drive'];
        $seltype = $stype[1];
        
       
        $connect->query("INSERT INTO ident VALUES (NULL, '$name$drive$name2','$name_2$name_22','$lastname$lastname2','$madeby','$seltype','$zone')");

        echo '<script>alert("Dodano identyfikator");</script>';

        //echo $_POST['number'];
    }

?>

</div>
</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>

</body>
</html>