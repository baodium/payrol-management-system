<?php
include_once '../controller/class.main.php';
$npr=new nprClass();
if(isset($_POST['check'])){
$scope=(isset($_SESSION['opt']) && ($_SESSION['opt']=="udr"))?'death_info':'birth_info';
$marked=$_POST['check'];

if($_POST['id']=="activate"){
foreach($marked as $key=>$value){
$npr->activate($value, $scope);
 }
}

}
header("location:index.php");
?>
