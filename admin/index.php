<?php
session_start();
if(!isset($_SESSION['payrolluser']))
header('location:login.php');
if(isset($_SESSION['error'])){
unset($_SESSION['error']);
}
?>
<?php 
include '../controller/class.main.php';
$payroll=new payroll();
$employees=$payroll->getAllEmployee();
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
						<li class="active" ><a href="index.php">Admin Home</a></li>
					<li ><a href="addnew.php">Add Employee</a></li>
					<li><a href="payroll.php">Payroll</a></li>
					<li><a href="rates.php">Change Rate</a></li>
					<li><a href="deductions.php">Change Deductions</a></li>
                    <li  ><a href="newpay.php">Pay</a></li>
                    <li><a href="logout.php"><span style="color: #FF9900">Logout</a></span></a></li>
                  <li><span style="color: #FF9900">|</span></li>
                    <li  color:#0099FF"><img src="images/user.png" width="30px" heigth="20px" style="margin-bottom:-5px"><span style="color:#006699">Hi:admin </span></li>

                  
				</ul>
				<div class="cl"></div>
                
			</nav>
			<!-- end of navigation -->
			<!-- slider-holder -->
			<div class="slider-holder">
				
				<p>
				<div class="featured">
					<p ><span style=" font-size:18px; color:#006699">Administrators Home  Page</span></p>Below is the list of employees on our payroll
					<a href="addnew.php" class="blue-btn">Add New Employee</a>				</div>
 <center><div class="featured"  style="background:#FFFFFF; width:850px; padding:10px 30px 10px 30px" >
             <p> <form name="payroll" action="gentable.php" method="post">
              Month: 
              <select name="month" style="width:230px; height:39px"> 
              <?php for ($i=1;$i<=12; $i++){
			  $mm=date('M.', mktime(0, 0, 0, $i, 1, 2000));
			  ?>
              <option value="<?php echo $i ?>"><?php echo $mm ?></option>
              
             <?php  } ?>
              
              </select>&nbsp;&nbsp;
              Year:&nbsp;<select name="year" style="width:200px; height:39px">
              <?php  for($i=2013; $i<=2050; $i++){ ?>
			  <option value="<?php echo $i ?>"><?php echo $i ?></option>
			  
			 <?php  }?>
              </select>
              &nbsp;&nbsp;<input type="submit" class="blue-btn2"  style="width:190px" name="load_emp" value="Download Employee List" />
              </p>
              </form>
              </div></center>
				</div>
			  </p>
				<div class="featured" style="background:#FFFFFF">
					<table id="emp_table" cellspacing="0" cellpadding="2" width="940px"; style=" border-radius:5px">
                    <tr><th style="width:50px">Select</th><th style="width:100px">ID</th><th style="width:450px"> Name</th><th style="width:200px">Employee Type</th><th style="width:200px">Level</th><th style="width:150px">In Association</th><th style="width:200px">On Pension Plan</th><th style="width:150px">View Ledger</th><th style="width:50px">Edit</th><th style="width:50px">Delete</th>
                    
                    </tr>
                    <?php $i=0;  foreach($employees as $employee){ $i++;  ?>
                    <tr class="<?php echo ($i%2=='0')?'odd':'even' ?>" ><td ><input type="checkbox" name="check[]" value="<?php echo $employee['employeeId']  ?>" style="width:50px"></td><td ><?php echo $employee['employeeId'] ?><td ><center> <?php echo $employee['employeeName']  ?></center></td><td ><center> <?php echo $employee['type']  ?></center></td><td ><center><?php echo $employee['level']  ?></center></td><td ><center><?php echo $employee['union']  ?></center></td><td ><center><?php echo $employee['pension_plan']  ?></center></td><td ><center><a href="ledger.php?id=<?php echo $employee['employeeId'] ?>"><img src="images/view_text.png" /></a></center></td><td ><center><a href="edit.php?id=<?php echo $employee['employeeId'] ?>"><img src="images/edit.png" ></a></center></td><td style="width:50px"><center><a href="#"><img src="images/delete.png" /></a></center></td>
                    
                    </tr>	
					<?php  } ?>			
                      </table>        

				</div>
				
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
                    <span>A  project submitted to  Computer Science Department, Oduduwa University, Ipetumodu in partiall fulfillment of the award of B.Sc</span></p>
		      </center>
			  <center><p >&nbsp;</p></center>
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