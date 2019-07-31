<?php
    session_start();
    if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
    {
        header('Location: main.php');
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
        
</header>
<section class="container">

<div id="loginform">
    <form action="login.php" method="post"> 
        <h2>Login:</h2>    
	        <input type="text" name="login">
        <h2>Hasło:</h2>    
	        <input type="password" name="password">
        <div class="center">
            <?php
                if(isset($_SESSION['error']))
                {
                    echo '<b>'.$_SESSION['error'].'</b>';
                    echo '</br></br>';
                }
            ?>   

                  

           <button class="button">Zaloguj</button>
        </div> 
    </form>      
</div>

</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>
</body>
</html>