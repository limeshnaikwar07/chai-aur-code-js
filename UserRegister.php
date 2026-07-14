<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Banking | Authentication Portal</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome v6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <style>
        body {
            background: #f4f6fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
        }

        .left-side img {
            width: 100%;
            height: 100%;
            min-height: 450px;
            object-fit: cover;
        }

        .right-side {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
        }

        .btn-custom {
            height: 48px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .hidden {
            display: none !important;
        }

        .clickable-link {
            color: #0d6efd;
            text-decoration: none;
            cursor: pointer;
            font-weight: 500;
        }

        .clickable-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <div class="auth-card">
            <div class="row g-0">

                <!-- LEFT IMAGE VIEWPORT -->
                <div class="col-md-5 left-side d-none d-md-block">
                    <img src="https://wpblogassets.paytm.com/paytmblog/uploads/2021/09/2_netbanking_Net-banking-what-are-its-advantages-disadvantages-features-and-more.jpg" alt="Banking Infrastructure Image">
                </div>

                <!-- RIGHT INTERACTIVE INTERFACE PANEL -->
                <div class=" col-md-6 right-side">

                    <!-- SECTION 1: SIGN UP / REGISTRATION VIEW -->
                    <div id="registerSection">
                        <form id="registerForm" onsubmit="handleRegistration(event)">
                            <div class="row">
                                <h2 class="text-center mb-4 font-weight-bold">Sign Up</h2>

                                <div class="col-sm-6 mb-3">
                                    <label for="firstname" class="form-label small text-muted mb-1">First Name</label>
                                    <input type="text" class="form-control" id="firstname" placeholder="John" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="lastname" class="form-label small text-muted mb-1">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Doe" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label small text-muted mb-1">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="mobile" class="form-label small text-muted mb-1">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile" placeholder="Enter Mobile Number" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small text-muted mb-1">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Create strong password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-custom mb-3">Sign Up</button>

                            <p class="text-center text-muted small mb-0">
                                Already have an account? <span class="clickable-link" onclick="switchView('login')">Login Here</span>
                            </p>
                        </form>
                    </div>

                    <!-- SECTION 2: LOGIN VIEW -->
                    <div id="loginSection" class="hidden">
                        <h2 class="text-center mb-4 font-weight-bold">User Login</h2>
                        <form id="loginForm" onsubmit="handleLogin(event)">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label small text-muted mb-1">Email Address</label>
                                <input type="email" class="form-control" id="loginEmail" placeholder="name@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="loginPassword" class="form-label small text-muted mb-1">Password</label>
                                <input type="password" class="form-control" id="loginPassword" placeholder="Enter security password" required>
                            </div>

                            <div class="text-end mb-4">
                                <span class="clickable-link small" onclick="switchView('reset')">Forgot Password?</span>
                            </div>

                            <div class="alert alert-danger p-2 small hidden" id="loginError">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> Invalid Email or Password configuration.
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-custom mb-3">Login</button>

                            <p class="text-center text-muted small mb-0">
                                New user? <span class="clickable-link" onclick="switchView('register')">Register here</span>
                            </p>
                        </form>
                    </div>

                    <!-- SECTION 3: RECOVERY & RESET PASSWORD VIEW -->
                    <div id="resetSection" class="hidden">
                        <h2 class="text-center mb-2 font-weight-bold">Reset Password</h2>
                        <!-- <p class="text-center text-muted small mb-4">For account protection, verified registration details remain fixed.</p> -->

                        <form id="resetForm" onsubmit="handleReset(event)">
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Registered Email Address</label>
                                <input type="email" class="form-control bg-light" id="resetEmail" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Registered Mobile Number</label>
                                <input type="text" class="form-control bg-light" id="resetMobile" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="resetOTP" class="form-label small text-muted mb-1">Verification OTP</label>
                                <input type="text" class="form-control" id="resetOTP" placeholder="Enter system security token" required>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="newPassword" class="form-label small text-muted mb-1">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="Min 5 characters" required>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label for="confirmPassword" class="form-label small text-muted mb-1">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Match password" required>
                                </div>
                            </div>

                            <div class="alert alert-danger p-2 small hidden" id="resetError"></div>
                            <div class="alert alert-success p-2 small hidden" id="resetSuccess">
                                <i class="fa-solid fa-circle-check me-1"></i> Password successfully modified! Returning to login...
                            </div>

                            <button type="submit" class="btn btn-warning text-white w-100 btn-custom mb-3">Update Password</button>

                            <p class="text-center text-muted small mb-0">
                               <span class="clickable-link" onclick="switchView('login')">Back to Login</span>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Runtime Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // const resetSection = "resetSection";
        // document.getElementById('resetSection').addEventListener('submit', handleReset);

        // CLIENT MEMORY STATE DEFINITIONS
        let appState = {
            email: "user@gmail.com", // Default fallback seed configuration
            mobile: "9876543210", // Default fallback seed configuration
            password: "12345",
            targetDashboard: "user_dashboard.php"
        };

        // VIEW CONTROLLER MANAGER
        function switchView(targetZone) {
            // Hide all functional containers
            document.getElementById('registerSection').classList.add('hidden');
            document.getElementById('loginSection').classList.add('hidden');
            document.getElementById('resetSection').classList.add('hidden');

            // Clean dynamic interface alerts
            document.getElementById('loginError').classList.add('hidden');
            document.getElementById('resetError').classList.add('hidden');
            document.getElementById('resetSuccess').classList.add('hidden');

            if (targetZone === 'register') {
                document.getElementById('registerSection').classList.remove('hidden');
            } else if (targetZone === 'login') {
                document.getElementById('loginSection').classList.remove('hidden');
            } else if (targetZone === 'reset') {
                // AUTO-FILL & LOCK logic: Ensure the reset fields copy dynamic active registration status
                document.getElementById('resetEmail').value = appState.email;
                document.getElementById('resetMobile').value = appState.mobile;

                document.getElementById('resetSection').classList.remove('hidden');
            }
        }

        // FLOW CONTROLLER 1: ACCOUNT REGISTRATION HANDLER
        function handleRegistration(event) {
            event.preventDefault();

            // Commit values to client state memory structures
            appState.email = document.getElementById('email').value;
            appState.mobile = document.getElementById('mobile').value;
            appState.password = document.getElementById('password').value;

            alert("Registration successful!.");

            // Reset the registration form values and swap views
            document.getElementById('registerForm').reset();
            switchView('login');
        }

        // FLOW CONTROLLER 2: USER LOGIN HANDLER
        function handleLogin(event) {
            event.preventDefault();

            const inputEmail = document.getElementById('loginEmail').value;
            const inputPass = document.getElementById('loginPassword').value;
            const errorPanel = document.getElementById('loginError');

            if (inputEmail === appState.email && inputPass === appState.password) {
                errorPanel.classList.add('hidden');
                window.location.href = appState.targetDashboard;
            } else {
                errorPanel.classList.remove('hidden');
            }
        }

        // FLOW CONTROLLER 3: SECURITY VALUE MODIFICATION HANDLER
        function handleReset(event) {
            event.preventDefault();

            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;
            const errorPanel = document.getElementById('resetError');
            const successPanel = document.getElementById('resetSuccess');

            errorPanel.classList.add('hidden');
            successPanel.classList.add('hidden');

            // Confirm match security assertion
            if (newPass !== confirmPass) {
                errorPanel.textContent = " Passwords do not match.";
                errorPanel.classList.remove('hidden');
                return;
            }

            // Commit changed value structure to persistent memory reference
            appState.password = newPass;
            successPanel.classList.remove('hidden');
            document.getElementById('resetForm').reset();

            // Auto transition layout back to login panel view after small delay
            setTimeout(() => {
                switchView('login');
            }, 2000);
        }
    </script>
</body>

</html>