<?php 
@session_start();
include_once 'controller/class.main.php';
$payroll=new payroll();
include 'confirm_login.php';
$error=(isset($errorMessage))?$errorMessage:"";

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
      <?php if (isset($errorMessage)){ 
$_SESSION['error']=$error;?>
<script>
window.location.reload();
</script>
<?php } ?>
<!-- wrapper -->
<div id="wrapper">
	<!-- shell -->
	<div class="shell">
		<!-- container -->
		<div class="container">
			<!-- header -->
			<header id="header">
				<h1 id="title" style="margin-top:-10px" ><img src="css/images/logo2.png" /></h1>
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
					<li ><a href="index.php">Site Home</a></li>
                    <li><a href="employeehome.php">Employee</a></li>
					<li ><a href="">About CPS</a></li>
                    
					<li class="active"><a href="">Login</a></li>
	                <li style="margin-left:300px; color: #006600"><p>Hi Stranger! You are not Logged In. </p></li>
				</ul><br/>
				<div class="cl">&nbsp;</div>
                <br/>
			</nav>
			<!-- end of navigation -->
			<!-- slider-holder -->
			<div class="slider-holder">
				
				<p>
				<div class="featured" style="width:750px">
					<p ><p ><span style=" font-size:18px; color:#006699">login Page</span></p>Please supply a valid Staff Identification Number and Password. (Hint: Use your surname as password)</p>
					</div>
  <div class="label-wrap"><?php echo (isset($_SESSION['error']))?'<div style="padding-top:5px; "><center>'.$_SESSION['error'].'</center></div><br/>':''; ?></div>
				</div>
			  </p>
				<center><div class="featured"  style="background:#FFFFFF; width:600px; padding:10px 30px 10px 30px" >
				<form accept-charset="UTF-8" action="" class="new_user_session" id="session_form" method="post"> 
                <table align="center"  >
               <tr style="border-bottom:border: 2px solid #0a7fb5; margin-bottom:10px; height:40px; background:#0099FF; color:#FFFFFF" ><th colspan="2" style="border-radius:3px; ">Login Box</th>
               </tr>
                
                  <tr>
                  
                <td style="width:200px">&nbsp;</td> <td style="">&nbsp;</td>
                </tr>
                <tr>
                <td style="width:250px">Staff ID:</td> 
                <td style="">
                <input type="text" name="username" ></td>
                </tr>
                  <tr>
                <td style="width:250px">Password:</td> 
                <td style=""><input type="password" name="password" /></td>
                </tr>
                <tr>
                <td style="width:250px">&nbsp;</td> <td style="">&nbsp;</td>
                </tr>
                
                <tr>
                <td style="width:200px"></td> <td style=""><input type="submit" class="blue-btn2" value="Login" name="login"></td>
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