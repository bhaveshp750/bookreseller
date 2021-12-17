<?php
       include('connection.php');

        $Fname = $Lname = $MNum =  $username = $password = $confirm_password = "";
        $username_err = $password_err = $confirm_password_err = "";
        if(isset($_POST['signin'])) {
            
            if(empty(trim($_POST["username"]))){
                $username_err = "Please enter email id.";
                echo "Please enter email id.";
            }else{
                $sql = "SELECT username from register where username = '$username'";

                $result = mysqli_query($conn,$sql);

                $count = mysqli_num_rows($result);
                        if($count == 1){
                            $username_err = "This username is already taken.";
                            echo  "This username is already taken.";
                        } else{
                            $username = trim($_POST["username"]);
                        }                    
                }                
             
            
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

            $Fname = $_POST['Fname'];
            $Lname = $_POST['Lname'];
            $MNum = $_POST['MNum'];
            

            if($Fname && $Lname && $MNum && empty($username_err) && empty($password_err) && empty($confirm_password_err)){

                $sql = "INSERT INTO `register`(`fname`, `lname`, `mobile`, `username`, `passcode`) 
                                    VALUES ('$Fname', '$Lname', '$MNum', '$username', '$hashed_password');";

                if($result = mysqli_query($conn, $sql)){
                    header("location: login.php");
                }else{
                    echo "Something went wrong. Please try again later.";
                }

            }
            mysqli_close($conn);
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" href="style.css">
        <style>
            ::placeholder {
              color: white;
              opacity: 0.4; 
            }
                      
        </style>
    </head>
    <body>
        
        <form  method="post" action="">
        <div class="login-box">
        </div>   
            <div class="login-box">
                <h1>Register</h1>
                <div class="text-box">
                    <i class = "fa fa-user" aria-hidden="true"></i>
                    <input type="text" placeholder="First name" name="Fname" required>
                </div>
                <div class="text-box">
                    <i class = "fa fa-lock" aria-hidden="true"></i>
                    <input type="text" placeholder="Last Name" name="Lname" required>
                </div>
                <div class="text-box">
                    <i class = "fa fa-lock" aria-hidden="true"></i>
                    <input type="email" placeholder="Email" name="username" required>
                </div>
                <div class="text-box">
                    <i class = "fa fa-lock" aria-hidden="true"></i>
                    <input type="number" placeholder="Mobile number" name="MNum" required>
                </div><div class="text-box">
                    <i class = "fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="text-box">
                    <i class = "fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                </div>
                <input type="submit" class="btn" name='signin' value="Submit" id="sub" >

                <br>
                <br>                
                <span class="signup">Already have account?<a href = "login.php" style="color:white">Login</a></span>
            </div>
        </form>
    </body> 
</html>