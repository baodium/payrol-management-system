<?php
session_start();
if(!isset($_SESSION['employee']))
header('location:login.php');
if(isset($_SESSION['error'])){
unset($_SESSION['error']);
}
include 'controller/class.main.php';
$instance=new payroll();
//var_dump($_SESSION['payrolluser']);
$user=$_SESSION['employee'][0];
$name=explode(" ",$user['employeeName']);
$username=$name[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
	<title>Electronic Payroll System</title>
	<link rel="shortcut icon" type="image/x-icon" href="css/images/fav.png" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	
	
	<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
		<script src="js/modernizr.custom.js"></script>
	<![endif]-->
	<script src="js/jquery.carouFredSel-5.5.0-packed.js" type="text/javascript"></script>
	<script src="js/functions.js" type="text/javascript"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
	<!-- shell -->
	<div class="shell">
		<!-- container -->
		<div class="container">
			<!-- header -->
	<h1 id="title" style="margin-top:-10px" ><img src="css/images/logo2.png" /></h1>
				<!-- search -->		<!-- search -->
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
                <li ><a href="index.php">Home</a></li>
				  <li class="active"><a href="#">Employee</a></li>
					
					<li><a href="payments.php">Ledger</a></li>
				  <li><a href="changepass.php">Change Password</a></li>
                     <li style="margin-left:300px; color:#0099FF"><p>Hi:&nbsp;<?php echo $username ?> </p></li>
                  <li><a href="logout.php"><span style="color: #FF9900">Logout</a></span></a></li>
				</ul>
				<div class="cl">&nbsp;</div>
                <br/>
			</nav>
			<!-- end of navigation -->
			<!-- slider-holder -->
		  <!-- end of navigation -->
			<!-- slider-holder -->
			<div class="slider-holder">
				
				<p>
				<div class="featured" style="width:76.2%" >
					<p ><span style=" font-size:18px; color:#006699">Employee Home Page</span></p><p>Your information is displayed below: </p>
							</div>

				</div>
			  </p>
				<center><div class="featured"  style="background:#FFFFFF;  padding:10px 30px 10px 30px" >
				<form name="" action="" enctype="multipart/form-data">  
                <table align="center"  style=" font-size:14px" >
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; height:40px; background:#0099FF; color:#FFFFFF" ><th colspan="2" style="border-radius:3px; ">Information</th>
               </tr>
                
                  <tr>
                  
                <td style="width:200px" >&nbsp;</td> <td style=""></td>
                </tr>
                <tr>
                <td style="width:250px" height="40px">Employee Id:</td> 
                <td style=""><b><?php echo strtoupper($user['employeeId']); ?></b></td>
                </tr>
                  <tr>
                <td style="width:250px" height="40px">Employee Name:</td> 
                <td style=""><b><?php echo $user['employeeName']; ?></b></td>
                </tr>
                <tr>
                <td style="width:250px" height="40px">Date Of Birth:</td> 
                <td style=""><b><?php echo $user['dateofbirth']; ?></b></td>
                </tr>
               
                <td style="width:250px" height="40px">Employed As:</td> 
                <td style=""><b><?php echo ucwords($user['type']); ?> Staff</b></td>
                </tr>
                <td style="width:250px" height="40px">Employement Mode:</td> 
                <td style=""><b>Full Time</b></td>
                </tr>
                <td style="width:250px" height="40px" >Current Level:</td> 
                <td style=""><b><?php echo ucwords($user['level']); ?></td>
                </tr>
                <td style="width:250px" height="40px">Number of years in service:</td> 
                <td style=""><b><?php echo ucwords($user['years_in_service']); ?></td>
                </tr>
                <td style="width:250px" height="40px">Email:</td> 
                <td style=""><b><?php echo ucwords($user['email']); ?></td>
               
                </tr>
                <td style="width:250px" height="40px">Phone Number:</td> 
                <td style=""><b><?php echo ucwords($user['phone']); ?></td>
                
                </tr>
                <td style="width:250px" height="40px">Address:</td> 
                <td style="width:250px" height="40px"><b><?php echo ucwords($user['address']); ?></td>
                </tr>
               
                
                </table>
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