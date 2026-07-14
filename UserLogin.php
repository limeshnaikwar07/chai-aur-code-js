<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 400px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
        }

        .input-group input:focus {
            border-color: #007bff;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 15px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #c70303;
            text-decoration: none;
            cursor: pointer;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            display: none;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
            display: none;
        }

        .user-panel {
            display: none;
            margin-top: 20px;
            background: #e8f5e9;
            padding: 15px;
            border-radius: 6px;
        }

        .hidden {
            display: none;
        }
    </style>

</head>

<body>

    <div class="container">

        <!-- LOGIN SECTION -->

        <div id="loginSection">

            <h2>User Login</h2>

            <div class="input-group">

                <label>Email</label>

                <input type="email" id="email">

            </div>

            <div class="input-group">

                <label>Password</label>

                <input type="password" id="password">

            </div>

            <button class="btn" onclick="login()">

                Login

            </button>

            <div class="link">

                <a onclick="showReset()">

                    Forgot Password?

                </a>

            </div>

            <div class="error" id="loginError">

                Invalid Email or Password

            </div>
            <div class="link">

                <a class="text-decoration-underline" onclick="SignUp()">

                    New user? Register here.
                </a>

            </div>

            <div class="user-panel" id="userPanel">

                <h3>Welcome User</h3>

                <p>Your account login successful.</p>

                <ul>
                    <li>Account Balance: ₹50,000</li>
                    <li>Last Transaction: ₹2,500</li>
                    <li>Status: Active</li>
                </ul>

            </div>

        </div>


        <!-- RESET PASSWORD SECTION -->

        <div id="resetSection" class="hidden">

            <h2>Reset Password</h2>

            <div class="input-group">

                <label>Enter Email</label>

                <input type="email" id="resetEmail">

            </div>
            <div class="span align-items-center justify-content-center" style="display: flex; gap: 10px; margin-bottom: 15px;">
                or
            </div>
            <div class="input-group">

                <label>Enter Mobile Number</label>

                <input type="text" id="resetMobile">

            </div>
            <div class="input-group">

                <label>Enter OTP</label>

                <input type="text" id="resetOTP">

            </div>

            <div class="input-group">

                <label>New Password</label>

                <input type="password" id="newPassword">

            </div>

            <div class="input-group">

                <label>Confirm Password</label>

                <input type="password" id="newPassword">

            </div>

            <button class="btn" onclick="resetPassword()">

                Reset Password

            </button>

            <div class="success" id="resetSuccess">

                Password Reset Successfully

            </div>

            <div class="error" id="resetError">

                Email not found

            </div>

            <div class="link">

                <a class="text-decoration-underline" onclick="backToLogin()">

                    Back to Login

                </a>

            </div>
            <div class="link">

                <a class="text-decoration-underline" onclick="SignUp()">

                    New user? Register here.
                </a>

            </div>

        </div>

    </div>


    <script>
        // USER CREDENTIALS

        let userEmail = "user@gmail.com";
        let userPass = "12345";

        // REDIRECT PAGE

        const dashboard = "user_dashboard.php";

        // LOGIN FUNCTION

        function login() {

            const email =
                document.getElementById("email").value;

            const password =
                document.getElementById("password").value;

            if (email === userEmail &&
                password === userPass) {

                // Redirect Dashboard

                window.location.href = dashboard;

            } else {

                document.getElementById("loginError")
                    .style.display = "block";
            }
        }


        // SHOW RESET FORM

        function showReset() {

            document.getElementById("loginSection")
                .classList.add("hidden");

            document.getElementById("resetSection")
                .classList.remove("hidden");
        }


        // BACK TO LOGIN

        function backToLogin() {

            document.getElementById("resetSection")
                .classList.add("hidden");

            document.getElementById("loginSection")
                .classList.remove("hidden");
        }


        // RESET PASSWORD FUNCTION

        function resetPassword() {

            const resetEmail =
                document.getElementById("resetEmail").value;

            const newPassword =
                document.getElementById("newPassword").value;

            if (resetEmail === userEmail) {

                // UPDATE PASSWORD

                userPass = newPassword;

                document.getElementById("resetSuccess")
                    .style.display = "block";

                document.getElementById("resetError")
                    .style.display = "none";

            } else {

                document.getElementById("resetError")
                    .style.display = "block";

                document.getElementById("resetSuccess")
                    .style.display = "none";
            }
        }
        let SignUp = () => {
            window.location.href = "UserRegister.php";
        }
    </script>

</body>

</html>