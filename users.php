<?php
    session_start();
    /*if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
    {
        header('Location: main.php');
        exit();
    }*/
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
<body>



<header>
    <div id="logo"></div>
        <!--<a href="#" class="btn open-menu">&#9776;</a>
	    <nav class="clearfix">
		    <a href="#" class="btn hide">&laquo; Zamknij</a>
		    <a href="#" class="btn">Główna</a>
            				
	    </nav>-->
</header>
<section class="container">

<?php

    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);

    $accounts = mysqli_query($connect,"SELECT * FROM users ");

    if(mysqli_num_rows($accounts) > 0) 
    {
        /* jeżeli wynik jest pozytywny, to wyświetlamy dane */
        echo "<table cellpadding=\"2\" border=1>";
        while($r = mysqli_fetch_assoc($accounts)) 
        {
            echo "<tr>";
            echo "<td>".$r['id']."</td>";
            echo "<td>".$r['login']."</td>";
            echo "<td>".$r['password']."</td>";
            echo "<td>".$r['email']."</td>";
            /*echo "<td>
           <a href=\"index.php?a=del&amp;id={$r['id']}\">DEL</a>
           <a href=\"index.php?a=edit&amp;id={$r['id']}\">EDIT</a>
           </td>";*/
            echo "</tr>";
        }
        echo "</table>";
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
</html>