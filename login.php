<!--<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
<title>Identy</title>
<meta charset='utf-8'> 
<!-- mobile meta tag --><!--
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
		    <a href="#" class="btn">Główna</a>
            				
	    </nav>
</header>
<section class="container">

<?php
    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $connect = @new mysqli($host,$db_user,$db_password,$db_name);

    if ($connect->connect_errno!=0)
    {
        echo "Error: ".$connect->connect_errno. "Opis: ".$connect->connect_error;
    }
    else
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        //$password = htmlentities($password, ENT_QUOTES, "UTF-8");


        if ($result = @$connect->query(sprintf("SELECT * FROM users WHERE login='%s'",mysqli_real_escape_string($connect,$login))))
        {
            $how_users = $result->num_rows;
            if($how_users>0)
            {
                $row = $result->fetch_assoc();

                if(password_verify($password, $row['password']))
                {                    
                    $_SESSION['logged'] = true;                    
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['login'] = $row['login'];
                    //$_SESSION['password'] = $row['password'];

                    unset($_SESSION['error']);
                    $result->free_result();
                    header('Location: main.php');
                }
                else
                {
                    $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
                    header('Location: index.php');
                }            
            }
            else
            {
                $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
                header('Location: index.php');
            }            
        }

        $connect->close();
    }    


?>

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
</html>-->