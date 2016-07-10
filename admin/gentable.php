<?php
include '../controller/class.main.php';


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
$data[2]=$month;
$data[3]=$year;
for($day=1; $day<=31; $day++){
//$days='Day '.$day;
/*
if($day>8)
$data[]='1';
else
$data[]='0';
*/
}
$list[]=$data;
//$list[]=array($employee['employeeId'], $employee['employeeName'], 'jan','2013');
}

$fp = fopen('list/'.$month.'_'.$year.'.csv', 'w+');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}
$filename=''.$month.'_'.$year.'.csv';
fclose($fp);
header("location:http://localhost/payroll/admin/list/".$filename);
}

//var_dump($_POST);
if(isset($_POST['load_emp'])){
$month=$_POST['month'];
$year=$_POST['year'];
makeList($month,$year);
}

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
	$num_days+=$each[$i][$j];
	}
	$detail['days_present']=$num_days;
	$result[]=$detail;
	}
	
	var_dump($result);
    fclose($handle);
}
*/