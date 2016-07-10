<?php
session_start();
if(!isset($_SESSION['payrolluser']))
header('location:login.php');
if(isset($_SESSION['error'])){
unset($_SESSION['error']);
}
include '../controller/class.main.php';
$instance=new payroll();
//var_dump($_SESSION['payrolluser']);

if(!$lastpay=$instance->getLastLedger($_GET['id']))
header("location:index.php");
if(isset($_POST['payslip_find'])){

$payroll=$instance->loadLedger($_POST['year'],$_GET['id']);

}else{
$payroll=$instance->loadLedger($lastpay[0]['year'],$_GET['id']);
}

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
					<li><a href="payroll.php">Payroll</a></li>
					<li ><a href="rates.php">Change Rate</a></li>
					<li class="active"><a href="deductions.php">Change Deductions</a></li>
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
				
				<p>
				<div class="featured" style="width:750px">
					<p ><span style=" font-size:18px; color:#006699">Payment History</span><br/>Below is the payment history for <?php  echo strtoupper($_GET['id']) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php" style="font-size:14px">Go Back </a></p>
							</div>

				</div>
			  </p>
              <center><div class="featured"  style="background:#FFFFFF; width:800px; padding:10px 30px 10px 30px" >
             <p> <form name="payroll" action="" method="post" >
             
              Year:&nbsp;<select name="year" style="width:450px; height:39px">
              <?php  for($i=2013; $i<=2050; $i++){
			  echo ' <option value="'.$i.'">'.$i.'</option>';
			  
			  }?>
              </select>
              &nbsp;&nbsp;<input type="submit" class="blue-btn2"  name="payslip_find" value="Load Ledger" />
              </p>
              </form>
              </div></center>
              
				<center><div class="featured"  style="background:#FFFFFF; width:850px; padding:10px 10px 10px 10px" >
				
                <p style="float:left; color:#990000; font-size:14px">Payment history for  <?php echo $payroll[0]['employeeName'].' ('.strtoupper($_GET['id']).') for year' ?> <?php echo $payroll[0]['year']!=""?$payroll[0]['year']:$_POST['year'] ?> </p><br/><br/>
              <table align="center" id="emp_table" cellspacing="0" cellpadding="2"  style=" border-radius:5px; "  width="850px"  >
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; background:#0099FF; color:#FFFFFF; height:30px" ><th>ID</th><th style="width:250px">Name</th><th>Year</th><th>Month</th> <th>Total Deduction</th><th>Gross Pay</th><th>Net Pay</th><th style="width:100px">Print payslip</th></tr>
               <?php 
			   if($payroll==NULL){ ?>
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; ><td colspan="10">&nbsp;</td></tr>
			   <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; " ><td colspan="10"><center>No payroll is available for the selected month/year</center></td></tr>
			   <?php } else{ ?>
			   <?php $i=0; foreach($payroll as $roll){ $i++; ?>
               <tr class="<?php echo ($i%2==1?'even':'odd') ?>">
                <td style="width:50px"><?php echo strtoupper($roll['employeeId']) ?></td> <td style="width:250px"><center><?php echo $roll['employeeName']?></center></td><td style="width:100px"><center><?php echo $roll['year']?></center></td><td style="width:100px"><center><?php echo date('M.', mktime(0, 0, 0, $roll['month'], 1, $roll['year']))?></center></td><td style="width:120px"><center><?php echo $roll['income_tax']+$roll['association_due']+$roll['pension_deduction']  ?></center></td><td style="width:120px"><center><?php echo $roll['gross_pay']?></center></td><td style="width:120px"><center><?php echo $roll['net_pay']?></center></td><td><center><a href="../payslip.php?id=<?php echo $roll['employeeId'] ?>&mm=<?php echo $roll['month'] ?>&yy=<?php  echo $roll['year'] ?>"> <img src="images/printer.png"  width="20px" height="20px" /></a></center></td>
                </tr>
               <?php } ?>
			   
			   <?php } ?>
                </table><br/>
               
                </form>      

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