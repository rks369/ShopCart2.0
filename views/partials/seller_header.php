<link rel="stylesheet" href="../static/css/style.css">
<link rel="stylesheet" href="../static/css/style2.css">
<nav id="navbar" class="navbar navbar-expand-lg " style="background-color: #06bfad;" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🛒Shop Cart Seller</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


        <?php if (isset($_SESSION['name'])) { ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['name'] ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Orders</a></li>
              <li><a class="dropdown-item" href="#">Chnage Password</a></li>
              <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
          </li>
        <?php } else { ?>

          <li class="nav-item">
            <a class="nav-link active" href="../login.php">User Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="signup.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="login.php">Login</a>
          </li>
        <?php } ?>
      </ul>

    </div>
  </div>
</nav>