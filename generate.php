<?php
    session_start();

    $indeks = $_SESSION['idents'];
    $i =  $_SESSION['howmuch'];

    if((!isset($indeks)) && (!isset($i)))
    {
        header('location:idents.php');
    }

    require_once 'connect.php';
    $connect = @new mysqli($host,$db_user,$db_password,$db_name);

    require('fpdf.php');
    require('phpqrcode/qrlib.php');
    
    $pdf = new FPDF ('P','mm','A5');

    $ident = array();
    
    $back = array();
    $type_2 = array();

    

    for($j=0;$j<$i;$j++)
    {
        $pdf ->AddPage();
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
        $qrinfo = new QRcode();
        $qrinfo = QRcode::png($name[$j].' / '.$name_2[$j].' / '.$lastname[$j].' / '.$type[$j].' / '.$zone[$j] , "temp_qr/qr".$j.".jpg");
        
        
        $pdf->Image($bg, 0, 0, 0, 0);

        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(255);
        $pdf->Rect(10, 90, 95, 10, 'DF');

        $pdf ->SetFont('Arial','B',16);
        $pdf ->SetTextColor(0,0,0);
        $pdf ->Text(15,97,$name[$j]);

        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(255);
        $pdf->Rect(10, 105, 95, 10, 'DF');

        $pdf ->SetFont('Arial');
        $pdf ->SetTextColor(0,0,0);
        $pdf ->Text(15,112,$name_2[$j]);

        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(255);
        $pdf->Rect(10, 120, 95, 10, 'DF');

        $pdf ->SetFont('Arial');
        $pdf ->SetTextColor(0,0,0);
        $pdf ->Text(15,127,$lastname[$j]);

        $pdf->Image('temp_qr/qr'.$j.'.jpg', 70, 30, 0, 0, 'PNG');
        unlink('temp_qr/qr'.$j.'.jpg');
        

        //$pdf ->Text(15,130,$bg);
    }
    $pdf->Output();

    unset($indeks);
    unset($i);
?>