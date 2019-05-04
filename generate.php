<?php
    session_start();

    $indeks = $_SESSION['idents'];
    $i =  $_SESSION['howmuch'];

    require_once 'connect.php';
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);

    require('fpdf.php');
    
    $pdf = new FPDF ('P','mm','A5');
    //$pdf ->AddPage();
    
    
    $ident = array();

    
    
    $back = array();
    $type_2 = array();

    for($j=0;$j<$i;$j++)
    {
        $ident[$j] = mysqli_query($connect,"SELECT * FROM ident WHERE id = $indeks[$j]");
        if(mysqli_num_rows($ident[$j]) > 0) 
        {
            while($r = mysqli_fetch_array($ident[$j]))
            {
                $id[$j] = $r['id'];
                $name[$j] = $r['name'];
                $name_2[$j] = $r['name_2'];
                $lastname[$j] = $r['lastname'];
                $madeby[$j] = $r['madeby'];
                $type[$j] = $r['type'];
                $zone[$j] = $r['zone'];

                $stype = $type[$j];
                $bg_query = mysqli_query($connect,"SELECT background FROM ident_type WHERE type = '$stype'");

                $bg = ' ';//wyciąganie adresu z drugiej tabeli w bazie odpowiadającego wybranemu rodzajowi identyfikatora
                while($row = mysqli_fetch_array($bg_query))
                {
                    $bg = $row['background'];
                }
            } 
        }
        $pdf ->AddPage();
        
        $pdf->Image($bg, 0, 0, 0, 0);

        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(192);
        $pdf->Rect(10, 100, 40, 30, 'DF');

        $pdf ->SetFont('Helvetica','B',16);
        $pdf ->SetTextColor(255,255,255);
        $pdf ->Text(15,110,$name[$j]);

        $pdf ->SetFont('Helvetica');
        $pdf ->SetTextColor(0,0,0);
        $pdf ->Text(15,120,$type[$j]);
        

        //$pdf ->Text(15,130,$bg);
    }
    $pdf->Output();
    
    

    


    //unset($_SESSION['idents']);
?>