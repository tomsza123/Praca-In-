<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);
    $is_ok = true;  
?>

<!-- walidacja -->
<?php

if(isset($_POST['ident_type']))
{       
    $is_ok = true;        
    $ident_type = $_POST['ident_type'];
    $folder = "ident_backgrounds/";
    $background_tmp = $_FILES['background']['tmp_name'];
    $background_name = $_FILES['background']['name'];
    $comment = $_POST['comment'];
    $login = $_SESSION['login'];
    $ident_type_2 = $_POST['ident_type_2'];

    $result=$connect->query("SELECT id FROM ident_type WHERE type='$ident_type'");

    $result2=$connect->query("SELECT id FROM ident_type WHERE background='$folder$background_name'");

        if(!($result->num_rows == 0))
        {
            $is_ok=false;
            $_SESSION['ident_type_error']='Podany typ identyfikatora już istnieje';
        }

        if(!($result2->num_rows == 0))
        {
            $is_ok=false;
            $_SESSION['background_error']='Tło o podanej nazwie już występuje w bazie. Zmień tło lub jego nazwę.';
        }
               
        if(is_uploaded_file($background_tmp)) 
        {
            move_uploaded_file($background_tmp, "ident_backgrounds/$background_name");                
        }

        list($width, $height) = getimagesize($folder.$background_name);
        
        if(($width != 440) && ($height != 620))
        {
            $is_ok = false;
            $_SESSION['background_error']='Rozmiar tła jest nieprawidłowy lub podany plik nie jest obrazem!';
            
            unlink($folder.$background_name);
        }
        

        if($comment != '' && (!(ctype_alnum(str_replace(' ', '', $comment)))))
        {
            $is_ok=false;
            $_SESSION['comment_error']='Komentarz powinien składać się wyłącznie z liter i cyfr(bez polskich znaków).' ;
        }

        if($is_ok==true)
        {            
            //umieszczanie do bazy
            if ($connect->query("INSERT INTO ident_type VALUES (NULL, '$ident_type','$folder$background_name','$ident_type_2','$comment','$login')"))
            {
                //gdy wszystko pojdzie ok - przekierowanie
                $_SESSION['add_ident_type_done']=true;
                        
                echo "<script language='javascript' type='text/javascript'>alert('Dodano typ identyfikatora'); </script>";
                unset($_SESSION['add_ident_type_done']);
            }
            else
            {
                echo ("nastąpił błąd");
            }
        }
}
?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
<title>Nowy rodzaj identyfikatora</title>
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

<h1>Nowy rodzaj identyfikatora</h1>

<div id="loginform">
    <form enctype="multipart/form-data"  method="post" id="form"> 
        <h2>Rodzaj identyfikatora:</h2>    
            <input type="text" name="ident_type" required maxlength="30" minlength="3">
            <?php
                if(isset($_SESSION['ident_type_error']))
                {
                    echo '<div class="error">'.$_SESSION['ident_type_error'].'</div>';
                    unset($_SESSION['ident_type_error']);
                }
            ?>

        <h2>Dodaj tło(format .jpg lub .png):</h2>
            <input type="file" name="background" accept="image/png, image/jpeg" required>
            <?php
                if(isset($_SESSION['background_error']))
                {
                    echo '<div class="error">'.$_SESSION['background_error'].'</div>';
                    unset($_SESSION['background_error']);
                }
            ?>
        <h2>Wybierz typ identyfikatora:</h2>
            <select name="ident_type_2" id="ident_type_2" onchange="identType();">
                <option>Identyfikator bezstrefowy</option>
                <option>Identyfikator strefowy</option>
                <option>Wjazdówka</option>
            </select>

        <h2>Komentarz:</h2>    
            <input type="text" name="comment" maxlength="160"> 
        <?php                
            if(isset($_SESSION['comment_error']))
            {
                echo '<div class="error">'.$_SESSION['comment_error'].'</div>';
                unset($_SESSION['comment_error']);
            }
        ?>            
        </form>  
        <div class="center"> 
            <button type="submit" form="form" class="button">Dodaj</button>
            <button class="button" onclick="anuluj()">Anuluj</button>
        </div> 
        
</div>

</section>


</body>



</html>