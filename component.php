<?php


    function component($productname,$productprice,$productimg,$description,$productid,$productauthor,$sessionuser,$condition,$category,$language,$date,$user){
        $doubleprice = $productprice * 2;
        if($sessionuser == $user)  $disabled = "title='This is your book.' disabled";
        else $disabled = '';
        $element = "
        
        <div class='col-md-3 col-sm-6 my-3 my-md-0'>
        <form action='book_cart.php' method='post'>
            <div class='card shadow'>
                <div>
                    <img src= '$productimg' alt='Book1' class='img-fluid card-img-top'>
                </div>
                <div class='card-body'>

                    <button type='button' id='btnid' value='$productid' onclick='showBookDetails(this.value)' name='btnname' class='btn' data-toggle='modal' data-target='#exampleModal' style='padding: 0; color:black; border: none; background: none;'><b>$productname</b></button>
                    <p> $productauthor </p>
                    <h6>
                        <small><s class='text-secondary'>₹ $doubleprice</s></small>
                        <span class='price'>₹ $productprice</span>
                    </h6>
                    <button type='submit' id='$productid' class='btn btn-warning my-3 btn' $disabled name='add'>Add to Cart <i class='fas fa-shopping-cart'></i></button>
                    <input type='hidden' name='product_id' value='$productid'>

                </div>
            </div>
        </form>
    </div>
    ";
    echo $element;
    }


    function admin_books($productname,$productprice,$productimg,$description,$productid,$productauthor,$user,$condition,$category,$language,$date,$stock){
        if($stock == 'Available'){
            $stock = "<font color='green'><b>$stock</b></font>";
            $output = "<tr>";
        }else{ 
            $stock = "<font color='red'><b>$stock</b></font>";
            $output = "<tr class=\"table-danger\">";
        }
        
        $output .= "
            
                <td><button type='button' id='btnid' value='$productid' onclick='showBookDetails(this.value)' name='btnname' class='btn' data-toggle='modal' data-target='#exampleModal' style='padding: 0; color:black; border: none; background: none;'><b>$productid</b></button></td>
                <td><img style='width:60px;height:80px' src='$productimg' alt='Book1' class='img-fluid card-img-top'> </td>
                <td style='width:50px'>$productname</td>
                <td style='width:50px'>$productauthor</td>
                <td>$productprice</td>
                <td>$condition</td>
                <td>$category</td>
                <td>$language</td>
                <td>$date</td>
                <td>$user</td>
                <td>$stock</td>
            </tr>
            <input type='hidden' name='product_id' value='$productid'>";
            
        echo $output;
    }


    function cartElement($productimg,$productname,$productprice, $productid,$description, $productauthor,$book_owner,$category,$language,$condition,$date,$stock){
        $element = "
        <form action='cart.php?action=remove&id=$productid' method='post' class='cart=items'>
                        <div class='border rounded'>
                            <div class='row bg-white'>
                                <div class='col-md-3 pl-0'>
                                    <img src=$productimg alt='Image1' class='img-fluid'>
                                </div>
                                <div class='col-md-5'>
                                    <h5 class='pt-2'>$productname</h5>
                                    <small class='text-secondary'>Seller : <b> $book_owner </b></small>
                                    <h5 class='pt-2'>₹ $productprice</h5>
                                    <div class='card-text py-1'>
                                        <p class='text-justify'> Author - <b>$productauthor</b> <br>
                                            $description
                                        </p>
                                    </div>
                                </div>
                                <div class='col-md-4 py-3'>
                                
                                <p style='text-align:left' class='pl-2'> 
                                    Book: <small><b> $category </small></b> <br>                             
                                    Language: <small><b>$language </small></b><br>
                                    Book Condition:<small><b> $condition </small></b> <br>  
                                    Purchase Date: <small><b>$date </small></b> <br>
                                    Book Status: <small><b>$stock</b> </small>                             
                                </p> 
                                <button type='' title='Working of it.!' class='btn btn-warning btn-sm' disabled>Save for Later</button> 
                                <button type='submit' class='btn btn-danger mx-2 btn-sm' name='Remove'>Remove</button>  
                                
                                </div>
                            </div>
                        </div>
                    </form>
        ";
        echo $element;
    }


    function myBooks($productimg,$productname,$productprice, $productid,$description, $productauthor, $category, $language, $condition, $date,$stock,$username,$login_session){
            if($login_session == $username){
                if($stock == 'Available'){
                    $stock = "<font color='green'><b>$stock</b></font>";
                    $edit_btn = "<button type='submit' name='edit_book' class='btn btn-warning mx-3'>Edit Book</button>";
                    $delete_btn ="<button class='btn btn-danger mx-2 remove' id='$productid'>Delete book</button>";// "<button   id='$productid'  name='delete_book' class='btn btn-danger mx-2 remove'>Delete Book</button>";
                }
                else {
                    $stock = "<font color='red'><b>$stock</b></font>";
                    $edit_btn = "<button type='button' name='edit_book' class='btn btn-warning mx-3' disabled>Edit Book</button>";
                    
                    $delete_btn = "<button type='button' name='delete_book' class='btn btn-danger mx-2' disabled>Delete Book</button>";
                }

                $element = "
                
                <div class='col-md-6 col-sm-6 my-3 my-md-0'>
                    <form action='edit_book.php' method='post'>
                        <div class='card shadow'>
                            <div class='card mb-6' style='max-width: 540px;'>
                                <div class='row no-gutters'>
                                    <div class='col-md-4'>
                                        <img src=$productimg class='card-img' alt='...'>
                                    </div>
                                    <div class='col-md-8'>
                                        <div class='card border-white pt-3'>
                                            <h5 class=''>$productname</h5>
                                            <h6 >$productauthor</h6>
                                            <h5>₹ $productprice </h5>
                                            <p style='text-align:left' class='pl-2'> 
                                                <small>
                                                        Book: $category <br>                             
                                                        Language: $language  <span style='float:right'>$edit_btn</span><br>
                                                        Book Condition: $condition<br>  
                                                        Purchase Date: $date <span style='float:right'>$delete_btn</span><br>
                                                        Book Status: $stock 
                                                        <input type='hidden' name='product_id' value='$productid'>
                                                </small>
                                            </p>              
                                        </div>
                                    </div>
                                    <div class='col-sm-12 pl-3'>
                                        <p style='text-align:left;'>
                                            <small>
                                                Description: $description
                                            </small>
                                        </p>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                ";

                echo $element;
        }
    }


?>