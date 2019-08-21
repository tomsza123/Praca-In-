<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }

    $id = $_GET['id'];
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);
    $is_ok = true;  
    $identtype = mysqli_query($connect,"SELECT * FROM ident_type WHERE id = $id");
    if(mysqli_num_rows($identtype) > 0) 
    {
        while($row = mysqli_fetch_array($identtype)) 
        {
            //$name = $row['name'];
            $type = $row['type'];
            $background = $row['background'];
            $type_2 = $row['type_2'];
            $comment = $row['comment'];
            $madeby = $row['madeby'];
        }
    }
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

        if(is_uploaded_file($background_tmp)) 
        {
            $result2=$connect->query("SELECT id FROM ident_type WHERE background='$folder$background_name'");
            if(!($result2->num_rows == 0))
            {
            $is_ok=false;
            $_SESSION['background_error']='Tło o podanej nazwie już występuje w bazie. Zmień tło lub jego nazwę.';
            }
            else
            {
                move_uploaded_file($background_tmp, "ident_backgrounds/$background_name");    

                list($width, $height) = getimagesize($folder.$background_name);
            
                if(($width != 440) && ($height != 620))
                {
                    $is_ok = false;
                    $_SESSION['background_error']='Rozmiar tła jest nieprawidłowy lub podany plik nie jest obrazem!';
                    
                    unlink($folder.$background_name);
                }
            }
        }

        if($comment != '' && (!(ctype_alnum(str_replace(' ', '', $comment)))))
        {
            $is_ok=false;
            $_SESSION['comment_error']='Komentarz powinien składać się wyłącznie z liter i cyfr(bez polskich znaków).' ;
        }

        if($is_ok==true)
        {  
            if($_FILES['background']['name'] == null) 
            {
                if ($connect->query("UPDATE ident_type SET type = '$ident_type', type_2 = '$ident_type_2', comment = '$comment', madeby = '$login' WHERE id = $id"))
                {
                    $_SESSION['edit_ident_type_done']=true;

                    unset($_SESSION['edit_ident_type_done']);
                    header('location: ident_types.php');
                    $connect->close();
                }     
                else
                {
                    echo ("nastąpił błąd");
                }
            }
            else
            {
                if ($connect->query("UPDATE ident_type SET type = '$ident_type', type_2 = '$ident_type_2',background = '$folder$background_name', comment = '$comment', madeby = '$login' WHERE id = $id"))
                {
                    $_SESSION['edit_ident_type_done']=true;
                    
                    unset($_SESSION['edit_ident_type_done']);
                    header('location: ident_types.php');
                    $connect->close();
                }     
                else
                {
                    echo ("nastąpił błąd");
                }
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
            <input type="text" name="ident_type" required maxlength="30" minlength="3" value="<?php echo $type;?>">
            <?php
                if(isset($_SESSION['ident_type_error']))
                {
                    echo '<div class="error">'.$_SESSION['ident_type_error'].'</div>';
                    unset($_SESSION['ident_type_error']);
                }
            ?>

        <h2>Zmień tło(opcjonalnie,format .jpg lub .png):</h2>
            <input type="file" name="background" accept="image/png, image/jpeg">
            <?php
                if(isset($_SESSION['background_error']))
                {
                    echo '<div class="error">'.$_SESSION['background_error'].'</div>';
                    unset($_SESSION['background_error']);
                }
            ?>
        <h2>Wybierz typ identyfikatora:</h2>
        <select name="ident_type_2">
            <?php
            switch($type_2)
            {
                case('Identyfikator bezstrefowy'):          
                    echo '<option selected>Identyfikator bezstrefowy</option><option>Identyfikator strefowy</option><option>Wjazdówka</option>';
                    break;
                
                case('Identyfikator strefowy'):
                    echo '<option>Identyfikator bezstrefowy</option><option selected>Identyfikator strefowy</option><option>Wjazdówka</option>';
                    break;
                
                case('Wjazdówka'):
                    echo '<option>Identyfikator bezstrefowy</option><option>Identyfikator strefowy</option><option selected>Wjazdówka</option>';
                    break;
                    
                default:
                    echo '<option selected></option><option>Identyfikator bezstrefowy</option><option>Identyfikator strefowy</option><option>Wjazdówka</option>';
                    break;
            } 
            ?>
            </select>

        <h2>Komentarz:</h2>    
            <input type="text" name="comment" maxlength="160" value="<?php echo $comment;?>"> 
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