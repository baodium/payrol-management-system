<?php
if(isset($_POST['login'])){
$user=$_POST['username'];
$pass=$_POST['password'];
$not_supported=array('#','-','/',';',',',':','/*','*/','*','=');
for($j=0;$j<strlen($user); $j++ ){
if(in_array(substr($user,$j,$j+1),$not_supported)){
$errorMessage='<div class="warning"><img src="images/warning.png" />&nbsp;character'. ' "'.substr($user,$j,$j+1).'" is not Supported</div>';
return;
}
}
$login_param=array('username'=>$user,'password'=>$pass);
$user=$payroll;
$current=$user->AdminLogin($login_param);
if($current[0]){
$_SESSION['payrolluser']=$current;//[0]['user'];
$_SESSION['error']=NULL;
header("location:index.php");
}else{
$errorMessage='<div class="warning"><img src="images/warning.png" />&nbsp;Invalid username or password</div>';
return;
}
}

?>
