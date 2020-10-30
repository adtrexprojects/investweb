<?php session_start();

 include_once('includes/dbConnection.php');
if (isset($_POST["paybill"])) {

$err_pay = "";

if (isset($_POST['email']) && !empty($_POST['email'])){
  $email = cleanse($_POST['email'], $conn);
}else{
  $err_mail = " Please Enter Your Email Address<br/>";
}
if (isset($_POST['bill']) && !empty($_POST['bill'])){
  $bill = $_SESSION['bill'];
}else{
  $err_bill = "Please Enter Your bill";
}
if($err_mail != "" || $err_bill != "" ){
        //echo $err_pay; 
        $_SESSION["err_mail"] = $err_mail;
        $_SESSION["err_bill"] = $err_bill;
        header('Location: cardpay.php');             
  }else{


$refno = md5(time());
$mode = 'online';
$status = 'verified-success';
$result = mysqli_query($conn, "SELECT * FROM user_data WHERE email='$email'");
$row = $result->fetch_assoc();
$user_id = $row["user_id"];

//add to pending table
mysqli_query($conn, "
INSERT INTO `pending_payment`(`sn`, `user_id`, `email`, `bill`, `ref_no`, `mode`, `time_created`) VALUES 
(NULL, '".$user_id."', '".$email."', '".$bill."', '".$refno."', '".$mode."', CURRENT_TIMESTAMP)          
");



$_SESSION["bill"] = $bill;







        






			

//Bill payment process


$curl = curl_init();

$customer_email = $email;
$amount = $bill;  
$currency = "NGN";
$txref = $refno ; // ensure you generate unique references per transaction.
$PBFPubKey = "FLWPUBK_TEST-acc8d53c906e57038f6c0172ba863f9f-X"; // get your public key from the dashboard.
$redirect_url = "http://orangecard.ng/login/verifypayment.php";


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'customer_email'=>$customer_email,
    'currency'=>$currency,
    'txref'=>$txref,
    'PBFPubKey'=>$PBFPubKey,
    'redirect_url'=>$redirect_url,
  ]),
  CURLOPT_HTTPHEADER => [
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the rave API
  die('Curl returned error: ' . $err);
}

$transaction = json_decode($response);

if(!$transaction->data && !$transaction->data->link){
  // there was an error from the API
  print_r('API returned error: ' . $transaction->message);
}

// uncomment out this line if you want to redirect the user to the payment page
//print_r($transaction->data->message);


// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $transaction->data->link);


}
}


ini_set('max_execution_time', 300);
set_time_limit(300);


function cleanse($field,$conn) {//To protect against sql Injection
    $result = trim($field);
    $result = stripslashes($result);
    $result = mysqli_real_escape_string($conn, $result); //for prevention of mySQL injection

    return $result;
}
?>