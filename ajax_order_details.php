<?php

include_once('session.php');

$con = mysqli_connect("localhost", "root", "", "book_reseller");


if(isset($_GET['q'])){

    $order_id = $_GET['q'];
    $sql = "SELECT b.book_image,b.book_name,b.book_author,b.book_price,b.book_description,b.book_condition,b.book_category,b.book_language,b.book_purchase_date,b.id,b.username from book_details b, order_details od, orders o where  od.book_id=b.id and od.order_id=o.order_id and o.order_id = ?";
    $stmt= $con->prepare($sql);
    $stmt->bind_param("s",$order_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($productimg, $productname, $productauthor, $productprice, $description, $condition, $category, $language, $date,$productid,$book_owner);
    

    $count = 1;
    while ($stmt->fetch()) {
        if($count != 1)echo"<hr>";else $count+=1;
    $output = "
        <div class='modal-body'>
            <div class='row bg-white' style='max-width:480px; margin-left:0px'>
                <div class='col-md-3'>
                    <img src='$productimg' style='' alt='Image1' class='img-fluid'>
                </div>
                <div class='col-md-4'>
                    <span style='float:left'> <h5 class='pt-2'>$productname</h5> <span>
                    <h6>$productauthor</h6>
                    <h5>₹ $productprice</h5>
                </div>
                <div class='col-md-5 pt-2'>
                    <p style='text-align:left;'>
                        <small>
                            Book: $category <br>
                            Language: $language  <br>
                            Book Condition: $condition <br>
                            Purchase Date: $date <br>
                        </small>
                    </p>
                </div>
            </div>
            <div class='row pl-4'>
                <div>
                    <p style='text-align:left;'><small>$description <br> 
                    </small><small class='text-secondary'>Seller : <b> $book_owner </b></small></p>
                    
                </div>
            </div>
            
        </div>
    ";
    
    echo $output; 
    }
    $stmt->close();
}



?>