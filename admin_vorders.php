
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
    <title>View Orders</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- boorstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>
<body>
<?php include_once('admin_header.php')?>
<div class="container-fludi pl-5 pr-5">
    <h5 class='pt-4 pl-8'>My Orders</h5>
    <hr>
        <table class="table table-striped">
            <thead>
                <tr class='table-info'>
                    <th scope='col'>Order ID</th>
                    <th scope='col'>Shipped To</th>
                    <th scope='col'>Book Names</th>
                    <th scope='col'>Date</th> 
                    <th scope='col'>Amount</th>
                    <th scope='col'>Payment mode</th>
                    <th scope='col'>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $limit = 20;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    
                    $start = ($page - 1) * $limit;

                    $sql = "SELECT * from orders";         
                    $result = mysqli_query($db->con,$sql);

                    $max_book = mysqli_num_rows($result);
                    $pages = ceil($max_book/$limit);
                    $Previous = $page - 1;
                    $Next = $page + 1;
                    if($page == 1)
                    $PreDisable = 'disabled';
                    else 
                    $PreDisable = '';
                    if($page == $pages)
                    $NextDisable = 'disabled';
                    else 
                    $NextDisable = '';

                    $sql = "SELECT * from orders limit $start, $limit";         
                    $result = mysqli_query($db->con,$sql);

                    $count = mysqli_num_rows($result);
                    if($count){
                        while($row = mysqli_fetch_assoc($result)){
                            $date=substr($row['timestamp'],0,10);
                            $order_id = $row['order_id'];
                            if($row['order_status'] == 'Order Placed')
                            $color = 'text-success';
                            else
                            $color = 'text-success';
                            $output = "
                            <tr>
                                
                                <td scope='row'><button type='button' id='btnid1' value='$order_id' onclick='showOrder(this.value)' name='btnname' class='btn' data-toggle='modal' data-target='#exampleModal' style='padding: 0; color:black; border: none; background: none;'><b>$order_id</b></button> </td>
                                <td>".$row['billing_name']."</td>
                                <td scope='row'><button type='button' id='btnid2' value='$order_id' onclick='showBook(this.value)' name='btnname' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter' style='padding: 0; color:black; border: none; background: none;'><b>".$row['products_name']."</b></button> </td>
                                <td>".$row['timestamp']."</td>
                                <td>".$row['total_amount']."</td>
                                <td>".$row['pmode']."</td>
                                <td class='$color'><b>".$row['order_status']."</b></td>
                            </tr>";
                            echo $output;
                        }
                    }else{
                        echo "<div class='text-center'> <h5>There are no orders yet.</h5> </div>";
                    }
                ?>
            </tbody>
        </table>
       <!-- Modal 1-->
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

        <!-- Modal 2-->
        <div class='modal fade bd-example-modal-lg' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered modal-lg'  role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'></h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div id='txtHint2'>

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

         <?php 
        if($pages <= 4)
        {
            for($i = 1; $i <= $pages; $i++)
                $pages_array[] = $i;
        }
        else
        {
            if($page < 4)
            {
                for($i = 1; $i <= 4; $i++)
                    $pages_array[] = $i;
                $pages_array[] = '...';
                $pages_array[] = $pages;
            }
            else 
            {
                $end_page = $pages - 4;
                if($page > $end_page)
                {
                    $pages_array[] = 1;
                    $pages_array[] = '...';
                    for($i = $end_page; $i <= $pages; $i++)
                        $pages_array[] = $i;
                }
                else 
                {
                    $pages_array[] = 1;
                    $pages_array[] = '...';
                    for($i = $page - 1; $i <= $page + 1; $i++)
                        $pages_array[] = $i;
                    $pages_array[] = '...';
                    $pages_array[] = $pages;
                }
            }
        }
    ?>
    <div class="row">
        <div class="col-md">
            <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $PreDisable ?> ">
                    <a class="page-link" href="admin_vorders.php?page=<?= $Previous ?>" tabindex="-1">Previous</a>
                </li>
                <?php foreach($pages_array as $i) : ?>
                    <li class="page-item"><a class="page-link" href="admin_vorders.php?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endforeach; ?>
                <li class="page-item  <?php echo $NextDisable ?>">
                    <a class="page-link" href="admin_vorders.php?page=<?= $Next ?>">Next</a>
                </li>
            </ul>
            </nav>      
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
      document.getElementById("exampleModalLongTitle").innerHTML = "Order ID : "+val;
    }
  };
  xhttp.open("GET", "ajax_order_details.php?q="+val, true);
  xhttp.send();
}

function showOrder(val) {
  var xhttp;    
  if (val == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint2").innerHTML = this.responseText;
      document.getElementById("exampleModalLabel").innerHTML = "Order ID : "+val;
    }
  };
  xhttp.open("GET", "admin_ajax_order_details.php?q="+val, true);
  xhttp.send();
}
</script>