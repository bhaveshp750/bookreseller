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
    <title>Complete Order</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- boorstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>
<body>
<?php include_once('header.php')?>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-lg-8 px-4 pb-4">
        <div id='txtHint'>
            <?php
                $allItems = '';
                $grand_total = 0;
                $items = array();
                $book_seller = array();
                if(isset($_SESSION['cart']) && count($_SESSION['cart'])){
                    $product_id = array_column($_SESSION['cart'],'product_id');
                    
                    $sql = "SELECT id,book_name,book_price,username from book_details";
                    $result = mysqli_query($db->con,$sql);
                    while($row = mysqli_fetch_assoc($result)){
                         
                        foreach($product_id as $id) {
                            if($row['id'] == $id){
                                $grand_total += $row['book_price'];
                                $items[] = $row['book_name'];
                                $book_seller[] = $row['username'];
                            }
                        }
                    }
                    
                    $Items = implode(', ',$items);
                    $allItems = strval($Items);
                    $all_book_seller = implode(', ',$book_seller);
                    $all_book_seller = strval($all_book_seller);
                    $allItems =  $allItems.' == '.$all_book_seller;

                }else{
                    echo "<script>window.location = 'cart.php' </script>";
                }
            ?>
            <h4 class="text-center text-info p-2">Complete your order </h4>
            <div class="jumbotron p-3 mb-2 text-center"> 
                <h6 class="lead"><b>Product(s) : </b><?= $Items; ?>
                <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                <h5><b>Total Amount Payable : </b><?= number_format($grand_total,2) ?></h5>
            </div> 
            <form action="order_success.php" method="post">
                <input type="hidden" name='products' id='products' value='<?php echo $allItems ?>' >
                <input type="hidden" name='grand_total' id='grand_total' value='<?php echo $grand_total ?>' >
                
                <div class="form-group"> <input type="text" id='name' name='name' id='bname' class='form-control' placeholder='Enter Name' required> </div>
                <div class="form-group"> <input type="email" id='email' name='email' class='form-control' placeholder='Enter E-mail' required> </div>
                <div class="form-group"> <input type="tel" id='phone' name='phone' maxlength="10" class='form-control' placeholder='Enter Phone' required> </div>
                <hr>
                <h6 class="text-center lead">Address</h6>
                <div class="form-group"> <input id="house" name="house" placeholder='Flat, House no., Building, Company, Apartment'  class="form-control" required> </div>
                <div class="form-group"> <input id="area" name="area" placeholder='Area, Colony, Street, Sector, Village'  class="form-control" required> </div>
                <div class="form-group"> <input id="landmark" name="landmark" placeholder='Enter Landmark'  class="form-control"> </div>
                <div class="form-group"> <input id="city" name="city" placeholder='Enter Town/City'  class="form-control" required> </div>
                <div class="form-group"> <input id="pincode" name="pincode" placeholder='Enter Pincode'  class="form-control" required> </div>
                <input type="hidden" name='all_book_seller' id='all_book_seller' value='<?php echo $all_book_seller ?>' >
                <hr>
                <h6 class="text-center lead">Selecl Payment Mode</h6>
                <div class="form-group"> 
                        <select name="pmode" id='pmode' class='form-control'>
                        <option selected disabled value="">--Select Payment Mode--</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="Net Banking">Net Banking</option>
                        <option value="Debit/Credit Card">Debit/Credit Card</option>
                    </select> 
                </div>
                <div class="form-gorup">
                    <input type="submit"  name='PlaceOrder'  id='submitorder' value='Place Order' class="btn btn-danger btn-block">
                </div>
            </form>
       </div>
       </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

