
{{-- start session --}}


{{-- Include main NAV --}}

  @include('includes.head')


     
  


  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" style="color: grey;" class="closebtn" onclick="closeNav()">&times;</a>

  <a href="index.php" ><p class="dash-active"><i style="color: #99C24D;" class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" style="color: #fff"><p class="dash-menu-text"><i  class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: black"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" style="color: #fff"><p class="dash-menu-text" ><i class="fas fa-cog" ></i>Settings</p></a>
  <a href="logout.php" style="color: black"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
</div>

    <div class="sidebar">
      <div class="text-center logo-main logo-main-1" style="background-color: #fff"><img width="120" height="80" src="logo.png"></div>



      <center>
      
    <div class="menu-bar" >
  <a href="index.php" ><p class="dash-active"><i style="color: grey;" class="fas fa-home"></i>Dashboard</p></a>
  <a href="profile.php" style="color: #fff"><p class="dash-menu-text"><i  class="fas fa-user-circle"></i>Profile</p></a>
  <a href="#" style="color: #fff"><p class="dash-menu-text"><i class="fas fa-shopping-cart"></i>Shopping</p></a>
  <a href="settings.php" style="color: #fff"><p class="dash-menu-text" ><i class="fas fa-cog" ></i>Settings</p></a>
  <a href="logout.php" style="color: #fff"><p class="dash-menu-text" ><i class="fas fa-arrow-right"></i>Logout</p></a>
  
</div>

  
</center>
</div>



<div class="main">




      @include('includes.nav')  


<div class="content text-center">
  <div class="container">


  <div class="row">
    <div class="box-pro">
      <h3>Active Trades</h3>
      
    </div>
    <div class="box-pro">
      <h3>Refferal</h3>
      
    </div>
    <div class="box-pro">
      <h3>Wallet Balance</h3>
      
    </div>
    <div class="box-pro">
      <h3>Account Number</h3>
      
    </div>

  </div>

  <div class="" style="">
   
    <div class="invest_history  col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12" style="margin-top: 30px; background-color: rgb(250,250,250); ">
                                <div class="card">
                                    <h5 class="card-header" style="font-size: 16px; text-align: left; background-color: rgb(250,250,250); color: 
    grey;">Investment History</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive " style="height:50px; overflow: hidden;background-color: rgb(250,250,250);">
                                            <table class="table"style=" ">
                                                <thead class="" >
                                                    <tr style="font-size: 16; color: 
    grey;" class="border-0">
                                                        <th s class="border-0">S/N</th>
                                                        <th class="border-0">Investor's Name</th>
                                                        <th class="border-0">Account No.</th>
                                               
                                                        <th class="border-0">Status</th>
                                                    </tr>
                                                </thead>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
  </div>
</div>
    
  



    
 </div>

@include('includes.footer')

