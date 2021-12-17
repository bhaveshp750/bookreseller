<?php
    include('session.php');
    include_once('connection.php');

    
    if(isset($_POST['addbook'])){

        $target = "upload/".basename($_FILES['bookimage']['name']);

        $bname =  $_POST['bookname'];
        $bauthor = $_POST['authorname'] ;
        $bcategory = $_POST['bookcategory'] ;
        $blanguage = $_POST['booklanguage'] ;
        $bcondition = $_POST['bookcondition'] ;
        $bpurchase = $_POST['bookpurchase'] ;
        $bprice = $_POST['bookprice'] ;
        $bimage = $_FILES['bookimage']['name'] ;
        $bdesc = $_POST['bookdescription'] ;
        $buser = $login_session;

        $bimage = preg_replace("/\s+/","_",$bimage);
        $file_ext = pathinfo($bimage, PATHINFO_EXTENSION);
        $bimage = pathinfo($bimage, PATHINFO_FILENAME);
        date_default_timezone_set('Asia/Kolkata');
        $target = "upload/".$bimage."_".date("YmdHis").".".$file_ext;

        if($file_ext == "jpg" || $file_ext == "jpge" || $file_ext == "png"){
            if(move_uploaded_file($_FILES['bookimage']['tmp_name'], $target)){
                
                $sql = "INSERT INTO `book_details`( `book_name`, `book_author`, `book_category`, `book_language`, `book_condition`, `book_purchase_date`, `book_price`, `book_image`, `book_description`, `username`, `stock`) 
                VALUES ('$bname','$bauthor','$bcategory','$blanguage','$bcondition','$bpurchase',$bprice,'$target','$bdesc','$buser', 'Available');";
                
                $result = mysqli_query($conn,$sql);
                
                if($result)
                echo "<script> alert('Book added successfully.')</script>";
                else {
                    echo "<br>Cannot Upload book details. Try Later.";
                }
            }else{
                echo"<script> alert('Something went wrong. Try again.')</script>";
            }
        }else{
            echo"<script> alert('Upload only JPG, JPGE or PNG file.')</script>";
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Books</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- boorstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>

<body>
<?php include_once('header.php')?>
<div class="container">
<h5 class='pt-3'>Sell Book</h5>
    <hr>
<form method="post" action="" enctype="multipart/form-data">
    
    <ul class="list-group py-2">
        <li class="list-group-item list-group-item-primary">Book Details</li>
        <li class="list-group-item">

            <div class="form-row py-2">
                <div class="col">
                    <label>Book name:</label>
                    <input type="text" name="bookname" class="form-control" placeholder="Book name" required>
                </div>
                <div class="col">
                    <label>Author name:</label>
                    <input type="text" name="authorname" class="form-control" placeholder="Author name" required>
                </div>
            </div>

            <div class="form-row py-2">
                <div class="col">
                    <label>Category:</label>
                    <select class="custom-select" name="bookcategory" id="validationTooltip04" required>
                        <option selected disabled value="">--Select Category--</option>
                        <option>Art</option>
                        <option>Biography</option>
                        <option>Business</option>
                        <option>Crafts & Hobbies</option>
                        <option>Computer Science</option>
                        <option>Cookbook</option>
                        <option>Drama</option>
                        <option>Dictioaries</option>
                        <option>English</option>
                        <option>Fiction</option>
                        <option>General Knowledge</option>
                        <option>Health</option>
                        <option>History</option>
                        <option>Historical</option>
                        <option>Journal</option>
                        <option>Kids</option>
                        <option>Maths</option>
                        <option>Mathematics</option>
                        <option>Noval</option>
                        <option>Polity</option>
                        <option>Religion</option>
                        <option>Science</option>
                        <option>Self Help</option>
                        <option>Social</option>
                        <option>Spirituality</option>
                        <option>Sport</option>
                        <option>Story</option>
                        <option>Travel</option>

                    </select>   
                </div>
                <div class="col">
                    <label>Book Language:</label>
                    <select class="custom-select" name="booklanguage" id="validationTooltip04" required>
                    <option selected disabled value="">--Select Book Language--</option>
                    <option>English</option>
                    <option>Kannada</option>
                    <option>Gujarati</option>
                    <option>Hindi</option>
                    <option>Spanish</option>
                    <option>Russain</option>

                </select>   
                </div>
            </div>
            
            <div class="form-row py-3">
                <div class="col">
                    <label>Book Condition:</label>
                    <select class="custom-select" name="bookcondition" id="validationTooltip04" required>
                        <option selected disabled value="">--Select Book Condition--</option>
                        <option>New</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
                    </select>   
                </div>
                <div class="col">
                    <label>Purchase Date:</label>
                    <input type="date" class="form-control" name="bookpurchase" placeholder="Purchase Date" required>
                </div>
            </div>

            <div class="form-row py-3">
                <div class="col">
                    <label>Price:</label>
                    <input type="text" class="form-control" name="bookprice" placeholder="Price" required>

                </div>
                <div class="col">
                    <label for="img">Upload Book Cover image:</label>
                    <input class="form-control py-1" type="file" name="bookimage" accept="image/*" required>
                </div>
                
            </div>

            <div class="form-row">
                <div class="col">
                    <label>Description:</label>
                    <textarea name="bookdescription" placeholder="Description" cols=71 rows=3 class="form-control" required></textarea>
                </div>
            </div>
            <hr>

            <input type="submit" class="btn btn-primary" name="addbook" value="Submit" style="float:right">

        </li>
    
    </ul>

        
</form>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>