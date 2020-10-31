
  <?php

               

                 $pay = $row["payment_status"];
                 $residential = $row["residential"];
                 
                    // output data of each row
                    if($pay == "unverified" ) {
                      echo '<a href="cardpay.php" style="text-decoration:none;"><div class="unverifed" align="center">Your Account is not yet verified. Please click here to make payment</div></a>';
                    }
                   else {
                   	if($residential == NULL ) {
                      echo '<a href="residential.php" style="text-decoration:none;"><div class="unverifed" align="center">Please click here to fill in your Residential Address</div></a>';
                    }
                   else {
                    
                  }
                    
                  }
 ?>