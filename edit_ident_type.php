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
    $id = $_GET['id'];
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
    if(isset($_POST['ident_type']))
    {
        $login = $_SESSION['login'];
        $ident_type_2 = $_POST['ident_type_2'];
        $ident_type = $_POST['ident_type'];

        $is_ok = true;
        if($_FILES['background'] == '')
        {
            $is_ok = true;
            
        }
        if(!empty($_FILES['background']))
        {
            $folder = "ident_backgrounds/";
            $background_tmp = $_FILES['background']['tmp_name'];
            $background_name = $_FILES['background']['name'];
       
            if(is_uploaded_file($background_tmp)) 
            {
                move_uploaded_file($background_tmp, "ident_backgrounds/$background_name");

                list($width, $height) = getimagesize($folder.$background_name);

                
            }
            if(!is_uploaded_file($background_tmp)) 
            {
                $is_ok = true;
                $background_up = $background;           
            }
            if(strlen($background_name)==0)
            {
                $is_ok = false;
                $_SESSION['background_error']='Identyfikator musi posiadać tło.';
                
            }
            if(($width != 440) && ($height != 620))
                {
                    $is_ok = false;
                    $_SESSION['background_error']='Rozmiar tła jest nieprawidłowy!';
                    
                    unlink($folder.$background_name);
                }
            $background_up = $folder.$background_name;           
        }
        if(isset($_POST['comment']))
        {
            $comment_up = $_POST['comment'];
            if(strlen($comment_up)>=160)
            {
                $is_ok = false;
                $_SESSION['comment_error']='Komentarz nie może przekraczać 160 znaków!';
            }
            if(ctype_alnum($comment_up)==false)
            {
                $is_ok=false;
                $_SESSION['login_error']='Komentarz powinien składać się wyłącznie z liter i cyfr(bez polskich znaków).' ;
            }
            if(strlen($comment_up) == 0)
            {
                $is_ok = true;
                $comment_up = '';
            }
        }
        else
        {
            $is_ok = true;
            $comment_up = $comment;
        }
        
    

        if($is_ok==true)
        {
            if ($connect->query("UPDATE ident_type SET type = '$ident_type', type_2 = '$ident_type_2',background = '$background_up', comment = '$comment_up', madeby = '$login' WHERE id = $id"))
            {
                
                //gdy wszystko pojdzie ok - przekierowanie
                $_SESSION['edit_ident_type_done']=true;
                                    
                //echo "<script language='javascript' type='text/javascript'>alert('Edytowano typ identyfikatora'); </script>";
                unset($_SESSION['edit_ident_type_done']);
                header('location: ident_types.php');
                $connect->close();
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
            <input type="text" name="ident_type" value="<?php echo $type;?>">
            <?php                
                if(isset($_SESSION['ident_type_error']))
                {
                    echo '<div class="error">'.$_SESSION['ident_type_error'].'</div>';
                    unset($_SESSION['ident_type_error']);
                }
            ?> 
        <h2>Dodaj tło(format .jpg lub .png):</h2>
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
            <input type="text" name="comment" value="<?php echo $comment;?>"> 
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
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>
</body>
</html>