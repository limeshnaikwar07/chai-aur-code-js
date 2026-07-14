<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cashier Login</title>

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
            width: 360px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            text-decoration: none;
            color: #007bff;
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

        .admin-panel {
            display: none;
            margin-top: 20px;
            background: #e9f7ef;
            padding: 15px;
            border-radius: 5px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- LOGIN FORM -->
        <div id="loginSection">
            <h2>Admin Login</h2>

            <div class="input-group">
                <label>Username</label>
                <input type="text" id="username">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" id="password">
            </div>

            <button class="btn" onclick="login()">Login</button>

            <div class="link">
                <a onclick="showReset()">Forgot Password?</a>
            </div>

            <div class="error" id="loginError">
                Invalid Username or Password
            </div>

            <div class="admin-panel" id="adminPanel">
                <h3>Welcome Admin</h3>
                <p>Only admin can view this information.</p>

                <ul>
                    <li>Total Users: 120</li>
                    <li>Revenue: $25,000</li>
                    <li>Pending Requests: 8</li>
                </ul>
            </div>
        </div>


        <!-- RESET PASSWORD FORM -->
        <div id="resetSection" class="hidden">
            <h2>Reset Password</h2>

            <div class="input-group">
                <label>Enter Admin Username</label>
                <input type="text" id="resetUsername">
            </div>

            <div class="input-group">
                <label>New Password</label>
                <input type="password" id="newPassword">
            </div>

            <button class="btn" onclick="resetPassword()">
                Reset Password
            </button>

            <div class="success" id="resetSuccess">
                Password Reset Successfully
            </div>

            <div class="error" id="resetError">
                Username not found
            </div>

            <div class="link">
                <a onclick="backToLogin()">Back to Login</a>
            </div>
        </div>

    </div>
<script>

  // Admin credentials
  let adminUser = "cashier";
  let adminPass = "12345";

  // Redirect page
  const admin = "cashier.php";

  function login(){

    const username =
      document.getElementById("username").value;

    const password =
      document.getElementById("password").value;

    if(username === adminUser && password === adminPass){

      // Redirect to admin dashboard
      window.location.href = admin;

    } else {

      document.getElementById("loginError").style.display = "block";
    }
  }

  function showReset(){

    document.getElementById("loginSection")
        .classList.add("hidden");

    document.getElementById("resetSection")
        .classList.remove("hidden");
}

function backToLogin(){

    document.getElementById("resetSection")
        .classList.add("hidden");

    document.getElementById("loginSection")
        .classList.remove("hidden");
}


function resetPassword(){

    const resetUsername =
        document.getElementById("resetUsername").value;

    const newPassword =
        document.getElementById("newPassword").value;

    if(resetUsername === adminUser){

        // Update password
        adminPass = newPassword;

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


</script>

</body>

</html>