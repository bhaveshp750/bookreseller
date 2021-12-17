<?php
    include_once('session.php');
    include_once("component.php"); 


    $con = mysqli_connect("localhost", "root", "", "book_reseller");
    if(isset($_POST['bookNewCount'])){
      $bookNewCount = $_POST['bookNewCount'];
      $sql = "SELECT * from book_details where stock='Available' limit $bookNewCount";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
              if($row['stock'] == 'Available')
                  component($row['book_name'],$row['book_price'],$row['book_image'],$row['book_description'],$row['id'],$row['book_author'],$user_check,$row['book_condition'],$row['book_category'],$row['book_language'],$row['book_purchase_date']);
          }
      }else{
          echo "<h4>There are no Books</h4>";
      } 
    }else{
    echo  "<div id='notfound'>
            <div class='notfound'>
                <div class='notfound-404'>
                    <h1>4<span>0</span>4</h1>
                </div>
                <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                <a href='#'>home page</a>
            </div>
        </div>";
    }            
?>
