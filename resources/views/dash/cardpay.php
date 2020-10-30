<?php

session_start(); // start session

//START User Verification
if(!isset($_SESSION['logDin_user_email']) || $_SESSION['logDin_user_email'] == ""){    
    header('Location: '.$home_dir.'login.php'); // Redirecting To Home Page  
    exit();
}

include_once('includes/dbConnection.php');


$email=$_SESSION['logDin_user_email'];
$sql_sort=mysqli_query($conn, "SELECT * FROM user_data WHERE email='$email'");
$row=mysqli_fetch_assoc($sql_sort);


?>

<?php
    //Include main NAV
    include_once 'includes/head.inc.php';

     
  ?>

  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" style="color: grey;" class="closebtn" onclick="closeNav()">&times;</a>

  <a href="index.php" style="color: black"><p class="dash-menu-text"><i  class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" style="color: black"><p class="dash-menu-text"><i  class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: black"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" style="color: black"><p class="dash-active" ><i style="color: #99C24D;" class="fas fa-cog" ></i>Settings</p></a>
  <a href="logout.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
</div>

    
<div class="sidebar">
      <div class="text-center logo-main logo-main-1" style="background-color: #fff"><img width="230" height="56" src="../images/logo.png"></div>
      <center>
      
    <div class="menu-bar" >
  <a href="index.php" style="color: black"><p  class="dash-menu-text"><i class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" style="color: black"><p class="dash-menu-text"><i  class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: black"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" ><p  class="dash-active"><i style="color: #99C24D;"  class="fas fa-cog" ></i>Settings</p></a>
<a href="logout.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
  
</div>
</center>
</div>




<div class="main">


   <?php

               

                include_once 'includes/accountverify.php';
 ?>


<div class="text-center logo-main logo-main-2" ><img width="230" height="56"  src="logo.png"></div>
<nav class="navbar navbar-light text-center ">
  <div class="container-fluid">
    <div class="row header">
      
       <i style="margin-top: 7px; margin-right: 20px; float: right; width: 20px; cursor:pointer" onclick="openNav()" class="fa fa-bars"></i>
      
      <div class="col search-box head-left nav-top-content" > <span class="search-icon nav-top-content"><i style="color: grey;" class="fas fa-search"></i></span><input class="search nav-top-content" type="search" placeholder="Search" name=""></div>
        <i style="margin-top: 7px; margin-right: 20px; float: right; width: 20px; font-size: 20px;" class="fas fa-user-circle"></i>
       <i style="margin-top: 7px; margin-right: 30px; float: right; width: 20px; font-size: 20px;" class="far fa-bell"></i>


      
    </div>
  </div>
</nav>

<div class="content">
  <div class="container" align="center">
    <?php 
     if(isset($_SESSION['success'])){
                    echo $_SESSION['success'];$_SESSION['success']='';
                   }
                   if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];$_SESSION['error']='';
                   }  
                    if(isset($_SESSION['err_mail'])){
                    echo $_SESSION['err_mail'];$_SESSION['err_mail']='';
                   } 
                   if(isset($_SESSION['err_bill'])){
                    echo $_SESSION['err_bill'];$_SESSION['err_bill']='';
                   } 
                   ?>
  <div class="pass-form" align="center">
    <h3>Card Subscription</h3>

    
    <form  method="POST" action="processpayment.php">
    
  <div>
      <label>Email</label><br />
    <input
    <?php
      $email = $row["email"];
      echo "value=" . $email; 
      ?>
     type="email" name="email" readonly required />
  </div>

    <label>Amount</label><br />
                <select name="bill"  required />
                    <option value="">Click to Select</option>
                    
                    <option
                <?php
                
                    if(isset($_SESSION['bill']) && $_SESSION['bill'] == '3910'){
                    echo "selected";
                    }

                ?>
                    > &#x20A6; 3910</option>
                </select>
            </p>
            <?php

               

                 $pay = $row["payment_status"];
                    // output data of each row
                    if($pay == "unverified" ) {
                      echo '
                    <button type="submit" name="paybill" align="center" ">PAY</button>';
                    }
                   else {
                    echo '
                    <pstyle="margin-bottom:10px;">You have already Paid</p>';
                  }
 ?>


</form>
</div>
  </div>
  </div>




<?php
    //Include main NAV
    include_once 'includes/footer.inc.php';
  ?>