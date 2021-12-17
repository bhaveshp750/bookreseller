<!-- <?php include("session.php"); ?> -->
<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark ">
        
        
        <span  class="navbar-brand pl-5">
            <a href="book_cart.php" style="text-decoration: none"><img src="_bookreseller.svg" alt="Logo" width="50%" height="50%"></a>
        </span>       
        
        
        <button class="navbar-toggler navbar-dark bg-dark"
            type="button"
            data-toggle = "collapse"
            data-target = "#navbarNavAltMarkup"
            aria-controls = "navbarNavAltMarkup"
            aria-expanded = "false"
            aria-label = "Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mr-auto"></div>
            <div class="navbar-nav">

                <span class="navbar-brand">
                    <h3 class="py-0">
                    <a href="profile.php" style="text-decoration: none; ">    <i class="fas fa-profile"></i> Hello, <?php if(isset($login_session_user)) echo $login_session_user; else header('location:admin_vbooks.php');  ?> </a>
                    </h3>
                </span>

                <span  class="navbar-brand"> 
                    <h3 class="px-5 cart">
                        <a href="cart.php" style="text-decoration: none"> <i class="fas fa-shopping-cart"></i> Cart
                        <?php 
                            if(isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']);
                                echo "<span id='cart_count' class='text-warning bg-dark'>$count</span>";
                            }else{
                                echo "<span id='cart_count' class='text-warning bg-dark'>0</span>";
                            }
                        ?>
                        </a>
                    </h3>
                </span>
                
                <span class="navbar-brand">
                    <h3 class="px-3">
                    <a href="logout.php" style="text-decoration: none">    Logout <i class="fas fa-sign-out-alt"></i> </a>
                    </h3>
                </span>
            </div>
        </div>

                            
    </nav>

<!-- <hr class=' bg-dark'> -->
<div class="" style="background-color:#76828D;">        
    <nav class="navbar navbar-form  navbar-dark bg-dark">
    
        <a href="sell_book.php" class="navbar-brand">
            <h3 class="">
                <i class="fas fa-book"></i> Sell Books
            </h3>
        </a>

        <a href="book_cart.php" class="navbar-brand">
            <h3 class="">
                <i class="fas fa-search"></i> Buy Books
            </h3>
        </a>   
        
        <a href="my_books.php" class="navbar-brand">
            <h3 class="">
                <i class="fas fa-book-open"></i> My Books
            </h3>
        </a>              

        <a href="my_orders.php" class="navbar-brand">
            <h3 class="">
                <i class="fas fa-calendar-check"></i> My Orders
            </h3>
        </a> 

        <a href="clients.php" class="navbar-brand">
            <h3 class="">
                <i class="fas fa-calendar-check"></i> Clients
            </h3>
        </a>   
        </div>
    </nav>         
    </div>

</header>