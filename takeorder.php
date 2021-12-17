<?php 

require_once("session.php");

$con = mysqli_connect("localhost", "root", "", "book_reseller");

$name = $_POST['firstname'];
$email = $_POST['lastname'];
$house = $_POST['house'];
$area = $_POST['area'];
$landmark = $_POST['landmark'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$phone = $_POST['phone'];
$products = $_POST['products'];
$grand_total = $_POST['grand_total'];
$pmode = $_POST['pmode'];
$order_status = "Order Placed";
$allItems = explode(" == ",$products);

for($i=0;$i<sizeof($allItems)-1;$i++) {
    $products = $allItems[$i];
    $book_seller = $allItems[$i+1];
}



$stmt = $con->prepare("INSERT into orders (buyer_username,billing_name,billing_email,billing_phone,billing_house,billing_area,billing_landmark,billing_city,billing_pincode,total_amount,pmode,order_status,products_name) values (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssssssss",$login_session,$name,$email,$phone,$house,$area,$landmark,$city,$pincode,$grand_total,$pmode,$order_status,$products);
$stmt->execute();
$stmt->store_result();
$stmt->close();

# retrive order id
$stmt1 = $con->prepare("SELECT max(order_id) from (SELECT order_id FROM orders where buyer_username= ?) as n");
$stmt1->bind_param("s",$login_session);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($order_id);
$stmt1->fetch();
$stmt1->close();



$product_id = array_column($_SESSION['cart'],'product_id');
$book_seller = explode(', ',$book_seller);
$limit = sizeof($product_id);

for($i=0; $i<$limit; $i++) {
    $id = $product_id[$i];
    $seller = $book_seller[$i];
    # store order sub details
    $stmt2 = $con->prepare("INSERT into order_details(order_id,book_id,book_seller) values (?,?,?)");
    $stmt2->bind_param("sss",$order_id,$id,$seller);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->close();

    # update sold
    $stmt3 = $con->prepare("UPDATE `book_details` set `stock`='Sold' where `id` = ?");
    $stmt3->bind_param("s",$id);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->close();
}

//empty cart
unset($_SESSION['cart']);

if($order_id){

    $data = "
    <div class='text-center'>
        <h1 class='display-4 mt-2 text-danger'>Thank You</h1>
        <h2 class='text-success'>Your Order Placed Successfully!</h2>
        <h3 class='text-success'>Order ID : ". $order_id ."</h3>
        <h4 class='bg-danger text-light rounded p-2'>Items Puchased : ". $products ."</h4>
        <h4>Your Name : ". $name ."</h4>
        <h4>Your E-mail : ". $email ."</h4>
        <h4>Your Phone : ". $phone ."</h4>
        <h4>Total Amount : ". number_format($grand_total,2) ."</h4>
        <h4>Payment Mode : ". $pmode ."</h4>
    </div>
    ";
    echo $data;
}
else 
    echo "Something went wrong. Please try later.";

?>