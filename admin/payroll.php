
<?php
session_start();
if(!isset($_SESSION['payrolluser']))
header('location:login.php');
if(isset($_SESSION['error'])){
unset($_SESSION['error']);
}

?>
<?php 
include_once '../controller/class.main.php';
$payroll=new payroll();
//include 'save.php';
$error=(isset($errorMessage))?$errorMessage."<br/>":"";
//$deductions= $payroll->loadDeductions();
$lastpay=$payroll->getLastPayment();

if(isset($_POST['load_payroll'])){
$lastpayroll=$payroll->loadLastRoll($_POST['month'],$_POST['year']);
}else{
$lastpayroll=$payroll->loadLastRoll($lastpay[0]['month'],$lastpay[0]['year']);
}
//var_dump($lastpayroll);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
	<title>Electronic Payroll System</title>
	<link rel="shortcut icon" type="image/x-icon" href="../css/images/fav.png" />
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
	
	
	<script src="../js/jquery-1.8.0.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
		<script src="js/modernizr.custom.js"></script>
	<![endif]-->
	<script src="../js/jquery.carouFredSel-5.5.0-packed.js" type="text/javascript"></script>
	<script src="../js/functions.js" type="text/javascript"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
	<!-- shell -->
	<div class="shell">
		<!-- container -->
		<div class="container">
			<!-- header -->
	<header id="header">
<h1 id="title" style="margin-top:-10px" ><img src="../css/images/logo2.png" /></h1>
				<!-- search -->
				<div class="search"></div>
				<!-- end of search -->
				<div class="cl">&nbsp;</div>
			    <p>&nbsp;</p>
			    <p>&nbsp;</p>
		    </header>
			<!-- end of header -->
			<!-- navigaation -->
			<nav id="navigation">
				<a href="#" class="nav-btn">HOME<span></span></a>
				<ul>
						<li ><a href="index.php">Admin Home</a></li>
					<li ><a href="addnew.php">Add Employee</a></li>
					<li class="active"><a href="payroll.php">Payroll</a></li>
					<li ><a href="rates.php">Change Rate</a></li>
					<li><a href="deductions.php">Change Deductions</a></li>
                    <li  ><a href="newpay.php">Pay</a></li
                     ><li style="margin-left:70px; color:#0099FF"><img src="images/user.png" width="30px" heigth="20px" style="margin-bottom:-5px"><span style="color:#006699">Hi:admin </span></li>

                  <li><a href="logout.php"><span style="color: #FF9900">Logout</a></span></a></li>
                  <li><span style="color: #FF9900">|</span></li>
				</ul>
				<div class="cl">&nbsp;</div>
               
			</nav>
			<!-- end of navigation -->
			<!-- slider-holder -->
			<div class="slider-holder">
				<div class="slider-holder">
				
				<p>
				<div class="featured" style="font-size:12px">
                <p ><p ><span style=" font-size:18px; color:#006699">Payroll Page</span></p>This page shows the previous payments . <span style="font-size:14px; color:#990000" >Your last payment was for <?php echo  date('M.', mktime(0, 0, 0, $lastpay[0]['month'], 1, $lastpay[0]['year'])).' '.$lastpay[0]['year'] ?>	</span></p>
					
					<a href="newpay.php" class="blue-btn" style="margin-right:110px" >Activate New Payment</a>			</div>

				</div>

				</div>
			  </p>
              <center><div class="featured"  style="background:#FFFFFF; width:850px; padding:10px 30px 10px 30px" >
             <p> <form name="payroll" action="" method="post">
              Month: 
              <select name="month" style="width:230px; height:39px"> 
              <?php for ($i=1;$i<=12; $i++){
			  $mm=date('M.', mktime(0, 0, 0, $i, 1, 2000));
			  ?>
              <option value="<?php echo $i.'" '.(($lastpay[0]['month']==$i)?'selected':''); ?>><?php echo $mm ?></option>
              
             <?php  } ?>
              
              </select>&nbsp;&nbsp;
              Year:&nbsp;<select name="year" style="width:200px; height:39px">
              <?php  for($i=2013; $i<=2050; $i++){ ?>
			  <option value="<?php echo $i.'" '.(($lastpay[0]['year']==$i)?'selected':''); ?>><?php echo $i ?></option>
			  
			 <?php  }?>
              </select>
              &nbsp;&nbsp;<input type="submit" class="blue-btn2"  style="width:190px" name="load_payroll" value="View Payroll" />
              </p>
              </form>
              </div></center>
              
				<center><div class="featured"  style="background:#FFFFFF; width:680px;" >
				 <p style="float:left; color:#990000; font-size:14px">Payroll for <?php echo (isset($_POST['month']))?date('M.', mktime(0, 0, 0, $_POST['month'], 1, $lastpayroll[0]['year'])).' '.$_POST['year']:date('M.', mktime(0, 0, 0, $lastpay[0]['month'], 1, $lastpay[0]['year'])).' '.$lastpay[0]['year']; ?> </p>
                <table align="center" id="emp_table" cellspacing="0" cellpadding="2"  style=" border-radius:5px"  width="875px"  >
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; background:#0099FF; color:#FFFFFF" ><th>ID</th><th>Name</th><th>Year</th><th>Month</th><th>Income Tax</th><th>Union  Dues</th> <th>Pension Dues</th> <th>Total Deduction</th><th>Gross Pay</th><th>Net Pay</th></tr>
               
               <?php 
			   if($lastpayroll==NULL){ ?>
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; ><td colspan="10">&nbsp;</td></tr>
			   <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; " ><td colspan="10"><center>No payroll is available for the selected month/year</center></td></tr>
			   <?php } else{ 
			   $i=0; foreach($lastpayroll as $roll){ $i++; ?>
               <tr class="<?php echo ($i%2==1?'even':'odd') ?>">
                <td style="width:50px"><?php echo $roll['employeeId']?></td> <td style="width:250px"><center><?php echo $roll['employeeName']?></center></td><td style="width:100px"><center><?php echo $roll['year']?></center></td><td style="width:100px"><center><?php echo $roll['month']?></center></td><td style="width:120px"><center><?php echo $roll['income_tax']?></center></td><td style="width:150px"><center><?php echo $roll['association_due']?></center></td><td style="width:150px"><center><?php echo $roll['pension_deduction']?></center></td><td style="width:120px"><center><?php echo $roll['income_tax']+$roll['association_due']+$roll['pension_deduction']  ?></center></td><td style="width:120px"><center><?php echo $roll['gross_pay']?></center></td><td style="width:120px"><center><?php echo $roll['net_pay'] ?></center></td>
                </tr>
               <?php } 
			   
			   }?>
               
                </table><br/>
               
                   

				</div>
				</center>
				<br/><br/>
				  <!-- end of thumbs -->
			                                      </p>
		  </div>

			<!-- main -->
		  <div class="main">



				</div>
			<!-- end of main -->
			<div class="cl">&nbsp;</div>
            </div>
			<br/><br/>
			<!-- footer -->
			<div id="footer">
				<div class="footer-nav">
					
					
					<div class="cl">&nbsp;</div>
				</div>
				<center>
				  <div class="footer-nav">
                    <div class="cl">&nbsp;</div>
			      </div>
				  <center>
                    <p >Designed By Falegan Taiwo Martha (U/10/CS/0006).</p>
				    <p >Project Supervisor: Mr. Yisa.<br/>
                        <span>A  project submitted to  Computer Science Department, Oduduwa University, Ipetumodu in partiall fulfillment of the award of B.Sc</span></p>
			      </center>
				  <p >&nbsp;</p>
				</center>
				<div class="cl">&nbsp;</div>
			</div>
			<!-- end of footer -->
		</div>
		<!-- end of container -->
	</div>
	<!-- end of shell -->
</div>
<!-- end of wrapper -->
</body>
</html>