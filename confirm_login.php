<?php
if(isset($_POST['login'])){
$user=$_POST['username'];
$pass=$_POST['password'];
$not_supported=array('#','-','/',';',',',':','/*','*/','*','=');
for($j=0;$j<strlen($user); $j++ ){
if(in_array(substr($user,$j,$j+1),$not_supported)){
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;character'. ' "'.substr($user,$j,$j+1).'" is not Supported</div>';
return;
}
}
$login_param=array('username'=>$user,'password'=>$pass);
$user=$payroll;
$current=$user->userLogin($login_param);
if($current[0]){
$_SESSION['employee']=$current;//[0]['user'];
$_SESSION['error']=NULL;
header("location:employeehome.php");
}else{
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;Invalid username or password</div>';
return;
}
}


if(isset($_POST['new_pass'])){

$old=$_POST['formerpass'];
$new1=$_POST['newpass1'];
$new2=$_POST['newpass2'];

$param=array('old'=>$old, 'new'=>$new1, 'id'=>$_SESSION['employee'][0]['employeeId']);

if($old!=$_SESSION['employee'][0]['password']){
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;Your old password is not correct</div>';
return;
}
if(strlen(trim($new1))<1){
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;Your new password cannot be empty</div>';
return;
}

if(strlen($new1)<6){
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;Your new password must be at least 6 characters in lenght </div>';
return;
}

if($new1!=$new2){
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;Your new password does not match</div>';
return;
}
if($payroll->savePass($param)){
$errorMessage='<div class="warning"><img src="admin/images/success.png" />&nbsp;Your password has been successfully changed</div>';
return;
}else{
$errorMessage='<div class="warning"><img src="admin/images/warning.png" />&nbsp;Error saving password</div>';
return;
}

}

?>
