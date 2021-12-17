<?php

include_once('session.php');

$con = mysqli_connect("localhost", "root", "", "book_reseller");


if(isset($_GET['q'])){

    $order_id = $_GET['q'];
    $sql = "SELECT products_name, buyer_username, billing_name, billing_email, billing_phone, billing_house, billing_area, billing_landmark, billing_city, billing_pincode, pmode, order_status, o.timestamp from orders o where order_id = ?";
    $stmt= $con->prepare($sql);
    $stmt->bind_param("s",$order_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($products, $username, $name, $email, $phone, $house, $area, $landmark, $city, $pincode,$pmode,$order_status,$timestamp);
    
    
    $count = 1;
    while ($stmt->fetch()) {
        if($count != 1)echo"<hr>";else $count+=1;
    $output = "
        <div class='modal-body'>
            <div class='row bg-white' style=' margin-left:0px'>
                <div class='col-md-7'>
                    
                    <h6 class='text'>Username: <b>$username</b></h6>
                    <hr>
                    <h6 class='text'>Products: <b>$products</b></h6>
                    <h6 class='text'>Name: <b>$name</b></h6>
                    <h6 class='text'>E-mail: <b>$email</b></h6>
                    <h6 class='text'>Phone No: <b>$phone</b></h6>
                    <h6 class='text'>Payment Mode: <b>$pmode</b></h6>
                    <h6 class='text'>Order Time: <b>$timestamp</b></h6>

                </div>
                <div class='col-md-5'>
                    
                        <h6><b>Delivery Address</b> <br></h6>
                        <hr>
                           <h6> House No: <b> $house</b> <br></h6>
                           <h6> Area:<b> $area </b> <br></h6>
                           <h6> Landmark: <b>$landmark</b> <br></h6>
                           <h6> City: <b>$city</b> <br></h6>
                        <h6 class='text'>    Pincode: <b> $pincode</b> <br> </h6>
                    <div>
                        
                        
                    </div>
                </div>
            </div>
                
            
        </div>
    ";
    
    echo $output; 
    }
    $stmt->close();
}



?>