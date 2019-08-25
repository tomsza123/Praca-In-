<?php
    session_start();
    if(!isset($_SESSION['logged']))
    {
        header('Location: index.php');
        exit();
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
    <th></th>
    <th><a href="zones.php?s=id&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Id</a></th>
    <th><a href="zones.php?s=type&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>">Strefa</a></th>
    <th>Akcja</th>
</tr>
</thead>
<?php
    require_once "connect.php";
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);
    if(!isset($_GET['s']))
    {
        $zones = mysqli_query($connect,"SELECT * FROM zone ");
    }
    else
    {
        $s = $_GET['s'];
        $order = $_GET['order'];
        //sortowanie rosnaco lub malejąco
        if($order == 1)
        {
            $zones = mysqli_query($connect,"SELECT * FROM zone ORDER BY $s ASC");
        }
        else
        {
            $zones = mysqli_query($connect,"SELECT * FROM zone ORDER BY $s DESC");
            //$order = '1';
        }
    }

    if(mysqli_num_rows($zones) > 0) 
    {
        /* jeżeli wynik jest pozytywny, to wyświetlamy dane */
        
        while($r = mysqli_fetch_array($zones)) 
        {
            echo "<tr>";
            echo '<td> <input type="checkbox" name="checkbox[]" value="'.$r['id'].'"></input> </td>';
            echo "<td>".$r['id']."</td>";
            echo "<td>".$r['zone']."</td>";
            echo "<td>
           <a href=\"zones.php?a=del&amp;id={$r['id']}\">Usuń</a>
           <a href=\"edit_zone.php?id={$r['id']}\">Edytuj</a>
           </td>";
            echo "</tr>";
        }
    }
?>
</table>
<div>
<div id="footer">

        <!--<button class="button" onclick="window.location.href='add_ident.php' ">Dodaj identyfikator</button>-->
        <button class="submit" name="add" value="add">Dodaj strefę</button>
        <!--<button class="submit" name="generate" value="generate">Wygeneruj wybrane</button>-->
        <button class="submit" name="delete" value="delete">Usuń wybrane</button>
        </form>
</div>
</form>

</section>

</body>
</html>

<?php
    if(isset($_GET['id']) && $_GET['a']=='del')
    {
        $id = $_GET['id'];//jesli usuwana strefa jest przypisana do identyfikatora to zapytaj czy na pewno usunac strefe, po czym usuń identyfikatory zawierajace tą strefę.
        $connect->query("DELETE FROM zone WHERE id = '$id'");
        $connect->close();
        header("location: zones.php");
    }
    if(isset($_POST['delete']))//do usuwania identów
    {        
        if(!empty($_POST['checkbox']))
        {
            foreach($_POST['checkbox'] as $selected)
            {
                $connect->query("DELETE FROM zone WHERE id = '$selected'");                
            }
            $connect->close();
            header("location: zones.php");
        }
    }
    if(isset($_POST['add']))
    {
        
        header('location: add_zone.php');
    }
?>