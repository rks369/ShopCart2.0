        <div class="container">
            <div class="left">
                <img src="../static/images/change_password.png">
            </div>
            <div class="right card">
                <br>
                <h1 class="heading">Change Password</h1>
                <br>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password">

                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="confirm_password">
                        <div>
                            <span id='password_err' class="error_span"></span>
                        </div>
                    </div>
                </div>
                <div class=" text-center">
                    <span id='error_msg' class="error_span"></span>
                </div>
                <br>
                <button id="change_password" class="primaryButton">Change Password</button>
                <br>
            </div>
        </div>
        <script src="/change_password.js"></script>