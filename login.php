
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