<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        exit();
        header('Location: index.php');
        
    }
    //require('fpdf.php');
    //header('location: idents.php');
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);

    if(isset($_GET['id']) && $_GET['a']=='del')
    {
        $id = $_GET['id'];
        $connect->query("DELETE FROM ident WHERE id = '$id'");
        unset($_GET['id']);
        unset($_GET['a']);
        //$connect->close();
        header("location: idents.php?");
        
    }
    if(isset($_POST['generate']))//do generowania pdfów
    {        
        if(!empty($_POST['checkbox']))
        {
            $i=0;
            foreach($_POST['checkbox'] as $selected)
            {
                $sel[$i] = $selected;
                $i++;
            }
            $_SESSION['howmuch'] = $i;
            $_SESSION['idents'] = $sel;
            header('location: generate.php');
            
        }
    }
    if(isset($_POST['delete']))//do usuwania identów
    {        
        if(!empty($_POST['checkbox']))
        {
            foreach($_POST['checkbox'] as $selected)
            {
                $connect->query("DELETE FROM ident WHERE id = '$selected'");                
            }
            $connect->close();
            header("location: idents.php");
        }
    }
    if(isset($_POST['add']))
    {
       header('location: add_ident.php');
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
        <a href="#" class="btn open-menu">&#9776;</a>
	    <nav class="clearfix">
		    <a href="#" class="btn hide">&laquo; Zamknij</a>
            <a href="main.php" class="btn">Główna</a>
            <a href="logout.php" class="btn">Wyloguj</a>          
	    </nav>
</header>
<section class="container">
<form method="POST">

<table>
<thead>
<tr>
    <th><input type="checkbox" onClick="toggle(this)" /> <br/></th><!--mozna poprawic na metode post-->
    <th><a href="idents.php?s=id&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Id</a></th>
    <th><a href="idents.php?s=name&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Nazwa</a></th>
    <th><a href="idents.php?s=name_2&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Imię</a></th>
    <th><a href="idents.php?s=lastname&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Nazwisko</a></th>
    <th><a href="idents.php?s=madeby&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Utworzony przez</a></th>
    <th><a href="idents.php?s=edited_by&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Edytowany przez</a></th>
    <th><a href="idents.php?s=type&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Typ</a></th>
    <th><a href="idents.php?s=zone&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Strefa</a></th>
    <th>Usuń/Edytuj</th>
</tr>
</thead>
<?php
    

    

    

    if(!isset($_GET['s']))
    {
        $idents = mysqli_query($connect,"SELECT * FROM ident ");
    }
    else
    {
        $s = $_GET['s'];
        $order = $_GET['order'];
        
        if($order == 1)
        {
            $idents = mysqli_query($connect,"SELECT * FROM ident ORDER BY $s ASC");
        }
        else
        {
            $idents = mysqli_query($connect,"SELECT * FROM ident ORDER BY $s DESC");
            
        }
        
        
    }

    if(mysqli_num_rows($idents) > 0) 
    {
        
        /* jeżeli wynik jest pozytywny, to wyświetlamy dane */
        echo "";
        while($r = mysqli_fetch_array($idents)) 
        {
            echo "<tr>";
            echo '<td> <input type="checkbox" name="checkbox[]" value="'.$r['id'].'"></input> </td>';
            echo "<td>".$r['id']."</td>";
            echo "<td>".$r['name']."</td>";
            echo "<td>".$r['name_2']."</td>";
            echo "<td>".$r['lastname']."</td>";
            echo "<td>".$r['madeby']."</td>";
            echo "<td>".$r['edited_by']."</td>"; 
            echo "<td>".$r['type']."</td>";
            echo "<td>".$r['zone']."</td>";
            echo "<td>
           <a href=\"idents.php?a=del&amp;id={$r['id']}\">Usuń</a>
           <a href=\"edit_ident.php?id={$r['id']}\">Edytuj</a>
           </td>";
            echo "</tr>";
        }
    }
?>
</table>
<div>
<div class="center">

        <!--<button class="button" onclick="window.location.href='add_ident.php' ">Dodaj identyfikator</button>-->
        <button class="submit" name="add" value="add">Dodaj identyfikator</button>
        <!--<button class="submit"><a href="add_ident.php">Dodaj nowy</a></button>-->
        <button class="submit" name="generate" value="generate">Wygeneruj wybrane</button>
        <button class="submit" name="delete" value="delete">Usuń wybrane</button>
        </form>
</div>
</form>

</section>
<div id="footer">
    <b>prawa zaszczeżone</b>
</div>
</body>
</html>

