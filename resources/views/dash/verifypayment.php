<?php session_start();


include_once('includes/dbConnection.php');

$bill = $_SESSION["bill"];






 if (isset($_GET['txref'])) {
        $ref = $_GET['txref'];
        $amount = $bill; //Correct Amount from Server
        $currency = "NGN"; //Correct Currency from Server
        

        $query = array(
            "SECKEY" => "FLWSECK_TEST-4156b01330d24e52ee3a6504d22a6e54-X",
            "txref" => $ref
        );

        

        $data_string = json_encode($query);
                
        $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        $resp = json_decode($response, true);

        $paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
            //get ref number
        
        //fetch data from table
        $result = mysqli_query($conn, "SELECT * FROM pending_payment WHERE ref_no='$ref'");
        $row = $result->fetch_assoc();
        $user_id = $row["user_id"];
        $email_pay = $row["email"];
        $ref_no = $row["ref_no"];
        $mode = $row["mode"];
        $status='verified-success';

           
            
            //update payment status
            mysqli_query($conn, "UPDATE user_data SET payment_status='verified-success' WHERE email='$email_pay'");
            
            //insert data to table    
            mysqli_query($conn, "
            INSERT INTO `payment`(`sn`, `user_id`, `slip_number`, `date_paid`, `branch_paid`, `status`, `time_modified`, `time_created`) VALUES 
                (NULL, '".$user_id."', '".$ref."', CURRENT_TIMESTAMP, '".$mode."', '".$status."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)          
            ");

            $_SESSION["success"] = '<span class="alert alert-success">'."Payment Successful".'</span>';
            $_SESSION['logDin_user_email'] = $email_pay;
            
            //delete from pending table
            mysqli_query($conn,"DELETE FROM pending_payment WHERE ref_no='$ref_no'" );

            header('Location: http://orangecard.ng/login/cardpay.php');
        

        } else {
            $result = mysqli_query($conn, "SELECT * FROM pending_payment WHERE ref_no='$ref'");
        $row = $result->fetch_assoc();
        $email_pay = $row["email"];
        $_SESSION['logDin_user_email'] = $email_pay;
           $_SESSION["error"] = '

           <span class="alert alert-warning">'."Payment Failed.".'</span>
           ';
            mysqli_query($conn,"DELETE FROM pending_payment WHERE ref_no='$ref'" );
            header('Location: cardpay.php');
        }
    }

?>