<?php

session_start(); // start session

//START User Verification
if(!isset($_SESSION['logDin_user_email']) || $_SESSION['logDin_user_email'] == ""){    
    header('Location: '.$home_dir.'login.php'); // Redirecting To Home Page  
    exit();
}

include_once('includes/dbConnection.php');

//sort the database for values
$email=$_SESSION['logDin_user_email'];
$sql_sort=mysqli_query($conn, "SELECT * FROM user_data WHERE email='$email'");//User data sort
$row=mysqli_fetch_assoc($sql_sort);


//retrieve  values from the database
$title = $row["title"];
$surname = $row["surname"];
$firstname = $row["firstname"];
$middlename = $row["middlename"];
$occupation = $row["occupation"];
$phone = $row["phone"];
$payment_status = $row["payment_status"];
$pickup_status = $row["pickup_status"];
$surname = $row["surname"];
$email = $row["email"];
$schoolname = $row["schoolname"];
$schoolzone = $row["schoolzone"];
$schoollga = $row["schoollga"];
$nationality = $row["nationality"];
$stateoforigin = $row["stateoforigin"];
$userid = $row["user_id"];
$residential = $row["residential"];

//sort the database for vlaues
$pay_sort=mysqli_query($conn, "SELECT * FROM payment WHERE user_id='$userid'");//Payment data sort
$pay=mysqli_fetch_assoc($pay_sort);
$payment_date = $pay["date_paid"]; 
$payment_date = strtotime($payment_date);
$payment_date = date('M d Y', $payment_date);


?>


<?php
    //Include main NAV
    include_once 'includes/head.inc.php';

     
  ?>

    <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" style="color: grey;" class="closebtn" onclick="closeNav()">&times;</a>

  <a href="index.php" style="color: black"><p class="dash-menu-text"><i  class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" ><p class="dash-active"><i style="color: #99C24D;"  class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: black"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-cog" ></i>Settings</p></a>
  <a href="logout.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
</div>

<div class="sidebar">
      <div class="text-center logo-main logo-main-1" style="background-color: #fff"><img width="230" height="56" src="../images/logo.png"></div>
      <center>
      
    <div class="menu-bar" >
  <a href="index.php" style="color: black"><p  class="dash-menu-text"><i  class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" ><p class="dash-active"><i style="color: #99C24D;" class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: black"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-cog" ></i>Settings</p></a>
<a href="logout.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
  
</div>
</center>
</div>

<div class="main">
   <?php include_once 'includes/accountverify.php';

    //Include main NAV
    include_once 'includes/nav.inc.php';
  ?>

  <!--Display all profile info-->
<div class="content">
  <div class="container">
  <div class="profile-header">
   
    </div>
      <div class="row pro-info-main">
    <div class="pro-info col-sm-5">
      <h3>Personal Information</h3>
      <p>Name: Mr <?php echo $surname; ?> <?php echo $firstname; ?></p>
      <p>Email: <?php echo $email ?></p>
      <?php
      if ($payment_status == "unverified") {
        
      }
      else{
        echo "<p>User ID: " .$user_id."</p>";
      } ?>
      <p>Phone: <?php echo $phone ?></p>
      <p>Occupation: <?php echo $occupation ?></p>
      <p>Nationality: <?php echo $nationality ?></p>
      <p>State of Origin: <?php
      if ($stateoforigin == NULL) {
        echo "N/A";
      }
      else{
        echo $stateoforigin;
      } ?></p>
      <p>Residential Address: <?php
      if ($residential == NULL) {
        echo "N/A";
      }
      else{
        echo $residential;
      } ?></p>
    </div>
    <div class="pro-info col-sm-5">
      <h3>School</h3>
      <p>Name: <?php echo $schoolname ?></p>
      <p>Zone: <?php echo $schoolzone ?></p>
      <p>LGA: <?php echo $schoollga ?></p>
      <h3>Status</h3>
      <p>Card pickup status: <?php echo $pickup_status ?></p>
      <p>Account status: <?php echo $payment_status ?></p>
      <?php
      if ($payment_status == "unverified") {
        
      }
      else{
        echo "<p>Date Paid :" .$payment_date."</p>";
      } ?>
      
    </div>
  </div>
  </div>

    


  </div>
    
  

  



  



<?php
    //Include main NAV
    include_once 'includes/footer.inc.php';
  ?>