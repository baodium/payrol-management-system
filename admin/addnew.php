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
            <link href="../css/style.css" media="all" rel="stylesheet" type="text/css">

<script src="../js/modernizr.custom.js" type="text/javascript"></script>
<script src="../js/baaa_jquery.js" type="text/javascript"></script>
<script src="../js/baaa_core.js" type="text/javascript"></script>

<script>
	$(document).ready(function() {
		
		$(".datepicker").datepicker();
		
		
	});
	</script>
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
					<li class="active"><a href="">Add Employee</a></li>
					<li><a href="payroll.php">Payroll</a></li>
					<li><a href="rates.php">Change Rate</a></li>
					<li><a href="deductions.php">Change Deductions</a></li>
                    <li  ><a href="newpay.php">Pay</a></li
                     ><li style="margin-left:70px; color:#0099FF"><img src="images/user.png" width="30px" heigth="20px" style="margin-bottom:-5px"><span style="color:#006699">Hi:admin </span></li>

                  <li><a href="logout.php"><span style="color: #FF9900">Logout</a></span></a></li>
                  <li><span style="color: #FF9900">|</span></li>
				</ul>
				<div class="cl"><center></center></div>
                
			</nav>
			<!-- end of navigation -->
			<!-- slider-holder -->
			<div class="slider-holder">
				
				<p>
				<div class="featured">
					<p ><span style=" font-size:18px; color:#006699">New Employee Page</span></p><p>Please enter correct information for the new staff. All fields are compulsory </p>
							</div>

				</div>
			  </p>
				<center><div class="featured"  style="background:#FFFFFF; width:600px; padding:10px 30px 10px 30px" >
				<form name="" action="" enctype="multipart/form-data" method="post">  
                <div class="label-wrap"><?php echo $error; ?></div>
                <table align="center" >
                <tr>
                <td style="width:250px">Employee ID:</td> <td style=""><input type="text" name="employeeId" placeholder="e.g ou/ts/005" value="<?php echo(isset($param['employeeId'])?strtoupper($param['employeeId']):'') ?>"  /></td>
                </tr>
                 <tr>
                <td style="width:250px">Employee Name:</td> <td style=""><input type="text" name="employeeName" value="<?php echo(isset($param['employeeName'])?$param['employeeName']:'');  ?>" /></td>
                </tr>
                 
                <td style="width:250px">Level:</td> <td style="">
                <select name="level">
                <option value="GA">GA</option>
                <option value="lecturer2">Lecturer 2</option>
                <option value="lecturer1">Lecturer 1</option>
                <option value="senior">Senoir Lecturer</option>
                <?php for ($i=6; $i<18; $i++ ){ 
                echo '<option value="level'.$i.'" '.((isset($param['level'])&&$param['level']=='level'.$i)?"selected":"").'>Level '.$i.' (for non-teaching staff only) </option>';
                }
				?>
                </select></td>
                </tr>
                   <tr>
                <td style="width:200px">Employee Type:</td> <td style=""><select name="type"><option value="teaching" <?php echo (isset($param['type'])&&$param['type']=='teaching')?'selected':'' ?>>Teaching Staff</option><option value="non teaching" <?php echo (isset($param['type'])&&$param['type']=='non teaching')?'selected':'' ?>>Non-Teaching Staff</option></select></td>
                </tr><tr>
                <td style="width:250px">Year Of Birth:</td> <td style="">
                <select name="date_of_birth">
                
                <?php for ($i=1960; $i<=1995; $i++ ){ 
                echo '<option value="'.$i.'" '.((isset($param['date_of_birth'])&&$param['date_of_birth']==$i)?'selected':''.'>'.$i).'</option>';
                }
				?>
                </select></td>
                </tr>
                
                <tr>
                <td style="width:200px">Year of service:</td> <td style=""><select name="year_in_service">
                
                <?php for ($i=0; $i<=70; $i++ ){ 
                echo '<option value="'.$i.'" '.((isset($param['year_in_service'])&&$param['year_in_service']==$i)?'selected':'').' >'.$i.'</option>';
                }
				?>
                </select></td>
                </tr>
                <tr>
                <td style="width:200px">Phone Number:</td> <td style=""><input type="text"  value="<?php echo(isset($param['phone'])?$param['phone']:'');  ?>" name="phone" placeholder="e.g 08030903099" /></td>
                </tr>
                <tr>
                <td style="width:200px">Email:</td> <td style=""><input type="text" value="<?php echo(isset($param['email'])?$param['email']:'');  ?>" name="email"/></td>
                </tr>
                <tr>
                <td style="width:200px">Address:</td> <td style=""><input type="text" name="address" value="<?php echo(isset($param['address'])?$param['address']:'');  ?>"/></td>
                </tr>
                <tr>
                <td style="width:200px">On Pension Plan</td> <td style=""><select name="pension_plan"><option value="Yes"  <?php echo (isset($param['pension_plan'])&&$param['pension_plan']=='Yes')?'selected':'' ?>>Yes</option><option value="No" <?php echo (isset($param['pension_plan'])&&$param['pension_plan']=='No')?'selected':'' ?>>No</option></select></td>
                </tr>
                <tr>
                <td style="width:200px">In Workers Union</td> <td style=""><select name="union"><option value="Yes" <?php echo (isset($param['union'])&&$param['union']=='Yes')?'selected':'' ?>>Yes</option><option value="No" <?php echo (isset($param['union'])&&$param['union']=='Yes')?'selected':'' ?>>No</option></select></td>
                </tr>
                <tr>
                <td style="width:200px"></td> <td style=""><input type="submit" class="blue-btn" value="submit" name="add_employee"></td>
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