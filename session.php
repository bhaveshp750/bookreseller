<?php
    include('connection.php');
    session_start();

    if(isset($_SESSION['login_user'])){
    
        $user_check = $_SESSION['login_user'];

        $ses_sql = mysqli_query($conn,"select fname,username from register where username = '$user_check' ");

        $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

        $login_session = $row['username'];
        $login_session_user = $row['fname'];

        if(!isset($_SESSION['login_user'])) {
            header("location:login.php");
            die();
        }
    }
    
    if(isset($_SESSION['login_admin'])){
        
        $admin_check = $_SESSION['login_admin'];
     
        if(!isset($_SESSION['login_admin'])) {
            header("location:login.php");
            die();
        }
    }

    if(!isset($_SESSION['login_admin']) && !isset($_SESSION['login_user'])) {
            header("location:login.php");
            die();
        }
    
?>