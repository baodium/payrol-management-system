<?php
require 'pdf/fpdf.php';
include_once 'controller/class.main.php';
$payroll=new payroll();

session_start();
if(!isset($_SESSION['payrolluser']) && !isset($_SESSION['employee']))
header("location:index.php");

$slip=$payroll->getPaySlip($_GET['id'], $_GET['mm'], $_GET['yy']);
if($slip==NULL)
header("location:index.php");


$slip=$slip[0];

$x=50;



$pdf=new FPDF('p', 'pt', 'Letter');
 $pdf->SetFont('Times','B',20);
 $pdf->addPage();
 $pdf->SetFillColor(255,0,0);
 $pdf->SetAutoPageBreak(0,1);
 
 $pdf->setXY($x,50);
$pdf->setXY($x,50);
 $pdf->Image('pdf/unilogo.jpg',$x,30,70,50,'JPG');
 $pdf->setXY($x,100);
 $pdf->setXY($x+60,30);
 $pdf->Write(25,'ODUDUWA UNIVERSITY, IPETUMODU');
 $pdf->SetFont('Times','B','16');
 $pdf->setXY($x+200,60);
 $pdf->Write(20,'Employee Payslip');
  $pdf->setXY($x,55+20);
 $pdf->cell(0,11," ",'B',2,'L', false);
 $pdf->SetFont('courier','','12');
$y=150;
  $pdf->setXY($x+30,$y);
  $pdf->Write(20,'Date:');
  $pdf->setXY($x+100,$y);
  $pdf->Write(20,$slip['date_paid']);
  
  $pdf->setXY($x+30,$y+30);
  $pdf->Write(20,'Name:');
  $pdf->setXY($x+100,$y+30);
  $pdf->Write(20,$slip['employeeName']);
  
  $pdf->setXY($x+30,$y+60);
  $pdf->Write(20,'Staff ID:');
   $pdf->setXY($x+100,$y+60);
  $pdf->Write(20,strtoupper($slip['employeeId']));
  
  
  $pdf->setXY($x+30,$y+90);
  $pdf->Write(20,'Level:');
  $pdf->setXY($x+100,$y+90);
  $pdf->Write(20,$slip['level']);
 

  
  $pdf->setXY($x+30,$y+120);
  $pdf->Write(20,'Address:');
  $pdf->setXY($x+100,$y+120);
 $pdf->Write(20,$slip['address']);
  
  $pdf->setXY($x+30,$y+150);
  $pdf->Write(20,'Email:');
   $pdf->setXY($x+100,$y+150);
  $pdf->Write(20,$slip['email']);
  

 //$pdf->SetFont('Times','B',14);
 $y=400;
  $pdf->SetFont('Arial','B','8');
  $pdf->setXY($x+220,$y-20);
   $pdf->Write(20,' SUMMARY');
   $x=$x+30;
  $pdf->setXY($x,$y);
  $pdf->MultiCell(40, 20, "Month", 1 , 'C' , 0);
  $pdf->setXY($x+40,$y);
  $pdf->MultiCell(40, 20, "Year ", 1 , 'C' , 0);
  $pdf->setXY($x+40+40,$y);
  $pdf->MultiCell(60, 20, "Gross Pay ", 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60,$y);
  $pdf->MultiCell(60, 20, "Union Due ", 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60+60,$y);
  $pdf->MultiCell(60, 20, "Income Tax ", 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60+60+60,$y);
  $pdf->MultiCell(90, 20, "Pension Deduction ", 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60+60+60+90,$y);
  $pdf->MultiCell(60, 20, "Net Pay ", 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60+60+60+90+60,$y);
  $pdf->MultiCell(80, 20, "Date Paid ", 1 , 'C' , 0);
  
  $pdf->setXY($x,$y+20);
  $pdf->SetFont('courier','','8');
  $pdf->MultiCell(40, 20, date('M.', mktime(0, 0, 0, $slip['month'], 1, $slip['year'])), 1 , 'C' , 0);
  $pdf->setXY($x+40,$y+20);
  $pdf->MultiCell(40, 20, $slip['year'], 1 , 'C' , 0);
  $pdf->setXY($x+40+40,$y+20);
  $pdf->MultiCell(60, 20, $slip['gross_pay'], 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60,$y+20);
  $pdf->MultiCell(60, 20, $slip['association_due'], 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60+60,$y+20);
  $pdf->MultiCell(60, 20, $slip['income_tax'], 1 , 'C' , 0);
  $pdf->setXY($x+40+40+60+60+60,$y+20);
  $pdf->MultiCell(90, 20, $slip['pension_deduction'], 1 , 'C' , 0);
 $pdf->setXY($x+40+40+60+60+60+90,$y+20);
  $pdf->MultiCell(60, 20, $slip['net_pay'], 1 , 'C' , 0);
   $pdf->setXY($x+40+40+60+60+60+90+60,$y+20);
  $pdf->MultiCell(80, 20, $slip['date_paid'], 1 , 'C' , 0);
 
 
  

 
 $pdf->setXY($x+225-90,680+35);
 $pdf->SetFont('Arial','I','6');
 $pdf->Write(20,'Electronic Payroll System. Designed By Falegan Taiwo Martha (U/10/CS/0006). ');
 $pdf->setXY($x+40,680+55);
 $pdf->Write(20,'A project submitted to Computer Science Department, Oduduwa University, Ipetumodu in partiall fulfillment of the award of B.Sc. (Supervisor : Mr. Yisa) ');
 $pdf->Output('simplu.pdf','D');//F(file system),I(to browser),D(to browser and force download), S(string format)

?> 