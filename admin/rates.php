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
//$deductions= $payroll->loadDeductions();
$rate=$payroll->loadRates();
//var_dump($rate);
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
					<li class="active"><a href="rates.php">Change Rate</a></li>
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
				
				<p>
				<div class="featured" style="width:750px">
                <p ><p ><span style=" font-size:18px; color:#006699">Payment Rate Page</span></p>Note that only numeric value is allowed for the rate, so avoid separating the figures with comma(,) .</p>
					
							</div>

				</div>
			  </p>
				<center><div class="featured"  style="background:#FFFFFF; width:650px; padding:10px 30px 10px 30px" >
                 <div class="label-wrap"><?php echo $error; ?></div>
				<form name="" action="" enctype="multipart/form-data" method="post">  
                <table align="center" id="emp_table" cellspacing="0" cellpadding="2"  style=" border-radius:5px"  >
               <tr   style="background:#0099FF; color:#FFFFFF" ><th>Level</th><th>Type</th><th>Charges</th>
               <th>Current Monthly Rate</th><th>New Rate</th>
               </tr>
                <tr class="even">
                <td style="width:200px"><center>GA</center></td><td style="width:200px"><center>Teaching Staff</center></td><td style="width:200px"><center>Per Month</center></td><td style="width:250px"><center><?php echo $rate['0']['workrate']  ?></center></td><td style=""><input type="text" style="width:100px" name="GA" value="<?php echo(isset($param['GA'])?$param['GA']:'');  ?>"></td><td style=""></td>
                </tr>
                 <tr class="odd">
                <td style="width:200px"><center>Lecturer 2</center></td><td style="width:200px"><center>Teaching Staff</center></td><td style="width:200px"><center>Per Month</center></td><td style="width:200px"><center><?php echo $rate['1']['workrate']  ?></center></td><td style=""><input type="text" name="lecturer2" style="width:100px" value="<?php echo(isset($param['lecturer2'])?$param['lecturer2']:'');  ?>" ></td><td style=""></td>
                </tr>
                <tr class="even">
                <td style="width:200px"><center>Lecturer 1</center></td><td style="width:200px"><center>Teaching Staff</center></td><td style="width:200px"><center>Per Month</center></td><td style="width:200px"><center><?php echo $rate['2']['workrate']  ?></center></td><td style=""><input type="text" name="lecturer1" style="width:100px" value="<?php echo(isset($param['lecturer1'])?$param['lecturer1']:'');  ?>"></td><td style=""></td></tr>
                </tr> 
                <tr class="odd">
                <td style="width:200px"><center>Senior Lecturer</center></td><td style="width:200px"><center>Teaching Staff</center></td><td style="width:200px"><center>Per Month</center></td><td style="width:200px"><center><?php echo $rate['3']['workrate']  ?></center></td><td style=""><input type="text" name="senior" style="width:100px"  value="<?php echo(isset($param['senior'])?$param['senior']:'');  ?>"></td><td style=""></td>
              </tr>
              <?php for($i=1;$i<=17; $i++){  ?>
                 <tr class="<?php echo ($i%2=='0')?'odd':'even' ?>">
                <td style="width:200px"><center>Level <?php echo $i ?></center></td><td style="width:200px"><center>Non-Teaching Staff</center></td><td style="width:200px"><center>Per Month</center></td><td style="width:200px"><center><?php echo $rate[$i+3]['workrate']  ?></center></td><td style=""><input type="text" name="level<?php echo $i."" ?>" style="width:100px" value="<?php echo(isset($param['level'.$i])?$param['level'.$i]:'');  ?>" ></td><td style=""></td></tr>
				<?php }?>
                </table><br/>
                <hr/><br/>
                <input type="submit" class="blue-btn" value="Submit" name="save_rate">
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