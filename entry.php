<?php 
    echo '<h2>Tablica Rejestracyjna</h2>';
    echo '<input type="text" name="name">'; 
    echo '<h2>Nazwa(opcjonalnie)</h2>';
    echo '<input type="text" name="lastname">';
    $number = 1;

    if(isset($name))
    {
        if ($connect->query("INSERT INTO idents VALUES (NULL, '$typeid','$name','$lastname',$number,'$login')"))
        {
            $_SESSION['ident_done']=true;
            echo "dodano identyfikator";
            unset($_SESSION['ident_done']);
        }
        else
        {
            echo "źle";
            echo $connect->error;
            //throw new Exceptipon($connect->error);
        }
    }
    else
    {
        echo "źle";
    }
    
?>