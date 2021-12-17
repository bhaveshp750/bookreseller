<?php 

    include_once("session.php");
    include_once("component.php"); 
    include_once("CreateDb2.php"); 

    //create instance of CreateDb class
    $db = new CreateDb("book_reseller","book_details");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- bootstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>
<body>
<?php include_once('header.php')?>
<div class="container-fludi pl-5 pr-5">
    <h5 class='pt-4 pl-8'>My Orders</h5>
    <hr>
    <?php
    
                    $sql = "SELECT b.book_name, od.book_id, o.* from orders o, order_details od, book_details b where o.order_id = od.order_id and od.book_id=b.id and od.book_id in (SELECT id from book_details where username = '$login_session')";         
                    $result = mysqli_query($db->con,$sql);
                    $count = mysqli_num_rows($result);
                    if($count){
                        echo"<table class=\"table table-striped\">
                                    <thead>
                                        <tr class='table-info'>
                                            <th scope='col'>Order ID</th>
                                            <th scope='col'>Book Names</th>
                                            <th scope='col'>Order Date</th>
                                            <th scope='col'>Client Name</th>
                                            <th scope='col'>Client Email</th>
                                            <th scope='col'>Shipping Address</th>
                                            <th scope='col'>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        while($row = mysqli_fetch_assoc($result)){
                            
                            $product_name = $row['book_name'];
                            $date=substr($row['timestamp'],0,10);
                            $arr = array($row['billing_house'],$row['billing_area'],$row['billing_landmark'],$row['billing_city'],$row['billing_pincode']);
                            $address = implode(", ",$arr);
                            $order_id = $row['order_id'];
                            
                            $output = "
                            <tr>
                                <th scope='row'>$order_id</th>
                                <th><button type='button' id='btnid' value='$product_name' onclick='showBook(this.value)' name='btnname' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter' style='padding: 0; color:black; border: none; background: none;'><b>$product_name</b></button></th>
                                <td>".$date."</td>
                                <td>".$row['billing_name']."</td>
                                <td>".$row['billing_email']."</td>
                                <td>".$address."</td>   
                                <td>".$row['order_status']."</td>
                            </tr>";
                            echo $output;
                        }
                    }else{
                        echo"
                        <div class='text-center'>        
                            <img src='empty_cart.png' style='width:20%;height:20%'class='card-img' alt='...'>
                            <h5 class=''>There are no orders yet!</h5>
                            <button type='button' onclick=\"location.href='book_cart.php'\" name='book_cart' class='btn btn-primary mx-3'>Shop now</button>
                        </div>";
                    }
            if($count)echo"</tbody>
        </table>"
        ?>
       <!-- Modal -->
       <div class='modal fade' id='exampleModalCenter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLongTitle'></h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div id='txtHint'>

                        <div class='d-flex justify-content-center'>  
                            <div class='spinner-border' role='status'>    
                                <span class='sr-only'>Loading...</span>  
                            </div>
                        </div>

                    </div>
                    <div class='modal-footer'>
                        <button type='button ' class='btn btn-primary' data-dismiss='modal'>Close</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>


</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>


<script>

function myFunction(params) {
    document.getElementById(params).click();
}

function showBook(val) {
  var xhttp;    
  if (val == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
      document.getElementById("exampleModalLongTitle").innerHTML = "Ordered Book : "+val;
    }
  };
  xhttp.open("GET", "ajax_client.php?q="+val, true);
  xhttp.send();
}
</script>