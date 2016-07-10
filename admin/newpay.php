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
include 'save.php';
$error=(isset($errorMessage))?$errorMessage."<br/>":"";
$lastpay=$payroll->getLastPayment();


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
						<li  ><a href="index.php">Admin Home</a></li>
					<li ><a href="addnew.php">Add Employee</a></li>
					<li><a href="payroll.php">Payroll</a></li>
					<li><a href="rates.php">Change Rate</a></li>
					<li><a href="deductions.php">Change Deductions</a></li>
                    <li class="active" ><a href="newpay.php">Pay</a></li>
                    <li><a href="logout.php"><span style="color: #FF9900">Logout</a></span></a></li>
                  <li><span style="color: #FF9900">|</span></li>
                    <li  color:#0099FF"><img src="images/user.png" width="30px" heigth="20px" style="margin-bottom:-5px"><span style="color:#006699">Hi:admin </span></li>

                  
				</ul>
				<div class="cl"><center></center></div>
                
			</nav>
			<!-- end of navigation -->
			<!-- slider-holder -->
		  <div class="slider-holder">
				
				<p>
			<div class="slider-holder">
				
				<p>
			  <div class="featured" style="font-size:12px">
                <p ><p ><span style=" font-size:18px; color:#006699">Payment Activation Page</span></p>Here, you can  activate the payment for the selected month and year .<span style="font-size:14px; color:#990000" >   Your last payment was for <?php echo  date('M.', mktime(0, 0, 0, $lastpay[0]['month'], 1, $lastpay[0]['year'])).' '.$lastpay[0]['year'] ?></p>
					
			  				</div>

				</div>

				</div>
			  </p>
              <center><div class="featured"  style="background:#FFFFFF; width:750px; padding:10px 30px 10px 30px" >
              <div class="label-wrap"><?php echo $error; ?></div>
             <p> <form name="payroll" action="" method="post" enctype="multipart/form-data">
             <table>
             <tr>
             <td> Month: </td> 
              <td><select name="month" style="width:250px; height:39px">
               
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
              </select>&nbsp;<br/><br/></td></tr>
              <tr><td>
              Year:&nbsp;&nbsp;&nbsp;</td><td>
              <select name="year" style="width:250px; height:39px">
              <?php  for($i=2013; $i<=2050; $i++){
			  echo ' <option value="'.$i.'">'.$i.'</option>';
			  
			  }?>
              </select><br/><br/></td></tr>
              <tr><td>
              Attendance List:&nbsp;&nbsp;&nbsp;</td><td>
              <input type="file" name="image" style="width:250px; height:39px"  /><br/><br/></td></tr>
              <tr><td></td><td>
              &nbsp;&nbsp;<input type="submit" class="blue-btn2"  style="width:150px; margin-left:90px " name="pay" value="Activate Payment" />
              </p>
              </td></tr>
              </form>
              </table>
              </div></center>
              
				
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
				  <p >Designed By Falegan Taiwo Martha (U/10/CS/0006).</p>
				  <p >Project Supervisor: Mr. Yisa.<br/>
			        <span>A  project submitted to  Computer Science Department, Oduduwa University, Ipetumodu in partiall fulfillment of the award of B.Sc </span></p>
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