

        <div class="container">
            <div class="left">
                <img src="../static/images/seller_login.png">
            </div>
            <div class="right card">
                <br>
                <h1 class="heading">Seller Login</h1>
                <br>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email">
                        <div>
                            <span id='email_err' class="error_span"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password">
                        <div>
                            <span id='password_err' class="error_span"></span>
                        </div>
                    </div>

                </div>

                <a class="text-end" href='./forgot_password.php'>Forgot Password?</a>
                <div class=" text-center">
                    <span id='error_msg' class="error_span"></span>
                </div>
                <br>
                <button id="loginBtn" class="primaryButton">Login</button>
                <br>
            </div>
        </div>
        <script src="../seller_login.js"></script>
