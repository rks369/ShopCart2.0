<nav id="navbar" class="navbar navbar-expand-lg " style="background-color: #06bfad;" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./">🛒Shop Cart</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


                <?php if (isset($_SESSION['name'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link active " href="#">Cart</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['name'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Order History</a></li>
                            <li><a class="dropdown-item" href="change_password">Chnage Password</a></li>
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </li>
                <?php } else { ?>

                    <li class="nav-item">
                        <a class="nav-link active" href="seller/login">Become Seller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="signup">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login">Login</a>
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>
</nav>