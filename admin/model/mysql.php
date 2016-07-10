<?php
require_once'dbconfig.php';
final class mysql {
	private $handle;
	private $fileType;
	
	public function __construct() {
	
		if (!$this->handle = mysql_connect(SERVER, USERNAME, PASSWORD)) {
      		exit('Error: Could not establish  connection to database using ' . USERNAME . '@' . SERVER);
    	}

    	if (!mysql_select_db(DATABASE, $this->handle)) {
      		exit('Error: Could not connect to database ' . DATABASE);
    	}
		
		mysql_query("SET NAMES 'utf8'", $this->handle);
		mysql_query("SET CHARACTER SET utf8", $this->handle);
  	}
		
  	private function query($sql) {
	$result=array();
	$resource=mysql_query($sql);
	if(@mysql_num_rows($resource)>0){
	 while($value=mysql_fetch_assoc($resource)){
	 $result[]=$value;
	 }
	 return $result;
	 }
	else return NULL;	
  	}
	
	 private function update($squel) {
	    if(mysql_query($squel))
	    return true;
	    return false;	
  	}
	
	function delete($id,$tableName){
	$sql= "DELETE FROM {$tableName} WHERE c_id='{$id}' ";
	return $this->update($sql);
	}
	
	function activate($id,$tableName){
	$sql= "UPDATE {$tableName} SET status='active' WHERE c_id='{$id}' ";
	return $this->update($sql);
	}
	
	function deActivate($id,$tableName){
	$sql= "UPDATE {$tableName} SET status='pending' WHERE c_id='{$id}' ";
	return $this->update($sql);
	}
	
	private function query2($sql) {
	$result=array();
	$resource=mysql_query($sql);
	if(@mysql_num_rows($resource)>0){
	 while($value=mysql_fetch_assoc($resource)){
	 $result[$value['level']]=$value;
	 }
	 return $result;
	 }
	else return NULL;	
  	}
	
	
	
	function loadEmployee($id){
	$sql="SELECT * FROM employee WHERE employeeId='$id'";
	return $this->query($sql);
	}
	
	function loadLastRoll($month, $year){
	
	$sql="SELECT payroll.*, employee.employeeName FROM payroll, employee WHERE payroll.month='$month' AND payroll.year='$year' AND payroll.employeeId=employee.employeeId ";
	return $this->query($sql);
	}
	
function verifyAdmin($param){
$param['username']=htmlspecialchars(strip_tags($param['username']));
$password=md5(htmlspecialchars(strip_tags($param['password'])));
$sql= "SELECT * FROM admin WHERE username='{$param['username']}' AND password= '$password' ";
return $this->query($sql);
}

 function login($param,$table){
 $username=htmlspecialchars(strip_tags($param['username']));
$password=htmlspecialchars(strip_tags($param['password']));

 $sql= "SELECT * FROM {$table} WHERE username='{$username}' AND password= '{$password}' ";

 return $this->query($sql);
}
function userLogin($param,$table){
$username=htmlspecialchars(strip_tags($param['username']));
$password=htmlspecialchars(strip_tags($param['password']));
 $sql= "SELECT * FROM {$table} WHERE employeeId='{$username}' AND password= '{$password}' ";
 
 return $this->query($sql);
}

function loadLedger($year,$id){
//$sql="SELECT * FROM payroll WHERE year= '$year' AND employeeId= '$id'";
$sql = "SELECT payroll.*, employee.employeeName FROM payroll, employee WHERE payroll.employeeId='$id' AND employee.employeeId='$id' AND payroll.year= '$year' ORDER BY sn DESC";
return $this->query($sql);
}



function getLastPayment(){
	$sql = 'SELECT * FROM payroll ORDER BY sn DESC LIMIT 1';
	return $this->query($sql);
	}
	
	function doPayroll($param,$result){
	$employees=$this->getAllEmployee();
	//$payroll=$this->getLastPayment();
	$rates=$this->loadRates2();
	$deductions=$this->loadDeductions();
	//var_dump(array_search('GA', $rates[0]) );
	//var_dump($deductions);
//var_dump($employees); exit;
$today=date('m/d/Y');
$i=0;
foreach($employees as $employee){
$days_present=$result[$i]['days_present'];
$level=$employee['level'];
if($days_present<18)
$absence_deduction=($deduction['absence_deduction']/100)*$grosspay;
else
$absence_deduction=0.00;
$hours_worked=$rates[$level]['hours_worked'];
$grosspay=$rates[$level]['workrate'];//pension_plan
$association_due=($employee['union']=='No')?0.00:($deductions[0]['association']/100)*$grosspay;
$pension_deduction=($employee['pension_plan']=='No')?0.00:($deductions[0]['pension']/100)*$grosspay;
$income_tax=($deductions[0]['income_tax']/100)*$grosspay;
//$absence_deduction=$deduction[0]['absence_deduction']
$netpay=$grosspay-($association_due+$pension_deduction+$income_tax);

$sql= "UPDATE payroll SET  association_due='$association_due', pension_deduction='$pension_deduction', income_tax='$income_tax', gross_pay='$grosspay', net_pay='$netpay',absence_deduction='$absence_deduction', date_paid= '$today'   WHERE employeeId='{$employee['employeeId']}' ";

$this->update($sql);
}
return true;
	}
	
function pay($param){
//var_dump($param); exit;
$result=array();
$sql="SELECT * FROM payroll";
if($this->query($sql)==NULL){
//$this->doPayroll($param);
//$sql="INSERT INTO payroll";
}

$sql="SELECT * FROM payroll WHERE month='{$param['month']}' AND year= '{$param['year']}' ";
if($this->query($sql)!=NULL){
$result['status']=false;
$result['message']='You have already activated the payment for '. date('M.', mktime(0, 0, 0, $param['month'], 1, $param['year'])).' '.$param['year'];
return $result;
}else{
$last_month=$param['month']-1;
$sql="SELECT * FROM payroll WHERE year='{$param['year']}'  AND month='$last_month' ";
if(count($this->query($sql))< 1){
$result['status']=false;
$result['message']='You must activate the payment for the latest month first';
return $result;//$sql="SELECT * FROM payroll WHERE month='$last_month' ";
}else{
//$this->doPayroll($param);
$result['status']=true;
$result['message']='done';
}

}
return $result; 
}


function updatePayroll($filename,$month,$year){
$param=array('month'=>$month,'year'=>$year);
$row = 1;
$each=array();

if (($handle = fopen("http://localhost/payroll/admin/list/".$filename, "r")) !== FALSE) {
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
	$total=0;
	for($i=1; $i<count($each); $i++){
	$detail['id']=$each[$i][0];
	$detail['name']=$each[$i][1];
	$detail['month']=$each[$i][2];
	$detail['year']=$each[$i][3];
	$num_days=0;
	$empty=0;
	for($j=4;$j<count($each[$i]); $j++){
	if($each[$i][$j]=='1')
	$num_days+=$each[$i][$j];
	if($each[$i][$j]==' ')
	$empty+=1;
	}
	$total+=$num_days;
	$detail['days_present']=$num_days;
	$result[]=$detail;
	}
	
	if($month!=$result[0]['month'] || $year!=$result[0]['year'])
	return "The uploaded attendance list is not for the selected month/year";
	//var_dump($result); exit;
	$sql="SELECT * FROM payroll";
if($this->query($sql)==NULL){
foreach($result as $res){
	//foreach($param as $key=>$value){
	$sql="INSERT INTO payroll (employeeId,month,  year, days_present ) VALUES ( '{$res['id']}', '{$res['month']}', '{$res['year']}', '{$res['days_present']}' ) ";
   $this->update($sql);
	
	}
return $this->doPayroll($param,$result);
	}else{
	
		if($total==0)
	return "You have uploaded an unfilled attendance list, please upload another list";
	

$sql="SELECT * FROM payroll WHERE month='$month' AND year= '$year' ";
if($this->query($sql)!=NULL){
return 'You have already activated the payment for '. date('M.', mktime(0, 0, 0, $month, 1, $year)).' '.$year;
}else{
$last_month=$month-1;
//var_dump($year);exit;
$sql="SELECT * FROM payroll WHERE year= '$year'  AND month='$last_month' ";
if(count($this->query($sql))< 1){
return 'You must activate the payment for the latest month and year first';
//$sql="SELECT * FROM payroll WHERE month='$last_month' ";
}else{
$rates=$this->loadRates2();
foreach($result as $res){
	//foreach($param as $key=>$value){
	$sql="INSERT INTO payroll (employeeId,month,  year, days_present ) VALUES ( '{$res['id']}', '{$res['month']}', '{$res['year']}', '{$res['days_present']}' ) ";
   $this->update($sql);
	
	}
return $this->doPayroll($param,$result);
//return"Yes";
}
//var_dump("Yes"); exit;
}
}
	fclose($handle);
	return true;
	
    
}

}

function getLastLedger($id){
$sql = "SELECT payroll.*, employee.employeeName FROM payroll, employee WHERE payroll.employeeId='$id' AND employee.employeeId='$id' ORDER BY sn DESC LIMIT 1";
return $this->query($sql);
}

	function updateImage($filename,$id){
//var_dump($id);exit;
	$sql="UPDATE `birth_info` SET image='$filename' WHERE c_id='$id' ";
	//var_dump($this->update($sql));exit;//
	return $this->update($sql);
	
	}

	function getPaySlip($id,$month,$year){
   $sql="SELECT payroll.*, employee.* FROM payroll,employee WHERE payroll.employeeId='$id' AND  payroll.month='$month' AND payroll.year='$year' AND payroll.employeeId=       employee.employeeId ";

return $this->query($sql);
}

function checkExistence($id){
$que="SELECT * FROM employee WHERE employeeId='$id' ";
//var_dump(($this->query($que))); exit;
if($this->query($que)==NULL)
return true;
return false;
}

function addEmployee($param){


$pass=explode(" ", $param['employeeName']);
$password=strtolower($pass[0]);
$sql="INSERT INTO employee (employeeId, employeeName, type,  level, dateofbirth, years_in_service, phone, email, address, password ) VALUES ('{$param['employeeId']}','{$param['employeeName']}' ,'{$param['type']}' ,'{$param['level']}' ,'{$param['date_of_birth']}', '{$param['year_in_service']}', '{$param['phone']}', '{$param['email']}', '{$param['address']}', '$password' ) ";
return $this->update($sql);
}


function saveEmployee($id, $param){
$pass=explode(" ", $param['employeeName']);
$password=strtolower($pass[0]);
$sql= "UPDATE employee SET  employeeName='{$param['employeeName']}', type='{$param['type']}', level='{$param['level']}', dateofbirth='{$param['date_of_birth']}', years_in_service='{$param['year_in_service']}', phone= '{$param['phone']}', email='{$param['email']}', address='{$param['address']}', password= '$password'   WHERE employeeId='{$id}' ";
return $this->update($sql);
}

function addUser($param){
$pass=explode(" ", $param['employeeName']);

$password=strtolower($pass[0]);
$sql="INSERT INTO employee (employeeId, employeeName, type,  level, dateofbirth, years_in_service, phone, email, address, password ) VALUES ('{$param['employeeId']}','{$param['employeeName']}' ,'{$param['type']}' ,'{$param['level']}' ,'{$param['date_of_birth']}', '{$param['year_in_service']}', '{$param['phone']}', '{$param['email']}', '{$param['address']}', '$password' ) ";
return $this->update($sql);
}
	


 
 function getAllEmployee(){
$sql="SELECT * FROM employee";
return $this->query($sql);
 }
 
 function loadDeductions(){
 $sql="SELECT * FROM deductions";
 return $this->query($sql);
 }
 
 function changeDeduction($param){

 $date_modified=date('m/d/Y');
 $sql= "UPDATE deductions SET association='{$param['association']}', income_tax='{$param['income_tax']}',  pension='{$param['pension']}', charges='monthly', last_update='$date_modified', absence_deduction='{$param['absence']}' ";
return $this->update($sql);
 
 }
 
 

 
	
	
	function loadGenInfo(){
	$sql="SELECT c_id, surname, othernames FROM `general_info` ";
	return $this->query($sql);
	}
	
    function register($param){
    $today=date("y.m.d");
    $squl="SELECT * FROM  members  WHERE USERNAME='{$param['username']}' ";
    if($this->query($squl)!=NULL)
    return 0;
    $password=$param['password'];
    $password=md5($password);
    $sql=" INSERT INTO members (USERNAME,PASSWORD,EMAIL,REG_DATE) VALUES ('{$param['username']}', '$password','{$param['email']}','{$today}')";
    return $this->update($sql);
    }

	function addToNewsLetterList($email){
	$today=date("Y.m.d");
	$sql=" INSERT INTO newsletter (email,dateadded) VALUES ('{$email}','{$today}')";
	return $this->update($sql);
	}
	
	function inList($email){
	$sql="SELECT email FROM  newsletter  WHERE email='{$email}' ";//.$pagination_query;
	return $this->query($sql);
	}
	

function changeSalary($param){
//var_dump($param); exit;	
$que="SELECT * FROM rates";
if($this->query($que)==NULL){
foreach($param as $key=>$value){
$sql="INSERT INTO rates (level, workrate, charges, hours_worked) VALUES ('$key', '$value', 'monthly', '180' )";
//var_dump($this->update($sql));
}
return true;
}
else{
	//$i=1;
	foreach($param as $key=>$value){
	$sql="UPDATE rates SET  workrate='$value' WHERE level='$key' ";
	//$i++;
		if(!$this->update($sql))
	return false;
	}
	
	return true;
	//"UPDATE {$tableName} SET status='active' WHERE c_id='{$id}' ";
	}
	
	
	}
	function loadRates(){
	$sql="SELECT * FROM rates ";
	return $this->query($sql);
	}
	
	function loadRates2(){
	$sql="SELECT * FROM rates ";
	return $this->query2($sql);
	}
	
	public function __destruct() {
	mysql_close($this->handle);
	}
}
?>
