<?php
include 'controller/class.main.php';


function makeList($month,$year){
$payroll=new payroll();
$all=$payroll->getAllEmployee();
var_dump($all);

//foreach
//$days='';
$header=array();
$header[0]='employee Id';
$header[1]='employee Name';
$header[2]='Month';
$header[3]='Year';
for($day=1; $day<=31; $day++){
$days='Day '.$day;
$header[]=$days;
}

//$employees=array();


$list = array ();
$list[0]=$header;


foreach ($all as $employee){
$data=array();
$data[0]=$employee['employeeId'];
$data[1]=$employee['employeeName'];
$data[2]='jan';
$data[3]='2013';
for($day=1; $day<=31; $day++){
//$days='Day '.$day;

if($day>9)
$data[]='1';
else
$data[]='0';

}
$list[]=$data;
//$list[]=array($employee['employeeId'], $employee['employeeName'], 'jan','2013');
}

$fp = fopen('jan_2013.csv', 'x+');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
}

makeList('3','2013');
/*
$row = 1;
$each=array();
if (($handle = fopen("jan_2013.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
		
		$each[]=$data;
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		//$each[$row]
        
    }
	$result=array();
	$detail=array();
	//var_dump($each);
	for($i=1; $i<count($each); $i++){
	$detail['id']=$each[$i][0];
	$detail['name']=$each[$i][1];
	$detail['month']=$each[$i][2];
	$detail['year']=$each[$i][3];
	$num_days=0;
	for($j=4;$j<count($each[$i]); $j++){
	//var_dump($each[$i][$j]);
	$num_days+=(int)$each[$i][$j];
	}
	$detail['days_present']=$num_days;
	$result[]=$detail;
	}
	
	var_dump($result);
    fclose($handle);
}*/
