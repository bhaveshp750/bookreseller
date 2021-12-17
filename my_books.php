
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
    <title>My Books</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- bootstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

    

</head>
<body>
<?php include_once('header.php')?>
<div class="container">
<h5 class='pt-3'>My Books</h5>
    <hr>
    <div class="row text-center py-3">
        <?php
            $sql = "SELECT * from book_details where username='$login_session'";
            
            $result = mysqli_query($db->con,$sql);
            if(mysqli_num_rows($result)){                  
                $result = $db->getData();
                while($row = mysqli_fetch_assoc($result)){
                    myBooks($row['book_image'], $row['book_name'], $row['book_price'], $row['id'],$row['book_description'],$row['book_author'],$row['book_category'],$row['book_language'],$row['book_condition'],$row['book_purchase_date'],$row['stock'],$row['username'],$login_session);    
                }
            }else{
               
                $output = "
                    <div class='col'><div class='text-center'>
                        <img src='add_book.png' style='width:20%;height:20%'class='card-img' alt='...'>
                        <h5 class=''>No Books.</h5>
                        <p><small>You don't have any book.</small></p>
                        <button type='button' onclick=\"location.href='sell_book.php'\" name='book_cart' class='btn btn-primary mx-3'>Sell a book now</button>
                        </div>
                    </div>    ";
                echo $output;
            }
            
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


</body>



<script type="text/javascript">

    $(".remove").click(function(){
        var id = $(this).attr("id");
        if(confirm('Are you sure to remove this record ?'))
        {
            $.ajax({
               url: 'ajax_deleteBook.php',
               type: 'GET',
               data: {id: id},
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
                    alert("Record removed successfully");  
               }
            });
        }
    });


</script>
</html>