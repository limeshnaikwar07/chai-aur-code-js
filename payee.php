<?php

/* =========================
   DATABASE CONNECTION
========================= */

$conn = mysqli_connect("localhost", "root", "", "ebankingdb");

if (!$conn) {
    die("Database Connection Failed : " . mysqli_connect_error());
}

/* =========================
   INSERT DATA
========================= */

$message = "";

if (isset($_POST['submit'])) {

    $upload_dir = "uploads/";

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $address_proof = $_POST['address_proof'];
    $address_proof_number = $_POST['address_proof_number'];
    $pan_number = $_POST['pan_number'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];

    /* ADDRESS PROOF FILE */

    $address_file_path = "";

    if (
        isset($_FILES['address_proof_file']) &&
        $_FILES['address_proof_file']['error'] == 0
    ) {

        $address_proof_file =
            basename($_FILES['address_proof_file']['name']);

        $address_tmp =
            $_FILES['address_proof_file']['tmp_name'];

        $address_file_path =
            $upload_dir . time() . "_" . $address_proof_file;

        move_uploaded_file(
            $address_tmp,
            $address_file_path
        );
    }

    /* PAN FILE */

    $pan_file_path = "";

    if (
        isset($_FILES['pan_card_file']) &&
        $_FILES['pan_card_file']['error'] == 0
    ) {

        $pan_card_file =
            basename($_FILES['pan_card_file']['name']);

        $pan_tmp =
            $_FILES['pan_card_file']['tmp_name'];

        $pan_file_path =
            $upload_dir . time() . "_" . $pan_card_file;

        move_uploaded_file(
            $pan_tmp,
            $pan_file_path
        );
    }

    /* INSERT QUERY */

    $insert = "INSERT INTO account_opening
    (
        address_proof,
        address_proof_number,
        address_proof_file,
        pan_card_file,
        pan_number,
        address,
        dob
    )
    VALUES
    (
        '$address_proof',
        '$address_proof_number',
        '$address_file_path',
        '$pan_file_path',
        '$pan_number',
        '$address',
        '$dob'
    )";

    if (mysqli_query($conn, $insert)) {

        $message = "Data Inserted Successfully";
    } else {

        $message = "Error : " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Account Opening</title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            overflow-x: hidden;
            font-family: Arial, sans-serif;
        }


        .mobile-navbar {
            display: none;
        }


        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #3b6ef5, #2b4dbf);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            overflow-y: auto;
            transition: 0.3s;
            z-index: 1000;
        }

        .sidebar h4 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .account {
            background: rgba(255, 255, 255, 0.2);
        }


        .main {
            margin-left: 260px;
            padding: 25px;
            transition: 0.3s;
        }

        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        .menu-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
        }

        .submenu {
            background: white;
            border-radius: 10px;
            margin-top: 5px;
            padding: 5px 0;
            display: none;
        }

        .submenu a {
            color: #333;
            padding: 10px 15px;
            display: block;
            border-radius: 6px;
        }

        .submenu a:hover {
            background: #f2f4f8;
        }

        .submenu.show {
            display: block;
        }

        .rotate {
            transform: rotate(90deg);
            transition: 0.3s;
        }

        .form-control,
        .form-select {
            height: 48px;
            border-radius: 10px;
        }

        textarea.form-control {
            height: auto;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
        }


        @media(max-width:991px) {

            .mobile-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #3b6ef5;
                color: white;
                padding: 15px;
                position: sticky;
                top: 0;
                z-index: 1100;
            }

            .mobile-navbar button {
                background: white;
                border: none;
                padding: 8px 12px;
                border-radius: 8px;
            }

            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .main {
                margin-left: 0;
                padding: 15px;
            }

            .form-card {
                padding: 20px;
            }
        }

        @media(max-width:576px) {

            .form-card {
                padding: 15px;
            }

            .main {
                padding: 10px;
            }

            .topbar {
                justify-content: center;
            }

            .btn-primary {
                width: 100%;
            }

            .form-control,
            .form-select {
                font-size: 14px;
            }
        }
    </style>

</head>

<body>

    <!-- MOBILE NAVBAR -->

    <div class="mobile-navbar">

        <button onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <h5 class="m-0">E-BANKING</h5>

    </div>

    <!-- SIDEBAR -->

    <div class="sidebar" id="sidebar">

        <h4>
            <a href="index.php">
                <i class="bi bi-bank"></i> E-BANKING
            </a>
        </h4>

        <a href="User_dashboard.php">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a class="account" href="user_acc_form.php">
            <i class="bi bi-person-plus"></i>
            Account Opening
        </a>

        <!-- PAYEE -->

        <div class="mb-3">

            <div class="menu-toggle"
                onclick="toggleMenu('payeeMenu','payeeArrow')">

                <span>
                    <i class="bi bi-people-fill"></i>
                    Payee / Beneficiary
                </span>

                <i id="payeeArrow"
                    class="bi bi-chevron-right"></i>

            </div>

            <div id="payeeMenu" class="submenu">

                <a href="payee.php">All Payee</a>

                <a href="payee.php">Manage Payee</a>

            </div>

        </div>

        <a href="#">
            <i class="bi bi-clock-history me-2"></i>
            Transaction History
        </a>

        <!-- REPORT -->

        <div>

            <div class="menu-toggle"
                onclick="toggleMenu('reportMenu','reportArrow')">

                <span>
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Report
                </span>

                <i id="reportArrow"
                    class="bi bi-chevron-right"></i>

            </div>

            <div id="reportMenu" class="submenu">

                <a href="#">Daily Report</a>

                <a href="#">Monthly Report</a>

                <a href="#">Transaction Report</a>

            </div>

        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="topbar">
            <div class="d-flex align-items-center gap-2">
                <span>User</span>
                <img src="https://i.pravatar.cc/50" class="rounded-circle justify-content-end" width="35">
            </div>
        </div>
        <div class="row g-4 mb-4">

            <!-- Available Balance -->
            <div class="col-md-6">
                <div class="card shadow-sm border-start-custom border-green">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success fw-bold text-uppercase small mb-1">
                                Available Balance
                            </h6>

                            <h3 class="fw-bold mb-0">
                                ₹<?php echo "10000" ?>
                            </h3>
                        </div>

                        <i class="bi bi-currency-dollar fs-1 text-light"></i>
                    </div>
                </div>
            </div>

            <!-- Payee Count -->
            <div class="col-md-6">
                <div class="card shadow-sm border-start-custom border-orange">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning fw-bold text-uppercase small mb-1">
                                Manage Payee / Beneficiaries
                            </h6>

                            <h3 class="fw-bold mb-0">
                                <?php echo  "5" ?>
                            </h3>
                        </div>

                        <i class="bi bi-people-fill fs-1 text-light"></i>
                    </div>
                </div>
            </div>

        </div>

    <!-- JS -->

    <script>
        function toggleSidebar() {
            document
                .getElementById("sidebar")
                .classList.toggle("active");
        }

        function toggleMenu(menuId, arrowId) {
            let menu =
                document.getElementById(menuId);

            let arrow =
                document.getElementById(arrowId);

            menu.classList.toggle("show");

            arrow.classList.toggle("rotate");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>