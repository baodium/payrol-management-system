<?php
require_once 'database/mysql.php';
class {
public $mysql;
function  __construct(){
DEFINE('MAXFILESIZE',99999);
$this->mysql=new mysql();
}


function countDownloads($id){
return $this->mysql->counter($id);
}

function addBooks($param,$table){
//return $this->mysql->addOffer($param,$table);
}



function upload($img,$id){
$errors=0;	
 	
 if ($image=$_FILES[$img]['name']){ 	 		
       $filename = stripslashes($image); 	   
       $extension = strtolower($this->getExtension($filename)); 		
       if (($extension != 'gif')&&($extension != 'jpg')&&($extension != 'png'))  		
       {		 			
             $errorMsg= '<div class="warning">&nbsp;&nbsp;'.$img.' has an unknown extension</div>'; 			
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
			 $image_name=$_FILES[$img]['name'];
        // $image_name=$this->getName($image);
         $newname="../images/".$image_name;
            if (!@move_uploaded_file($_FILES[$img]['tmp_name'], $newname)) {	
            $errorMsg= '<div class="warning">&nbsp;&nbsp;Upload unsuccessfull!</div>';	
            $errors=1;
            return $errorMsg;
			}
	}}
	if($image && $image_name)
	$done=$this->mysql->updateImage($img,$image_name,$id);
	return $done;//$this->mysql->putInfoInDb($_FILES);
 }


function uploadOnly($img){
$errors=0;	
 	
 if ($image=$_FILES[$img]['name']){ 	 		
       $filename = stripslashes($image); 	   
       $extension = strtolower($this->getExtension($filename)); 		
       if (($extension != 'gif')&&($extension != 'jpg')&&($extension != 'png'))  		
       {		 			
             $errorMsg= '<div class="warning">&nbsp;&nbsp;'.$img.' has an unknown extension</div>'; 			
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
			 $image_name=$_FILES[$img]['name'];
        // $image_name=$this->getName($image);
         $newname="../images/".$image_name;
            if (!@move_uploaded_file($_FILES[$img]['tmp_name'], $newname)) {	
            $errorMsg= '<div class="warning">&nbsp;&nbsp;Upload unsuccessfull!</div>';	
            $errors=1;
            return $errorMsg;
			}
	}}
	if($image)
	return true;
 }
 
function loadSpecificBook($id){
return $this->mysql->getPredFile($id,"homes");
}
 
function loadBooks($type){
return $this->mysql->getAllFile("homes");
}



//function paginativ_search($term,$scope,$startpoint,$limit){
//return $this->mysql->paginative_search($term,$scope,$startpoint,$limit);
//}

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

function login($param){
return $this->mysql->login($param);
}


function isAdmin($user){
if($user['user_level']=='admin')
return true;
return false;
}

function rateOffer($id,$val){
return $this->mysql->rateOffer($audio_id,$val);
}

function paginate($startpoint,$limit){
return $this->mysql->paginate($startpoint,$limit);
}

function loadSpecialHome($offerId,$start,$limit){
return $this->mysql->loadSpecialHome($offerId,$start,$limit);
}

function search($param,$startpoint,$limit,$page){
$result=$this->mysql->search($param,$startpoint,$limit,$page);
return $result;
}
function searchCount($param,$start,$limit){
$result=$this->mysql->search($param,$start,$limit);
return $result['count'];
}
function searchPagin($param,$page,$limit){
$result=$this->mysql->search($param);
return $result['pagination'];
}

function addToNewsLetterList($email){
return $this->mysql->addToNewsLetterList($email);
}

function inList($email){
return ($this->mysql->inList($email))?true:false;
}

}
?>