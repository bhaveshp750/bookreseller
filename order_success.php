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
    <title>Complete Order</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- bootstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">


    <script>
    function ajax_post(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "takeorder.php";
    var fn = "<?php echo $_POST['name'] ?>";
    var ln = "<?php echo $_POST['email'] ?>";
    var house = "<?php echo rtrim(ltrim($_POST['house'])) ?>";
    var area = "<?php echo rtrim(ltrim($_POST['area'])) ?>";
    var landmark = "<?php echo rtrim(ltrim($_POST['landmark'])) ?>";
    var city = "<?php echo rtrim(ltrim($_POST['city'])) ?>";
    var pincode = "<?php echo rtrim(ltrim($_POST['pincode'])) ?>";
    var bphone = "<?php echo $_POST['phone'] ?>";
    var pmode = "<?php echo $_POST['pmode'] ?>";
    var pd = "<?php echo $_POST['products'] ?>";
    var gt = "<?php echo $_POST['grand_total'] ?>";

    var vars = "firstname="+fn+"&lastname="+ln+"&house="+house+"&area="+area+"&landmark="+landmark+"&city="+city+"&pincode="+pincode+"&phone="+bphone+"&pmode="+pmode+"&products="+pd+"&grand_total="+gt;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("txtHint").innerHTML = return_data;
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("txtHint").innerHTML = "<div class='d-flex justify-content-center'>  <div class='spinner-border' role='status'>    <span class='sr-only'>Loading...</span>  </div></div>";
}

    
</script>

<?php 
    if(isset($_POST['PlaceOrder'])) {  
        echo"<script> ajax_post(); </script>";
    } 
    else {
        echo "<script>window.location = 'book_cart.php' </script>";
    }
?>

</head>
<body>
<?php include_once('header.php')?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 px-4 pb-4">
            <div id='txtHint'>

            </div>
       </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

