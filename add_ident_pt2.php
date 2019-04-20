<?php
    
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);
    $types = mysqli_query($connect,"SELECT * FROM ident_type "); 
    //$ident = mysqli_query($connect,"INSERT INTO idents VALUES") 
    @$id_type = $_POST['identtype'];
    @$name = $_POST['name'];
    @$lastname = $_POST['lastname'];
    $login = $_SESSION['login'];

    

    //echo $_SESSION['type2'];
    //echo '<h2>'.$_POST['identtype'].'</h2>';
    $sql = mysqli_query($connect,"SELECT type_2 FROM ident_type WHERE type = '".$_POST['identtype']."'");      
    $row = mysqli_fetch_array($sql);
        //$row['type_2'] = $type2;
    //echo $row['type_2'];

    @$typeid = $row['id'];
    //echo '<br><br>';
    switch ($row['type_2']) 
    {
        case "Identyfikator bezstrefowy":
            include("non_zone.php");
            break;
        case "Identyfikator strefowy":
            include("zone.php");
            break;
        case "Wjazdówka":
            require("entry.php");
            break;
    }
?>  
