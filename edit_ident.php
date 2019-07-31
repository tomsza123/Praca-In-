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
        //include('add_ident_pt2.php'); 
    }

    $id = $_GET['id'];
    $ident = mysqli_query($connect,"SELECT * FROM ident WHERE id = $id");

    while($r = mysqli_fetch_array($ident)) 
    {
        $name = $r['name'];        
        $name_2 = $r['name_2'];
        $lastname = $r['lastname'];
        
        
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

<h1>Edycja Identyfikatora nr: <?php echo $id; ?></h1>
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
<input type="text" name="name(2)" required value=<?php echo'"'.$name.'" ';?> >
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="name_2(2)" value=<?php echo'"'.$name_2.'" ';?> >
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="lastname(2)" >
</div>



<div id="nonzone" style="display: none;">


<h2>Nazwa</h2>
<input type="text" name="name" required>
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="name_2">
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="lastname">
</div>

<div id="drive" style="display: none;">


<h2>Numer rejestracyjny</h2>
<input type="text" name="drive" required>

</div>

<div id="empty" style="display: none;">
</div>

</form>


<div class="center">       
    
    <button type="submit" form="form" class="button" id="add" style="display: none;">Edytuj</button>       
    <button class="button" onclick="anuluj()">Anuluj</button>

</div>


<?php

    if(isset($_POST['identtype']))
    {
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
        
        switch($stype[0])
        {
            case('Identyfikator bezstrefowy'):
                $connect->query("INSERT INTO ident VALUES (NULL, '$name$drive$name2','$name_2$name_22','$lastname$lastname2','$madeby','$seltype','$zone')");
            break;
            case('Identyfikator strefowy'):
                $connect->query("INSERT INTO ident VALUES (NULL, '$name$drive$name2','$name_2$name_22','$lastname$lastname2','$madeby','$seltype','$zone')");
            break;
            case('Wjazdówka'):
                $connect->query("INSERT INTO ident VALUES (NULL, '$name$drive$name2','$name_2$name_22','$lastname$lastname2','$madeby','$seltype','$zone')");
            break;
        }
        
        echo '<script>alert("Edytowano identyfikator");</script>';
        
    }

?>


</body>
</html>