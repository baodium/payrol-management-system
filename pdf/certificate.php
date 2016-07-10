<?php
require 'fpdf.php';


$author="Meee";
$x=50;
$text="This is to certify that the following information has been taken from the original record of birth";
$text2="which is in the register for ADEDAYO Ayodele Olubunmi of Ife Central Local Government,"; 
$text3="Ile-Ife, Osun State. ";
 $pdf=new FPDF('p', 'pt', 'Letter');
 $pdf->SetFont('Times','B',24);
 $pdf->addPage();
 $pdf->SetFillColor(255,0,0);
 
 
 $pdf->setXY($x,50);
 $pdf->Image('logo.png',$x,30,50,50,'PNG');
  $pdf->Image('capture.jpg',$x,150,500,500,'JPG');
 $pdf->setXY($x,100);
 $pdf->setXY($x+80,30);
 $pdf->Write(25,'NATIONAL POPULATION REGISTRY');
 $pdf->SetFont('Times','B','18');
 $pdf->setXY($x+150,60);
 $pdf->Write(20,'CERTIFICATE OF BIRTH');
  $pdf->setXY($x,55+20);
 $pdf->cell(0,11," ",'B',2,'L', false);
 $pdf->SetFont('courier','','10');
 $pdf->SetTextColor(255,0,0);
  $pdf->SetFont('Times','B','12');
 $pdf->setXY($x+350,70+40);
 $pdf->cell(0,11," ",'B',2,'L', false);
 $pdf->setXY($x+390,80+40);
 $pdf->Write(20,'Registration Number');
 

 
 $pdf->SetFont('Arial','','12');
 $pdf->SetTextColor(0,0,0);
 $pdf->setXY($x+20,120+30);
 $pdf->Write(13,$text);
 $pdf->setXY($x,150+30);
  $pdf->Write(13,$text2);
  $pdf->setXY($x,180+30);
  $pdf->Write(13,$text3);
  $pdf->SetFont('Arial','B','12');
  $pdf->setXY($x,250);
  $pdf->cell(0,20,'DETAIL',1,0,'C',false);
  $pdf->setXY($x,250);
  $y=320;
  $pdf->cell(0,350,'',1,0,'C',false);
  $pdf->setXY($x+50,$y-30);
  $pdf->Write(20,'Surname:');
  $pdf->setXY($x+50,$y);
  $pdf->Write(20,'Othernames:');
  $pdf->setXY($x+50,$y+30);
  $pdf->Write(20,'Date of Birth:');
  $pdf->setXY($x+50,$y+60);
  $pdf->Write(20,'Sex:');
  $pdf->setXY($x+50,$y+90);
  $pdf->Write(20,'Place Of Birth:');
  $pdf->setXY($x+50,$y+120);
  $pdf->Write(20,'Date Of Registration:');
  $pdf->setXY($x+50,$y+150);
  $pdf->Write(20,'Father\'s Name:');
   $pdf->setXY($x+50,$y+180);
  $pdf->Write(20,'Mother\'s Name:');
   $pdf->setXY($x+50,$y+210);
  $pdf->Write(20,'Address:');
  $pdf->setXY($x,680-10);
 $pdf->cell(150,11,"",'B',2,'L', false);
 $pdf->setXY($x,680);
 $pdf->Write(20,'Signature');
 $pdf->setXY($x+350,680-10);
 $pdf->cell(150,11,"",'B',2,'L', false);
 $pdf->setXY($x+350,680);
 $pdf->Write(20,'Signature');
 $pdf->setXY($x+225,680+35);
 $pdf->SetFont('Arial','I','8');
 $pdf->Write(20,'Copyrite 2013, NPR ');
 $pdf->Output('simple2.pdf','F');//F(file system),I(to browser),D(to browser and force download), S(string format)
?> 