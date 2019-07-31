<?php
    //session_start();
    
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
    }


    //walidacja formularza
    if(isset($_POST['email']))
    {
        $is_ok = true;
        $login = $_POST['login'];
        
        if((strlen($login)<3)||(strlen($login)>20))
        {
            $is_ok=false;
            $_SESSION['login_error']='Login powinien posiadać od 3 do 20 znaków.';            
        }
        
        if(ctype_alnum($login)==false)
        {
            $is_ok=false;
            $_SESSION['login_error']='Login powinien składać się wyłącznie z liter i cyfr(bez polskich znaków).' ;
        }
        
        $email = $_POST['email'];
        $email_san= filter_var($email,FILTER_SANITIZE_EMAIL);//sanityzacja e-mail
        if((filter_var($email_san,FILTER_VALIDATE_EMAIL)==false) || ($email_san!=$email))
        {
            $is_ok = false;
            $_SESSION['mail_error'] = 'Nieprawidłowy adres e-mail!';
        }
        //sprawdzenie haseł
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1)<8)||(strlen($password1)>20))
        {
            $is_ok=false;
            $_SESSION['pass_error']='Hasło powinno składać się od 3 do 20 znaków.';            
        }        
        if($password1!=$password2)
        {
            $is_ok=false;
            $_SESSION['pass_identity_error']='Hasła muszą być identyczne';            
        }
        $password_hash = password_hash($password1, PASSWORD_DEFAULT);
        //echo $password_hash;
        //exit();
        require_once "connect.php";
        //mysqli_report(MYSQLI_REPORT_STRICT);//rzucanie wyjątkami zamiast ostrzezeniami
        try
        {
            $connect = @new mysqli($host,$db_user,$db_password,$db_name);
            if($connect->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                //czy email istnieje
                $result=$connect->query("SELECT id FROM users WHERE email='$email'");
                if (!$result) throw new Exception($connect->error);
                $email_num = $result->num_rows;
                if($email_num>0)
                {
                    $is_ok=false;
                    $_SESSION['mail_error']='Adres mail znajduje sie w bazie';            
                }
                //czy nick siedzi w bazie
                $result=$connect->query("SELECT id FROM users WHERE login='$login'"); 
                if (!$result) throw new Exception($connect->error);
                $login_num = $result->num_rows;
                if($login_num>0)
                {
                    $is_ok=false;
                    $_SESSION['login_error']='Uzytkownik o podanym loginie już istnieje';            
                }
                if($is_ok==true)
                {            
                    //umieszczanie do bazy
                    if ($connect->query("INSERT INTO users VALUES (NULL, '$login','$password_hash','$email')"))
                    {
                        //gdy wszystko pojdzie ok - przekierowanie
                        $_SESSION['registration_done']=true;
                        echo "dodano użytkownika";
                        unset($_SESSION['registration_done']);
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
            //echo $error;
        }       
    }
?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
<head>
<title>Rejestracja użytkownika</title>
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
		    <a href="main.php" class="btn">Panel Administratora</a>
            				
	    </nav>
</header>
<section class="container">

<div id="loginform">
    <form method="post" id="form"> 
        <h2>Login:</h2>    
            <input type="text" name="login">
            <?php
                
                if(isset($_SESSION['login_error']))
                {
                    echo '<div class="error">'.$_SESSION['login_error'].'</div>';
                    unset($_SESSION['login_error']);
                }
            ?>
        <h2>E-mail:</h2>    
            <input type="mail" name="email">
            <?php
                
                if(isset($_SESSION['mail_error']))
                {
                    echo '<div class="error">'.$_SESSION['mail_error'].'</div>';

                    unset($_SESSION['mail_error']);
                }
            ?>
        <h2>Hasło:</h2>    
            <input type="password" name="password1">
            <?php
                
                if(isset($_SESSION['pass_error']))
                {
                    echo '<div class="error">'.$_SESSION['pass_error'].'</div>';

                    unset($_SESSION['pass_error']);
                }
            ?>
        <h2>Powtórz hasło:</h2>    
            <input type="password" name="password2">
            <?php
                
                if(isset($_SESSION['pass_identity_error']))
                {
                    echo '<div class="error">'.$_SESSION['pass_identity_error'].'</div>';

                    unset($_SESSION['pass_identity_error']);
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

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>