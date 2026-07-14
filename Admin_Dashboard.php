<?php
/* ============================================================
   DATABASE CONNECTION
   ============================================================ */
$conn = mysqli_connect("localhost", "root", "", "ebankingdb");

if (!$conn) {
    die("Database Connection Failed");
}
//  ---------- 1. Available Balance ----------
$availableBalance = 0;
$sql = "SELECT COALESCE(SUM(balance), 0) AS total_balance
        FROM accounts
        WHERE status = 'approved'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $availableBalance = $row['total_balance'];
}

//  ---------- 2. Manage Payee Count ----------
//   Total number of payee records */
$payeeCount = 0;
$sql = "SELECT COUNT(*) AS total_payees FROM payees";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $payeeCount = $row['total_payees'];
}

//  ---------- 3. Rejected Accounts Count ----------
$rejectedCount = 0;
$sql = "SELECT COUNT(*) AS total_rejected
        FROM accounts
        WHERE status = 'rejected'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $rejectedCount = $row['total_rejected'];
}

//  ---------- 4. Cashier Count ----------
//   Total number of active cashiers */
$cashierCount = 0;
$sql = "SELECT COUNT(*) AS total_cashiers
        FROM cashiers
        WHERE status = 'active'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $cashierCount = $row['total_cashiers'];
}

//  ---------- 5. Total Amount ----------
//   Sum of balance across ALL accounts (approved + pending etc.) */
$totalAmount = 0;
$sql = "SELECT COALESCE(SUM(balance), 0) AS grand_total FROM accounts";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $totalAmount = $row['grand_total'];
}

//  ---------- Helper: format numbers for display ---------- */
function formatMoney($value) {
    return number_format((float) $value, 2);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminDashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
        }

        /* SIDEBAR */
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
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 8px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* TOGGLE */
        .menu-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* SUBMENU */
        .submenu {
            background: #fff;
            border-radius: 10px;
            margin-top: 5px;
            padding: 5px 0;
            display: none;
            border: 1px solid #e5e5e5;
        }

        .submenu a {
            color: #333;
            padding: 10px 12px;
            display: block;
            border-radius: 6px;
            text-decoration: none;
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

        /* MAIN CONTENT FIX */
        .main {
            margin-left: 260px;
            padding: 20px;
        }

        /* CARDS */
        .card-box {
            height: 100%;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .account {
            border: 1px solid white;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
        }

        .account:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .vertical-line {
            border-left: 2px solid #ccc;
            height: 30px;
            margin: 0 5px;
        }

        .text-pink {
            color: #d6336c;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <a href="index.php">
            <h4 class="mb-4"><i class="bi bi-bank"></i> E-BANKING</h4>
        </a>

        <a href="Admin_dashboard.php" target="_blank" rel="noopener noreferrer">
            Dashboard
        </a>

        <!-- CASHIER -->
        <div>
            <a href="cashier.php">
                <div class="menu-toggle  account" onclick="toggleMenu('cashierMenu','cashierArrow')">
                    <span><i class="bi bi-people-fill me-2"></i> Cashier</span>
                    <i id="cashierArrow" class="bi bi-chevron-right"></i>
                </div>
            </a>

            <div id="cashierMenu" class="submenu">
                <a href="all_cashier.php">All Cashier</a>
                <a href="manage_cashier.php">Manage Cashier</a>
            </div>
        </div>

        <!-- ACCOUNT APPROVAL -->
        <div>
            <div class="menu-toggle" onclick="toggleMenu('approvalMenu','approvalArrow')">
                <span><i class="bi bi-check2-circle me-2"></i> Account Approval</span>
                <i id="approvalArrow" class="bi bi-chevron-right"></i>
            </div>

            <div id="approvalMenu" class="submenu">
                <a href="view_requests.php">Pending Requests</a>
                <a href="#">Approved Accounts</a>
            </div>
        </div>

        <a href="#"><i class="bi bi-search me-2"></i> Search Account</a>

        <!-- REPORT -->
        <div>
            <div class="menu-toggle" onclick="toggleMenu('reportMenu','reportArrow')">
                <span><i class="bi bi-file-earmark-text me-2"></i> Report</span>
                <i id="reportArrow" class="bi bi-chevron-right"></i>
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

        <!-- TOP BAR -->
        <div class="d-flex justify-content-end align-items-center mb-4 gap-3">

            <button type="button" class="btn btn-light rounded-circle border-0" style="width: 40px; height: 40px; color: #495057;">
                <i class="bi bi-bell-fill"></i>
            </button>

            <div class="vertical-line"></div>

            <div class="profile-wrapper">
                <div class="d-flex align-items-center gap-2 profile-trigger">
                    <span class="admin">Admin</span>
                    <img src="https://i.pravatar.cc/50" class="rounded-circle" width="35" alt="Avatar">
                </div>

                <div class="hover-card">
                </div>
            </div>
        </div>

        <!-- CARDS (now rendered with live DB values) -->
        <div class="row g-3">

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-success">Available Balance</h6>
                            <h3>&#8377; <?php echo formatMoney($availableBalance); ?></h3>
                        </div>
                        <i class="bi bi-currency-dollar fs-1 text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-warning">Manage Payee</h6>
                            <h3><?php echo (int) $payeeCount; ?></h3>
                        </div>
                        <i class="bi bi-people-fill fs-1 text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-danger">Rejected Accounts</h6>
                            <h3><?php echo (int) $rejectedCount; ?></h3>
                        </div>
                        <i class="bi bi-x-circle fs-1 text-danger"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-primary">Cashier</h6>
                            <h3><?php echo (int) $cashierCount; ?></h3>
                        </div>
                        <i class="bi bi-person fs-1 text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-pink">Total Amount</h6>
                            <h3>&#8377; <?php echo formatMoney($totalAmount); ?></h3>
                        </div>
                        <i class="bi bi-cash fs-1 text-dark"></i>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- JS -->
    <script>
        function toggleMenu(menuId, arrowId) {
            let menu = document.getElementById(menuId);
            let arrow = document.getElementById(arrowId);

            menu.classList.toggle("show");
            arrow.classList.toggle("rotate");
        }
    </script>

</body>

</html>
<?php
/* Close the database connection at the end of the script */
mysqli_close($conn);
?>