  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      
      <div class="user-panel">        
        <div class="pull-left image">
          
            <img src="dist/img/avatar.png" class="img-circle" alt="Store Image" style="max-width: 45px; height: auto;">
                  
        </div>
        
        <div class="pull-left info">
          <p><?php echo ucfirst($_SESSION['logDin_username']); ?></p>
          <!-- Status -->
          <span style="font-size: 1em"><i class="fa fa-circle text-success"></i> Online </span>
        </div>
      </div>
      
      <hr/>
      
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="<?php echo $dashboard_active; ?>">
          <a href="index.php"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
        </li>

        <li class="<?php echo $profile_active; ?>">
          <a href="profile.php"><i class="fa fa-user"></i><span>Profile</span></a>
        </li>

        <li class="<?php echo $notify_active; ?>">
          <a href="notification.php"><i class="fa fa-bell"></i><span>Notifications</span></a>
        </li>

        <li class="treeview <?php echo $shopping_content_active; ?>">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Shopping</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $carts_active; ?>"><a href="carts.php"><i class="fa fa-circle-o"></i>Shopping Carts</a></li><!-- 
            <li class="<?php echo $file_content_active; ?>"><a href="add_image.php"><i class="fa fa-circle-o"></i>Pick Up Location</a></li> -->
            <li class="<?php echo $history_active; ?>"><a href="order_history.php"><i class="fa fa-circle-o"></i>Order History</a></li>
          </ul>
        </li>        

        <li class="<?php echo $change_pass; ?>">
          <a href="change_password.php"><i class="fa fa-lock"></i><span>Change Password</span></a>
        </li>

        <!-- <li class="treeview <?php //echo $site_content_active; ?>">
          <a href=""><i class="fa fa-archive"></i><span>Site Content</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
          </a>
          <ul class="treeview-menu">            
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Welcome_Message</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Slider</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Vision_Belief</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Who_we_are</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Offerings</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Feedbacks</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>FAQ</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Partners</a></li>
            <li class="<?php //echo $overview_active; ?>"><a href="#"><i class="fa fa-circle-o"></i>Contact_Information</a></li>
          </ul>
        </li> -->

        <li><a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
		  
	   </ul>
      
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>