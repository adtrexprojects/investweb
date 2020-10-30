<?php
//Verify if user is logged in and act accordingly
session_start(); // start session

//START User Verification
if(!isset($_SESSION['logDin_admin']) || $_SESSION['logDin_admin'] == ""){    
    header('Location: '.$home_dir.'login.php'); // Redirecting To Home Page  
    exit();
}
//END user verification

//setting directory level
$dir_level = 0;

//Creating a valid page title
$page_title = "Teachers";

//include variables
include_once 'includes/variables.inc.php';

//Include page header
include_once 'includes/header.inc.php';

//===========PAGINATION AND PAGE CONTENT COLLECTION=================================//
//Include database connection file
include_once('includes/dbConnection.php');

//PAGE FORM VARIABLES
$show10 = "";
$show25 = "selected";
$show50 = "";
$show100 = "";


//Pagination code
$tbl_name = "user_data";        //your table name   
$adjacents = 3; // How many adjacent pages should be shown on each side?
$page = 1; //default value for current page
$sort_by = ""; //creating variable for sort attribute
$search_string = ""; //creating variable for search attribute

//Status Variables

$pay_verified="";

$pay_unverified="";

$pickup_verified="";

$pickup_unverified="";

if (isset($_GET['account_verified'])) {
  $pay_verified=" selected";
  $pickup_verified=" selected";
}

//Get total number of unverified teachers
$query_pay = "SELECT sn FROM ".$tbl_name." WHERE status = 'active' AND payment_status = 'unverified' ";  
$result_pay = $conn->query($query_pay);
if($result_pay){//if query was executed successfully
    $rows_pay = $result_pay->num_rows;
} 


/* Get data for Pagination*/

//setting/getting value for total number of users to be shown on one page
if(isset($_GET['users_per_page'])){   
    //collecting P3 value through GET
    $limit = $_GET['users_per_page'];
    $limit = stripslashes($limit);
    $limit = mysqli_real_escape_string($conn, $limit); //for prevention of mySQL injection

    //setting form variables ("selected")
    switch ($limit) {
        case '10':
            $show10 = "selected";
            $show25 = "";
            $show50 = "";
            $show100 = "";
            break;
        case '25':            
            $show10 = "";
            $show25 = "selected";
            $show50 = "";
            $show100 = "";
            break;
         case '50':
            $show10 = "";
            $show25 = "";
            $show50 = "selected";
            $show100 = "";
            break;
        case '100':
            $show10 = "";
            $show25 = "";
            $show50 = "";
            $show100 = "selected";
            break;
        
        default:
            $show25 = "selected";
            break;
    }
}else{
    //default value for limit
    $limit = 25;
}  

$male="";
$female="";

//collecting GET variables and using them to create and execute a query.
if(isset($_GET['search'])){
    //collecting search value through GET
    $search_string = trim($_GET['search']);
    $search_string = stripslashes($search_string);
    $search_string = mysqli_real_escape_string($conn, $search_string); //for prevention of mySQL injection 

    //setting the target page
    $targetpage = "teachers.php?search=".$search_string."&users_per_page=".$limit."&";

    //Creating a query to get search results from DB
    $query_teachers = "SELECT * FROM ".$tbl_name." WHERE 
        surname LIKE '%".$search_string."%' OR 
        user_id LIKE '%".$search_string."%' OR 
        occupation LIKE '%".$search_string."%' OR 
        phone LIKE '%".$search_string."%' OR 
        pickuplocation LIKE '%".$search_string."%' OR 
        schoolname LIKE '%".$search_string."%' OR 
        firstname LIKE '%".$search_string."%' OR 
        middlename LIKE '%".$search_string."%' 
        ";    //creating the query        
    $result_search = $conn -> query($query_teachers); // executing the query  
}elseif(isset($_GET['gender'])){

    //collecting gender value through GET
    $gender_string = trim($_GET['gender']);
    $gender_string = stripslashes($gender_string);
    $gender_string = mysqli_real_escape_string($conn, $gender_string); //for prevention of mySQL injection 

    if ($gender_string=='Male') {
      $male=" selected";
    }elseif($gender_string=='Female'){
      $female=" selected";
    }
    //setting the target page
    $targetpage = "teachers.php?gender=".$gender_string."&";

    //Creating a query to get search results from DB
    $query_gender = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND
        gender='".$gender_string."' 
        ";    //creating the query        
    $result_search = $conn -> query($query_gender); // executing the query  

}elseif(isset($_GET['account_status'])){
    

    //collecting gender value through GET
    $account_status_string = trim($_GET['account_status']);
    $account_status_string = stripslashes($account_status_string);
    $account_status_string = mysqli_real_escape_string($conn, $account_status_string); //for prevention of mySQL injection 

    //setting the target page
    $targetpage = "teachers.php?account_status=".$account_status_string."&";

    //Creating a query to get search results from DB
    $query_account_status = "SELECT * FROM ".$tbl_name." WHERE 
        status='".$account_status_string."' 
        ";    //creating the query        
    $result_search = $conn -> query($query_account_status); // executing the query  

}elseif(isset($_GET['pay_status'])){
    

    //collecting gender value through GET
    $pay_status_string = trim($_GET['pay_status']);
    $pay_status_string = stripslashes($pay_status_string);
    $pay_status_string = mysqli_real_escape_string($conn, $pay_status_string); //for prevention of mySQL injection 

    if ($pay_status_string=='verified-success') {
      $pay_verified=" selected";
    }elseif($pay_status_string=='unverified'){
      $pay_unverified=" selected";
    }

    //setting the target page
    $targetpage = "teachers.php?pay_status=".$pay_status_string."&";

    //Creating a query to get search results from DB
    $query_pay_status = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND
        payment_status='".$pay_status_string."' 
        ";    //creating the query        
    $result_search = $conn -> query($query_pay_status); // executing the query  

}elseif(isset($_GET['pick_status'])){
    

    //collecting gender value through GET
    $pick_status_string = trim($_GET['pick_status']);
    $pick_status_string = stripslashes($pick_status_string);
    $pick_status_string = mysqli_real_escape_string($conn, $pick_status_string); //for prevention of mySQL injection 

    if ($pick_status_string=='verified-picked') {
      $pickup_verified=" selected";
    }elseif($pick_status_string=='unverified'){
      $pickup_unverified=" selected";
    }

    //setting the target page
    $targetpage = "teachers.php?pay_status=".$pick_status_string."&";

    //Creating a query to get search results from DB
    $query_pay_status = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND 
        pickup_status='".$pick_status_string."' 
        ";    //creating the query        
    $result_search = $conn -> query($query_pay_status); // executing the query  

}elseif(isset($_GET['account_verified'])){
    

    //collecting gender value through GET
    $account_verified_string = trim($_GET['account_verified']);
    $account_verified_string = stripslashes($account_verified_string);
    $account_verified_string = mysqli_real_escape_string($conn, $account_verified_string); //for prevention of mySQL injection 

    /*if ($pick_status_string=='verified-picked') {
      $pickup_verified=" selected";
    }elseif($pick_status_string=='unverified'){
      $pickup_unverified=" selected";
    }*/

    //setting the target page
    $targetpage = "teachers.php?account_verified=".$account_verified_string."&";

    //Creating a query to get search results from DB
    $query_account_verified = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND payment_status='verified-success' AND pickup_status='verified-picked'";    //creating the query        
    $result_search = $conn -> query($query_account_verified); // executing the query  

}else{
    //setting the target page
    $targetpage = "teachers.php?users_per_page=".$limit."&"; 
    $query_teachers = "SELECT * FROM ".$tbl_name." WHERE status = 'active'";
    $result_search = $conn -> query($query_teachers); // executing the query    
}


//getting the total number of rows gotten from the executed query, if executed successfully.
if($result_search){
    //getting the total number of rows from the query execution
    $total_rows = $result_search->num_rows;   
}else{
    echo "QUERY ERROR: <br/>".$query_teachers;
    exit();
}


//setting/getting value for current page number
if(isset($_GET['page'])){
    //collecting page value through GET
    $page = $_GET['page'];
    $page = stripslashes($page);
    $page = mysqli_real_escape_string($conn, $page); //for prevention of mySQL injection 

    //set the start item number for current page
    $start = ($page - 1) * $limit;
}else{ 
    $start = 0;
} //if no page var is given, set start to 0


// Get data for Display in search page 
if(isset($_GET['search'])){ 
    $sql = "SELECT * FROM ".$tbl_name." WHERE 
        surname LIKE '%".$search_string."%' OR 
        user_id LIKE '%".$search_string."%' OR 
        occupation LIKE '%".$search_string."%' OR 
        phone LIKE '%".$search_string."%' OR 
        pickuplocation LIKE '%".$search_string."%' OR 
        schoolname LIKE '%".$search_string."%' OR 
        firstname LIKE '%".$search_string."%' OR 
        middlename LIKE '%".$search_string."%' 
        LIMIT $start, $limit 
        ";    //creating the query             
    $get_query_teacher = $conn->query($sql);  
}elseif(isset($_GET['gender'])){
    $sql = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND gender='$gender_string' order BY sn DESC LIMIT $start, $limit";
    $get_query_teacher = $conn->query($sql);
}elseif(isset($_GET['account_status'])){
    $sql = "SELECT * FROM ".$tbl_name." WHERE status='$account_status_string' order BY sn DESC LIMIT $start, $limit";
    $get_query_teacher = $conn->query($sql);
}elseif(isset($_GET['pay_status'])){
    $sql = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND payment_status='$pay_status_string' order BY sn DESC LIMIT $start, $limit";
    $get_query_teacher = $conn->query($sql);
}elseif(isset($_GET['pick_status'])){
    $sql = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND pickup_status='$pick_status_string' order BY sn DESC LIMIT $start, $limit";
    $get_query_teacher = $conn->query($sql);
}elseif(isset($_GET['account_verified'])){
    $sql = "SELECT * FROM ".$tbl_name." WHERE status = 'active' AND pickup_status='verified-picked' AND payment_status='verified-success' order BY sn DESC LIMIT $start, $limit";
    $get_query_teacher = $conn->query($sql);
}else{
    $sql = "SELECT * FROM ".$tbl_name." WHERE status = 'active' order BY sn DESC LIMIT $start, $limit";
    $get_query_teacher = $conn->query($sql);
}




$sql_index = "SELECT * FROM ".$tbl_name;

$get_query_index = $conn->query($sql_index);
$trash_no=0;
//$all_users_no=$get_query_index->num_rows;
$all_users_no=0;
$gender_male_no=0;
$gender_female_no=0;
$verified_no=0;
while ($row = mysqli_fetch_array($get_query_index)) {
  if ($row['status']=='active') {
    $all_users_no++;
  }
  if ($row['status']=='inactive') {
    $trash_no++;
    if($row['gender']=='Male' AND $row['status']=='active' ){
      $gender_male_no++;
    }else if($row['gender']=='Female' AND $row['status']=='active'){
      $gender_female_no++;
    }
  }else if($row['payment_status']=='verified-success' AND $row['pickup_status']=='verified-picked'){
    $verified_no++;
    if($row['gender']=='Male' AND $row['status']=='active'){
      $gender_male_no++;
    }else if($row['gender']=='Female' AND $row['status']=='active'){
      $gender_female_no++;
    }
  }else if($row['gender']=='Male' AND $row['status']=='active'){
    $gender_male_no++;
  }else if($row['gender']=='Female' AND $row['status']=='active'){
    $gender_female_no++;
  }
}

$allusers="";
$account_status="";
$account_verified="";
$gender_male="";
$gender_female="";
if (isset($_GET['allusers'])) {
  $allusers=" selected";
}
if(isset($_GET['account_verified'])){
  $account_verified=" selected";
}
if(isset($_GET['account_status'])){
  $account_status=" selected";
}
if(isset($_GET['gender']) AND $_GET['gender']=='Male'){
  $gender_male=" selected";
}
if(isset($_GET['gender']) AND $_GET['gender']=='Female'){
  $gender_female=" selected";
}



/* Setup page vars for display. */
$prev = $page - 1;                          //previous page is page - 1
$next = $page + 1;                          //next page is page + 1
$lastpage = ceil($total_rows/$limit);      //lastpage is = total pages / users per page, rounded up.
$lpm1 = $lastpage - 1;                      //last page minus 1

//setting the value for number of the last item on a page 
$last_item_num = 0;
if( $page != $lastpage){
    $last_item_num = $page * $limit;
}else{
    $last_item_num = $total_rows;
}
if ($total_rows <= 0) {
    $last_item_num = 0;
}

/* 
    Now we apply our rules and draw the pagination object. 
    We're actually saving the code to a variable in case we want to draw it more than once.
*/


$pagination = "";
if($lastpage > 1)
{               
    //pages 
    for ($counter = 1; $counter <= $lastpage; $counter++)
    {
        if ($counter < $page && $counter >= $page-2){
            $pagination.= '<li><a href="'.$targetpage.'page='.$counter.'" >'.$counter.'</a></li>  ';                     
        }                   
        else if ($counter == $page){
            $pagination.= '<li class="active"><a href="#">'.$counter.'</a></li>';//<li class="active"><a href="#">1</a></li>
        }   
        else if ($counter > $page && $counter <= $page+2){                
            $pagination.= '<li><a href="'.$targetpage.'page='.$counter.'" >'.$counter.'</a></li>  ';
        }                   
    }

    if($page <= $lastpage && $page > 1){
        $prev_page = $page - 1;
        $pagination = '
                            <li>
                              <a href="'.$targetpage.'page='.$prev_page.'" aria-label="Prev" title="previous page">
                                <span aria-hidden="true"> <strong>&laquo;</strong></span>
                              </a>
                            </li>
                        '.$pagination;            
    }

    if($page < $lastpage){
        $next_page = $page + 1;
        $pagination .= '
                            <li>
                              <a href="'.$targetpage.'page='.$next_page.'" aria-label="Next" title="next page">
                                <span aria-hidden="true"><strong>&raquo;</strong></span>
                              </a>
                            </li>
                        ';            
    }

    $pagination .= '
                            </ul>
                        </nav>
                        <div class="pull-right" style="color:#999; margin-top: -10px;">
                          Page '.$page.' of '.$lastpage.' || 
                          Page: <input type="text" style="width: 40px;"> 
                          <button class="btn btn-primary btn-sm">
                            go
                          </button>
                        </div>
                    </div>
            <!-- pagination -->
                        ';
}else{
   //echo "PAGINATION ERROR";
}

                                

//collecting Pick up Zones for display
$count=0;
$count_pickup = 0;
$query_pickup = "SELECT * FROM pickup_branches WHERE status=\"active\" ";  
$result_pickup = $conn->query($query_pickup);
if($result_pickup){//if query was executed successfully
    $rows_pickup = $result_pickup->num_rows;
    if ($rows_pickup > 0){ 
      //collect rows' DB data
      while($each_row_pickup = mysqli_fetch_array($result_pickup)){ 
          $pickup_name_db[$count] = $each_row_pickup['name'];
          $count++;
      }
    } 
} 


//collecting states for display
$count = 0;
$query_states = "SELECT * FROM ng_states WHERE status=\"active\" ";  
$result_states = $conn->query($query_states);
if($result_states){//if query was executed successfully
    $rows_states = $result_states->num_rows;
} 
?>

  <!--START IN-PAGE STYLES -->
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link href="../css/jquery-ui.min.css" rel="stylesheet" type="text/css">

<link href="../css/bootstrap.min.css?id=1" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui.min.css" rel="stylesheet" type="text/css">
  <!--END IN-PAGE STYLES -->


  <?php
    //Include main NAV
    include_once 'includes/nav.inc.php';

    //setting active sidebar variables
    $teachers_active = "active";

    //Include sidebar
    include_once 'includes/sidebar.inc.php';
  ?>

 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teachers
        <small>Teachers Overview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-Teachers"></i> Teachers</a></li>
        <li class="active">Overview</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
          <!-- box-header -->
          <div class="box-header">
            
            <div class="row">
              
              <div class="col-sm-6">

                <label title="Add product" id="add_new" data-toggle="modal" data-target="#pop_register">
                  <span class="btn btn-primary btn-sm "  style="font-size: 1.0em;"><i class="fa fa-plus fa-lg"></i></span>&nbsp;&nbsp;&nbsp;
                </label>

                  <select name="pay_status" id="id_pay_verified" onchange="
                    var value_pay=$('#id_pay_verified').val(); 
                    var split =value_pay.split('|');
                    if(split[0]=='payment'){
                      window.location='?pay_status='+split[1];
                    }else if(split[0]=='pickup'){
                      window.location='?pick_status='+split[1];
                    }
                  ">
                      <option value="">Sort by</option>                 
                      <option <?php echo $pay_verified;?> value="payment|verified-success">Payment (Verified)</option>
                      <option <?php echo $pay_unverified;?> value="payment|unverified">Payment (Unverified)</option>
                      <option <?php echo $pickup_verified;?>  value="pickup|verified-picked">Pickup (Verified)</option>
                      <option <?php echo $pickup_unverified;?> value="pickup|unverified">Pickup (Unverified)</option>
                  </select>

                   <select name="pay_status" id="id_user_sort" onchange="
                  var value_pay=$('#id_user_sort').val(); 
                  var split =value_pay.split('|');
                  window.location='?'+split[0]+'='+split[1];
                  
                  ">
                      <option value="">Select...</option>                 
                      <option <?php echo $allusers;?> value="allusers|users">All Users (<?php echo $all_users_no ?>)</option>
                      <option <?php echo $account_verified;?> value="account_verified|true">only Verified users (<?php echo $verified_no ?>)</option>
                      <option <?php echo $account_status;?>  value="account_status|inactive">only Trashed users(<?php echo $trash_no ?>)</option>
                      <option <?php echo $gender_male;?> value="gender|Male">Only Male (<?php echo $gender_male_no ?>)</option>
                      <option <?php echo $gender_female;?> value="gender|Female">Only Female (<?php echo $gender_female_no ?>)</option>
                  </select>

                
                <!--<label>
                  <span class="btn btn-default btn-xs btn-flat"  style="font-size: 1.0em;">UNVERIFIED PAYMENTS: <b><?php //echo $rows_pay; ?></b></span>&nbsp;
                </label>-->
                
              </div>

              <div class="col-sm-6">
                <div id="example1_filter" class="dataTables_filter">
                  <form method="get" style="display:inline;">
                    <label>
                    <select name="users_per_page" id="users_per_page" onchange="this.form.submit()">
                        <option <?php echo $show10;?> value="10">Show 10</option>
                        <option <?php echo $show25;?> value="25">Show 25</option>
                        <option <?php echo $show50;?> value="50">Show 50</option>
                        <option <?php echo $show100;?> value="100">Show 100</option>
                    </select>
                  </label>

                  <label>
                  <input type="search" name="search" class="form-control input-sm" placeholder="Search by Keyword" aria-controls="example1">
                  </label>
                  <button type="submit">
                    <i class="fa fa-search" title="Search"></i>
                  </button>
                  <button type="button" onclick="Export()">Export <i class="fa fa-"></i></button>
                  </form>

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">                    
                <p style="font-style: italic; text-align: center;">
                  Viewing <?php echo number_format($start+1)."-".number_format($last_item_num)." of ".number_format($total_rows);?>  registered Teachers
                </p>
              </div>
            </div>
          </div>
          <!-- /.box-header -->

          <!-- box-body -->
          <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped table-responsive">
            <?php 
                if (isset($_SESSION['alert_type']) && $_SESSION['alert_type'] === "success") {
                  echo "<div class='alert alert-success'>".$_SESSION['message']."</div>";
                }else
                if (isset($_SESSION['alert_type']) && $_SESSION['alert_type'] === "failed") {
                  echo "<div class='alert alert-danger'>".$_SESSION['message']."</div>";
                }
              ?>
              <thead>
                <tr>
                  <th width="5%">SN</th>
                  <th width="5%">ID</th>
                  <th width="20%">Full Name</th>
                  <th width="5%">Gender</th>               
                  <th width="10%">Phone Number</th>
                  <th width="15%">Email</th>
                  <th width="10%">PickUp Location</th>
                  <th width="5%">PickUp Status</th>
                  <th width="5%">Payment Status</th>
                  <th width="10%">Time Registered</th>
                  <th width="15%">Action</th>
                </tr>
              </thead>
              
              <tbody>
                <?php
                //displaying search results                     
                $count = $start;
                
                if($get_query_teacher){
                    $rows_search = $get_query_teacher->num_rows;
                    if ($rows_search > 0){ 
                        //echo "RESULT(S) EXISTS<br/>";

                        //collect rows' DB data
                        while($each_row_search = mysqli_fetch_array($get_query_teacher)){ 
                            $count++;
                    
                            $id_db = $each_row_search['sn'];
                            $user_id = $each_row_search['user_id'];
                            $fullname_db = $each_row_search['surname']." ".$each_row_search['firstname']." ".$each_row_search['middlename'];
                            $title_db = $each_row_search['title'];
                            $occupation_db = $each_row_search['occupation'];
                            $gender_db = $each_row_search['gender'];
                            $phone_db = $each_row_search['phone'];
                            $email_db = $each_row_search['email'];
                            $pickup_location_db = $each_row_search['pickuplocation'];
                            $pickup_status__db = $each_row_search['pickup_status'];    
                            $payment_db = $each_row_search['payment_status'];      
                            $status_db = $each_row_search['status'];                                        
                            $time_reg_db = $each_row_search['time_created'];  

                            $payment_item=mysqli_query($conn, "SELECT * FROM payment WHERE user_id='$user_id'");

                            $payment_data=mysqli_fetch_array($payment_item);    

                            $pick_item=mysqli_query($conn, "SELECT * FROM pick_up WHERE user_id='$user_id'");
                            $pick_data=mysqli_fetch_array($pick_item);   
                ?>   


                            <!-- Payment Values -->
                            <input type="hidden" id="slip_number_db<?php echo $id_db ?>" value="<?php echo $payment_data['slip_number'] ?>">
                            <input type="hidden" id="date_paid_db<?php echo $id_db ?>" value="<?php echo $payment_data['date_paid'] ?>">
                            <input type="hidden" id="branch_paid_db<?php echo $id_db ?>" value="<?php echo $payment_data['branch_paid'] ?>">
                            <input type="hidden" id="paid_created_db<?php echo $id_db ?>" value="<?php echo $payment_data['time_created'] ?>">
                            <input type="hidden" id="paid_status_db<?php echo $id_db ?>" value="<?php echo $payment_data['status'] ?>">
                            <!-- Payment Values -->

                            <!-- Picked Values -->
                            <input type="hidden" id="date_pick_db<?php echo $id_db ?>" value="<?php echo $pick_data['date_picked'] ?>">

                            <input type="hidden" id="branch_pick_db<?php echo $id_db ?>" value="<?php echo $pick_data['branch_picked_from'] ?>">

                            <input type="hidden" id="pick_created_db<?php echo $id_db ?>" value="<?php echo $pick_data['time_created'] ?>">
                            <input type="hidden" id="pick_status_db<?php echo $id_db ?>" value="<?php echo $pick_data['status'] ?>">
                            <!-- Picked Values -->


                            <input type="hidden" id="state_db<?php echo $id_db ?>" value="<?php echo $each_row_search['stateoforigin'] ?>">

                            <input type="hidden" id="username_db<?php echo $id_db ?>" value="<?php echo $each_row_search['surname'] ?>">
                            <input type="hidden" id="firstname_db<?php echo $id_db ?>" value="<?php echo $each_row_search['firstname'] ?>">
                            <input type="hidden" id="middlename_db<?php echo $id_db ?>" value="<?php echo $each_row_search['middlename'] ?>">
                            <input type="hidden" id="title_db<?php echo $id_db ?>" value="<?php echo $each_row_search['title'] ?>">

                            <input type="hidden" id="occupation_db<?php echo $id_db ?>" value="<?php echo $each_row_search['occupation'] ?>">

                            <input type="hidden" id="homenumber_db<?php echo $id_db ?>" value="<?php echo $each_row_search['homenumber'] ?>">

                            <input type="hidden" id="dob_db<?php echo $id_db ?>" value="<?php echo $each_row_search['dob'] ?>">

                            <input type="hidden" id="nationality_db<?php echo $id_db ?>" value="<?php echo $each_row_search['nationality'] ?>">
                            <input type="hidden" id="stateoforigin_db<?php echo $id_db ?>" value="<?php echo $each_row_search['nationality'] ?>">
                            <input type="hidden" id="schoolname_db<?php echo $id_db ?>" value="<?php echo $each_row_search['schoolname'] ?>">
                            <input type="hidden" id="schoolzone_db<?php echo $id_db ?>" value="<?php echo $each_row_search['schoolzone'] ?>">
                            <input type="hidden" id="schoollga_db<?php echo $id_db ?>" value="<?php echo $each_row_search['schoollga'] ?>">
                            <input type="hidden" id="acc_number_db<?php echo $id_db ?>" value="<?php echo $each_row_search['acc_number'] ?>">
                            
                            
                            <tr>
                              <td style="vertical-align: middle;"><?php echo $count; ?>.</td>

                              <td style="vertical-align: middle;" id="id_db<?php echo $id_db ?>">
                                <?php echo $user_id; ?>
                              </td>

                              <td style="vertical-align: middle;" id="fullname_db<?php echo $id_db ?>">
                                <?php echo $fullname_db; ?>
                              </td>

                              <td style="vertical-align: middle;" id="gender_db<?php echo $id_db ?>">
                                <?php echo $gender_db; ?>
                              </td>

                              <td style="vertical-align: middle;" id="phone_db<?php echo $id_db ?>">
                                <?php echo $phone_db;  ?>
                              </td>

                              <td style="vertical-align: middle;" id="email_db<?php echo $id_db ?>">
                                <?php echo $email_db;  ?>
                              </td>

                              <td style="vertical-align: middle;" id="pickup_location_db<?php echo $id_db ?>">
                                <?php echo $pickup_location_db;  ?>
                              </td>

                              <td style="vertical-align: middle;" id="pickup_status_db<?php echo $id_db ?>">
                              <?php
                              if($status_db == 'active'){
                                if($pickup_status__db === "unverified"){
                                    echo '<span class="label label-danger">  '.$pickup_status__db.' </span><br/>';
                                    echo '
                                      <small class="verify_but'.$id_db.'"><a href="#" data-toggle="modal" data-target="#pick_verify" onclick="verifyPick(\''. $fullname_db .'\', \''.$user_id.'\')">Verify Now</a></small>
                                    ';  
                                    echo '
                                      <small class="replace_pick'.$id_db.'" style="display:none;"><a href="#" data-toggle="modal" data-target="#pick_verify" onclick="viewPick(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>
                                    ';
                                  

                                }elseif($pickup_status__db=="verified-picked"){    
                                  echo '
                                    <span class="label label-success">  '.$pickup_status__db.' </span><br/>
                                    <small><a href="#" data-toggle="modal" data-target="#pick_verify" onclick="viewPick(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>
                                  ';
                                }else{  
                                  echo '<span class="label label-warning">  '.$pickup_status__db.' </span><br/>';
                                  echo '
                                    <small class="verify_but'.$id_db.'"><a href="#" data-toggle="modal" data-target="#pick_verify" onclick="verifyPick(\''. $fullname_db .'\', \''.$user_id.'\')">Verify Now</a></small>
                                  ';  
                                  echo '
                                    <small class="replace_pick'.$id_db.'" style="display:none;"><a href="#" data-toggle="modal" data-target="#pick_verify" onclick="viewPick(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>
                                  ';
                                }
                              }else{
                                  if($pickup_status__db === "unverified"){
                                    echo '<span class="label label-danger">  '.$pickup_status__db.' </span><br/>';
                                  }elseif($pickup_status__db=="verified-picked"){ 
                                    echo '<span class="label label-success">  '.$pickup_status__db.' </span><br/>';
                                  }
                                  echo '
                                    <small class="replace_pick" style=""><a href="#" data-toggle="modal" data-target="#pick_verify" onclick="viewPick(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>
                                  ';
                              }
                              ?>
                              </td>

                              <td style="vertical-align: middle;" id="payment_status_db<?php echo $id_db ?>">
                              <?php

                              if($status_db == 'active'){
                                if($payment_db === "unverified"){
                                  echo '
                                    <span class="label label-danger">  '.$payment_db.' </span><br/>
                                    <small class="verify_but'.$id_db.'"><a href="#" data-toggle="modal" data-target="#pop_verify" onclick="verifyPay(\''. $fullname_db .'\', \''.$user_id.'\')">Verify Now</a></small>	
                                  ';
                                  echo '<small class="replace_pick'.$id_db.'" style="display:none;"><a href="#" data-toggle="modal" data-target="#pop_verify" onclick="viewPay(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>';

                                }elseif($payment_db ==="verified-success"){    
                                  echo '
                                    <span class="label label-success">  '.$payment_db.' </span><br/>
                                    <small><a href="#" data-toggle="modal" data-target="#pop_verify" onclick="viewPay(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>
                                  ';
                                }else{  
                                  echo '
                                    <span class="label label-warning">  '.$payment_db.' </span><br/>
                                    <small class="verify_but'.$id_db.'"><a href="#" data-toggle="modal" data-target="#pop_verify" onclick="verifyPay(\''. $fullname_db .'\', \''.$user_id.'\')">Verify Now</a></small>
                                  ';
                                  echo '<small class="replace_pick'.$id_db.'" style="display:none;"><a href="#" data-toggle="modal" data-target="#pop_verify" onclick="viewPay(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>';
                                }
                              }else{
                                if($payment_db === "unverified"){
                                  echo '
                                    <span class="label label-danger">  '.$payment_db.' </span><br/>';
                                }elseif($payment_db ==="verified-success"){ 
                                  echo '
                                    <span class="label label-success">  '.$payment_db.' </span><br/>';
                                }else{
                                  echo '
                                    <span class="label label-warning">  '.$payment_db.' </span><br/>';
                                }
                                echo '<small class="replace_pick'.$id_db.'"><a href="#" data-toggle="modal" data-target="#pop_verify" onclick="viewPay(\''. $fullname_db .'\', \''.$id_db.'\')">View Now</a></small>';

                              }
                              ?>
                              </td>

                              <td style="vertical-align: middle;" id="time_created_db<?php echo $id_db; ?>">
                                <?php echo $time_reg_db; ?>
                              </td>

                              <td style="vertical-align: middle;" id="id_status_trash<?php echo $id_db ?>">                     
                              <?php
                                if($status_db === "active"){
                                  echo '
                                    <button data-toggle="modal" data-target="#pop_view" class="btn btn-default btn-sm btn-flat" title="View" onclick="view_response(\''. $fullname_db .'\', \''.$id_db.'\');">
                                      <i class="fa fa-eye fa-lg"></i>
                                    </button> 
                                    
                                    <button class="btn btn-default btn-sm btn-flat" data-toggle="modal" data-target="#pop_register_edit" title="edit" onclick="edit_options(\''. $fullname_db .'\', \''.$id_db.'\')">
                                      <i class="fa fa-pencil fa-lg"></i>
                                    </button> 
                                    
                                    <button class="btn btn-default btn-sm btn-flat" title="trash" onclick="ignore_contact(\''. $fullname_db .'\', \''.$id_db.'\')">
                                      <i class="fa fa-trash fa-lg"></i>
                                    </button>
                                  ';
                                }else{  
                                  echo '
                                    <label class="label label-danger" style="font-size: 0.9em;">
                                        TRASHED
                                    </label>
                                  ';
                                }
                                ?>                  
                              </td>
                            </tr>

            <?php
                      } //End while                                   
                  }else{
                      //echo "NO RESULT(S)!!!<br/>";
                      echo '
                        <li class="col-sx-12 col-sm-12">
                          <div style="text-align: center;">
                              No results were found.<br/>
                          </div>
                        </li>
                      ';
                  }
              }else{
                  echo "QUERY ERROR!!!<br/>";
              }
            ?> 

                  </tbody>
                  <!--<tfoot>
                  </tfoot>-->
                </table>

                        <div class="sortPagiBar pull-right">
                          <!-- PAGINATION HERE -->
                          <?php
                              $start_pagination = '
                                  
                                      <div class="bottom-pagination">
                                          <nav>
                                            <ul class="pagination">
                                                      ';              
                              if (!empty($pagination)){
                                  echo $start_pagination.$pagination;                 
                              }else{
                                  ;
                              }
                          ?> 
                      </div>
                    </div>
                    <!-- /.box-body -->
          
          
                    <!-- Form creation for trashing a user's contact-->
                    <form action="forms/form_teacher_trash.php" method="post" id="id_account_trash_form" role="form">
                        <input type="hidden" name="trash_account" id="id_trash_account" value="">
                    </form>

                    <!-- Form creation for viewing a user's contact-->
                    <form action="forms/form_view_teachers_details.php" method="post" id="id_account_teacher_form" role="form">
                        <input type="hidden" name="teacher_account" id="id_teacher_account" value="">
                    </form>

        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="pop_register">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <?php
            if (isset($_GET['page'])) {
              $urlEdit='edit='.$_GET['page'];
            }else{
              $urlEdit='';
            }
           ?>
          <form id="registration_form_popup" action="forms/form_register.php?<?php echo $urlEdit ?>" name="newReg" class="reservation-form" method="post">
            
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:#000">&times;</span></button>                  
                  <h4 class="modal-title" id="ReplyCont">New Teacher: <u><small id="id_set_username"></small></u> </h4>
                </div>

                <div class="modal-body ">

                    <div id="form_messages" style="text-align: center; display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i id="alert_fa"></i>
                        <strong style="border-bottom: 2px solid;" id="alert_header"></strong><br/>  
                        <strong id="alert_message"></strong>
                    </div>
             
                    <input type="hidden" name="check_submit" value="new">
                    <div id="form_content" class="newContent">
                      <div class="row">
                        <div class="col-lg-12">
                          <!-- Registration Form Start-->
                            <div class="row">
                              <div id="form_content">
                                <h4 style="padding-left: 20px;">Card Holder Details</h4>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="new_pickuplocation" name="pickuplocation" class="form-control" required="">
                                      <option value="">- Select Pick-Up Location -</option>
                                      <?php   

                                        $count_pickup = 0;                                      
                                        while($count_pickup != sizeof($pickup_name_db)){                                             
                                            echo '<option value="'.$pickup_name_db[$count_pickup].'">'.$pickup_name_db[$count_pickup].'</option>';
                                            $count_pickup++;
                                        } 
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="new_gender" name="gender" class="form-control" required="">
                                        <option value="">- Select Gender -</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">                                  
                                    <div class="form-group">
                                      <div class="styled-select">
                                        <select id="new_title" name="title" class="form-control" required="">
                                          <option value="">- Select Title -</option>
                                          <option value="Mr.">Mr.</option>
                                          <option value="Mrs.">Mrs.</option>
                                          <option value="Miss">Miss</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Surname" type="text" id="new_surname" name="surname" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="First Name" type="text" id="new_firstname" name="firstname" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Middle Name" type="text" id="new_middlename" name="middlename" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="E-mail" type="email" id="new_email" name="email" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Home Tel No (08012345678)" type="text" id="new_homenumber" name="homenumber" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Mobile No (08012345678)" type="text" id="new_phone" name="phone" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input id="new_dob" name="dob" class="form-control required date-picker" type="text" placeholder="Date Of Birth" aria-required="true">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Occupation" type="text" id="new_occupation" name="occupation" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="new_nationality" name="nationality" class="form-control" required="">
                                      <option value="">- Select Nationality -</option>
                                      <option value="Nigerian">Nigerian</option>
                                      <option value="Others">Others</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4" id="new_states" style="display: none;">
                                  <div class="form-group">
                                    <select id="new_stateoforigin" name="stateoforigin" class="form-control">
                                      <option value="">- Select State of Origin -</option>
                                      <option value="Ogun State">Ogun State<option>
                                      <?php 
                                        if ($rows_states > 0){ 
                                          //collect rows' DB data
                                          while($each_row_states = mysqli_fetch_array($result_states)){ 
                                              $name_db = $each_row_states['name'];
                                              echo '<option value="'.$name_db.'">'.$name_db.'</option>';
                                          }
                                        } 
                                      ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-12">
                                  <h4>School Details</h4>
                                </div>

                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Name of School" type="text" id="new_schoolname" name="schoolname" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="new_schoolzone" name="schoolzone" class="form-control" required="">
                                      <option value="">- Select School's Zone -</option>
                                      <option value="Ogun West - Yewa">Ogun West - Yewa</option>
                                      <option value="Ogun Central - Egba">Ogun Central - Egba</option>
                                      <option value="Ijebu-Ode">Ijebu-Ode</option>
                                      <option value="Sagamu - Remo">Sagamu - Remo</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="new_schoollga" name="schoollga" class="form-control" required="">
                                      <option value="">- Select School's LGA -</option>
                                      <?php   
                                        $count_pickup = 0;                                      
                                        while($count_pickup != sizeof($pickup_name_db)){                                             
                                            echo '<option value="'.$pickup_name_db[$count_pickup].'">'.$pickup_name_db[$count_pickup].' LGA </option>';
                                            $count_pickup++;
                                        } 
                                      ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-12">
                                  <h4>Account Details</h4>
                                </div>

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    Do you have an account with Gateway Mortgage Bank? &nbsp; &nbsp;
                                    <input class="form-check-input" name="acc_radio" type="radio" id="new_yesradio" value="yes">
                                    <label class="form-check-label" for="yesradio">Yes</label>&nbsp; &nbsp;
                                  
                                    <input class="form-check-input" name="acc_radio" type="radio" id="new_noradio" value="no" checked>
                                    <label class="form-check-label" for="noradio">No</label>
                                    
                                    <div style="display: none;" id="new_accountEntry">                                    
                                      <input placeholder="Account Number" type="text" id="new_acc_number" name="acc_number" class="form-control" style="width:300px;"> <br/>
                                    </div>

                                    <p><b>Note:</b> Kindly note that it is your responsibility to keep your Card safely and under your control. Do not reveal your
                                      Personal Identification Number (PIN). It is your Signature. GMB will not accept any liability for any fraud that may
                                      be committed on your account as a result of your failure to protect to your PIN.
                                    </p>
                                    <input class="form-check-input" name="tnc" type="checkbox" id="tnc" value="no" required="">
                                    <label class="form-check-label" for="tnc">I hereby agree to the terms and condition stated above.</label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-group mb-0 mt-0">
                                  <input name="form_botcheck" class="form-control" type="hidden" value="">
                                  
                                </div>
                              </div>
                            </div>

                            <button type="reset" style="display: none;" id="reset"></button>
                          <!-- </form> -->
                          <!-- Registration Form End-->
                        </div>
                      </div>  
                    </div>

                    <div class="alert new_error_msg" style="display: none;"></div>

                </div>
                <div class="modal-footer" id="modal_footer">                 
                  <button id="submitbtn" type="submit" class="btn btn-primary new_btn" name="submit" value="new"  data-loading-text="Please wait...">Add New</button><br>
                </div>
          </form>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div>

  <!-- Modal to Edit Teachers -->
  <div class="modal fade" id="pop_register_edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

           <form id="edit_registration_form_popup" action="forms/form_edit.php" name="editReg" class="reservation-form" method="post">
            
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                  
                  <h4 class="modal-title" id="editReplyCont">Edit Teacher: <u><small id="id_edit_username"></small></u> </h4>
                </div>

                <div class="modal-body ">

                    <div id="form_messages" style="text-align: center; display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i id="alert_fa"></i>
                        <strong style="border-bottom: 2px solid;" id="alert_header"></strong><br/>  
                        <strong id="alert_message"></strong>
                    </div>

                    <input type="hidden" name="edit_sn" id="edit_ID">                   
                    <input type="hidden" name="check_submit" value="edit">
                    <div id="form_content">
                      <div class="row">
                        <div class="col-lg-12">
                          <!-- Registration Form Start-->
                            <div class="row">
                              <div id="form_content">
                                <h4 style="padding-left: 20px;">Card Holder Details</h4>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="pickuplocation" name="pickuplocation" class="form-control" required="">
                                      <option value="">- Select Pick-Up Location -</option>
                                      <?php   

                                        $count_pickup = 0;                                      
                                        while($count_pickup != sizeof($pickup_name_db)){                                             
                                            echo '<option value="'.$pickup_name_db[$count_pickup].'">'.$pickup_name_db[$count_pickup].'</option>';
                                            $count_pickup++;
                                        } 
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="gender" name="gender" class="form-control" required="">
                                        <option value="">- Select Gender -</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">                                  
                                    <div class="form-group">
                                      <div class="styled-select">
                                        <select id="title" name="title" class="form-control" required="">
                                          <option value="">- Select Title -</option>
                                          <option value="Mr.">Mr.</option>
                                          <option value="Mrs.">Mrs.</option>
                                          <option value="Miss">Miss</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Surname" type="text" id="surname" name="surname" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="First Name" type="text" id="firstname" name="firstname" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Middle Name" type="text" id="middlename" name="middlename" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="E-mail" type="email" id="email" name="email" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Home Tel No (08012345678)" type="text" id="homenumber" name="homenumber" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Mobile No (08012345678)" type="text" id="phone" name="phone" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input id="dob" name="dob" class="form-control required date-picker" type="text" placeholder="Date Of Birth" aria-required="true">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Occupation" type="text" id="occupation" name="occupation" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="nationality" name="nationality" class="form-control" required="">
                                      <option value="">- Select Nationality -</option>
                                      <option value="Nigerian">Nigerian</option>
                                      <option value="Others">Others</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4" id="states" style="display: none;">
                                  <div class="form-group">
                                    <select id="stateoforigin" name="stateoforigin" class="form-control">
                                      <option value="">- Select State of Origin -</option>
                                      <option value="Ogun State">Ogun State<option>
                                      <?php 

                                        $result_states_edit=$conn->query($query_states);
                                        if ($result_states_edit->num_rows > 0){ 
                                          //collect rows' DB data
                                          while($each_row_states_e = mysqli_fetch_array($result_states_edit)){ 
                                              $name_db = $each_row_states_e['name'];
                                              echo '<option value="'.$name_db.'">'.$name_db.'</option>';
                                          }
                                        } 
                                      ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-12">
                                  <h4>School Details</h4>
                                </div>

                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <input placeholder="Name of School" type="text" id="schoolname" name="schoolname" required="" class="form-control">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="schoolzone" name="schoolzone" class="form-control" required="">
                                      <option value="">- Select School's Zone -</option>
                                      <option value="Ogun West - Yewa">Ogun West - Yewa</option>
                                      <option value="Ogun Central - Egba">Ogun Central - Egba</option>
                                      <option value="Ijebu-Ode">Ijebu-Ode</option>
                                      <option value="Sagamu - Remo">Sagamu - Remo</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <select id="schoollga" name="schoollga" class="form-control" required="">
                                      <option value="">- Select School's LGA -</option>
                                      <?php   
                                        $count_pickup = 0;                                      
                                        while($count_pickup != sizeof($pickup_name_db)){                                             
                                            echo '<option value="'.$pickup_name_db[$count_pickup].'">'.$pickup_name_db[$count_pickup].' LGA </option>';
                                            $count_pickup++;
                                        } 
                                      ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-sm-12">
                                  <h4>Account Details</h4>
                                </div>

                                <div class="col-sm-12">
                                  <div class="form-group">
                                    Do you have an account with Gateway Mortgage Bank? &nbsp; &nbsp;
                                    <input class="form-check-input" name="acc_radio" type="radio" id="yesradio" value="yes">
                                    <label class="form-check-label" for="yesradio">Yes</label>&nbsp; &nbsp;
                                  
                                    <input class="form-check-input" name="acc_radio" type="radio" id="noradio" value="no" checked>
                                    <label class="form-check-label" for="noradio">No</label>
                                    
                                    <div style="display: none;" id="accountEntry">                                    
                                      <input placeholder="Account Number" type="text" id="acc_number" name="acc_number" class="form-control" style="width:300px;"> <br/>
                                    </div>

                                    <p><b>Note:</b> Kindly note that it is your responsibility to keep your Card safely and under your control. Do not reveal your
                                      Personal Identification Number (PIN). It is your Signature. GMB will not accept any liability for any fraud that may
                                      be committed on your account as a result of your failure to protect to your PIN.
                                    </p>
                                    <input class="form-check-input" name="tnc" type="checkbox" id="tnc" value="no" required="">
                                    <label class="form-check-label" for="tnc">I hereby agree to the terms and condition stated above.</label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-group mb-0 mt-0">
                                  <input name="form_botcheck" class="form-control" type="hidden" value="">
                                  
                                </div>
                              </div>
                            </div>

                            <button type="reset" style="display: none;" id="reset"></button>
                            <div class="alert edit_error_msg" style="display:none;"></div>
                          <!-- </form> -->
                          <!-- Registration Form End-->
                        </div>
                      </div>  
                    </div>

                    <!-- /.row -->
                </div>
                <div class="modal-footer" id="modal_footer">              
                  <button id="edit_btn" type="submit" class="btn btn-primary edit_btn" name="submit" value="edit"   style="display: none;">Edit</button><br/>            
                </div>
          </form>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div>
  <!-- Modal to Popup the View Verification Form -->
  <div class="modal fade" id="pop_verify" tabindex="2" role="dialog" >
      <div class="modal-dialog modal-md" role="document"    >
        <div class="modal-content">  
            <form id="verify_form_popup" name="reservation_form" class="reservation-form" method="post" action="forms/form_add_pay.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="ReplyCont">Verify: <u><small id="id_set_username"></small></u> </h3>
                </div>
                <div class="modal-body clearfix">
                        <div id="form_messages" style="text-align: center; display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i id="alert_fa"></i>
                            <strong style="border-bottom: 2px solid;" id="alert_header"></strong><br/>  
                            <strong id="alert_message"></strong>
                        </div>
                       
                        <input type="hidden" name="edit_sn" id="edit_sn">                   
                        <div class="row" id="form_content_pay" style="margin-bottom: 7px; display: none;">
                            <div class="col-lg-2"></div>
                            <!-- /.col-lg-7 -->
                            <div class="col-lg-8">
                              <!-- Registration Form Start-->
                                <div class="row">
                                  <div id="form_content">
                                      <p>&nbsp;&nbsp;&nbsp;<b> <u>Payment Details</u> </b></p>
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                          <label>Slip Number</label>
                                          <input type="text" class="form-control" id="slip_number" name="slip_number" placeholder="Slip Number" required="">
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                          <label>Date Paid</label>
                                          <input type="text" id="datepicker" class="form-control datepicker" name="date_paid">
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">                                  
                                          <div class="form-group mb-30">
                                            <label>Branch Paid</label>
                                            <select name="branch_paid" class="form-control" required="">
                                              <option value="">- Select Pick-Up Location -</option>
                                              <?php   

                                                $count_pickup = 0;                                      
                                                while($count_pickup != sizeof($pickup_name_db)){                                             
                                                    echo '<option value="'.$pickup_name_db[$count_pickup].'">'.$pickup_name_db[$count_pickup].'</option>';
                                                    $count_pickup++;
                                                } 
                                              ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                          <label>Status</label>
                                          <select class="form-control" name="status">
                                            <option value="">Change status</option>
                                            <option>verified-failed</option>
                                            <option>verified-success</option>
                                            <option>unverified</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    
                                </div>

                                <button type="reset" style="display: none;" id="reset"></button>
                              <!-- </form> -->
                              <!-- Registration Form End-->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-2">
                              
                            </div>
                        </div>
                        <!-- /.row --> 
                        <div id="form_content_view" class="form_content_view view_paid">                        

                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col-lg-2">                                
                                    
                                </div>
                                <!-- /.col-lg-6 -->
                                <div class="col-lg-8">                          
                                    <div id="contentView">
                                        <b > Slip number:<span id="view_slip_number"></span> </b><br>
                                        <b > Date Paid: <span id="view_date_paid"></span></b><br>
                                        <b > Branch Paid: <span id="view_branch_paid"></span></b><br>           
                                        <b > Payment Status: <span id="view_pay_status"></span></b><br>       
                                        <b > Time Created: <span id="view_paidtime_created"></span></b><br>
                                    </div>

                                </div>
                                <!-- /.col-lg-6 -->
                                <div class="col-lg-2">
                                  
                                </div>
                            </div>
                            <!-- /.row -->
                            
                        </div>
                    <!-- /.row -->

                </div>
                <div class="modal-footer" id="modal_footer">                    
                    <!--<input type="submit" name="reg_submit" id="reg_submit" tabindex="4" class="form-control btn btn-primary" value="Submit">-->
                    <div class="col-md-12 text-center">
                        <button id="submitbtn" type="submit" name="submit" value="new" class="btn btn-primary verifyButton" data-loading-text="Please wait...">Verify</button><br>
                        <input type="hidden" name="verify_sn" value="0" id="verify_sn">
                        <!-- <button type="submit" name="submit" value="edit" id="edit_btn" class="btn btn-primary" style="display: none;">Edit</button><br/> -->
                        <!--<input type="submit" name="reg_submit" id="reg_submit" tabindex="4" class="btn btn-warning btn-sm" value="Start Your Free Trial"><br/>-->                        
                    </div>
                    
                </div>
            </form>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <!-- View teachers Deatails -->
  <div class="modal fade" id="pop_view">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                  
                  <h4 class="modal-title" id="ReplyCont_view">Viewing : <u><small id="id_view_username"></small></u> </h4>
                </div>

                <div class="modal-body ">

                    <div id="form_messages" style="text-align: center; display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>
             
                  
                    <!-- /.row -->
                    <div id="form_content_view">                        
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col-lg-2">                                
                                
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-8">                          
                                <div id="contentView">
                                    <b > Full Name:<span id="view_title"></span> <span id="view_full_name"></span></b><br>
                                    <b>  User's ID:<span id="view_id_db"></span></b><br>
                                    <b > Gender: <span id="view_gender"></span></b><br>
                                    <b > Phone No: <span id="view_phone"></span></b><br>
                                    <b > Email: <span id="view_email"></span></b><br>  
                                    <b > Occupation: <span id="view_occupation"></span></b><br>  
                                    <b > D.O.B: <span id="view_dob"></span></b><br>  
                                    <b > Home Number: <span id="view_home_number"></span></b><br>  
                                    <b > Nationality: <span id="view_nationality"></span></b><br>  
                                    <b > State of Origin: <span id="view_stateoforigin"></span></b><br> 
                                    <b > School Name: <span id="view_school_name"></span></b><br>  
                                    <b > School Zone: <span id="view_school_zone"></span></b><br>  
                                    <b > School LGA: <span id="view_school_lga"></span></b><br>   
                                    <b > Account No: <span id="view_account_no"></span></b><br>   
                                    <b > PickUp Location: <span id="view_pickup_location"></span></b><br>  
                                    <b > PickUp Status: <span id="view_pickup_status"></span></b><br>                
                                    <b > Payment Status: <span id="view_payment_status"></span></b><br>       
                                    <b > Time Created: <span id="view_time_created"></span></b><br>
                                </div>

                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-2">
                              
                            </div>
                        </div>
                        <!-- /.row -->                                                    
                    </div>
                    <!-- /.row -->

                </div>
          </form>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div>

       <!-- Modal to Popup the View pick Form -->
    <div class="modal fade" id="pick_verify" tabindex="2" role="dialog" >
      <div class="modal-dialog modal-md" role="document"    >
        <div class="modal-content">  

            <form id="pick_verify_now" name="reservation_form" class="reservation-form" method="post" action="forms/form_add_pick.php" style="display: none;">
                  <!--Div to show Loading IMGL when working-->
                  
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="ReplyCont">Pick-Up: <u><small id="id_set_username"></small></u> </h3>
                  </div>
                  <div class="modal-body clearfix">
                      <div id="form_messages" style="text-align: center; display: none;">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <i id="alert_fa"></i>
                          <strong style="border-bottom: 2px solid;" id="alert_header"></strong><br/>  
                          <strong id="alert_message"></strong>
                      </div>
                      
                      <div>     
                        <input type="hidden" name="verify_sn" id="edit_sn_pick">                   
                          <div class="row form_content_pick" id="form_content_pick" style="margin-bottom: 7px;">
                              <div class="col-lg-2"></div>
                              <!-- /.col-lg-7 -->
                              <div class="col-lg-8">
                                <!-- Registration Form Start-->
                                    <div id="form_content">
                                      <p>&nbsp;&nbsp;&nbsp;<b> <u>Pick Up Details</u> </b></p>
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                          <label>Branch Picked</label>
                                          <select id="pickuplocation" name="pickuplocation" class="form-control" required="">
                                            <option value="">- Select Pick-Up Location -</option>
                                            <?php   

                                              $count_pickup = 0;                                      
                                              while($count_pickup != sizeof($pickup_name_db)){                                             
                                                  echo '<option value="'.$pickup_name_db[$count_pickup].'">'.$pickup_name_db[$count_pickup].'</option>';
                                                  $count_pickup++;
                                              } 
                                            ?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                          <label>Date Picked</label>
                                          <input type="text" class="form-control datepicker" name="date_picked">
                                        </div>
                                      </div><!-- 
                                      <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                          <label>Status</label>
                                          <select class="form-control" name="status">
                                            <option value="">Change status</option>
                                            <option >verified-picked</option>
                                            <option >verified-not-picked</option>
                                            <option >unverified</option>
                                          </select>
                                        </div>
                                      </div> -->
                                    </div>

                                  <button type="reset" style="display: none;" id="reset"></button>
                                <!-- </form> -->
                                <!-- Registration Form End-->
                              </div>
                              <!-- /.col-lg-6 -->
                              <div class="col-lg-2">
                                
                              </div>
                          </div>
                          <!-- /.row -->      
                      </div>
                      <div id="form_content_view_pick" class="form_content_view_pick" style="display: none;">
                          <div class="row" style="margin-bottom: 7px;">
                              <div class="col-lg-2">                                
                                  
                              </div>
                              <!-- /.col-lg-6 -->
                              <div class="col-lg-8">                          
                                  <div id="contentView">
                                      <b > Date Picked: <span id="view_date_pick"></span></b><br>
                                      <b > Branch Picked From: <span id="view_branch_pick"></span></b><br>           
                                      <b > Status: <span id="view_pick_status"></span></b><br>       
                                      <b > Time Created: <span id="view_picktime_created"></span></b><br>
                                  </div>

                              </div>
                              <!-- /.col-lg-6 -->
                              <div class="col-lg-2">
                                
                              </div>
                          </div>
                          <!-- /.row -->
                          
                      </div>
                      <!-- /.row -->

                  </div>
                  <div class="modal-footer" id="modal_footer">                    
                      <!--<input type="submit" name="reg_submit" id="reg_submit" tabindex="4" class="form-control btn btn-primary" value="Submit">-->
                      <div class="col-md-12 text-center">
                          <button id="submitbtn" type="submit" name="submit" value="new" class="btn btn-primary verifyButton" data-loading-text="Please wait...">Verify</button><br><!-- 
                          <input type="hidden" name="verify_sn" value="0" id="verify_sn"> -->
                          <!-- <button type="submit" name="submit" value="edit" id="edit_btn" class="btn btn-primary" style="display: none;">Edit</button><br/> -->
                          <!--<input type="submit" name="reg_submit" id="reg_submit" tabindex="4" class="btn btn-warning btn-sm" value="Start Your Free Trial"><br/>-->                        
                      </div>
                      
                  </div>
              </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
 

  <?php
  //clear Session Variables
  $_SESSION['alert_type'] = "";
  $_SESSION['message'] = "";
  
  //Include page footer
  include_once 'includes/footer.inc.php';
  ?>

  <!-- START IN-PAGE SRIPTS -->
  <!-- <script src="../js/jquery-2.2.4.min.js"></script> -->
  <script src="../js/jquery-ui.min.js"></script>
  <script src="dist/js/table2excel.js" type="text/javascript"></script>

  <script type="text/javascript">
      function Export() {
            $("#example1").table2excel({
                filename: "teachersData.xls"
            });
      }

     function verifyPay(username, userSN) {
          $('#form_content_pay').show();
          $('.form_content_view').hide();
          $('.verifyButton').show();
          //set trash input
          $("#verify_sn").val(userSN); 
          $('.ReplyCont').text('Verify Payment : '+username);
          //alert(userSN);    
          $('#pick_verify').hide();
     }

     function viewPay(username, userSN) {
          var sn=userSN;
          $('#form_content_pay').hide();
          $('.form_content_view').show();
          $('#form_content_view').show();
          $('.view_paid').show();
          $('.verifyButton').hide();
          $('.ReplyCont').text('Payment Status : '+sn);
          $('#view_slip_number').html($('#slip_number_db'+sn).val());
          $('#view_date_paid').html($('#date_paid_db'+sn).val());
          $('#view_branch_paid').html($('#branch_paid_db'+sn).val());
          $('#view_pay_status').html($('#paid_status_db'+sn).val());
          $('#view_paidtime_created').html($('#paid_created_db'+sn).val());     
          $('#pick_verify').hide();
     }

      function verifyPick(username, userSN) {
          $('#pick_verify_now').show();
          $('.form_content_pick').show();
          $('.form_content_view_pick').hide();
          $('.verifyButton').show();
          $('.ReplyCont').text('Verify Pick Up : '+username);
          //set trash input
          $("#edit_sn_pick").val(userSN); 
          //alert(userSN);    
     }

     function viewPick(username, userSN) {
          var sn=userSN;
          $('#pick_verify_now').show();
          $('.form_content_pick').hide();
          $('.form_content_view_pick').show();
          $('.verifyButton').hide();
          $('.ReplyCont').text('Pick Up Status : '+username);
          $('#view_date_pick').html($('#date_pick_db'+sn).val());
          $('#view_branch_pick').html($('#branch_pick_db'+sn).val());
          $('#view_pick_status').html($('#pick_status_db'+sn).val());
          $('#view_picktime_created').html($('#pick_created_db'+sn).val());     
     }

      $("form[name='newReg']").submit(function(e) {
        e.preventDefault()
        $(".new_btn").html("Please wait.......");
        $('.new_error_msg').hide();
        
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'forms/form_register.php?ajax=true',
            type: "POST",
            data: formData,
            success: function (data) {
                
                if (data.includes("Your Registration is")) {
                    $(".new_btn").html('Add New');
                    $('.new_error_msg').html(data).addClass('alert-success').removeClass('alert-danger');
                    $('.new_error_msg').show();
                    window.location='teachers.php';
                }else{
                    $(".new_btn").html('Add New');
                    $('.new_error_msg').html(data).addClass('alert-danger').removeClass('alert-success');
                    $('.new_error_msg').show();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        e.preventDefault()
     });

      $("form[name='editReg']").submit(function(e) {
        e.preventDefault()
        $(".edit_btn").html("Please wait.......");
        $('.edit_error_msg').hide();
        
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'forms/form_edit.php?ajax=true',
            type: "POST",
            data: formData,
            success: function (data) {
                $('.error_msg').show();
                if (data.includes("successfull")) {
                    $(".edit_btn").html('Edit');
                    $('.edit_error_msg').show();
                    $('.edit_error_msg').html(data).addClass('alert-success').removeClass('alert-danger');

                    window.location='teachers.php';
                }else{
                    $(".edit_btn").html('Edit');
                    $('.edit_error_msg').show();
                    $('.edit_error_msg').html(data).addClass('alert-danger').removeClass('alert-success');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        e.preventDefault()
     });

     $('#add_new').click(function () {
          //$('').show();
          $('#registration_form_popup').attr('action', 'forms/form_register.php');
          $('#form_content').show();
          //$('#reg_submit').hide();
          $('#form_content_view').hide();
          $('#ReplyCont').text('New Teacher');
          $('.new_btn').show();
          $('#edit_btn').hide();
          $('#btn_type').val('new');
          //$('#reset').click();
          $('#error_msg').hide();
          $('#modal_footer').show();

      });


      function view_response(name_db, sn) {
        $('#modal_footer').hide();

        $('#form_content_view').show();

        $('#ReplyCont_view').text('Veiwing Teacher\'s Details : '+name_db);
        $('#view_full_name').html($('#fullname_db'+sn).text().trim());
        $('#view_gender').html($('#gender_db'+sn).text().trim());
        $('#view_phone').html($('#phone_db'+sn).text().trim());
        $('#view_email').html($('#email_db'+sn).text().trim());
        $('#view_id_db').html($('#id_db'+sn).text().trim());

        $('#view_pickup_location').html($('#pickup_location_db'+sn).text().trim());
        $('#view_pickup_status').html($('#pickup_status_db'+sn).html());
        $('#view_payment_status').html($('#payment_status_db'+sn).html());
        $('#view_time_created').html($('#time_created_db'+sn).text().trim());

        $('#view_occupation').html($('#occupation_db'+sn).val());
        $('#view_title').html($('#title_db'+sn).val());
        $('#view_home_number').html($('#homenumber_db'+sn).val());
        $('#view_dob').html($('#dob_db'+sn).val());
        $('#view_nationality').html($('#nationality_db'+sn).val());
        $('#view_school_name').html($('#schoolname_db'+sn).val());
        $('#view_school_zone').html($('#schoolzone_db'+sn).val());
        $('#view_school_lga').html($('#schoollga_db'+sn).val());
        $('#view_account_no').html($('#acc_number_db'+sn).val());
      }

       function ignore_contact(userID, userSN){
            var trash_me = confirm("Are sure you want to Trash this details, this process is irreversible?");            
            if (trash_me == true) {
                 // Get and process the form     
                var form = $('#id_account_trash_form');

                form.serialize();
                    
                //set trash input
                $("#id_trash_account").val(userSN); 
                //alert(userSN);
                
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var formData = {
                    'trash_submit' : "Trash User contact",
                    'trash_id' : userSN            
                };
                
                // process the form
                $.ajax({
                    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url         : $(form).attr('action'), // the url where we want to POST
                    data        : formData, // our data object
                    dataType    : 'json', // what type of data do we expect back from the server
                    encode      : true
                })
                
                //using the done promise callback
                .done(function(data) { 
                    if (data.status == "success") {    
                        var status_html = `
                            <label class="label label-danger" style="font-size: 0.9em;" id="id_status`+userSN+`" >
                                TRASHED
                            </label> 
                        `;

                        //change displayed status to trashed
                        $('#id_status_trash'+userSN).html(status_html);
                        $('#action_'+userSN).html('');
                        alert("Trash Action Completed Successfully!"+data.message);

                        $('.verify_but'+userSN).hide();
                        $('.replace_pick'+userSN).show();
                    }else{
                        alert("Trash Error, Please try again Later.");
                    }
                })

                // using the fail promise callback
                .fail(function(data) {
                    alert("Trash Error Data, Please try again Later.");                    
                });                
            }           
        }


        function edit_options(name_db, sn){
            //alert( $('#name_db'+sn).text().trim() );
             //Preview Data
            //$('#registration_form_popup').hide();
            //$('#edit_registration_form_popup').show();
            $('.edit_error_msg').hide();
            $("#edit_ID").val(sn);
            $('#edit_btn').show();

            $('#form_content').show();
            $('#form_messages').hide();
            $('#reg_submit').show();
            $('#form_content_view').hide();
            $('#pickuplocation').val($('#pickup_location_db'+sn).text().trim());
            $('#email').val($('#email_db'+sn).text().trim());
            $('#pickup_status').val($('#pickup_status_db'+sn).html());
            $('#payment_status').val($('#payment_status_db'+sn).html());
            $('#surname').val($('#username_db'+sn).val());
            $('#middlename').val($('#middlename_db'+sn).val());
            $('#firstname').val($('#firstname_db'+sn).val());
            $('#phone').val($('#phone_db'+sn).text().trim());
            $('#occupation').val($('#occupation_db'+sn).val());
            $('#title').val($('#title_db'+sn).val());
            $('#homenumber').val($('#homenumber_db'+sn).val());
            $('#dob').val($('#dob_db'+sn).val());
            $('#nationality').val($('#nationality_db'+sn).val());
            $('#stateoforigin').val($('#state_db'+sn).val());
            $('#schoolname').val($('#schoolname_db'+sn).val());
            $('#schoolzone').val($('#schoolzone_db'+sn).val());
            $('#schoollga').val($('#schoollga_db'+sn).val());
            $('#acc_number').val($('#acc_number_db'+sn).val());
            $('#gender').val($('#gender_db'+sn).text().trim());

            if($('#acc_number_db'+sn).val()!=''){
                $('#yesradio').click();

            }else{
                $('#noradio').click();
            }

            if($('#nationality_db'+sn).val()=='Nigerian'){
              $('#states').show();
            }else{
              $('#states').hide();
            }
            $('#modal_footer').show();
        
            $('#editReplyCont').text('Edit Teacher\'s details: '+name_db);
            //set inputs appropriately
            $('#id_to').val(name_db);
            $('#id_from').val('<?php echo $_SESSION['logDin_admin'] ?>');
            $('#contactSN').val(sn);
            //$('#id_set_username').text(name_db);

           
        }
  </script>

  <script type="text/javascript">
      $(document).ready(function(){
        //$("#myModal").modal('show');

        //JQuery Script to hide/show account entry field
        $('#yesradio').on('click',function(){
          $('#accountEntry').show();
        }); 
        
        $('#noradio').on('click',function(){
          $('#accountEntry').hide();
        }); 

        //JQuery Script to hide/show account entry field
        $('#new_yesradio').on('click',function(){
          $('#new_accountEntry').show();
        }); 
        
        $('#new_noradio').on('click',function(){
          $('#new_accountEntry').hide();
        }); 


        $("#nationality").change(function(){          
          if($(this).val() == "Nigerian"){
            $('#states').show();
          }else{
            $('#states').hide();
          }
        });

          $("#new_nationality").change(function(){          
          if($(this).val() == "Nigerian"){
            $('#new_states').show();
          }else{
            $('#new_states').hide();
          }
        });
    });
  </script>


  <script type="text/javascript">
    $(document).ready(function () {
        var today = new Date();
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            autoclose:true,
            endDate: "today",
            maxDate: today
        }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
        });


        /*$('.datepicker').keyup(function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9^-]/g, '');
            }
        });*/
    });
  </script>
  <!-- END IN-PAGE SRIPTS -->

</body>
</html>
