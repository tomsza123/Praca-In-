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

    /*if(isset($_POST['identtype']))
    {
        $_SESSION['type2'] = $_POST['identtype'];
        echo $_SESSION['type2'];
        include('add_ident_pt2.php');
    }*/
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
    <?php
        $value=1;
        echo '<h2>Wybierz rodzaj identyfikatora:</h2>';
        //action="add_ident_pt2.php"
        echo '<form  method="post" value="'.$value.'">';
        if(mysqli_num_rows($types) > 0) 
        { 
            echo '<select name="identtype">';                
            while($r = mysqli_fetch_assoc($types)) 
            {                      
                echo '<option>';
                echo $r['type'];                 
                echo '</option>';                                            
            }  
            echo '</select>';
        }
        
        if(isset($_POST['identtype']))
        {
            $_SESSION['type2'] = $_POST['identtype'];
            //echo $_SESSION['type2'];            
            include('add_ident_pt2.php');

        }
        echo '<div class="center">'; 
        echo '<button type=submit class="button" >Dodaj</button>';
        echo '</form>';    
        echo '</div>';
        
    ?>  
</div>
</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>

<script type="text/javascript" >
$(document).ready(function(){
	$('.open-menu, .hide').click(function(){	
		$('nav').toggleClass('show');		
	});//open click	
});//document ready end
</script>


</body>
</html>