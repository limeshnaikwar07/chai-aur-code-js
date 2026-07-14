<?php

/* =========================
   DATABASE CONNECTION
========================= */

$conn = mysqli_connect("localhost", "root", "", "ebankingdb");

if (!$conn) {
    die("Database Connection Failed");
}


/* =========================
   FETCH DATA
========================= */

$fetch = mysqli_query(
    $conn,
    "SELECT * FROM account_opening ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>User Dashboard</title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

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

        .submenu {
            background: #fff;
            border-radius: 10px;
            margin-top: 5px;
            padding: 5px 0;
            display: none;
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

        /* MAIN */

        .main {
            margin-left: 260px;
            padding: 20px;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: #3b6ef5;
            color: white;
        }

        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
        }

        .account {
            border: 1px solid white;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
        }

        .account:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .file-link {
            text-decoration: none;
            font-weight: bold;
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
    </style>

</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar">

        <a href="index.php">
            <h4 class="mb-4"><i class="bi bi-bank"></i> E-BANKING</h4>
        </a>

        <a href="Admin_dash
        board.php" target="_blank" rel="noopener noreferrer">
            Dashboard
        </a>
        <!-- CASHIER -->
        <div>
            <div class="menu-toggle" onclick="toggleMenu('cashierMenu','cashierArrow')">
                <span><i class="bi bi-people-fill me-2"></i> Cashier</span>
                <i id="cashierArrow" class="bi bi-chevron-right"></i>
            </div>

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
        <div class="d-flex justify-content-end align-items-center mb-4">
            <span class="me-2">Admin</span>
            <img src="https://i.pravatar.cc/50" class="rounded-circle" width="35">
        </div>


    <!-- DASHBOARD CARD -->

    <div class="dashboard-card">

        <h4 class="text-primary mb-4">
            Account Opening Records
        </h4>


        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Address Proof</th>

                        <th>Proof Number</th>

                        <th>Address Proof File</th>

                        <th>PAN Card File</th>

                        <th>PAN Number</th>

                        <th>Address</th>

                        <th>DOB</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    if (mysqli_num_rows($fetch) > 0) {

                        while ($row = mysqli_fetch_assoc($fetch)) {

                    ?>

                            <tr>

                                <td>
                                    <?php echo $row['id']; ?>
                                </td>

                                <td>
                                    <?php echo $row['address_proof']; ?>
                                </td>

                                <td>
                                    <?php echo $row['address_proof_number']; ?>
                                </td>

                                <td>

                                    <a
                                        class="file-link"
                                        href="<?php echo $row['address_proof_file']; ?>"
                                        target="_blank">
                                        View File
                                    </a>

                                </td>

                                <td>

                                    <a
                                        class="file-link"
                                        href="<?php echo $row['pan_card_file']; ?>"
                                        target="_blank">
                                        View File
                                    </a>

                                </td>

                                <td>
                                    <?php echo $row['pan_number']; ?>
                                </td>

                                <td>
                                    <?php echo $row['address']; ?>
                                </td>

                                <td>
                                    <?php echo $row['dob']; ?>
                                </td>

                            </tr>

                        <?php

                        }
                    } else {

                        ?>

                        <tr>

                            <td colspan="8">
                                No Data Found
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

    </div>


    <!-- JS -->

    <script>
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