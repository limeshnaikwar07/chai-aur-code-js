<?php

$conn = mysqli_connect("localhost", "root", "", "ebankingdb");

if (!$conn) {
    die("Database Connection Failed");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Opening Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f4f6fb;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar */

        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #3b6ef5, #2b4dbf);
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 8px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, .2);
        }

        .account {
            border: 1px solid rgba(255, 255, 255, .5);
            background: rgba(255, 255, 255, .15);
        }

        .menu-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            border-radius: 8px;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, .15);
        }

        .submenu {
            display: none;
            background: white;
            border-radius: 10px;
            padding: 5px;
        }

        .submenu a {
            color: #333;
        }

        .submenu.show {
            display: block;
        }

        .rotate {
            transform: rotate(90deg);
            transition: .3s;
        }

        /* Main */

        .main {
            margin-left: 260px;
            padding: 25px;
            min-height: 100vh;
        }

        /* Form */

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
            max-width: 900px;
            margin: auto;
        }

        /* Profile */

        .profile-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .hover-card {
            position: absolute;
            right: 0;
            top: 100%;
            width: 220px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: .3s;
            z-index: 100;
        }

        .profile-wrapper:hover .hover-card {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .menu-link:hover {
            background: #f8f9fa;
        }

        .logout {
            color: red;
        }

        /* Mobile toggle button — hidden on desktop, shown inside topbar on mobile */
        .mobile-toggle {
            display: none;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, .2);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Mobile topbar — visible only on small screens */
        .mobile-topbar {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .sidebar {
                left: -100%;
                transition: left .3s;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                margin-left: 0;
                padding: 15px;
                padding-top: 70px;
                /* space for fixed topbar */
            }

            .mobile-topbar {
                display: flex;
                align-items: center;
                gap: 12px;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 58px;
                background: linear-gradient(90deg, #3b6ef5, #2b4dbf);
                color: #fff;
                z-index: 9999;
                padding: 0 15px;
            }

            .mobile-topbar h4 {
                margin: 0;
                font-size: 1.1rem;
                letter-spacing: 1px;
            }

            .mobile-toggle {
                display: flex;
            }

            .profile-wrapper span {
                display: none;
            }

            .form-card {
                padding: 20px;
            }

            h3 {
                font-size: 1.4rem;
            }
        }

        /* Hide number input spinners */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
    </style>
</head>

<body>

    <!-- Mobile topbar (visible only on small screens) -->
    <div class="mobile-topbar">
        <button class="mobile-toggle" id="toggleBtn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <h4><i class="bi bi-bank me-2"></i>E-BANKING</h4>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">

        <h4 class="mb-4">
            <i class="bi bi-bank me-2"></i>E-BANKING
        </h4>


        <a href="User_dashboard.php">
            <i class="bi bi-speedometer2  mt-2 me-2"></i>Dashboard
        </a>
        <hr>

        <a href="user_acc_form.php" class="account">
            <i class="bi bi-person-plus me-2"></i>Account Opening
        </a>

        <div>
            <div class="menu-toggle" onclick="toggleMenu('payeeMenu','payeeArrow')">
                <span><i class="bi bi-people-fill me-2"></i>Payee / Beneficiary</span>
                <i id="payeeArrow" class="bi bi-chevron-right"></i>
            </div>
            <div class="submenu" id="payeeMenu">
                <a href="all_payee.php">All Payee</a>
                <a href="manage_payee.php">Manage Payee</a>
            </div>
        </div>

        <a href="Transaction_history.php">
            <i class="bi bi-clock-history me-2 mt-2"></i>Transaction History
        </a>
        <hr>

        <a href="Report.php">
            <i class="bi bi-file-earmark-text me-2"></i>Report
        </a>

    </div>

    <!-- Main Content -->
    <div class="main">

        <!-- Profile -->
        <div class="d-flex justify-content-end mb-4">
            <div class="profile-wrapper">
                <div class="d-flex align-items-center gap-2">
                    <span>Hey, Mr. Limesh!</span>
                    <img src="https://i.pravatar.cc/50" width="40" class="rounded-circle">
                </div>
                <div class="hover-card">
                    <div class="p-3">
                        <a href="#" class="menu-link">
                            <i class="bi bi-person"></i>My Profile
                        </a>
                        <a href="#" class="menu-link">
                            <i class="bi bi-key"></i>Change Password
                        </a>
                        <hr>
                        <a href="#" class="menu-link logout">
                            <i class="bi bi-box-arrow-right"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-primary mb-4">Account Opening Form</h3>

        <div class="form-card m-0">

            <!-- FIX: id="accountForm" to match the JS event listener -->
            <form id="accountForm" novalidate>

                <div class="row g-3">

                    <!-- ADDRESS PROOF TYPE -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">Address Proof</label>
                        <select class="form-select" required>
                            <option value="">Select</option>
                            <option>Aadhaar</option>
                            <option>Passport</option>
                            <option>Voter ID</option>
                        </select>
                    </div>

                    <!-- AADHAAR NUMBER -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">Aadhaar Number</label>
                        <input type="number" id="aadhaar" class="form-control" required>
                        <div class="invalid-feedback">Enter a valid 12-digit Aadhaar number.</div>
                    </div>

                    <!-- ADDRESS PROOF FILE UPLOAD -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">Upload Address Proof</label>
                        <input type="file" id="addressFile" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="invalid-feedback">Please upload a valid file (JPG, PNG, PDF, max 2MB).</div>
                    </div>

                    <!-- PAN CARD FILE UPLOAD -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">Upload PAN Card</label>
                        <input type="file" id="panFile" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="invalid-feedback">Please upload a valid file (JPG, PNG, PDF, max 2MB).</div>
                    </div>

                    <!-- PAN NUMBER -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">PAN Number</label>
                        <input type="text" id="pan" class="form-control" placeholder="ABCDE1234F"
                            maxlength="10" minlength="10" required>
                        <div class="invalid-feedback">PAN must be in format ABCDE1234F</div>
                    </div>

                    <!-- DATE OF BIRTH -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" id="dob" class="form-control" required>
                        <div class="invalid-feedback">You must be at least 18 years old.</div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="col-12 col-md-9">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" id="address" rows="4"
                            minlength="10" maxlength="250" required></textarea>
                        <div class="invalid-feedback">Please enter your address (min 10 characters).</div>
                    </div>

                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">Accept Terms &amp; Conditions</label>
                    <div class="invalid-feedback">You must accept the terms &amp; conditions.</div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">Submit</button>
                </div>

            </form>

        </div>

    </div>

    <script>
        /* ── Sidebar Toggle ── */
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const btnIcon = document.querySelector("#toggleBtn i");

            sidebar.classList.toggle("show");

            if (sidebar.classList.contains("show")) {
                btnIcon.classList.replace("bi-list", "bi-x-lg");
            } else {
                btnIcon.classList.replace("bi-x-lg", "bi-list");
            }
        }

        /* ── Submenu Toggle ── */
        function toggleMenu(menuId, arrowId) {
            document.getElementById(menuId).classList.toggle("show");
            document.getElementById(arrowId).classList.toggle("rotate");
        }

        /* ── Age Validation (18+) ── */
        const today = new Date();
        const minAgeDate = new Date(
            today.getFullYear() - 18,
            today.getMonth(),
            today.getDate()
        );
        document.getElementById("dob").max = minAgeDate.toISOString().split("T")[0];

        /* ── Aadhaar: digits only, max 12 ── */
        document.getElementById("aadhaar").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "").slice(0, 12);
        });

        /* ── PAN: enforce AAAAA9999A format live ── */
        document.getElementById("pan").addEventListener("input", function() {
            let value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, "");
            let result = "";

            for (let i = 0; i < value.length && result.length < 10; i++) {
                if (i < 5 && /[A-Z]/.test(value[i])) result += value[i];
                else if (i >= 5 && i < 9 && /[0-9]/.test(value[i])) result += value[i];
                else if (i === 9 && /[A-Z]/.test(value[i])) result += value[i];
            }

            this.value = result;

            const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            this.setCustomValidity(
                this.value.length === 10 && !panRegex.test(this.value) ?
                "PAN format should be ABCDE1234F" :
                ""
            );
        });

        /* ── Form Submit & Validation ── */
        document.getElementById("accountForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = this;
            const aadhaar = document.getElementById("aadhaar");
            const pan = document.getElementById("pan");
            const addressFile = document.getElementById("addressFile");
            const panFile = document.getElementById("panFile");
            const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            const allowedTypes = ["image/jpeg", "image/png", "application/pdf"];
            const maxSize = 2 * 1024 * 1024; // 2 MB

            /* Aadhaar */
            aadhaar.setCustomValidity(
                /^\d{12}$/.test(aadhaar.value) ? "" : "Enter a valid 12-digit Aadhaar number."
            );

            /* PAN */
            pan.setCustomValidity(
                panRegex.test(pan.value) ? "" : "PAN format should be ABCDE1234F"
            );

            /* Address file type */
            if (addressFile.files.length && !allowedTypes.includes(addressFile.files[0].type)) {
                addressFile.setCustomValidity("Only JPG, PNG, or PDF allowed.");
            } else {
                addressFile.setCustomValidity("");
            }

            /* PAN file type */
            if (panFile.files.length && !allowedTypes.includes(panFile.files[0].type)) {
                panFile.setCustomValidity("Only JPG, PNG, or PDF allowed.");
            } else {
                panFile.setCustomValidity("");
            }

            /* File size */
            if (addressFile.files.length && addressFile.files[0].size > maxSize) {
                alert("Address Proof file size should be less than 2 MB.");
                return;
            }
            if (panFile.files.length && panFile.files[0].size > maxSize) {
                alert("PAN Card file size should be less than 2 MB.");
                return;
            }

            form.classList.add("was-validated");

            if (!form.checkValidity()) return;

            alert("Form Submitted Successfully!");
            form.reset();
            form.classList.remove("was-validated");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>