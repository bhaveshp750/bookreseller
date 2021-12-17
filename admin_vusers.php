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
    <title>View Users</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- bootstrap CND -->
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
                <th scope='col'>User ID</th>
                <th scope='col'>First Name</th>
                <th scope='col'>Last Name</th>
                <th scope='col'>Mobile</th>
                <th scope='col'>E-Mail</th>
                <th scope='col'>Registered Date</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $limit = 20;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    
                    $start = ($page - 1) * $limit;

                    $sql = "SELECT * from register";         
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

                    $sql = "SELECT * from register limit $start, $limit";         
                    $result = mysqli_query($db->con,$sql);

                    $count = mysqli_num_rows($result);
                    if($count){
                        while($row = mysqli_fetch_assoc($result)){
                            
                            $output = "
                            <tr>
                                <td>".$row['id']."</td>
                                <td>".$row['fname']."</td>
                                <td>".$row['lname']."</td>
                                <td>".$row['mobile']."</td>
                                <td>".$row['username']."</td>
                                <td>".$row['timestamp']."</td>

                            </tr>";
                            echo $output;
                        }
                    }else{
                        echo "<div class='text-center'> <h5 class=''>There are no orders yet.</h5> </div>";
                    }
                ?>
            </tbody>
        </table>
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
                    <a class="page-link" href="admin_vusers.php?page=<?= $Previous ?>" tabindex="-1">Previous</a>
                </li>
                <?php foreach($pages_array as $i) : ?>
                    <li class="page-item"><a class="page-link" href="admin_vusers.php?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endforeach; ?>
                <li class="page-item  <?php echo $NextDisable ?>">
                    <a class="page-link" href="admin_vusers.php?page=<?= $Next ?>">Next</a>
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
