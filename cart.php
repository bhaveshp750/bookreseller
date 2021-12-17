<?php

require_once("session.php");
require_once("CreateDb2.php");
require_once("component.php");

$db = new CreateDB("book_reseller","book_details");

if(isset($_POST['Remove'])){
    if($_GET['action'] == 'remove'){
        
           foreach($_SESSION['cart'] as $key => $value){
               if($value['product_id'] == $_GET['id']){
                   unset($_SESSION['cart'][$key]);
                   echo "<script>alert('Product has been Removed.')</script>";
                   echo "<script>window.location = 'cart.php' </script>";
               }
           }
       }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

     <!-- Font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- bootstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>
<body class=bg-light>
    
    <?php include_once('header.php'); ?>

    <div class="container-fluif">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h6>My Cart</h6>
                    <hr>

                    <?php
                    
                       $total = 0;
                       $count = 0;
                       
                        if(isset($_SESSION['cart']) && count($_SESSION['cart'])){
                            $product_id = array_column($_SESSION['cart'],'product_id');
                            
                            $result = $db->getData();
                            while($row = mysqli_fetch_assoc($result)){
                                foreach($product_id as $id) {
                                    if($row['id'] == $id){                                                                                                                                                                                      
                                        cartElement($row['book_image'], $row['book_name'], $row['book_price'], $row['id'],$row['book_description'],$row['book_author'],$row['username'],$row['book_category'],$row['book_language'],$row['book_condition'],$row['book_purchase_date'],$row['stock']);
                                        $total = $total + (int)$row['book_price'];
                                    }
                                }
                            }
                        }else{
                            $output = "
                                <div class='text-center'>
                                    
                                    
                                    <img src='empty_cart.png' style='width:40%;height:40%'class='card-img' alt='...'>
                                    <h5 class=''>Cart is empty "."</h5>
                                    <p><small>Add items to cart.</small></p>
                                    <button type='button' onclick=\"location.href='book_cart.php'\" name='book_cart' class='btn btn-primary mx-3'>Shop now</button>
                                    
                                </div>";
                            echo $output;
                        }
                        
                    ?>
                    
                </div>
            </div>

            <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">

                <div class="pt-4">
                    <h6>PRICE DETAILS</h6>
                    <hr>
                    <div class="row price-details">
                        <div class="col-md-6">
                            <?php
                                
                                if(isset($_SESSION['cart'])){
                                    $count = count($_SESSION['cart']);
                                    echo "<h6>Price ($count items)</h6>";

                                }else{
                                    echo "<h6>Price (0 items)</h6>";    
                                }
                                $disabled = $count > 0 ? "" : "disabled title='Cart is Empty!'";
                            ?>
                            <h6>Delivery Charges</h6>
                            <hr>
                            <h6>Amount Payable</h6>
                        </div>
                        <div class="col-md-6">
                            <h6>Rs. <?php echo $total ?></h6>
                            <h6 class="text-success">FREE</h6>
                            <hr>
                            <h6>Rs. <?php 
                                echo $total
                            ?></h6>
                        </div>
                    </div>
                   
                </div>
                <div class="col py-3">
                    <button type='submit' onclick="location.href = 'order.php'" style="" class='btn btn-primary btn-block' <?php echo $disabled; ?>>Check out</button>
                    <input type='hidden' name='product_id' value='$productid'>
                </div>
            </div>
            
            
        </div>
    
    </div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>