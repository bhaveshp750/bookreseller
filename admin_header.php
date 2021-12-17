<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark ">
        
        <span  class="navbar-brand pl-5">
            <a href="admin_vbooks.php" style="text-decoration: none"><img src="_bookreseller.svg" alt="Logo" width="40%" height="40%"></a>
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
                    <a href="book_cart.php" style="text-decoration: none;">    <i class="fas fa-user"></i> Hello, <?php if(isset($admin_check)) echo $admin_check; else header('location:book_cart.php'); ?></a>
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


    <!-- nav-bar-2 -->
    <div class="" style="background-color:#76828D;">        
        <nav class="navbar navbar-form  navbar-dark bg-dark pl-5 pr-5">
            
            <a href="admin_vbooks.php" class="navbar-brand">
                <h3 class="px-5">
                    <i class="fas fa-book"></i> View Books
                </h3>
            </a>

            <a href="admin_vorders.php" class="navbar-brand">
                <h3 class="px-5">
                    <i class="fas fa-search"></i> View Orders
                </h3>
            </a>              

            <a href="admin_vusers.php" class="navbar-brand">
                <h3 class="px-5">
                    <i class="fas fa-calendar-check"></i> View Users
                </h3>
            </a>    
        
        </nav>         
</div>

</header>