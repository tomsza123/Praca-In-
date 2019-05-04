<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }
    //walidacja formularza(nieprzepuszczanie duplikatów)
    
    //zrobić sanityzację pol komentarz i ewentualnie tło

    //dokończyć walidację(pola tło(przepuszczać tylko jpg i png o określonej wadze) i komentarz(do 160 znaków))
    //zmienić kodowanie nazw plików na polskie
    if(isset($_POST['ident_type']))
    {       
        $is_ok = true;        
        $ident_type = $_POST['ident_type'];
        
        
        if((strlen($ident_type)<3)||(strlen($ident_type)>30))
        {
            $is_ok=false;
            $_SESSION['ident_type_error']='Nieprawidłowa nazwa rodzaju identyfikatora!';            
        }   
        $folder = "ident_backgrounds/";
        $background_tmp = $_FILES['background']['tmp_name'];
        $background_name = $_FILES['background']['name'];
        //jebnc wyjatek        
        if(is_uploaded_file($background_tmp)) 
        {
            move_uploaded_file($background_tmp, "ident_backgrounds/$background_name");                
        }
        if(strlen($background_name)==0)
        {
            $is_ok = false;
            $_SESSION['background_error']='Identyfikator musi posiadać tło.';
        }

        list($width, $height) = getimagesize($folder.$background_name);
        //if(($background_name!== IMAGETYPE_JPG) || ($background_name!== IMAGETYPE_PNG))
        //{
            //wyjebac wyjatek
        //    $is_ok = false;
        //    $_SESSION['background_error']='Podany plik nie jest obrazem. Wymagane jest rozszerzenie pliku .jpg lub .png';
        //    //usuwanie z serwera obrazka o nieoptymalnej rozdzielczosci(moze niezbyt optymalne ale dziala)
       //     unlink($folder.$background_name);
        //}
        if(($width != 440) && ($height != 620))
        {
            $is_ok = false;
            $_SESSION['background_error']='Rozmiar tła jest nieprawidłowy!';
            //usuwanie z serwera obrazka o nieoptymalnej rozdzielczosci(moze niezbyt optymalne ale dziala)
            unlink($folder.$background_name);                
            

        }
        $comment = $_POST['comment'];
        if(strlen($comment)>=160)
        {
            $is_ok = false;
            $_SESSION['comment_error']='Komentarz nie może przekraczać 160 znaków!';
        }
        $login = $_SESSION['login'];
        $ident_type_2 = $_POST['ident_type_2'];
        require_once "connect.php";
        
        try
        {
            $connect = @new mysqli($host,$db_user,$db_password,$db_name);
            if($connect->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {  
                $result=$connect->query("SELECT id FROM ident_type WHERE type='$ident_type'");
                if (!$result) throw new Exception($connect->error);
                $ident_type_num = $result->num_rows;
                if($ident_type_num>0)
                {
                    $is_ok=false;
                    $_SESSION['ident_type_error']='Podany typ identyfikatora już istnieje';            
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
                        throw new Exceptipon($connect->error);
                    }
                }
                $connect->close();
            }
        }
        catch(Exception $error)
        {            
            echo "Błąd serwera!";
            echo $error;
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
            				
	    </nav>
</header>
<section class="container">

<h1>Nowy rodzaj identyfikatora</h1>

<div id="loginform">
    <form enctype="multipart/form-data"  method="post"> 
        <h2>Rodzaj identyfikatora:</h2>    
            <input type="text" name="ident_type" >
            <?php                
                if(isset($_SESSION['ident_type_error']))
                {
                    echo '<div class="error">'.$_SESSION['ident_type_error'].'</div>';
                    unset($_SESSION['ident_type_error']);
                }
            ?> 
        <h2>Dodaj tło(format .jpg lub .png):</h2>
            <input type="file" name="background" accept="image/png, image/jpeg" >
            <?php
                if(isset($_SESSION['background_error']))
                {
                    echo '<div class="error">'.$_SESSION['background_error'].'</div>';
                    unset($_SESSION['background_error']);
                }
            ?>
        <h2>Wybierz typ identyfikatora:</h2>
            <select name="ident_type_2">
                <option>Identyfikator bezstrefowy</option>
                <option>Identyfikator strefowy</option>
                <option>Wjazdówka</option>
            </select>
            

        <h2>Komentarz:</h2>    
            <input type="text" name="comment" > 
        <?php                
            if(isset($_SESSION['comment_error']))
            {
                echo '<div class="error">'.$_SESSION['comment_error'].'</div>';
                unset($_SESSION['comment_error']);
            }
        ?>            

        <div class="center"> 
           <button class="button">Dodaj</button>
        </div> 
    </form>      
</div>

</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>
</body>
</html>