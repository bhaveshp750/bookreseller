<?php
        //include('connection.php');
        include_once("CreateDb2.php"); 
        session_start();

        $db = new CreateDb("book_reseller","book_details");
        if($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['Username'];
        $password = $_POST['Password'];
        
        if($username != 'admin'){
            $sql = "SELECT _password FROM login_table WHERE username = \"$username\"";
            $result = mysqli_query($db->con,$sql);
            
            $row = mysqli_fetch_assoc($result);
            $count = password_verify($password, $row['_password']);
            if($count) {
                $_SESSION['login_user'] = $username;
                header("location: book_cart.php");   
                if ($result) {
                    echo "<script> alert('Hello User.')</script>";
                }
            }else{
                echo "<script> alert('Username or Password Invalid.')</script>";
            }
        }else{
            $sql2 = "SELECT username,passcode FROM admin_login WHERE passcode = \"$password\" ";
            $result2 = mysqli_query($db->con,$sql2);
            
            $row = mysqli_fetch_assoc($result2);
            $count = mysqli_num_rows($result2);
            if($count) {
                $_SESSION['login_admin'] = $row['username'];
                header("location: admin_vbooks.php");   
                if ($result) {
                    echo "<script> alert('Hello User.')</script>";
                }
            }else {
                echo "<script> alert('Username or Password Invalid.')</script>";
            }
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
        <style>
            ::placeholder {
              color: white;
              opacity: 0.4; 
            }
        </style>
    </head>
    <body>
        <form name='login_form' method="post">
        <div class="login-box">
        </div>   
            <div class="login-box">
                <h1>Login</h1>
                <div class="text-box">
                    <i class = "fa fa-user" aria-hidden="true"></i>
                    <input type="text" placeholder="Username" name="Username" required>
                </div>
                <div class="text-box">
                    <i class = "fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password" name="Password" required>
                </div>
                <input class="btn" type="submit" name="Login" value="Sign in">
                <span style="color:white"><a href= "#" style="color:white">Forget password?</a></span>
                <br>
                <br>                
                <span class="signup">Don't have account?<a href = "register.php" style="color:white">Sign up</a></span>
            </div>
        </form>
    </body> 
</html>
