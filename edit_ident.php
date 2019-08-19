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
    }

    $id = $_GET['id'];
    $ident = mysqli_query($connect,"SELECT * FROM ident WHERE id = $id");

    while($row = mysqli_fetch_array($ident)) 
    {
        $name = $row['name'];        
        $name_2 = $row['name_2'];
        $lastname = $row['lastname'];
        $type = $row['type'];
        $sel_zone = $row['zone'];
    }
    //zabezpieczenie przed wpisaniem w pasku przegladarki nieistniejącego id(przekierowanie na strone główną jesli wystapi blad)
    $result = mysqli_query($connect,"SELECT id FROM ident WHERE id=$id");

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
            while($r = mysqli_fetch_assoc($types)) 
            {
                if($r['type'] == $type)//wybór przypisanego do identyfikaotra typu
                {
                    echo '<option value="'.$r['type_2'].'|'.$r['type'].'" selected>';
                    echo $r['type'];
                    echo '</option>';
                    $stype = $r['type_2'];
                    
                } 
                else
                {
                    echo '<option value="'.$r['type_2'].'|'.$r['type'].'" >';
                    echo $r['type'];
                    echo '</option>';
                }
            }  
            /*if(isset($_POST['identtype']))
            {
                //$_SESSION['type2'] = $_POST['identtype'];
                $st = explode("|",$_POST['identtype']);

            }*/
            echo '</select>';
        }
        $zones = mysqli_query($connect,"SELECT * FROM zone");
?>

<div id="demo"> <?php echo $stype; ?> </div>

<div id="zone" 
<?php
if ($stype == "Identyfikator strefowy") echo "";
else echo 'style="display: none;"';
?>
>
<?php
    if(mysqli_num_rows($zones) > 0) 
    { 
        echo '<select id="zone" name="zone" onchange=typeSelect();>';
        //echo'<option value="" selected>';
        while($r = mysqli_fetch_assoc($zones)) 
        {   //wybór wczesniejszej strefy dopisac jw z wybrorem typu
            if($r['zone']==$sel_zone)
            {
                echo '<option value="'.$r['zone'].'"selected >';
                echo $r['zone'];
                echo '</option>';
                
            }
            else
            {
                echo '<option value="'.$r['zone'].'" >';
                echo $r['zone'];
                echo '</option>';
            }
        }  
    }
    echo '</select>';
?>

<h2>Nazwa</h2>
<input type="text" name="zone_name" value=<?php echo'"'.$name.'" ';?> >
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="zone_name_2" value=<?php echo'"'.$name_2.'" ';?> >
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="zone_lastname" value=<?php echo'"'.$lastname.'" ';?> >
</div>



<div id="nonzone" 

<?php
if ($stype == "Identyfikator bezstrefowy") echo '';
else echo 'style="display: none;"';
?>
>

<h2>Nazwa</h2>
<input type="text" name="nonzone_name" value=<?php echo'"'.$name.'" ';?>>
<h2>Imię(opcjonalnie)</h2>
<input type="text" name="nonzone_name_2" value=<?php echo'"'.$name_2.'" ';?>>
<h2>Nazwisko(opcjonalnie)</h2>
<input type="text" name="nonzone_lastname" value=<?php echo'"'.$lastname.'" ';?>>
</div>

<div id="drive"
<?php
if ($stype == "Wjazdówka") echo '';
else echo 'style="display: none;"';
?>
>

<h2>Numer rejestracyjny</h2>
<input type="text" name="drive" value=<?php echo'"'.$name.'" ';?>><!--pomysle moze nad walidacją rejestracji-->

</div>
</form>


<div class="center">       
    
    <button type="submit" form="form" class="button" id="edit" >Edytuj</button>       
    <button class="button" onclick="goBack()">Anuluj</button>

</div>


<?php

    if(isset($_POST['identtype']))
    {
        $name = $_POST['zone_name'];
        $name_2 = $_POST['zone_name_2'];
        $lastname = $_POST['zone_lastname'];
        $zone = $_POST['zone'];

        $name2 = $_POST['nonzone_name'];
        $name_22 = $_POST['nonzone_name_2'];
        $lastname2 = $_POST['nonzone_lastname'];
        
        $drive = $_POST['drive'];

        $madeby = $_SESSION['login'];  
        $type = $_SESSION['type2'];
        //$seltype = $stype[1];
        $tab = explode("|",$_POST['identtype']);
        $selected= $tab[1];

        
        switch($stype)
        {
            case('Identyfikator strefowy'):
            $connect->query("UPDATE ident SET name = '$name', name_2 = '$name_2', lastname = '$lastname', type = '$selected', zone = '$zone' WHERE id = '$id'");
            $connect->query("UPDATE ident SET name = '$name', name_2 = '$name_2', lastname = '$lastname', type = '$selected', zone = '$zone' WHERE id = '$id'");
                //echo '<script>alert("Edytowano identyfikator");</script>';
                $connect->close;
                header("Location: idents.php");
                break;

            case('Identyfikator bezstrefowy'):
            $connect->query("UPDATE ident SET name = '$name2', name_2 = '$name_22', lastname = '$lastname2', type = '$selected', zone = NULL WHERE id = '$id'");
            $connect->query("UPDATE ident SET name = '$name2', name_2 = '$name_22', lastname = '$lastname2', type = '$selected', zone = NULL WHERE id = '$id'");
                //echo '<script>alert("Edytowano identyfikator");</script>';
                $connect->close;
                header("Location: idents.php");

                break;
            
            case('Wjazdówka'):
            $connect->query("UPDATE ident SET name = '$drive', name_2 = NULL, lastname = NULL, type = '$selected', zone = NULL WHERE id = '$id'");
            $connect->query("UPDATE ident SET name = '$drive', name_2 = NULL, lastname = NULL, type = '$selected', zone = NULL WHERE id = '$id'");
                //echo '<script>alert("Edytowano identyfikator");</script>';
                $connect->close;
                header("Location: idents.php");
                break;
            default:
                echo '<script>alert("Wystąpił błąd. Spróbuj ponownie.");</script>';
                break;
        }//zmiany wchodzą za drugim razem
    }
?>


</body>
</html>