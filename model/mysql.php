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
	
	function getLastPayment(){
	$sql = 'SELECT * FROM payroll ORDER BY sn DESC LIMIT 1';
	return $this->query($sql);
	}
	
	function getPaySlip($id,$month,$year){
   $sql="SELECT payroll.*, employee.* FROM payroll,employee WHERE payroll.employeeId='$id' AND  payroll.month='$month' AND payroll.year='$year' AND payroll.employeeId=       employee.employeeId ";

return $this->query($sql);
}
	
	function doPayroll($param){
	$employees=$this->getAllEmployee();
	
	$rates=$this->loadRates2();
	$deductions=$this->loadDeductions();
	//var_dump(array_search('GA', $rates[0]) );
	//var_dump($deductions);
	
//var_dump($employees); exit;

foreach($employees as $employee){
$level=$employee['level'];
$hours_worked=$rates[$level]['hours_worked'];
$grosspay=$rates[$level]['workrate'];//pension_plan
$association_due=($employee['union']=='No')?0.00:($deductions[0]['association']/100)*$grosspay;
$pension_deduction=($employee['pension_plan']=='No')?0.00:($deductions[0]['pension']/100)*$grosspay;
$income_tax=($deductions[0]['income_tax']/100)*$grosspay;
$netpay=$grosspay-($association_due+$pension_deduction+$income_tax);

$sql="INSERT INTO payroll (employeeId, hours_worked, month,  year, association_due, pension_deduction, income_tax, gross_pay, net_pay ) VALUES ( '{$employee['employeeId']}', '$hours_worked', '{$param['month']}', '{$param['year']}', '$association_due', '$pension_deduction', '$income_tax', '$grosspay', '$netpay' ) ";
var_dump($this->update($sql));
}
return true;
	}
	
function pay($param){
//var_dump($param); exit;
$result=array();
$sql="SELECT * FROM payroll";
if($this->query($sql)==NULL){
$this->doPayroll($param);
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
$this->doPayroll($param);
$result['status']=true;
$result['message']='done';
}

}
return $result; 
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


function getLastLedger($id){
$sql = "SELECT * FROM payroll WHERE employeeId='$id' ORDER BY sn DESC LIMIT 1";
return $this->query($sql);
}

//pagination($return['result'],$limit,0)
function pagination($result, $per_page ,$page, $url = '?'){  
    
    	//$query = "SELECT COUNT(*) as 'num' FROM books WHERE {$query}";
    	//$row = mysql_fetch_array(mysql_query($query));
		//var_dump($result);exit;
    	$total = count($result);
		//var_dump($total); exit;
        $adjacents = "2"; 
        //$per_page=2;
    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
		//var_dump($per_page);exit;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 

	function updateImage($filename,$id){
//var_dump($id);exit;
	$sql="UPDATE `birth_info` SET image='$filename' WHERE c_id='$id' ";
	//var_dump($this->update($sql));exit;//
	return $this->update($sql);
	
	}

function checkExistence($id){
$que="SELECT * FROM employee WHERE employeeId='$id' ";
//var_dump(($this->query($que))); exit;
if($this->query($que)==NULL)
return true;
return false;
}

function addEmployee($param){
var_dump($param); exit;

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
	



function loadPending($startpoint=null,$limit=null){

//$sql="SELECT c_id, surname, othernames,dob,dod,health information FROM `birth_info` UNION `death_info` UNION `health_info`  WHERE `birth_info.status`='pending' ";
$sql="SELECT DISTINCT birth_info.*, general_info.surname, general_info.othernames FROM birth_info, general_info  WHERE  birth_info.status='pending' AND general_info.c_id=birth_info.c_id ";
return array_slice($this->query($sql),$startpoint,$limit);
}

public function getPredCiv($id){
$sql="SELECT DISTINCT birth_info.*,  birth_info.c_id, general_info.*, death_info.dod,death_info.is_dead, death_info.cause_of_death,health_info.health_information,health_info.dates, migration_info.migration,migration_info.date,criminal_info.offence,criminal_info.offence_date FROM birth_info, death_info, health_info,general_info,migration_info,criminal_info WHERE  birth_info.c_id='{$id}' AND general_info.c_id='{$id}' AND death_info.c_id='{$id}' AND criminal_info.c_id='{$id}' AND health_info.c_id='{$id}' AND migration_info.c_id='{$id}' ";
	return $this->query($sql);
	
	}
	
	function setHasPrintedB($id){
	$sql="UPDATE civilian SET has_printed_bc='1' WHERE c_id='{$id}' ";
	return $this->update($sql);
	}

	public function getPred($id,$table){
	if($table=='death_info'){
$sql="SELECT DISTINCT {$table}.*, birth_info.dob,  general_info.*  FROM {$table},general_info, birth_info WHERE  {$table}.c_id='{$id}' AND general_info.c_id='{$id}' AND birth_info.c_id='{$id}' ";
	
	}else{
	$sql="SELECT DISTINCT {$table}.*,  general_info.*  FROM {$table},general_info WHERE  {$table}.c_id='{$id}' AND general_info.c_id='{$id}' ";
	}
	return $this->query($sql);
	
	}

function updatePersonal($param,$id){
$sql= "UPDATE general_info,birth_info SET  general_info.surname='{$param['surname']}', general_info.othernames='{$param['others']}',general_info.father='{$param['father']}', general_info.mother='{$param['mother']}', general_info.address='{$param['address']}' WHERE birth_info.c_id='{$id}' AND general_info.c_id='{$id}'";
return $this->update($sql);
}


 function updateBirth($param,$id){
 //var_dump($param);
 //var_dump($id);exit;
$sql= "UPDATE general_info,birth_info SET  birth_info.date_of_reg='{$param['regdate']}', general_info.surname='{$param['surname']}', general_info.othernames='{$param['others']}',general_info.fsurname='{$param['fsurname']}', general_info.msurname='{$param['msurname']}',general_info.fothers='{$param['fothers']}', general_info.mothers='{$param['mothers']}',general_info.faddress='{$param['faddress']}', general_info.maddress='{$param['maddress']}',general_info.fpbirth='{$param['fpbirth']}', general_info.mpbirth='{$param['mpbirth']}',general_info.isurname='{$param['isurname']}', general_info.iothers='{$param['iothers']}',general_info.iqualification='{$param['iqualification']}', general_info.iaddress='{$param['iaddress']}' ,general_info.foccupation='{$param['foccupation']}', general_info.moccupation='{$param['moccupation']}' WHERE birth_info.c_id='{$id}' AND general_info.c_id='{$id}'";
return $this->update($sql);
 }
 
  function updateDeath($param,$id){
 //var_dump($param);
// var_dump($param['dod']);exit;
 $reg=explode("/",$param['regdate']);
 if($param['dod']!='0'){
 $dod=explode("/",$param['dod']);
 $doddate=date_create($dod[2].'-'.$dod[0].'-'.$dod[1]);
 date_format($doddate,'Y-m-d');
 $doddate=(array)$doddate;
//var_dump($regdate['date']);exit;
$dod=explode(" ",$doddate['date']);
 $dod_sql="dod='{$dod[0]}' ,";
// var_dump($dod_sql);exit;
 }else{
 $dod_sql="";
 }
 
 $regdate=date_create($reg[2].'-'.$reg[0].'-'.$reg[1]);
 date_format($regdate,'Y-m-d');
$regdate=(array)$regdate;
//var_dump($regdate['date']);exit;
$reg=explode(" ",$regdate['date']);
//var_dump($param);exit;
$sql= "UPDATE death_info SET ".$dod_sql." cause_of_death='{$param['cause']}', hospital_of_death='{$param['pod']}', lga_of_death='{$param['lga']}', state_of_death='{$param['state']}', death_regdate='{$reg[0]}', hospital_id='{$param['hospital_id']}', is_dead='1',informant='{$param['iname']}', occupation_bf_death='{$param['occu']}',add_bf_death='{$param['uaddress']}', informant_address='{$param[iadd]}', informant_qualification='{$param['iquali']}' WHERE death_info.c_id='{$id}'";
return $this->update($sql);
 }
 
 
 function updateHealth($param,$id){
$reg=explode("/",$param['date']);
 $regdate=date_create($reg[2].'-'.$reg[0].'-'.$reg[1]);
 date_format($regdate,'Y-m-d');
$regdate=(array)$regdate;
$reg=explode(" ",$regdate['date']);
 $result=$this->query("SELECT health_information, date_added FROM health_info WHERE c_id='{$id}' ");
 $info=($result[0]['health_information'])?$result[0]['health_information'].','.$param['info']:$param['info'];
 $date=$result[0]['date_added'];
 $date=($date)?$date.','.$reg[0]:$reg[0];
 $sql= "UPDATE health_info SET health_information='{$info}', dates='{$date}' WHERE c_id='{$id}'";
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
 $sql= "UPDATE deductions SET association='{$param['association']}', income_tax='{$param['income_tax']}',  pension='{$param['pension']}', charges='monthly', last_update='$date_modified' ";
return $this->update($sql);
 
 }
 
function savePass($param){

$sql= "UPDATE employee SET password='{$param['new']}' WHERE employeeId='{$param['id']}'  ";
return $this->update($sql);
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
