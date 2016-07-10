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
$deductions= $payroll->loadDeductions();

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
					<li class="active"><a href="deductions.php">Change Deductions</a></li>
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
				<div class="featured" style="width:750px">
				  <p ><span style=" font-size:18px; color:#006699">Deductions Page</span></p>Note that income tax deduction will affect all employees while Pension deduction, and Union dues are optional.</p>
					
							</div>

				</div>
			  </p>
				<center><div class="featured"  style="background:#FFFFFF; width:600px; padding:10px 30px 10px 30px" >
				<form name="" action="" enctype="multipart/form-data" method="post" > 
                 <div class="label-wrap"><?php echo $error; ?></div> 
                <table align="center"  >
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; background:#0099FF; color:#FFFFFF" ><th>Deduction Type</th><th>Amount to deduct (in pecentage of Basic Salary)</th>
               </tr>
                
                  <tr>
                  
                <td style="width:200px">&nbsp;</td> <td style="">&nbsp;</td>
                </tr>
                <tr>
                <td style="width:250px">Pension Deduction:</td> <td style="">
                <select name="pension">
               <option  value="1" <?php echo ($deductions[0]['pension']==1)?"selected":"" ?>>1%</option>
                <option value="2"  <?php echo ($deductions[0]['pension']==2)?"selected":"" ?>>2%</option>
                <option value="3" <?php echo ($deductions[0]['pension']==3)?"selected":"" ?>>3%</option>
                <option  value="4" <?php echo ($deductions[0]['pension']==4)?"selected":"" ?>>4%</option>
                <?php for ($i=5; $i<=50; $i+=5 ){ 
                echo '<option value='.$i.'" '.(($deductions[0]['pension']==$i)?"selected":"").'>'.$i.' % </option>';
                }
				?>
                
                
                </select></td>
                </tr>
                  <tr>
                <td style="width:250px">Income Tax:</td> <td style="">
                <select name="income_tax">
                <option  value="1" <?php echo ($deductions[0]['income_tax']==1)?"selected":"" ?>>1%</option>
                <option value="2"  <?php echo ($deductions[0]['income_tax']==2)?"selected":"" ?>>2%</option>
                <option value="3" <?php echo ($deductions[0]['income_tax']==3)?"selected":"" ?>>3%</option>
                <option  value="4" <?php echo ($deductions[0]['income_tax']==4)?"selected":"" ?>>4%</option>
                <?php for ($i=5; $i<=50; $i+=5 ){ 
                echo '<option value="'.$i.'" '.(($deductions[0]['income_tax']==$i)?"selected":"").'>'.$i.' % </option>';
                }
				?>
                
                
                </select></td>
                </tr>
                <tr>
                <td style="width:250px">Union Due:</td> <td style="">
                <select name="association">
               <option  value="1" <?php echo ($deductions[0]['association']==1)?"selected":"" ?>>1%</option>
                <option value="2"  <?php echo ($deductions[0]['association']==2)?"selected":"" ?>>2%</option>
                <option value="3" <?php echo ($deductions[0]['association']==3)?"selected":"" ?>>3%</option>
                <option  value="4" <?php echo ($deductions[0]['association']==4)?"selected":"" ?>>4%</option>
                <?php for ($i=5; $i<=50; $i+=5 ){ 
                echo '<option value="'.$i.'" '.(($deductions[0]['association']==$i)?"selected":"").'>'.$i.' % </option>';
                }
				?>
                
                
                </select></td>
                </tr>
                 <tr>
                <td style="width:250px">Absence for more than 5 Days:</td> <td style="">
                <select name="absence">
                <option  value="0" <?php echo ($deductions[0]['absence_deduction']==0)?"selected":"" ?>>0%</option>
               <option  value="1" <?php echo ($deductions[0]['absence_deduction']==1)?"selected":"" ?>>1%</option>
                <option value="2"  <?php echo ($deductions[0]['absence_deduction']==2)?"selected":"" ?>>2%</option>
                <option value="3" <?php echo ($deductions[0]['absence_deduction']==3)?"selected":"" ?>>3%</option>
                <option  value="4" <?php echo ($deductions[0]['absence_deduction']==4)?"selected":"" ?>>4%</option>
                
                <option  value="5" <?php echo ($deductions[0]['absence_deduction']==5)?"selected":"" ?>>5%</option>
                
                </select></td>
                </tr>
                <tr>
                <td style="width:200px"></td> <td style=""><input type="submit" class="blue-btn" value="save" name="deduct"></td>
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
			<br/>
			<div class="footer-nav">
              <div class="cl">&nbsp;</div>
  </div>
			<center>
              <p >Designed By Falegan Taiwo Martha (U/10/CS/0006).</p>
			  <p >Project Supervisor: Mr. Yisa.<br/>
                  <span>A  project submitted to  Computer Science Department, Oduduwa University, Ipetumodu in partiall fulfillment of the award of B.Sc</span></p>
  </center>
  <div id="footer"><center></center>
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