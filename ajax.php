<?php

include_once('session.php');

$con = mysqli_connect("localhost", "root", "", "book_reseller");


if(isset($_GET['id'])){

    $sql = "SELECT book_image, book_name, book_author, username, book_price, book_description, book_condition, book_category, book_language, book_purchase_date, id
    FROM book_details WHERE id = ?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($productimg, $productname, $productauthor, $user, $productprice, $description, $condition, $category, $language, $date,$productid);
    $stmt->fetch();
    $stmt->close();

    if($login_session == $user)  $disabled = "title='This is your book.' disabled";
        else $disabled = '';
    
    $output = "
            <div class='row bg-white' style='max-width:790px; margin-left:0px'>
                <div class='col-md-3'>
                    <img src=$productimg alt='Image1' class='img-fluid'>
                </div>
                <div class='col-md-3'>
                    <h5 class='text-left pt-2'>$productname</h5>
                    <h6 class='text-left'>$productauthor</h6>
                    <h5 class='text-left'>₹ $productprice</h5>
                    <p style='text-align:left;'>
                        <small>
                            Book: $category <br>
                            Language: $language  <br>
                            Book Condition: $condition <br>
                            Purchase Date: $date <br>
                        </small>
                    </p>
                </div>
                <div class='col-md-6'>
                    <div>
                        <p style='text-align:left;'>$description</p>
                    </div>
                </div> 
                    <p class='pl-5'><small class='text-secondary' >Seller: $user</small></p>
                </div>
                </div>
                <div class='modal-footer'>
                    <button type='submit' onclick='myFunction($productid);' $disabled class='btn btn-primary' name='add'>Add to Cart <i class='fas fa-shopping-cart'></i></button>
                    <input type='hidden' name='product_id' value='$productid'>
                </div>
            </div>
                ";
 
    echo $output; 
}

?>
