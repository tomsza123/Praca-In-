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

    $ident = mysqli_query($connect,"SELECT *FROM ident WHERE id = $id");

    if(mysqli_num_rows($ident) > 0) 
    {
        while($row = mysqli_fetch_array($ident)) 
        {
            $name = $row['name'];
            $name_2 = $row['name_2'];
            $lastname = $row['lastname'];
            $madeby = $row['madeby'];
            $type = $row['type'];
            $zone_selected = $row['zone'];
        }
        
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

<h1>Edytuj identyfikator</h1>
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
                echo '<option value="'.$r['type_2'].'" >';
                echo $r['type'];
                echo '</option>';
            }  
            echo '</select>';
        }
        if(isset($_POST['identtype']))
        {
            $_SESSION['type2'] = $_POST['identtype'];
        }

        $zones = mysqli_query($connect,"SELECT * FROM zone");
?>
<div id="demo"></div>
<div id="zone" style="display: none;">

<?php
    if(mysqli_num_rows($zones) > 0) 
    { 
        echo '<select id="zone" name="zone" "onchange=typeSelect();>';
        echo '<option value="" selected>';
        while($r = mysqli_fetch_assoc($zones)) 
        {  
            
            if($r['zone'] == $zone_selected)
            {
                echo '<option value="'.$r['zone'].'" selected>'.$r['zone'].'</option>';
                
            }
            else
            {
                echo '<option value="'.$r['zone'].'" >'.$r['zone'].'</option>';
            }
           
        }  
    }
    echo '</select>'

   
?>


<h2>Nazwa</h2>
<input type="text" name="name(2)"value="<?php echo $name;?>"> 
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="name_2(2)" value="<?php echo $name_2;?>">
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="lastname(2)" value="<?php echo $lastname;?>">
<h2>Ilość</h2>
<input type="number" name="number" min="1" value=1>




</div>



<div id="nonzone" style="display: none;">


<h2>Nazwa</h2>
<input type="text" name="name" value="<?php echo $name;?>">
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="name_2" value="<?php echo $name_2;?>">
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="lastname" value="<?php echo $lastname;?>">
<h2>Ilość</h2>
<input type="number" name="number" min="1" value=1>


</div>

<div id="drive" style="display: none;">


<h2>Numer rejestracyjny</h2>
<input type="text" name="drive" value="<?php echo $name;?>">

</div>

<div class="center">
        
    <button type=submit class="button" >Dodaj</button>  
        
</div>
</form>

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
        $id = $_GET['id'];
        
        if($_POST['identtype'] == "Identyfikator strefowy")
        {
            $connect->query("UPDATE ident SET name='$name2',name_2 = '$name_22', lastname = '$lastname2', madeby = '$madeby', type = '$type', zone = '$zone'  WHERE id = $id");
        }
        if($_POST['identtype'] == "Identyfikator bezstrefowy")
        {
            $connect->query("UPDATE ident SET name='$name',name_2 = '$name_2', lastname = '$lastname', madeby = '$madeby', type = '$type', zone = NULL WHERE id = $id");
        }
        if($_POST['identtype'] == "Wjazdówka")
        {
            $connect->query("UPDATE ident SET name='$drive',name_2 = NULL, lastname = NULL,madeby = '$madeby', type = '$type', zone = NULL WHERE id = $id");
        }
        header("location: idents.php");
    }

?>

</div>
</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>

</body>
</html>