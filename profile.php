
<?php 

    include_once("session.php");
  
    $con = mysqli_connect("localhost","root","","book_reseller");

    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $fname = $_POST['Fname'];
        $lname = $_POST['Lname'];
        $mobile = $_POST['MNum'];
        $email = $_POST['username'];
        $pwd = $_POST['password'];
        $cpwd = $_POST['confirm_password'];
        
        
        if ($pwd) {
                 
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter a password.";
            } elseif(strlen(trim($_POST["password"])) < 6){
                $password_err = "Password must have atleast 6 characters.";
                echo"Password must have atleast 6 characters.";
            } else{
                $password = trim($_POST["password"]);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            }

            if(empty(trim($_POST["confirm_password"]))){
                $confirm_password_err = "Please confirm password.";
                echo  "Please confirm password.";
            } else{
                $confirm_password = trim($_POST["confirm_password"]);
                if(empty($password_err) && ($password != $confirm_password)){
                    $confirm_password_err = "Password did not match.";
                    echo  "Password did not match.";
                }
            }
            if($fname && $lname && $mobile && empty($password_err) && empty($confirm_password_err)){
            
                $sql = "UPDATE `register` SET `fname`='$fname' ,`lname`= '$lname' ,`mobile`= '$mobile', `passcode`='$hashed_password'  WHERE `username`= '$email'";

                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<script> alert('Profile updated successfully.')</script>";
                }else{
                    echo "Somrthing went wrong. Try again.";
                }
            }else{
                echo "Something is wrong. Try again.";
            }
        }else{//without password
            if($fname && $lname && $mobile){

            $sql = "UPDATE `register` SET `fname`='$fname' ,`lname`= '$lname' ,`mobile`= '$mobile'  WHERE `username`= '$email'";

            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<script> alert('Profile updated successfully.')</script>";
            }else{
                echo "Somrthing went wrong. Try again.";
            }
        }
        }


    }else{
        $ses_sql = mysqli_query($conn,"select * from register where username = '$user_check' ");
        $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

        if($row){
            $fname = $row['fname'];
            $lname = $row['lname'];
            $mobile = $row['mobile'];
            $email = $row['username'];
            $pwd = $row['passcode'];
        }
        else {
            echo "something went wrong, try again.";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- boorstrap CND -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style_cart.css">

</head>
<body>
<?php include_once('header.php')?>
<div class="container">
<form method="post" action="" enctype="multipart/form-data">
    
    <ul class="list-group py-2">
        <div class="row justify-content-center">
        <div class="col-md-8 pt-3">
            <li class="list-group-item list-group-item-white"><h3>Profile</h3></li>
            <li class="list-group-item">
                <div class='row p-2'>
                    <div class="col-md-3">
                        <h6 class='text-secondary'>FIRST NAME</h6>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id='fname' name='Fname' value='<?php echo $fname ?>' required disabled>
                    </div>
                    <div class="col-md-2">
                        <p>Edit <input type="checkbox" id='f' onclick="toggle_edit('f','fname')" ></p>
                    </div>
                </div>
                <div class='row p-2'>
                    <div class="col-md-3">
                        <h6 class='text-secondary'>LAST NAME</h6>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id='lname' name='Lname' value='<?php echo $lname ?>' required disabled>
                    </div>
                    <div class="col-md-2">
                        <p>Edit <input type="checkbox" id='l' onclick="toggle_edit('l','lname')" ></p>
                    </div>
                </div>
                <div class='row p-2'>
                    <div class="col-md-3">
                        <h6 class='text-secondary'>PHONE</h6>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id='mobile' name='MNum' value='<?php echo $mobile ?>' required disabled>
                    </div>
                    <div class="col-md-2">
                        <p>Edit <input type="checkbox" id='m' onclick="toggle_edit('m','mobile')" ></p>
                    </div>
                </div>
                <div class='row p-2'>
                    <div class="col-md-3">
                        <h6 class='text-secondary'>EMAIL</h6>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id='email' name='username' value='<?php echo $email ?>' required disabled>
                    </div>
                    <div class="col-md-2">
                        <p>Edit <input type="checkbox" id='e' onclick="toggle_edit('e','email')" disabled title='Work in process.'></p>
                    </div>
                </div>
                <div class='row p-2'>
                            <div class="col-md-3">
                                <h6 class='text-secondary'>PASSWORD</h6>
                            </div>
                            <div class="col-md-7">
                                <input type="text" style="filter: blur(3px)" class="form-control" id='1' name='pwd1' value='HELLO,How@are!you?' required disabled>
                            </div>
                            <div class="col-md-2">
                                <p>Edit <input type="checkbox" id='p' data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></p>
                            </div>
                </div>

                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <div class='row p-2'>
                            <div class="col-md-4">
                                <h6 class='text-secondary pt-1'>RESET PASSWORD</h6>
                            </div>
                            <div class="col-md-7">
                                <input type="password" class="form-control" id='pwd' name='password' placeholder='Enter Password' >
                            </div>
                            <div class="col-md-4 pt-2">
                                <h6 class='text-secondary'>CONFIRM PASSWORD</h6>
                            </div>
                            <div class="col-md-7 pt-2">
                                <input type="password" class="form-control" id='cpwd' name='confirm_password' placeholder='Confirm Password' >
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                <div class='row  text-right' >
                    <div class="col-md-3"></div><div class="col-md-4"></div>
                    <div class="col-md-5">
                        <input type="button" onclick=" window.location.href = 'book_cart.php';" class="btn btn-secondary mx-2" name="cancel" value="Cancel" >
                        <input type="submit" onclick='checkSubmit()' class="btn btn-primary" name="updateprofile" value="Update" >
                    </div>
                </div>               

            </li>
        
        </div>
        </div>
    </ul>    
</form>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>


<script>

function checkSubmit() {
        document.getElementById("fname").disabled = false;
        document.getElementById("lname").disabled = false;
        document.getElementById("mobile").disabled = false;
        document.getElementById("email").disabled = false;

        function hi() {
            document.getElementById("formsubid").submit();    
        }
        hi();
    }

    function toggle_edit(checkboxID, toggleID) {
      var checkbox = document.getElementById(checkboxID);
      var toggle = document.getElementById(toggleID);
      updateToggle = checkbox.checked ? toggle.disabled=false : toggle.disabled=true;
    }

</script>

