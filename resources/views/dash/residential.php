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

$residential =$row['residential']

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
  <a href="index.php" style="color: black"><p  class="dash-menu-text"><i  class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" style="color: black"><p class="dash-menu-text"><i  class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: black"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" ><p  class="dash-active"><i class="fas fa-cog" style="color: #99C24D;"></i>Settings</p></a>
<a href="logout.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
  
</div>
</center>
</div>




<div class="main">
   <?php
    include_once 'includes/accountverify.php';
    //Include main NAV
    include_once 'includes/nav.inc.php';
  ?>

<div class="content">
  <div class="container">
  <div class="pass-form" align="center">
    <h3>Residential Address</h3>
    <?php 
        if(isset($_SESSION['residential_error'])){
        echo $_SESSION['residential_error'];$_SESSION['residential_error']='';
        }  
    ?>
    <?php
    if ($residential == NULL) {
      echo '
        <form action="forms/form_residential.php" method="post">
        <div>
        <label>Input your residential address </label><br />
        <input type="text" name="residential">
        </div>

        <button name="SubmitResidential" align="center">SAVE</button>
        </form>
      ';
    }
    else {
      echo '<a style="color:rgb(255,186,8); " href="index.php">Address has been filled click to go back to dashboard</a>';
    }
    
    
?>
</div>
  </div>
  </div>




<?php
    //Include main NAV
    include_once 'includes/footer.inc.php';
  ?>