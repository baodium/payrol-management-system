<?php
require_once 'model/mysql.php';


class payroll{
public $currentFile;
public $prevFile;
public $nextFile;
public $mysql;
function  __construct(){
DEFINE('MAXFILESIZE',99999);
$this->mysql=new mysql();
}
function getPath(){
$here=$_SERVER['PHP_SELF'];
if(strpos($here,'admin')>1){
return '../';
}
return '';
}

function loadRates(){
return $this->mysql->loadRates();
}

function changeSalary($param){

return $this->mysql->changeSalary($param);
}

function addEmployee($param){
//var_dump($this->mysql->checkExistence($param['employeeId'])); exit;
if($this->mysql->checkExistence($param['employeeId'])==true){
return $this->mysql->addEmployee($param);
}else{
return false;
}
}

function saveEmployee($id, $param){
return $this->mysql->saveEmployee($id, $param);

}

function getPaySlip($id,$month,$year){
return $this->mysql->getPaySlip($id,$month,$year);
}

function loadEmployee($id){

return $this->mysql->loadEmployee($id);
}

function loadLastRoll($month, $year){
return $this->mysql->loadLastRoll($month, $year);
}

function pay($param){
return $this->mysql->pay($param);
}


function getLastPayment(){
return $this->mysql->getLastPayment();
}

function getAllEmployee(){
return $this->mysql->getAllEmployee();
}

function loadDeductions(){

return $this->mysql->loadDeductions();
}

function changeDeduction($param){
return $this->mysql->changeDeduction($param);

}

function savePass($param){
return $this->mysql->savePass($param);
}

function uploadList($img,$month,$year){
$errors=0;	
 	
 if ($image=$_FILES[$img]['name']){ 	 		
       $filename = stripslashes($image); 	   
       $extension = strtolower($this->getExtension($filename)); 		
       if (($extension != 'csv')&&($extension!='xls'))  		
       {		 			
             $errorMsg= '<div class="warning">&nbsp;&nbsp;The file is not a valid excel file</div>'; 			
             $errors=1;
            return $errorMsg;		
       } 		
       else {
            $size=filesize($_FILES[$img]['tmp_name']);
             if ($size > MAXFILESIZE*1024){	
                 $errorMsg= '<div class="warning">&nbsp;&nbsp;You have exceeded the size limit!</div>';	
                 $errors=1;
                 return $errorMsg;
             }
			 $image_name=$month.'_'.$year.'.csv';//$_FILES[$img]['name'];
       $image_param=array('name'=>$image_name, 'size'=>$size);
	  
	   $newname=$this->getPath()."/admin/list/".$image_name;
        // $newname="admin/list/".$image_name;
		//unlink($newname);
		 //var_dump($newname); exit;
            if (!@move_uploaded_file($_FILES[$img]['tmp_name'], $newname)) {	
            $errorMsg= '<div class="warning">&nbsp;&nbsp;Upload unsuccessfull!</div>';	
            $errors=1;
            return $errorMsg;
			}
	}}
	if($image && $image_name)
	return $this->mysql->updatePayroll($image_name,$month,$year);
	
	return "please upload a file";//$this->mysql->putInfoInDb($_FILES);
 }


function uploadOnly($img,$user){
$errors=0;	
	
 if ($image=$_FILES[$img]['name']){ 	 		
       $filename = stripslashes($image); 	   
       $extension = strtolower($this->getExtension($filename)); 		
       if (($extension != 'gif')&&($extension != 'jpg')&&($extension != 'png'))  		
       {		 			
             $errorMsg= 'Your picture has an unknown extension'; 			
             $errors=1;
            return $errorMsg;		
       } 			
       else {
            $size=filesize($_FILES[$img]['tmp_name']);
             if ($size > 9999*1024){	
                 $errorMsg= 'You have exceeded the size limit!';	
                 $errors=1;
                 return $errorMsg;
             }
			 //var_dump($user);exit;
			 $image_name=str_replace("/","_",$user).".".$this->getExtension($_FILES[$img]['name']);
        // $image_name=$this->getName($image);
		
		 $newname=$this->getPath()."image/".$image_name;
		 
            if (!@move_uploaded_file($_FILES[$img]['tmp_name'], $newname)) {	
            $errorMsg= 'Upload not successfull';	
            $errors=1;
            return $errorMsg;
			}
	}}
	if($image && $this->updateImage($user, $this->getExtension($image)))
	return true;
 }
 
function updateImage($user,$ext){
$filename=str_replace("/","_",$user).".".$ext;
return $this->mysql->updateImage($filename,$user);
}

function loadSpecificBirth($id){
return $this->mysql->getPred($id,'birth_info');
}



function setHasPrintedB($id){
return $this->mysql->setHasPrintedB($id);
}


function loadGenInfo(){
return $this->mysql->loadGenInfo();
}

function loadAllInfo($id){
return $this->mysql->getPredCiv($id);
}


function paginativ_search($term,$scope,$startpoint,$limit){
return $this->mysql->paginative_search($term,$scope,$startpoint,$limit);
}

function exeedUploadLimit($file){
if(filesize($file)>MAXFILESIZE)
return true;
return false;
}

function getName($file){
 return substr($file,(strrpos($file,"/")+1),strlen($file));
 }

function getExtension($file){
return substr($file,strrpos($file,".")+1,strlen($file));
}
function update($newVal,$id){
return $this->mysql->performUpdate($newVal,$id);
}

function isImage($file){
$ext=$this->getExtension($file);
if($ext=="jpg"||$ext=="png"||$ext=="gif"||$ext=="jpeg")
return true;
return false;
}

function AdminLogin($param){
$splitUser=explode("/",$param['username']);
//var_dump($splitUser);exit;
if(count($splitUser)>1)
return $this->mysql->login($param,"employee");
else
return $this->mysql->login($param,"admin");

}

function userLogin($param){
return $this->mysql->userLogin($param,"employee");
}

function getLastLedger($id){
return $this->mysql->getLastLedger($id);
}

function loadLedger($year,$id){
return $this->mysql->loadLedger($year,$id);
}

function search($param,$startpoint,$limit,$page){
$result=$this->mysql->search($param,$startpoint,$limit,$page);
return $result;
}



function delete($id){
return ($this->mysql->delete($id,"books"));
}

function activate($id,$scope){
return ($this->mysql->activate($id,$scope));
}

function deActivate($id){
return ($this->mysql->deActivate($id,"books"));
}

}
?>