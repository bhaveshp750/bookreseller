<?php
    include('session.php');
    include_once('connection.php');

    if(isset($_POST['edit_book'])){
        //print_r('Edit Button '.$_POST['product_id']);
        $sql = "SELECT * from book_details where id=".$_POST['product_id'];
        $result = mysqli_query($conn,$sql);
        if($row = mysqli_fetch_assoc($result)){                  

            $id = $row['id'];
            $name = $row['book_name'];
            $author = $row['book_author'];
            $category = $row['book_category'];
            $language = $row['book_language'];
            $condition = $row['book_condition'];
            $purchase_date = $row['book_purchase_date'];
            $price = $row['book_price'];
            // $hand = $row['book_hand'];
            $description = $row['book_description'];

        }
    }    
    elseif(isset($_POST['updatebook'])){

        //echo $login_session; 
        $target = "upload/".basename($_FILES['bookimage']['name']);

        $bid = $_POST['product_id'];
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

        if($bimage){
            if($file_ext == "jpg" || $file_ext == "jpge" || $file_ext == "png"){
                if(move_uploaded_file($_FILES['bookimage']['tmp_name'], $target)){
                    
                    $sql = "UPDATE `book_details` set  `book_name`='$bname', `book_author`='$bauthor', `book_category`='$bcategory', `book_language`='$blanguage', `book_condition`='$bcondition', `book_purchase_date`='$bpurchase', `book_price`=$bprice, `book_image`='$target', `book_description`='$bdesc' where `id`=$bid";
                    
                    $result = mysqli_query($conn,$sql);
                    
                    if($result){
                        ?>
                            <script type="text/javascript"> 
                                if(confirm("Book Updated successfully.")) 
                                    window.location.href = "my_books.php";        
                            </script>
                        <?php
                    }
                    else {
                        ?>
                            <script type="text/javascript"> 
                                if(confirm("Cannot Upload book details. Try Later.")) 
                                    window.location.href = "my_books.php";
                            </script>
                        <?php  
                            
                    }
                }else{
                    echo"<script type=\"text/javascript\"> 
                            if(confirm(\"Something went wrong. Try again.\")) {
                                window.location.href = \"my_books.php\";
                            }  
                        </script>";
                }
            }else{
                echo"<script type=\"text/javascript\"> 
                        if(confirm(\"Upload only JPG, JPGE or PNG file. Try again.\")) {
                            window.location.href = \"my_books.php\";
                        }  
                    </script>";
            }   
        }else{ 
            //update book without image    
            $sql = "UPDATE `book_details` set  `book_name`='$bname', `book_author`='$bauthor', `book_category`='$bcategory', `book_language`='$blanguage', `book_condition`='$bcondition', `book_purchase_date`='$bpurchase', `book_price`=$bprice, `book_description`='$bdesc' where id = $bid";
            $result = mysqli_query($conn,$sql);
            if($result){
                ?>
                    <script type="text/javascript"> 
                        if(confirm("Book Updated successfully. ")) 
                            window.location.href = "my_books.php";        
                    </script>
                <?php
            }else{
                ?>
                    <script type="text/javascript"> 
                        if(confirm("Cannot Upload book details. Try Later.")) 
                            window.location.href = "my_books.php";        
                    </script>
                <?php                    
            }
        }
    }else{
        header("location: my_books.php");
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- bootstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>

<body>
<?php include_once('header.php')?>
<div class="container">
<h5 class='pt-3'>Edit Books</h5>
    <hr>
    
<form method="post" action="" enctype="multipart/form-data">
    
    <ul class="list-group py-2">
        <li class="list-group-item list-group-item-primary">Book Details</li>
        <li class="list-group-item">

            <div class="form-row py-2">
                <div class="col">
                    <input id="n" onClick="toggle_edit('n', 'name')"  type="checkbox"/>
                    <label>Book name:</label>
                    <input type="text" name="bookname" id='name' class="form-control" value="<?php echo $name;?>"  required disabled>
                </div>
                <div class="col">
                <input id="a" onClick="toggle_edit('a', 'author')"  type="checkbox"/>
                    <label>Author name:</label>
                    <input type="text" name="authorname" id='author' class="form-control" value="<?php echo $author; ?>" required disabled>
                </div>
            </div>

            <div class="form-row py-2">
                <div class="col">
                    <input id="c" onClick="toggle_edit('c', 'category')" type="checkbox"/>
                    <label>Category:</label>
                    <select class="custom-select" name="bookcategory"  id="category" required disabled>
                        <option selected><?php echo $category; ?></option>
                        <option>Science</option>
                        <option>Mathematics</option>
                        <option>English</option>
                        <option>History</option>
                        <option>Travel</option>
                        <option>Fiction</option>
                        <option>Dictionaries</option>
                        <option>Cookbook</option>
                        <option>Novel</option>
                        <option>General Knowledge</option>
                        <option>Health</option>
                        <option>Spirituality</option>
                        <option>Self Help</option>
                        <option>Journal</option>
                        <option>Biography</option>
                        <option>Math</option>
                        <option>Religion</option>
                        <option>Art</option>
                        <option>Story</option>
                        <option>Sport</option>
                        <option>Kids</option>
                        <option>Crafts & Hobbies</option>
                        <option>Business</option>

                    </select>   
                </div>
                <div class="col">
                    <input id="l" onClick="toggle_edit('l', 'language')" type="checkbox"/>
                    <label>Book Language:</label>
                    <select class="custom-select" name="booklanguage"  id="language" required disabled>
                    <option selected><?php echo $language ?></option>
                    <option>English</option>
                    <option>Kannada</option>
                    <option>Gujarati</option>
                    <option>Hindi</option>
                </select>   
                </div>
            </div>
            
            <div class="form-row py-3">
                <div class="col">
                    <input id="cd" onClick="toggle_edit('cd', 'condition')" type="checkbox"/>
                    <label>Book Condition:</label>
                    <select class="custom-select" name="bookcondition"  id="condition" required disabled>
                        <option selected><?php echo $condition ?></option>
                        <option>New</option>
                        <option>Good</option>
                        <option>Fair</option>
                        <option>Poor</option>
                    </select>   
                </div>
                <div class="col">
                    <input id="pd" onClick="toggle_edit('pd', 'date')" type="checkbox"/>
                    <label>Purchase Date:</label>
                    <input type="text" class="form-control" id='date' name="bookpurchase" value=<?php echo $purchase_date ?> placeholder="Purchase Date" required disabled>
                </div>
            </div>

            <div class="form-row py-3">
                <div class="col">
                    <input id="p" onClick="toggle_edit('p', 'price')" type="checkbox"/>
                    <label>Price:</label>
                    <input type="text" class="form-control" id='price' name="bookprice" placeholder="Price" value=<?php echo $price ?> required disabled>

                </div>
                <div class="col">
                    <input id="i" onClick="toggle_edit('i', 'image')"  type="checkbox"/>
                    <label for="img">Upload Book Cover image:</label>
                    <input class="form-control py-1" id='image' type="file" name="bookimage" accept="image/*" disabled >
                </div>
                
            </div>

            <div class="form-row">
                <div class="col">
                    <input id="des" onClick="toggle_edit('des', 'description')" type="checkbox"/>
                    <label>Description:</label>
                    <textarea name="bookdescription" id='description' placeholder="Description" cols=71 rows=3 class="form-control" required disabled><?php echo $description ?></textarea>
                </div>
            </div>
            <hr>
            <input type="hidden" name='product_id' value='<?php echo $id ?>'>
            <input type="submit" onclick="checkSubmit()" class="btn btn-primary" name="updatebook" value="Update" style="float:right">
            
        </li>
    
    </ul>

</form>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>


<script>

function toggle_edit(checkboxID, toggleID) {
     var checkbox = document.getElementById(checkboxID);
     var toggle = document.getElementById(toggleID);
     updateToggle = checkbox.checked ? toggle.disabled=false : toggle.disabled=true;
}   

function checkSubmit() {
        document.getElementById("name").disabled = false;
        document.getElementById("author").disabled = false;
        document.getElementById("category").disabled = false;
        document.getElementById("language").disabled = false;
        document.getElementById("condition").disabled = false;
        document.getElementById("date").disabled = false;
        document.getElementById("price").disabled = false;
        document.getElementById("image").disabled = false;
        document.getElementById("description").disabled = false;

        function hi() {
            document.getElementById("formid").submit();    }
    hi();
    }
</script>

</body>
 </html>