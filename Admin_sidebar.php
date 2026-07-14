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
            /* Adjust color and thickness */
            height: 30px;
            /* Adjust length */
            margin: 0 5px;
            /* Spacing */
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


</body>

</html>