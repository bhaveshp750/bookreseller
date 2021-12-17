<?php


$conn = mysqli_connect("localhost","root","","book_reseller");


if(isset($_GET['id']))
{
    $sql = "DELETE FROM book_details WHERE id=".$_GET['id'];
     mysqli_query($conn,$sql);
	 echo 'Deleted successfully.';
}


?>