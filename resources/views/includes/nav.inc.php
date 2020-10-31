
<div class="text-center logo-main logo-main-2" ><img width="230" height="56" src="../images/logo.png"></div>

<nav class="navbar navbar-light text-center ">
  <div class="container-fluid">
    <div class="row header">
      
       <i style="margin-top: 7px; margin-right: 20px; float: right; width: 20px; cursor:pointer" onclick="openNav()" class="fa fa-bars"></i>
       
      
      <div class="col search-box head-left nav-top-content" > 
        <span class="search-icon nav-top-content">
          <i style="color: grey;" class="fas fa-search">
          </i>
        </span>
        <input class="search nav-top-content" type="search" placeholder="Search" name=""></div>
       
       
        
       <i style="margin-top: 7px;  float: right; width: 20px; font-size: 20px;" class="far fa-bell">
        <span class="nav-hover">
          <p>Notifications</p>
          
            <?php 
          
          if ($residential == NULL) {
            echo'<a href="residential.php"  style="text-decoration:none;">
            <div  class="notification"> 
             click here to fill in your residential address
            </div></a>';
          }
          else {
          
          }
          
           ?>
           
          
           
        </span>
      </i> 
      <span id="no1">
        <?php
        if ($residential == NULL) {
            echo "1";
          }
          else {
            echo'0';
          }?>
          </span>


       <i style="margin-top: 7px; margin-right: 20px; float: right; width: 20px; font-size: 20px;" class="fas fa-user-circle">
          <span class="nav-hover">
          <?php 
          echo $title."  ". $surname."  ". $firstname." <br> ";
          if ($payment_status == "unverified") {
          }
          else {
          echo $user_id;
          }
          
           ?>
        </span></i><span style="padding-top: 6px; padding-left: 0px; padding-right: 0px; margin-right: 35px; width: auto;">Adekunte Tolulope</span>
    </div>
  </div>
  <script>
    
  </script>
</nav>