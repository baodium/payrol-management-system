<?php

if(isset($_POST['add_employee']) || isset($_POST['save_employee'])){
$param=array();
foreach($_POST as $key=>$value){
$param[$key]=$value;
}
foreach($param as $key=>$value)
if(strlen(trim($param[$key]))<1){ 
$errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp; '.$key.' field cannot be empty</div>';
return;
}



if(!is_numeric($param['phone']) || strlen($param['phone'])<11 || strlen($param['phone'])>11){
$errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Invalid phone number</div>';
return;
}
//preg_match('@^(?:http://)?([^/]+)@i',
   // "http://www.php.net/index.html",
if(strpos($param['email'],"@")=== false || strpos($param['email'],".com") === false){
$errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Invalid email address</div>';
return;

}


if(isset($_POST['add_employee'])){
$ct=count(explode("/",$param['employeeId']));
if($ct<'3' || $ct>'3'){
$errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Invalid Employee Id</div>';
return;
}
if(($payroll->addEmployee($param))){
header("location:index.php");
     }else{
     $errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Employee already exist</div>';
     return;
     }

}


if(isset($_POST['save_employee'])){
unset($param['save_employee']);
if(($payroll->saveEmployee($_GET['id'], $param))){
//var_dump($param); exit;
header("location:index.php");
     }else{
	// unset($param);
     $errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Error updating employee</div>';
     return;
     }

}

}


if(isset($_POST['deduct'])){
$param=array();
foreach($_POST as $key=> $value){
$param[$key]=$value;
}

 if(($payroll->changeDeduction($param))){
 $errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/success.png" />&nbsp;Deductions successfully saved</div>';
     return;
//header("location:index.php");
     }else{
	 
     $errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Error adding deductions</div>';
     return;
     }

}


if(isset($_POST['save_rate'])){
$param=array();
foreach($_POST as $key=> $value){
if(strlen(trim($value))>'1')
$param[$key]=$value;

}

//var_dump($_POST); exit;
unset($param['save_rate']);

foreach ($param as $key=>$value){
if(!is_numeric($value)){
$errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Inavalid value for '. $key.' rate</div>';
     return;

}
}


if(($payroll->changeSalary($param))){
header("location:rates.php");
     }else{
     $errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;Error adding deductions</div>';
     return;
     }


}



if(isset($_POST['pay'])){
$month=$_POST['month'];
$year=$_POST['year'];
$response=$payroll->uploadList('image',$month,$year);
/*
$param=array('month'=>$month,'year'=>$year);
$pay=$payroll->pay($param);
//var_dump($pay); exit;
*/
//var_dump($response); exit;
if($response=='true'){
header("location:payroll.php");
}else{
$errorMessage='<div class="error">&nbsp;&nbsp; <img src="images/warning.png" />&nbsp;'.$response.'</div>';
     return;
}

}